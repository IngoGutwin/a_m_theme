<?php
/**
 * Name: Shooting Lead API
 * Description: Registers a custom REST API endpoint that receives customer inquiry
 *              form submissions and stores them via the Participants Database plugin.
 * Version:     1.0.0
 *
 * Endpoint:    POST /wp-json/custom/v1/shooting-lead
 *
 * Security layers (outermost → innermost):
 *   1. Rate limiting      – max. 5 requests per IP per 60 seconds (transient-based)
 *   2. Schema validation  – WordPress validates and sanitizes every field before
 *                           the callback is reached
 *   3. GDPR check         – consent flag must be explicitly true
 *   4. Duplicate guard    – same e-mail address cannot be submitted twice
 *
 * Architecture note:
 *   Business logic and validation are intentionally kept server-side.
 *   Client-side validation (Vue.js) serves UX only and is not trusted here.
 */

// Prevent direct file access – exit immediately if WordPress is not bootstrapped.
defined( 'ABSPATH' ) || exit;

/**
 * Receives validated & sanitised POST data and persists it via
 * the Participants Database plugin.
 *
 * Field names (array keys) must match the "name" column of your
 * Participants Database field configuration exactly.
 *
 * @param  WP_REST_Request $request
 * @return WP_REST_Response
 */
function am_shooting_lead_main_callback( WP_REST_Request $request ): WP_REST_Response {
	// ── 1. Guard: plugin must be active ─────────────────────────────────────
	if ( ! class_exists( 'Participants_Db' ) ) {
		return new WP_REST_Response(
			array(
				'status'  => 'error',
				'message' => 'Database plugin is not active.',
			),
			503
		);
	}

	// ── 2. Pull validated params (already sanitised by get_args) ────────────
	$p        = $request->get_params();   // merged: JSON body + defaults
	$customer = $p['customer'];
	$booking  = $p['booking'];
	$parts    = $booking['participants'];
	$variant  = $booking['variant'];

	if ( ! $customer['gdpr'] ) {
		return new WP_REST_Response(
			array(
				'status'  => 'error',
				'code'    => 'gdpr_field_required',
				'message' => 'The gdpr field is required.',
			),
			400
		);
	}

	// ── 3. Duplicate guard: reject if e-mail already exists ─────────────────
	$existing_ids = Participants_Db::get_id_list(
		array(
			'filter' => 'email=' . $customer['email'],
		)
	);

	if ( ! empty( $existing_ids ) ) {
		return new WP_REST_Response(
			array(
				'status'  => 'error',
				'code'    => 'duplicate_email',
				'message' => 'A record with this e-mail address already exists.',
			),
			409
		);
	}

	// ── 4. Map to Participants Database field names ──────────────────────────
	$record = array(
		'first_name'       => $customer['firstName'],
		'email'            => $customer['email'],
		'gdpr'             => $customer['gdpr'] ? '1' : '0',
		'mobile_phone'     => $customer['mobilePhone'],
		'last_name'        => $customer['lastName'] ?? '',
		'street'           => $customer['street'] ?? '',
		'house_number'     => $customer['houseNumber'] ?? '',
		'zip_code'         => $customer['zipCode'] ?? '',
		'city'             => $customer['city'] ?? '',
		'newsletter'       => $customer['newsLetter'] ? '1' : '0',

		'booking_title'    => sanitize_text_field( $booking['title'] ),
		'product_id'       => sanitize_text_field( $booking['productId'] ),
		'variant_title'    => sanitize_text_field( $variant['title'] ),
		'variant_benefits' => sanitize_textarea_field( $variant['benefits'] ),

		'adults'           => (int) $parts['adults'],
		'toddlers'         => (int) $parts['toddlers'],
		'children'         => (int) $parts['childrens'],
		'animals'          => (int) $parts['animals'],
	);

	// ── 5. Write record ──────────────────────────────────────────────────────
	$record_id = Participants_Db::write_participant( $record );

	if ( ! $record_id ) {
		return new WP_REST_Response(
			array(
				'status'  => 'error',
				'code'    => 'server_error',
				'message' => 'Sorry an Error occurred, try again later.',
			),
			500
		);
	}

	return new WP_REST_Response(
		array(
			'status'    => 'success',
			'record_id' => $record_id,
		),
		201
	);
}

/**
 * Hooks into WordPress's REST API initialisation to register our custom route.
 */
function am_register_rest_route_shooting_lead() {
	register_rest_route(
		'custom/v1',          // namespace
		'/shooting-lead',     // resource path
		array(
			// Only allow POST; WP_REST_Server::CREATABLE is the constant for 'POST'
			'methods'             => WP_REST_Server::CREATABLE,

			// Main handler – runs only when permission_callback returns true
			'callback'            => 'am_shooting_lead_main_callback',

			// Gate-keeper – runs BEFORE the callback; must return true or WP_Error
			'permission_callback' => '__return_true',

			'args'                => am_shooting_lead_get_args( array() ),
		)
	);
}
add_action( 'rest_api_init', 'am_register_rest_route_shooting_lead' );

/**
 * Runs the rate limiting script.
 */
function am_shooting_lead_rate_limit( $result, $server, $request ) {
	$route = $request->get_route();
	if ( '/custom/v1/shooting-lead' !== $route ) {
		return $result;
	}

	$method = $request->get_method();
	if ( 'POST' !== $method ) {
		return $result;
	}

	$body     = $request->get_json_params();
	$honeypot = $body['honeypot'] ?? '';
	if ( '' !== $honeypot ) {
		return new WP_Error(
			'bot_detected',
			__( 'Submission rejected.' ),
			array( 'status' => 422 )
		);
	}

	$is_checked = \AM_Security_Functions\am_security_check_rate_limit();

	return is_wp_error( $is_checked ) ? $is_checked : null;
}
add_filter(
	'rest_pre_dispatch',
	'am_shooting_lead_rate_limit',
	10,
	3
);

function am_shooting_lead_get_args( $args ): array {
	return array(
		// ── Customer ────────────────────────────────────────────────────────────
		'customer' => array(
			'required'          => true,
			'type'              => 'object',

			'validate_callback' => function ( $value ) {

				if ( ! is_array( $value ) ) {
					return new WP_Error(
						'invalid_customer',
						__( 'Customer must be an object.' ),
						array( 'status' => 422 )
					);
				}

				// ─────────────────────────────
				// FIRST NAME
				// ─────────────────────────────
				$firstName = $value['firstName'] ?? '';

				if ( empty( $firstName ) || ! is_string( $firstName ) ) {
					return new WP_Error(
						'invalid_first_name',
						__( 'First name is required.' ),
						array( 'status' => 422 )
					);
				}

				if ( strlen( $firstName ) < 2 || strlen( $firstName ) > 100 ) {
					return new WP_Error(
						'invalid_first_name_length',
						__( 'First name length invalid.' ),
						array( 'status' => 422 )
					);
				}

				if ( ! preg_match( '/^[\p{L}\s\-\'\.]+$/u', $firstName ) ) {
					return new WP_Error(
						'invalid_first_name_chars',
						__( 'First name contains invalid characters.' ),
						array( 'status' => 422 )
					);
				}

				// ─────────────────────────────
				// LAST NAME
				// ─────────────────────────────
				$lastName = $value['lastName'] ?? '';

				if ( empty( $lastName ) || ! is_string( $lastName ) ) {
					return new WP_Error(
						'invalid_last_name',
						__( 'Last name is required.' ),
						array( 'status' => 422 )
					);
				}

				if ( strlen( $lastName ) < 2 || strlen( $lastName ) > 100 ) {
					return new WP_Error(
						'invalid_last_name_length',
						__( 'Last name length invalid.' ),
						array( 'status' => 422 )
					);
				}

				if ( ! preg_match( '/^[\p{L}\s\-\'\.]+$/u', $lastName ) ) {
					return new WP_Error(
						'invalid_last_name_chars',
						__( 'Last name contains invalid characters.' ),
						array( 'status' => 422 )
					);
				}

				// ─────────────────────────────
				// EMAIL
				// ─────────────────────────────
				$email = $value['email'] ?? '';

				if ( empty( $email ) || ! is_email( $email ) ) {
					return new WP_Error(
						'invalid_email',
						__( 'Invalid email address.' ),
						array( 'status' => 422 )
					);
				}

				if ( strlen( $email ) > 254 ) {
					return new WP_Error(
						'invalid_email_length',
						__( 'Email too long.' ),
						array( 'status' => 422 )
					);
				}

				// ─────────────────────────────
				// MOBILE PHONE
				// ─────────────────────────────
				$mobilePhone = preg_replace( '/[\s\-\(\)]/', '', $value['mobilePhone'] ?? '' );

				if ( ! preg_match( '/^\+?[0-9]{7,15}$/', $mobilePhone ) ) {
					return new WP_Error(
						'invalid_mobile_phone',
						__( 'Mobile phone number is invalid.' ),
						array( 'status' => 422 )
					);
				}

				// ─────────────────────────────
				// GDPR
				// ─────────────────────────────
				if ( ( $value['gdpr'] ?? false ) !== true ) {
					return new WP_Error(
						'gdpr_required',
						__( 'GDPR consent is required.' ),
						array( 'status' => 422 )
					);
				}

				// ─────────────────────────────
				// NEWSLETTER (optional)
				// ─────────────────────────────
				if ( isset( $value['newsLetter'] ) && ! is_bool( $value['newsLetter'] ) ) {
					return new WP_Error(
						'invalid_newsletter',
						__( 'Newsletter must be boolean.' ),
						array( 'status' => 422 )
					);
				}

				// ─────────────────────────────
				// STREET (optional)
				// ─────────────────────────────
				if ( ! empty( $value['street'] ) && ! is_string( $value['street'] ) ) {
					return new WP_Error(
						'invalid_street',
						__( 'Street must be string.' ),
						array( 'status' => 422 )
					);
				}

				// ─────────────────────────────
				// ZIP CODE (optional)
				// ─────────────────────────────
				if ( ! empty( $value['zipCode'] ) ) {
					if ( ! preg_match( '/^\d{5}$/', $value['zipCode'] ) ) {
						return new WP_Error(
							'invalid_zip_code',
							__( 'ZIP code must be 5 digits.' ),
							array( 'status' => 422 )
						);
					}
				}

				// ─────────────────────────────
				// CITY (optional)
				// ─────────────────────────────
				if ( ! empty( $value['city'] ) ) {
					if ( ! preg_match( '/^[\p{L}\s\-\.]+$/u', $value['city'] ) ) {
						return new WP_Error(
							'invalid_city',
							__( 'City contains invalid characters.' ),
							array( 'status' => 422 )
						);
					}
				}

				return true;
			},
		),

		// ── Booking ─────────────────────────────────────────────────────────────

		'booking'  => array(
			'required'          => false,
			'type'              => 'object',
			'validate_callback' => function ( $value ) {

				// title
				if ( empty( $value['title'] ) || ! is_string( $value['title'] ) ) {
					return new WP_Error(
						'invalid_booking_title',
						__( 'Booking title is required.' ),
						array( 'status' => 422 )
					);
				}

				// productId
				if ( empty( $value['productId'] ) || ! is_string( $value['productId'] ) ) {
					return new WP_Error(
						'invalid_product_id',
						__( 'Product ID is required.' ),
						array( 'status' => 422 )
					);
				}

				// variant
				if ( ! isset( $value['variant'] ) || ! is_array( $value['variant'] ) ) {
					return new WP_Error(
						'invalid_variant',
						__( 'Variant is required.' ),
						array( 'status' => 422 )
					);
				}
				if ( empty( $value['variant']['title'] ) ) {
					return new WP_Error(
						'invalid_variant_title',
						__( 'Variant title is required.' ),
						array( 'status' => 422 )
					);
				}

				// participants
				if ( ! isset( $value['participants'] ) || ! is_array( $value['participants'] ) ) {
					return new WP_Error(
						'invalid_participants',
						__( 'Participants data is required.' ),
						array( 'status' => 422 )
					);
				}

				$participant_keys = array( 'adults', 'toddlers', 'childrens', 'animals' );
				foreach ( $participant_keys as $key ) {
					$count = $value['participants'][ $key ] ?? null;
					if ( ! is_int( $count ) || $count < 0 || $count > 99 ) {
						return new WP_Error(
							'invalid_participant_count',
							/* translators: %s: participant type */
							sprintf( __( 'Invalid count for participant type "%s".' ), $key ),
							array( 'status' => 422 )
						);
					}
				}

				// Mindestens 1 Erwachsener
				if ( ( $value['participants']['adults'] ?? 0 ) < 1 ) {
					return new WP_Error(
						'no_adults',
						__( 'At least one adult participant is required.' ),
						array( 'status' => 422 )
					);
				}

				return true;
			},
		),
	);
}

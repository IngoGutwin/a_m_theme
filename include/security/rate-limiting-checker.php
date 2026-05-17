<?php
// ══════════════════════════════════════════════════════════════════════════════
// 3. RATE LIMITING  (WordPress transient-based, per client IP)
// ══════════════════════════════════════════════════════════════════════════════

/**
 * Enforces a sliding-window rate limit using WordPress transients.
 *
 * How it works:
 *   - On the first request from an IP, a transient is created with value 1
 *     and a TTL equal to the time window (60 s).
 *   - Each subsequent request increments the counter WITHOUT resetting the TTL,
 *     so the window does not extend on every hit.
 *   - Once the counter reaches the limit the next request is rejected until
 *     the transient expires naturally.
 *
 * Storage backend:
 *   Without an object cache (Redis / Memcached), WordPress stores transients
 *   in the wp_options table. This is perfectly adequate for a low-frequency
 *   lead form. For high-traffic endpoints, install a persistent object cache.
 *
 * Privacy note:
 *   The client IP is never stored in plain text. The transient key contains
 *   only an MD5 hash of the IP address.
 *
 * Known limitation (race condition):
 *   Two simultaneous requests from the same IP could both read the same counter
 *   value before either writes. Under very high concurrency this may allow
 *   marginally more than $limit requests. Acceptable for a contact form.
 *
 * @return true|WP_Error  true = within limit, WP_Error = limit exceeded (HTTP 429).
 */

namespace AM_Security_Functions;

use WP_Error;

function am_security_check_rate_limit(): null|WP_Error {

	$ip     = am_get_client_ip();
	$limit  = 5;
	$window = 60;

	// shootinglead_ratelimit_
	$transient_key = 'sl_rl_' . md5( $ip );
	$request       = (int) get_transient( $transient_key );

	if ( $request >= $limit ) {
		return new WP_Error(
			'rate_limited',
			'Too many requests. Please try again later.',
			array(
				'status'      => 429,
				'retry_after' => $window,
			)
		);
	}

	set_transient( $transient_key, $request + 1, $window );

	return null;
}

/**
 * Resolves the real client IP address in a proxy-aware manner.
 *
 * On shared hosting, requests often pass through a reverse proxy or load
 * balancer. In that case REMOTE_ADDR contains the proxy's IP, not the
 * client's. The actual client IP is forwarded in the X-Forwarded-For header.
 *
 * X-Forwarded-For can be a comma-separated list (client, proxy1, proxy2…).
 * We trust only the leftmost entry (the original client IP).
 *
 * Security note:
 *   X-Forwarded-For can be spoofed by a client. If your hosting provider
 *   guarantees a trusted proxy (e.g. Cloudflare), this is not a concern.
 *   For extra security, restrict which IPs are trusted as proxies.
 *
 * @return string  Validated IPv4 or IPv6 address, or '0.0.0.0' as fallback.
 */
function am_get_client_ip(): string {

	if ( ! empty( $_SERVER['HTTP_X_FORWARDED_FOR'] ) ) {
		// Extract the first (leftmost) IP from a potentially comma-separated list
		$forwarded = explode( ',', $_SERVER['HTTP_X_FORWARDED_FOR'] );
		$ip        = trim( $forwarded[0] );

		// Validate before trusting – rejects malformed or injected values
		if ( filter_var( $ip, FILTER_VALIDATE_IP ) ) {
			return $ip;
		}
	}

	// Fall back to the direct connection IP (reliable when no proxy is involved)
	return $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';
}

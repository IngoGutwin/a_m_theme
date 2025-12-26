<?php
/**
 * Footer ACF Module
 *
 * Registers an Advanced Custom Fields (ACF) group for the Footer Section.
 *
 * @package    a_m_theme
 * @subpackage ACF_Modules
 */

/**
 * Registers the Footer field group for specific page templates.
 *
 * The group is assigned to the templates:
 * - page-landing.php
 * - page-shooting.php
 *
 * @param string $group_title The unique name used as the group key and title.
 *
 * @return array|false The field group configuration array if registered, false otherwise.
 *
 * @see acf_add_local_field_group()
 */
function generate_footer_section( $group_title ) {
	/**
	 * Builds up the acf fileds array.
	 *
	 * @param array  $fields_array The resource array.
	 *
	 * @param string $field_group_hash md5 hash.
	 *
	 * @return array The acf array with fields.
	 */
	function make_acf_fields( $fields_array, $field_group_hash ) {
		$result = array();

		foreach ( $fields_array as $field ) {
			$result[] = array(
				'key'               => "field_{$field['resource']}_" . $field_group_hash,
				'label'             => ucfirst( $field['resource'] ),
				'name'              => "{$field['resource']}_" . $field_group_hash,
				'aria-label'        => '',
				'type'              => $field['type'],
				'instructions'      => '',
				'required'          => 0,
				'conditional_logic' => 0,
				'wrapper'           => array(
					'width' => '',
					'class' => '',
					'id'    => '',
				),
				'default_value'     => '',
				'placeholder'       => '',
			);
		}
		return $result;
	}

	if ( ! function_exists( 'acf_add_local_field_group' ) ) {
		return;
	}

	$field_group_hash = md5( "$group_title" );

	$resources = array(
		array(
			'resource' => 'impressum',
			'type'     => 'url',
		),
		array(
			'resource' => 'gdpr',
			'type'     => 'url',
		),
		array(
			'resource' => 'instagram',
			'type'     => 'url',
		),
		array(
			'resource' => 'facebook',
			'type'     => 'url',
		),
		array(
			'resource' => 'contact',
			'type'     => 'url',
		),
	);

	$fields = make_acf_fields( $resources, $field_group_hash );

	$acf_fields_added = acf_add_local_field_group(
		array(
			'key'                   => 'group_' . $field_group_hash,
			'title'                 => $group_title,
			'fields'                => $fields,
			'location'              => array(
				array(
					array(
						'param'    => 'page_template',
						'operator' => '==',
						'value'    => 'front-page.php',
					),
				),
			),
			'menu_order'            => 100,
			'position'              => 'normal',
			'style'                 => 'default',
			'label_placement'       => 'top',
			'instruction_placement' => 'label',
			'hide_on_screen'        => '',
			'active'                => true,
			'description'           => '',
			'show_in_rest'          => false,
		)
	);

	return $acf_fields_added;
}

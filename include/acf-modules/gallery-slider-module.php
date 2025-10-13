<?php
/**
 * Gallery slider ACF Module
 *
 * Registers an Advanced Custom Fields (ACF) group for a Gallery slider.
 *
 * @package    a_m_theme
 * @subpackage ACF_Modules
 */

/**
 * Generate_gallery_slider
 *
 * Generates and registers an Advanced Custom Fields (ACF) field group for a gallery slider.
 *
 * It's crucial to choose a unique name for the `$group_name` to prevent conflicts
 * with existing ACF field groups.

 * @param string $group_title A unique identifier for this ACF field group.
 *
 * @param int    $slides_count The number of individual slides (and their associated
 *    fields) you want to generate within this slider.
 *
 * @param string $location_value post/template type/name.
 *
 * @param string $location_param template/post name.
 *
 * @param int    $menu_order Menu order on admin.
 *
 * @return bool Returns `true` if the ACF field group was successfully
 * generated and registered. Returns `false` if a field
 * group with the given `$group_name` already exists,
 */
function generate_gallery_slider( $group_title, $slides_count, $location_value, $location_param, $menu_order ) {

	$fields = array();

	$field_group_hash = md5( "$group_title" );

	for ( $i = 0; $i < $slides_count; $i++ ) {
		$fields_hash = md5( "{$group_title}_{$i}" );

		$fields[] = array(
			'key'               => "field_{$fields_hash}",
			'label'             => 'Slide' . $i + 1,
			'name'              => "$fields_hash",
			'type'              => 'group',
			'instructions'      => '',
			'required'          => 0,
			'conditional_logic' => 0,
			'wrapper'           => array(
				'width' => '',
				'class' => '',
				'id'    => '',
			),
			'layout'            => 'block',
			'sub_fields'        => array(
				array(
					'key'               => "field_image_url_{$fields_hash}",
					'label'             => 'Image',
					'name'              => 'image_url',
					'aria-label'        => '',
					'type'              => 'image',
					'instructions'      => '',
					'required'          => 0,
					'conditional_logic' => 0,
					'wrapper'           => array(
						'width' => '',
						'class' => '',
						'id'    => '',
					),
					'return_format'     => 'url',
					'library'           => 'all',
					'min_width'         => '',
					'min_height'        => '',
					'min_size'          => '',
					'max_width'         => '',
					'max_height'        => '',
					'max_size'          => '',
					'mime_types'        => '',
					'allow_in_bindings' => 0,
					'preview_size'      => 'medium',
				),
				array(
					'key'          => "field_page_url_{$fields_hash}",
					'label'        => 'Page URL',
					'name'         => 'page_url',
					'type'         => 'page_link',
					'instructions' => 'Choose a Site',
					'post_type'    => array( 'page', 'post' ),
					'required'     => 0,
					'wrapper'      => array( 'width' => '50' ),
					'multiple'     => 0,
				),
			),
		);
	}

	$acf_group_added = acf_add_local_field_group(
		array(
			'key'                   => "group_{$field_group_hash}",
			'title'                 => $group_title,
			'fields'                => $fields,
			'location'              => array(
				array(
					array(
						'param'    => $location_param,
						'param'    => $location_param,
						'operator' => '==',
						'value'    => $location_value,
						'value'    => $location_value,
					),
				),
			),
			'menu_order'            => $menu_order,
			'position'              => 'normal',
			'style'                 => 'default',
			'label_placement'       => 'top',
			'instruction_placement' => 'label',
			'hide_on_screen'        => '',
			'active'                => true,
			'description'           => '',
			'show_in_rest'          => 0,
		)
	);

	return $acf_group_added;
}

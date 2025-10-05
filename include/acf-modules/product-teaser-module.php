<?php
/**
 * Product Teaser ACF Module
 *
 * Registers an Advanced Custom Fields (ACF) group for a Product Teaser.
 *
 * @package    a_m_theme
 * @subpackage ACF_Modules
 */

/**
 * Generate_teaser_slides
 *
 * Generates and registers an Advanced Custom Fields (ACF) field group for a teaser slider.
 *
 * It's crucial to choose a unique name for the `$group_name` to prevent conflicts
 * with existing ACF field groups.

 * @param string $group_name A unique identifier for this ACF field group.
 *
 * @param int    $slides_count The number of individual slides (and their associated
 * fields) you want to generate within this slider.
 *
 * @param string $location_value post/file type/name.
 *
 * @param string $location_param post/template type.
 *
 * @return bool Returns `true` if the ACF field group was successfully
 * generated and registered. Returns `false` if a field
 * group with the given `$group_name` already exists,
 */
function generate_teaser_slides( $group_title, $slides_count, $location_value, $location_param ) {
	$fields = array();

	for ( $i = 0; $i < $slides_count; $i++ ) {
		$fields[] = array(
			'key'               => "field_{$group_name}_{$i}",
			'label'             => 'Product ' . $i + 1,
			'name'              => "{$group_name}_{$i}",
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
					'key'           => "field_{$group_name}_{$i}_title",
					'label'         => 'Titel',
					'name'          => 'title',
					'type'          => 'text',
					'instructions'  => '',
					'required'      => 0,
					'wrapper'       => array( 'width' => '50' ),
					'default_value' => '',
					'placeholder'   => 'Slide Titel',
					'maxlength'     => '',
				),
				array(
					'key'           => "field_{$group_name}_{$i}_subtitle",
					'label'         => 'Sub Titel',
					'name'          => 'sub_title',
					'type'          => 'text',
					'instructions'  => '',
					'required'      => 0,
					'wrapper'       => array( 'width' => '50' ),
					'default_value' => '',
					'placeholder'   => 'Slide Sub Title',
					'maxlength'     => '',
				),
				array(
					'key'               => "field_{$group_name}_{$i}_image",
					'label'             => 'Image',
					'name'              => 'image',
					'type'              => 'image',
					'aria-label'        => '',
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
					'key'           => "field_{$group_name}_{$i}_url",
					'label'         => 'URL',
					'name'          => 'url',
					'type'          => 'page_link',
					'instructions'  => 'Link zu der entsprechenden Seite',
					'required'      => 0,
					'wrapper'       => array( 'width' => '50' ),
					'post_type'     => array( 'page', 'post', 'shooting' ),
					'default_value' => '',
					'placeholder'   => 'https://example.com',
					'multiple'      => 0,
				),
			),
		);
	}

	$acf_group_added = acf_add_local_field_group(
		array(
			'key'                   => "group_{$group_name}",
			'title'                 => $group_name,
			'fields'                => $fields,
			'location'              => array(
				array(
					array(
						'param'    => $location_param,
						'operator' => '==',
						'value'    => $location_value,
					),
				),
			),
			'menu_order'            => 0,
			'position'              => 'normal',
			'style'                 => 'default',
			'label_placement'       => 'top',
			'instruction_placement' => 'label',
			'hide_on_screen'        => '',
			'active'                => true,
		)
	);

	return $acf_group_added;
}

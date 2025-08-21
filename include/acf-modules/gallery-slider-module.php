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

 * @param string $group_name A unique identifier for this ACF field group.
 *
 * @param int    $slides_count The number of individual slides (and their associated
 *    fields) you want to generate within this slider.

 * @return bool Returns `true` if the ACF field group was successfully
 * generated and registered. Returns `false` if a field
 * group with the given `$group_name` already exists,
 */
function generate_gallery_slider( $group_name, $slides_count ) {

	$field_group_key = md5( "$group_name" );

	$fields = array();

	$fields[] = array(
		'key'           => 'slider_heading' . $field_group_key,
		'label'         => 'Slider Überschrift',
		'name'          => 'hero_slider_heading',
		'type'          => 'text',
		'instructions'  => 'Hauptüberschrift für den Hero Slider',
		'required'      => 0,
		'wrapper'       => array( 'width' => '50' ),
		'default_value' => '',
		'placeholder'   => 'Willkommen auf unserer Website',
		'maxlength'     => '',
	);

	$fields[] = array(
		'key'           => 'slider_cta' . $field_group_key,
		'label'         => 'Slider Beschreibung',
		'name'          => 'hero_slider_text',
		'type'          => 'textarea',
		'instructions'  => 'Optional: Beschreibungstext unter der Überschrift',
		'required'      => 0,
		'wrapper'       => array( 'width' => '50' ),
		'default_value' => '',
		'placeholder'   => 'Entdecken Sie unsere neuesten Angebote...',
		'maxlength'     => '',
		'rows'          => 3,
		'new_lines'     => '',
	);

	for ( $i = 0; $i < $slides_count; $i++ ) {
		$fields[] = array(
			'key'               => 'field_' . $group_name . '_slide_' . $i,
			'label'             => 'Slide ' . $i + 1,
			'name'              => $group_name,
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
					'key'               => $i . '_image_' . $field_group_key,
					'label'             => 'Image',
					'name'              => 'image',
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
					'key'          => $i . '_url_' . $field_group_key,
					'label'        => 'Page URL',
					'name'         => 'url',
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
			'key'                   => 'group_' . $field_group_key,
			'title'                 => $group_name,
			'fields'                => $fields,
			'location'              => array(
				array(
					array(
						'param'    => 'page_template',
						'operator' => '==',
						'value'    => 'page-landing.php',
					),
				),
				array(
					array(
						'param'    => 'page_template',
						'operator' => '==',
						'value'    => 'page-shooting.php',
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
			'description'           => '',
			'show_in_rest'          => 0,
		)
	);

	return $acf_group_added;
}

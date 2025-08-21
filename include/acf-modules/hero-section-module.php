<?php
/**
 * Hero Section ACF Module
 *
 * Registers an Advanced Custom Fields (ACF) group for a Hero Section.
 *
 * @package    a_m_theme
 * @subpackage ACF_Modules
 */

/**
 * Registers the Hero Section field group for specific page templates.
 *
 * This function defines and registers an ACF field group with the following fields:
 * - Hero Title (text)
 * - Hero Sub Title (WYSIWYG editor)
 * - Hero Button Text (text)
 * - Hero Background Image SM (image, URL return)
 * - Hero Background Image XL (image, URL return)
 *
 * The group is assigned to the templates:
 * - page-landing.php
 * - page-shooting.php
 *
 * @param string $group_name The unique name used as the group key and title.
 *
 * @return array|false The field group configuration array if registered, false otherwise.
 *
 * @see acf_add_local_field_group()
 */
function generate_hero_section( $group_name ) {

	if ( ! function_exists( 'acf_add_local_field_group' ) ) {
		return;
	}

	$acf_fields_added = acf_add_local_field_group(
		array(
			'key'                   => "field_{$group_name}",
			'title'                 => $group_name,
			'fields'                => array(
				array(
					'key'               => 'field_hero_title',
					'label'             => 'Hero Title',
					'name'              => 'hero_title',
					'aria-label'        => '',
					'type'              => 'text',
					'instructions'      => '',
					'required'          => 0,
					'conditional_logic' => 0,
					'wrapper'           => array(
						'width' => '',
						'class' => '',
						'id'    => '',
					),
					'default_value'     => '',
					'maxlength'         => '',
					'allow_in_bindings' => 0,
					'placeholder'       => '',
					'prepend'           => '',
					'append'            => '',
				),
				array(
					'key'               => 'field_sub_hero_title',
					'label'             => 'Hero Sub Title',
					'name'              => 'hero_sub_title',
					'aria-label'        => '',
					'type'              => 'wysiwyg',
					'instructions'      => '',
					'required'          => 0,
					'conditional_logic' => 0,
					'wrapper'           => array(
						'width' => '',
						'class' => '',
						'id'    => '',
					),
					'default_value'     => '',
					'maxlength'         => '',
					'allow_in_bindings' => 0,
					'placeholder'       => '',
					'prepend'           => '',
					'append'            => '',
				),
				array(
					'key'               => 'field_hero_button_text',
					'label'             => 'Hero Button Text',
					'name'              => 'hero_button_text',
					'aria-label'        => '',
					'type'              => 'text',
					'instructions'      => '',
					'required'          => 0,
					'conditional_logic' => 0,
					'wrapper'           => array(
						'width' => '',
						'class' => '',
						'id'    => '',
					),
					'default_value'     => '',
					'maxlength'         => '',
					'allow_in_bindings' => 0,
					'placeholder'       => '',
					'prepend'           => '',
					'append'            => '',
				),
				array(
					'key'               => 'field_hero_background_image_sm',
					'label'             => 'Hero Background Image SM',
					'name'              => 'hero_bg_image_sm',
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
					'key'               => 'field_hero_background_image_xl',
					'label'             => 'Hero Background Image XL',
					'name'              => 'hero_bg_image_xl',
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
			),
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

	return $acf_fields_added;
}

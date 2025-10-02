<?php
/**
 * Banner Call to Action ACF Module
 *
 * Registers an Advanced Custom Fields (ACF) group for a Banner Section.
 *
 * @package    a_m_theme
 * @subpackage ACF_Modules
 */

/**
 * Registers the Hero Section field group for specific page templates.
 *
 * This function defines and registers an ACF field group with the following fields:
 * - Title (text)
 * - Sub Title (WYSIWYG editor)
 * - Button Text (text)
 * - Background Image SM (image, URL return)
 * - Background Image XL (image, URL return)
 *
 * The group is assigned to the templates:
 * - page-landing.php
 * - page-shooting.php
 *
 * @param string $group_title The unique name used as the group key and title.
 *
 * @param string $template The template name for the fields.
 *
 * @return array|false The field group configuration array if registered, false otherwise.
 *
 * @see acf_add_local_field_group()
 */
function generate_banner_cta_section( $group_title, $template ) {

	if ( ! function_exists( 'acf_add_local_field_group' ) ) {
		return;
	}

	$field_group_hash = md5( "$group_title" );

	$acf_fields_added = acf_add_local_field_group(
		array(
			'key'                   => $field_group_hash,
			'title'                 => $group_title,
			'fields'                => array(
				array(
					'key'               => 'title_' . $field_group_hash,
					'label'             => 'Title',
					'name'              => 'title_' . $field_group_hash,
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
					'key'               => 'sub_title_' . $field_group_hash,
					'label'             => 'Sub Title',
					'name'              => 'sub_title_' . $field_group_hash,
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
					'key'               => 'button_text_' . $field_group_hash,
					'label'             => 'Button Text',
					'name'              => 'button_text_' . $field_group_hash,
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
					'key'               => 'bg_image_sm_' . $field_group_hash,
					'label'             => 'Background Image SM',
					'name'              => 'bg_image_sm_' . $field_group_hash,
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
					'key'               => 'bg_image_xl' . $field_group_hash,
					'label'             => 'Background Image XL',
					'name'              => 'bg_image_xl_' . $field_group_hash,
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
						'value'    => $template . '.php',
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

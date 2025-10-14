<?php
/**
 * Prose Block ACF Module
 *
 * Registers an Advanced Custom Fields (ACF) group for a Prose Block.
 *
 * @package    a_m_theme
 * @subpackage ACF_Modules
 */

/**
 * Generate_prose_block_teaser
 *
 * Generates and registers an Advanced Custom Fields (ACF) field group for a a call to action block.
 *
 * It's crucial to choose a unique name for the `$group_name` to prevent conflicts
 * with existing ACF field groups.
 *
 * @param string $group_title A unique identifier for this ACF field group.
 *
 * @param string $location_value the template or post file/type.
 *
 * @param string $location_param the post/template type.
 *
 * @param int    $menu_order Menu Ordern front end admin.
 *
 * @return bool Returns `true` if the ACF field group was successfully
 * generated and registered. Returns `false` if a field
 * group with the given `$group_name` already exists
 */
function generate_prose_block( $group_title, $location_value, $location_param, $menu_order ) {
	if ( ! function_exists( 'acf_add_local_field_group' ) ) {
		return;
	}

	$field_group_hash = md5( "$group_title" );

	$acf_group_added = acf_add_local_field_group(
		array(
			'key'                   => 'group_' . $field_group_hash,
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
					'key'               => 'description_' . $field_group_hash,
					'label'             => 'Description',
					'name'              => 'description_' . $field_group_hash,
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
					'allow_in_bindings' => 0,
					'tabs'              => 'all',
					'toolbar'           => 'full',
					'media_upload'      => 1,
					'delay'             => 0,
				),
				array(
					'key'               => 'bg_image_' . $field_group_hash,
					'label'             => 'Image',
					'name'              => 'bg_image_' . $field_group_hash,
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
					'key'               => 'hashtags_' . $field_group_hash,
					'label'             => 'Hashtags',
					'name'              => 'hashtags_' . $field_group_hash,
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
					'allow_in_bindings' => 0,
					'tabs'              => 'all',
					'toolbar'           => 'full',
					'media_upload'      => 1,
					'delay'             => 0,
				),
			),
			'location'              => array(
				array(
					array(
						'param'    => $location_param,
						'operator' => '==',
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

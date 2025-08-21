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
 * @return bool Returns `true` if the ACF field group was successfully
 * generated and registered. Returns `false` if a field
 * group with the given `$group_name` already exists,
 */
function generate_prose_block_teaser( $group_title ) {
	if ( ! function_exists( 'acf_add_local_field_group' ) ) {
		return;
	}

	$field_group_key = md5( "$group_title" );

	// Bail early if field group already exists.
	if ( acf_is_local_field_group( $field_group_key ) ) {
		return false;
	}

	$acf_group_added = acf_add_local_field_group(
		array(
			'key'                   => "group_$field_group_key",
			'title'                 => $group_title,
			'fields'                => array(
				array(
					'key'               => 'title_' . $field_group_key,
					'label'             => 'Title',
					'name'              => 'title',
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
					'key'               => 'description_' . $field_group_key,
					'label'             => 'Description',
					'name'              => 'description',
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
					'key'               => 'hashtags_' . $field_group_key,
					'label'             => 'Hashtags',
					'name'              => 'hashtags',
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

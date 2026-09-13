<?php
/**
 * Shooting Reference ACF Module
 *
 * Registers an Advanced Custom Fields (ACF) group each shooting product.
 *
 * @package    a_m_theme
 * @subpackage ACF_Modules
 */

/**
 * Registers the fields each shooting.
 *
 * The group is assigned to the shooting post type:
 *
 * @return array|false The field group configuration array if registered, false otherwise.
 *
 * @see acf_add_local_field_group()
 */
function add_shooting_reference( $group_title ) {

	$fields_hash = md5( $group_title );

	function generate_sub_fields( $variants, $group_title ) {
		$fields = array();

		for ( $i = 0; $i < $variants; $i++ ) {
			$group_hash = md5( "{$group_title}_{$i}" );

			$fields[] = array(
				'key'        => "group_{$group_hash}",
				'label'      => 'Variant ' . $i + 1,
				'name'       => 'variant_' . $i + 1,
				'type'       => 'group',
				'layout'     => 'block',
				'sub_fields' => array(
					array(
						'key'   => "field_variant_{$group_hash}",
						'label' => 'Title ' . $i + 1,
						'name'  => 'title',
						'type'  => 'text',
					),
					array(
						'key'   => "field_benefits_{$group_hash}",
						'label' => 'Benefits',
						'name'  => 'benefits',
						'type'  => 'textarea',
					),
				),
			);
		}
		return $fields;
	}

	if ( ! function_exists( 'acf_add_local_field_group' ) ) {
		return;
	}

	$acf_fields_added = acf_add_local_field_group(
		array(
			'key'                   => "group_shooting_reference_{$fields_hash}",
			'title'                 => 'Shooting Reference',
			'fields'                => array(
				array(
					'key'               => 'title',
					'label'             => 'Product Name',
					'name'              => 'title',
					'type'              => 'text',
					'required'          => 0,
					'conditional_logic' => 0,
				),
				array(
					'key'      => 'product_id',
					'label'    => 'Product Id',
					'name'     => 'product_id',
					'type'     => 'text',
					'readonly' => 1,
					'disabled' => 1,
				),
				array(
					'key'        => 'group',
					'label'      => 'Variants',
					'name'       => 'variants',
					'type'       => 'group',
					'layout'     => 'block',
					'sub_fields' => generate_sub_fields( 3, $group_title ),
				),
			),
			'location'              => array(
				array(
					array(
						'param'    => 'post_type',
						'operator' => '==',
						'value'    => 'shooting',
					),
				),
			),
			'position'              => 'normal',
			'style'                 => 'default',
			'label_placement'       => 'top',
			'instruction_placement' => 'label',
			'active'                => true,
			'show_in_rest'          => true,
		)
	);

	return $acf_fields_added;
}

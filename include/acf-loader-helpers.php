<?php
/**
 * Theme ACF Utilities
 *
 * Helper functions for loading and structuring Advanced Custom Fields (ACF)
 * in this theme.
 *
 * Contains:
 * - get_page_fields(): Retrieves all ACF fields for a given post and groups them by field group.
 * - include_acf_modules_landing_page(): Dynamically includes ACF modules based on a list of module names.
 *
 * @package    a_m_theme
 * @subpackage ACF
 */

/**
 * Retrieves all ACF field values for a given post, grouped by their field group.
 *
 * This function:
 *   1. Finds all ACF field groups assigned to the given post.
 *   2. Iterates through each field group and gets its fields.
 *   3. For each field:
 *        - If it is a "group" field, it loads all its sub-fields as an array.
 *        - If it is a simple field, it loads its value directly.
 *   4. Structures the result as a nested array:
 *        [ 'Field Group Title' => [ 'field_name' => value | [sub_fields] ] ]
 *
 * @param int $post_id - The ID of the post/page from which to retrieve ACF field values.
 *
 * @return array
 *
 * @see acf_get_field_groups()
 * @see acf_get_fields()
 * @see get_field()
 */
function get_page_fields( $post_id ) {
	$result = array();

	// 1. Get all field groups assigned to the given post
	$field_groups = acf_get_field_groups( array( 'post_id' => $post_id ) );

	foreach ( $field_groups as $field_group ) {
		$current_fields_data = array();

		// 3. Get all fields of this group (returns definitions, not values)
		$acf_group_fields = acf_get_fields( $field_group['key'] );

		// 4. Loop through each field in the group
		foreach ( $acf_group_fields as $acf_group ) {
			$field_name = $acf_group['name'];
			if ( 'group' === $acf_group['type'] ) {
				// 👉 Special case: if the field itself is a group,
				// get_field() will return an associative array of all sub-fields
				$group_values                       = get_field( $field_name, $post_id );
				$current_fields_data[ $field_name ] = $group_values;
			} else {
				// 👉 Normal field (not a group)
				$field_name                         = $acf_group['name'];
				$field_value                        = get_field( $field_name, $post_id, true, true );
				$current_fields_data[ $field_name ] = $field_value;
			}
		}
		if ( array_filter( $current_fields_data ) ) {
			$result[ $field_group['title'] ] = $current_fields_data;

			$group_hash                                    = preg_replace( '/^group_/', '', $field_group['key'] );
			$result[ $field_group['title'] ]['group_hash'] = $group_hash;
			$result[ $field_group['title'] ]['field_group_title'] = $field_group['title'];
		}
	}
	return $result;
}

/**
 * Includes ACF module PHP files.
 *
 * Expects a list of module names (e.g. "hero-section", "gallery-slider")
 * and loads the corresponding file for each module:
 *
 *   /include/acf-modules/{module-name}-module.php
 *
 * @param string[] $acf_modules List of module names without file extension.
 *
 * @return void
 */
function include_acf_modules( $acf_modules ) {
	foreach ( $acf_modules as $module_name ) {
		require_once get_template_directory() . "/include/acf-modules/$module_name-module.php";
	}
}

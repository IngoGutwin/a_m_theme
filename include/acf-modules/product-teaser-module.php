<?php

/**
 * generate_teaser_slides
 *
 * Generates and registers an Advanced Custom Fields (ACF) field group for a teaser slider.
 *
 * It's crucial to choose a unique name for the `$group_name` to prevent conflicts
 * with existing ACF field groups.

 * @param string $group_name A unique identifier for this ACF field group.
 * 
 * @param int $slides_count The number of individual slides (and their associated
 * fields) you want to generate within this slider.
 
 * @return bool Returns `true` if the ACF field group was successfully
 * generated and registered. Returns `false` if a field
 * group with the given `$group_name` already exists,
 */
function generate_teaser_slides($group_name, $slides_count)
{
  $field_group_key = md5("$group_name");

  // Bail early if field group already exists.
  if (acf_is_local_field_group($field_group_key)) {
    return false;
  }

  $fields = array();

  for ($i = 0; $i < $slides_count; $i++) {
    $fields[] = array(
      'key' => $group_name . '_' . $i . '_' . $field_group_key,
      'label' => 'Product ' . $i + 1,
      'name' => $group_name,
      'type' => 'group',
      'instructions' => '',
      'required' => 0,
      'conditional_logic' => 0,
      'wrapper' => array(
        'width' => '',
        'class' => '',
        'id' => '',
      ),
      'layout' => 'block',
      'sub_fields' => array(
        array(
          'key' => $i . '_title'  . '_' . $field_group_key,
          'label' => 'Titel',
          'name' => 'title',
          'type' => 'text',
          'instructions' => '',
          'required' => 0,
          'wrapper' => array('width' => '50'),
          'default_value' => '',
          'placeholder' => 'Slide Titel',
          'maxlength' => '',
        ),
        array(
          'key' => $i . '_subtitle' . '_' . $field_group_key,
          'label' => 'Sub Titel',
          'name' => 'sub_title',
          'type' => 'text',
          'instructions' => '',
          'required' => 0,
          'wrapper' => array('width' => '50'),
          'default_value' => '',
          'placeholder' => 'Slide Sub Title',
          'maxlength' => '',
        ),
        array(
          'key' => $i . '_image' . '_' . $field_group_key,
          'label' => 'Image',
          'name' => 'image',
          'type' => 'image',
          'aria-label' => '',
          'instructions' => '',
          'required' => 0,
          'conditional_logic' => 0,
          'wrapper' => array(
            'width' => '',
            'class' => '',
            'id' => '',
          ),
          'return_format' => 'url',
          'library' => 'all',
          'min_width' => '',
          'min_height' => '',
          'min_size' => '',
          'max_width' => '',
          'max_height' => '',
          'max_size' => '',
          'mime_types' => '',
          'allow_in_bindings' => 0,
          'preview_size' => 'medium',
        ),
        array(
          'key' => $i . '_url' . '_' . $field_group_key,
          'label' => 'URL',
          'name' => 'url',
          'type' => 'page_link',
          'instructions' => 'Link zu der entsprechenden Seite',
          'required' => 0,
          'wrapper' => array('width' => '50'),
          'post_type' => array('page', 'post'),
          'default_value' => '',
          'placeholder' => 'https://example.com',
          'multiple' => 0
        ),
      ),
    );
  }

  $acf_group_added = acf_add_local_field_group(array(
    'key' => "group_$field_group_key",
    'title' => $group_name,
    'fields' => $fields,
    'location' => array(
      array(
        array(
          'param' => 'page_template',
          'operator' => '==',
          'value' => 'page-landing.php',
        ),
      ),
      array(
        array(
          'param' => 'page_template',
          'operator' => '==',
          'value' => 'page-shooting.php',
        ),
      ),
    ),
    'menu_order' => 0,
    'position' => 'normal',
    'style' => 'default',
    'label_placement' => 'top',
    'instruction_placement' => 'label',
    'hide_on_screen' => '',
    'active' => true,
  ));

  return $acf_group_added;
}

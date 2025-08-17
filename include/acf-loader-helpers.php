<?php

function get_page_fields($post_id)
{
  $result = array();
  $field_groups = acf_get_field_groups(array('post_id' => $post_id));

  foreach ($field_groups as $field_group) {
    $field_group_id = $field_group['key'];
    $field_group_title = $field_group['title'];
    $acf_fields = acf_get_fields($field_group_id);

    foreach ($acf_fields as $acf_group) {
      $field_name = $acf_group['name'];
      $field_value = get_field($field_name, $post_id, true, true);

      if ($acf_group['type'] === 'image') {
        $result[$field_group_title]['images'][$field_name] = $field_value;
      } else {
        $result[$field_group_title][$field_name] = $field_value;
      }
    }
  }

  return $result;
}

function include_acf_modules_landing_page($acf_modules)
{

  foreach ($acf_modules as $module_name) {
    require_once get_template_directory() . "/include/acf-modules/$module_name-module.php";
  }
}

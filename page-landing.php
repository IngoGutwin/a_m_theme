<?php

/**
 * Template Name: landing page
 * Template Post Type: page
 */

$post_id = get_the_ID();

get_template_part('parts/header-default', 'default');

get_template_part('parts/navbar');

if (function_exists('get_page_fields')) {

  $page_fields = get_page_fields($post_id);

  // error_log(print_r($page_fields, true));

  get_template_part('parts/hero-default', 'default', $page_fields['Hero Section']);

  get_template_part('parts/footer-default', 'default');
}

<?php

/**
 * Template Name: shooting page 
 */

$post_id = get_the_ID();

get_template_part('parts/header-default', 'default');

get_template_part('parts/navbar');

if (function_exists('get_page_fields')) {

  $page_fields = get_page_fields($post_id);

  get_template_part('parts/hero-default', 'default', $page_fields['Hero Section']);

  // get_template_part('parts/intro-default', 'default', $page_fields['Introduction Section']);

  // get_template_part('parts/benefits-default', 'default', $page_fields['benefits_section']);

  // get_template_part('parts/about-default', 'default', $page_fields['about_section']);

  get_template_part('parts/footer-default', 'default');
}

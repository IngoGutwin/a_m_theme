<?php
/**
 * Template Name: Template Page
 * Template Post Type: page
 *
 * @package a_m_theme
 */

$page_id = get_the_ID();

$page_fields = get_page_fields( $page_id );

$section_fields = $page_fields['Hero Section Template Page'] ?? array();

$footer_section = $page_fields['Footer Section'] ?? array();

get_template_part( 'parts/header-default' );

if ( ! empty( $section_fields ) ) {
	get_template_part( 'parts/prose-block', 'default', $section_fields );
}

get_template_part( 'parts/footer-default', 'default', $footer_section );

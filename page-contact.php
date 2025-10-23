<?php
/**
 * Template Name: Contact Page
 * Template Post Type: page
 *
 * @package a_m_theme
 */

$page_id = get_the_ID();

$page_fields = get_page_fields( $page_id );

$hero_section_fields = $page_fields['Hero Section Contact'] ?? array();

$description_block_fields = $page_fields['Contact Description'] ?? array();

$footer_section = $page_fields['Footer Section'] ?? array();

get_template_part( 'parts/header-default' );

get_template_part( 'parts/navbar' );

if ( ! empty( $hero_section_fields ) ) {
	get_template_part(
		'parts/banner-call-to-action',
		'',
		array(
			'page_fields' => $hero_section_fields,
			'css_class'   => 'banner',
		)
	);
}

if ( ! empty( $description_block_fields ) ) {
	get_template_part( 'parts/prose-block', 'default', $description_block_fields );
}

get_template_part( 'parts/footer-default', 'default', $footer_section );

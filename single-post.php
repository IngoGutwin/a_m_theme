<?php
/**
 * Template Name: Singe Post Template
 * Template Post Type: post
 *
 * @package a_m_theme
 */

$page_id = get_the_ID();

$page_fields = get_page_fields( $page_id );

$hero_section_fields = $page_fields['Hero Section Post'];

$blog_post = $page_fields['Blog Post Main Content'];

$gallery_slider = $page_fields['Gallery Slider Blog Post'];

get_template_part( 'parts/header-default', 'default' );

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

if ( ! empty( $blog_post ) ) {
	get_template_part( 'parts/prose-block', 'default', $blog_post );
}

if ( ! empty( $gallery_slider ) ) {
	get_template_part( 'parts/gallery-slider', '', $gallery_slider );
}

get_template_part( 'parts/footer-default' );

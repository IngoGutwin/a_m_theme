<?php
/**
 * Template Name: Front Page
 * Template Post Type: page
 *
 * @package a_m_theme
 */

$page_id = get_the_ID();

$page_fields = get_page_fields( $page_id );

$hero_section_fields = $page_fields['Hero Section'] ?? array();

$product_teaser_fields = $page_fields['Product Teaser Slides'] ?? array();

$teaser_prose_block_fields = $page_fields['Offer Prose Block'] ?? array();

$impressions_galley_one_fields = $page_fields['Impressions Gallery One'] ?? array();

$info_call_to_action_fields = $page_fields['Impressions Prose Block'] ?? array();

$call_to_action_ads_banner = $page_fields['Call to Action Banner'] ?? array();

$call_to_action_ads_banner_message = $page_fields['Call to Action Banner Message'] ?? array();

$impressions_galley_two = $page_fields['Impressions Gallery Two'] ?? array();

$advertisement_seo_block = $page_fields['Advertisement Seo Block'] ?? array();

$footer_section = $page_fields['Footer Section'] ?? array();

get_template_part( 'parts/header-default' );

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

if ( ! empty( $product_teaser_fields ) ) {
	get_template_part( 'parts/teaser-slider-products', 'products', $product_teaser_fields );
}

if ( ! empty( $teaser_prose_block_fields ) ) {
	get_template_part( 'parts/prose-block', 'default', $teaser_prose_block_fields );
}

if ( ! empty( $impressions_galley_one_fields ) ) {
	get_template_part( 'parts/gallery-slider', '', $impressions_galley_one_fields );
}

if ( ! empty( $info_call_to_action_fields ) ) {
	get_template_part( 'parts/prose-block', 'default', $info_call_to_action_fields );
}

if ( ! empty( $call_to_action_ads_banner ) ) {
	get_template_part(
		'parts/banner-call-to-action',
		'',
		array(
			'page_fields' => $call_to_action_ads_banner,
			'css_class'   => 'ads-banner',
		)
	);
}

if ( ! empty( $call_to_action_ads_banner_message ) ) {
	get_template_part( 'parts/prose-block', 'default', $call_to_action_ads_banner_message );
}

if ( ! empty( $impressions_galley_two ) ) {
	get_template_part( 'parts/gallery-slider', '', $impressions_galley_two );
}

if ( ! empty( $advertisement_seo_block ) ) {
	get_template_part( 'parts/prose-block', 'default', $advertisement_seo_block );
}

get_template_part( 'parts/footer-default', 'default', $footer_section );

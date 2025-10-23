<?php
/**
 * Singe post type for shooting
 *
 * @package a_m_theme
 */

$page_on_front = (int) get_option( 'page_on_front' );

$page_id = get_the_ID();

$page_fields = get_page_fields( $page_id );

$hero_section_shooting_fields = $page_fields['Hero Section Shooting'] ?? array();

$shooting_prices_fields = $page_fields['Shooting Prices'] ?? array();

$shooting_impressions_fields = $page_fields['Shooting Impressions Gallery'] ?? array();

$shooting_products_fields = $page_fields['Shooting Products Teaser Slides'] ?? array();

$shooting_checkup_fields = $page_fields['Shooting Checkup List'] ?? array();

$shooting_advertisement_banner_fields = $page_fields['Shooting Advertisement Banner'] ?? array();

$shooting_advertisement_impressions_fields = $page_fields['Shooting Advertisement Impressions'] ?? array();

$shooting_info_fields = $page_fields['Shooting Infos Prose Block'] ?? array();

get_template_part( 'parts/header-default', 'default' );

get_template_part( 'parts/navbar' );

if ( ! empty( $hero_section_shooting_fields ) ) {
	get_template_part(
		'parts/banner-call-to-action',
		'',
		array(
			'page_fields' => $hero_section_shooting_fields,
			'css_class'   => 'banner',
		)
	);
}

if ( ! empty( $shooting_prices_fields ) ) {
	get_template_part( 'parts/prose-block', 'default', $shooting_prices_fields );
}

if ( ! empty( $shooting_impression_fields ) ) {
	get_template_part( 'parts/gallery-slider', '', $shooting_impressions_fields );
}

if ( ! empty( $shooting_checkup_fields ) ) {
	get_template_part( 'parts/prose-block', 'default', $shooting_checkup_fields );
}

if ( ! empty( $shooting_advertisement_banner_fields ) ) {
	get_template_part(
		'parts/banner-call-to-action',
		'',
		array(
			'page_fields' => $shooting_advertisement_banner_fields,
			'css_class'   => 'ads-banner',
		)
	);
}

if ( ! empty( $shooting_advertisement_impressions_fields ) ) {
	get_template_part( 'parts/gallery-slider', '', $shooting_advertisement_impressions_fields );
}


if ( ! empty( $shooting_info_fields ) ) {
	get_template_part( 'parts/prose-block', 'default', $shooting_info_fields );
}

if ( ! empty( $shooting_products_fields ) ) {
	get_template_part( 'parts/teaser-slider-products', 'products', $shooting_products_fields );
}

get_template_part( 'parts/footer-default' );

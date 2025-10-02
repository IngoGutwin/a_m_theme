<?php
/**
 * Template Name: shooting page
 * Template Post Type: page
 *
 * @package a_m_theme
 */

$page_id = get_the_ID();

$page_fields = get_page_fields( $page_id );

get_template_part( 'parts/header-default', 'default' );

get_template_part( 'parts/navbar' );

get_template_part(
	'parts/banner-call-to-action',
	'',
	array(
		'page_fields' => $page_fields['Hero Section Shooting'],
		'css_class'   => 'banner',
	)
);

get_template_part( 'parts/prose-block', 'default', $page_fields['Shooting Prices'] );

get_template_part( 'parts/gallery-slider', '', $page_fields['Shooting Impressions'] );

get_template_part( 'parts/teaser-slider-products', 'products', $page_fields['Shooting Products'] );

get_template_part( 'parts/prose-block', 'default', $page_fields['Shooting Checkup'] );

get_template_part(
	'parts/banner-call-to-action',
	'',
	array(
		'page_fields' => $page_fields['Family Shooting Ad'],
		'css_class'   => 'ads-banner',
	)
);

get_template_part( 'parts/gallery-slider', '', $page_fields['Shooting Advertisement Impressions'] );

get_template_part( 'parts/prose-block', 'default', $page_fields['Shooting Infos'] );

get_template_part( 'parts/footer-default', 'default' );

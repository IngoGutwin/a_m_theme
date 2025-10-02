<?php
/**
 * Template Name: landing page
 * Template Post Type: page
 *
 * @package a_m_theme
 */

$page_id = get_the_ID();

$page_fields = get_page_fields( $page_id );

get_template_part( 'parts/header-default', 'default' );

get_template_part( 'parts/navbar' );

get_template_part( 'parts/banner-call-to-action', '', $page_fields['Hero Section'] );

get_template_part( 'parts/teaser-slider-products', 'products', $page_fields['Product Teaser'] );

get_template_part( 'parts/prose-block', 'default', $page_fields['Teaser Prose Block'] );

get_template_part( 'parts/gallery-slider', '', $page_fields['Impressions Gallery One'] );

get_template_part( 'parts/prose-block', 'default', $page_fields['Info Call to Action'] );

get_template_part( 'parts/banner-call-to-action', '', $page_fields['Call to Action Banner'] );

get_template_part( 'parts/prose-block', 'default', $page_fields['Call to Action Banner Message'] );

get_template_part( 'parts/gallery-slider', '', $page_fields['Impressions Gallery Two'] );

get_template_part( 'parts/prose-block', 'default', $page_fields['Advertisment Seo Block'] );

get_template_part( 'parts/footer-default', 'default' );

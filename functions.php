<?php
/**
 * Theme Functions.
 *
 * Bootstrap for enqueuing scripts, styles, and registering ACF blocks.
 *
 * @package a_m_theme
 */

require_once get_template_directory() . '/include/acf-loader-helpers.php';
require_once get_template_directory() . '/include/svg-sanitizer.php';
require_once get_template_directory() . '/include/logo.php';

add_theme_support( 'post-thumbnails' );

/**
 * Enqueue script for coockie banner.
 *
 * @return void
 */
function am_theme_enqueue_ccm19_script(): void {
	wp_enqueue_script(
		'ccm19-app',
		COOKIE_API_URL,
		array(),
		null,
		false
	);
	add_filter(
		'script_loader_tag',
		function ( $tag, $handle ) {
			if ( $handle === 'ccm19-app' ) {
				return str_replace( '<script ', '<script referrerpolicy="origin" ', $tag );
			}
			return $tag;
		},
		10,
		2
	);
}

/**
 * Enqueue scripts and styles for production build.
 *
 * @return void
 */
function am_theme_enqueue_production_scripts(): void {
	$json_manifest = json_decode( file_get_contents( get_template_directory() . '/dist/.vite/manifest.json' ), true );

	$entries = array(
		'entry_js'          => $json_manifest['resources/app/base.ts'] ?? array(),
		'appoinment_script' => $json_manifest['resources/app/appoinment.entry.ts'] ?? array(),
	);

	$entry_css = $json_manifest['resources/css/main.css'];

	am_theme_enqueue_ccm19_script();

	foreach ( $entries as $entry ) {
		wp_enqueue_script_module( $entry['name'], get_theme_file_uri( '/dist/' ) . $entry['file'], array(), null );
	}

	wp_enqueue_style( 'main', get_theme_file_uri( '/dist/' ) . $entry_css['file'], array(), null );
}

/**
 * Enqueue scripts and styles for development mode (Vite dev server).
 *
 * @return void
 */
function am_theme_enqueue_development_scripts(): void {
	$resources_path = '/resources';
	$id_vite_client = 'vite-client';
	$vite_host_url  = 'http://localhost:5173';
	wp_enqueue_script_module( $id_vite_client, $vite_host_url . '/@vite/client', array(), null );
	wp_enqueue_script_module( 'base', $vite_host_url . $resources_path . '/app/base.ts', array(), null );
	wp_enqueue_script_module( 'appoinment', $vite_host_url . $resources_path . '/app/appoinment.entry.ts', array(), null );
	wp_enqueue_style( 'main', $vite_host_url . $resources_path . '/css/main.css', array(), null );
}

/**
 * Enqueue scripts depending on the current environment.
 *
 * @return void
 */
function am_theme_handle_scripts(): void {
	if ( WP_ENVIRONMENT === 'production' ) {
		am_theme_enqueue_production_scripts();
	} else {
		am_theme_enqueue_development_scripts();
	}
}
add_action( 'wp_enqueue_scripts', 'am_theme_handle_scripts' );

/**
 * Load ACF blocks and register custom field groups for landing page template.
 *
 * @return void
 */
function load_acf_fields_front_page(): void {
	$location_value = 'front-page.php';
	$location_param = 'page_template';
	generate_banner_cta_section( 'Hero Section', $location_value, $location_param, 0 );
	generate_teaser_slides( 'Product Teaser Slides', 10, $location_value, $location_param, 1 );
	generate_prose_block( 'Offer Prose Block', $location_value, $location_param, 2 );
	generate_gallery_slider( 'Impressions Gallery One', 10, $location_value, $location_param, 3 );
	generate_prose_block( 'Impressions Prose Block', $location_value, $location_param, 4 );
	generate_banner_cta_section( 'Call to Action Banner', $location_value, $location_param, 5 );
	generate_prose_block( 'Call to Action Banner Message', $location_value, $location_param, 6 );
	generate_gallery_slider( 'Impressions Gallery Two', 10, $location_value, $location_param, 7 );
	generate_prose_block( 'Advertisement Seo Block', $location_value, $location_param, 8 );
}

/**
 * Load ACF blocks and register custom field groups for shooting page template.
 *
 * @return void
 */
function load_acf_fields_shooting_page(): void {
	$location_value = 'shooting';
	$location_param = 'post_type';
	generate_banner_cta_section( 'Hero Section Shooting', $location_value, $location_param, 0 );
	generate_prose_block( 'Shooting Prices', $location_value, $location_param, 1 );
	generate_gallery_slider( 'Shooting Impressions Gallery', 10, $location_value, $location_param, 2 );
	generate_prose_block( 'Shooting Checkup List', $location_value, $location_param, 3 );
	generate_banner_cta_section( 'Shooting Advertisement Banner', $location_value, $location_param, 4 );
	generate_gallery_slider( 'Shooting Advertisement Impressions', 10, $location_value, $location_param, 5 );
	generate_prose_block( 'Shooting Infos Prose Block', $location_value, $location_param, 6 );
	generate_teaser_slides( 'Shooting Products Teaser Slides', 10, $location_value, $location_param, 7 );
}

/**
 * Load ACF blocks and register custom field groups for blog post page template.
 *
 * @return void
 */
function load_acf_fields_blog_post_page(): void {
	$location_value = 'post';
	$location_param = 'post_type';
	generate_banner_cta_section( 'Hero Section Post', $location_value, $location_param, 0 );
	generate_prose_block( 'Blog Post Main Content', $location_value, $location_param, 1 );
	generate_gallery_slider( 'Gallery Slider Blog Post', 10, $location_value, $location_param, 2 );
}

/**
 * Load ACF blocks and register custom field groups for contact page template.
 *
 * @return void
 */
function load_acf_fields_contact_page(): void {
	$location_value = 'page-contact.php';
	$location_param = 'page_template';
	generate_banner_cta_section( 'Hero Section Contact', $location_value, $location_param, 0 );
	generate_prose_block( 'Contact Description', $location_value, $location_param, 1 );
}

/**
 * Load ACF blocks and register custom field groups for archive shooting-page template.
 *
 * @return void
 */
function load_acf_fields_archive_shooting_page(): void {
	$location_value = 'archive-shooting.php';
	$location_param = 'page_template';
	generate_banner_cta_section( 'Hero Section Archive Shootings', $location_value, $location_param, 0 );
	generate_prose_block( 'Archive Seo Description', $location_value, $location_param, 1 );
}

/**
 * Load ACF blocks and register custom field groups for the blog template.
 *
 * @return void
 */
function load_acf_fields_archive_blog_page(): void {
	$location_value = 'posts_page';
	$location_param = 'page_type';
	generate_banner_cta_section( 'Hero Section Blog Page', $location_value, $location_param, 0 );
	generate_prose_block( 'Archive Seo Description', $location_value, $location_param, 1 );
}

/**
 * Load general ACF blocks and register custom field groups.
 *
 * @return void
 */
function load_general_acf_fields(): void {
	generate_footer_section( 'Footer Section' );
}

/**
 * Load ACF blocks and register custom field groups.
 *
 * @return void
 */
function load_acf_fields(): void {
	/**
	 * Register the modules here
	 */
	$acf_modules = array(
		'banner-call-to-action',
		'product-teaser',
		'prose-block',
		'gallery-slider',
		'footer',
	);
	include_acf_modules( $acf_modules );

	load_general_acf_fields();
	load_acf_fields_archive_shooting_page();
	load_acf_fields_archive_blog_page();
	load_acf_fields_blog_post_page();
	load_acf_fields_front_page();
	load_acf_fields_shooting_page();
	load_acf_fields_contact_page();
}


add_action( 'acf/init', 'load_acf_fields' );

/**
 * Register custom post type for shootings
 */
function shooting_post_type() {
	$labels = array(
		'name'          => 'Shootings',
		'singular_name' => 'Shooting',
		'menu_name'     => 'Shootings',
		'add_new'       => 'Neues Shooting',
		'add_new_item'  => 'Neues Shooting hinzufügen',
		'edit_item'     => 'Shooting bearbeiten',
		'new_item'      => 'Neues Shooting',
		'view_item'     => 'Shooting ansehen',
		'search_items'  => 'Shootings durchsuchen',
		'not_found'     => 'Keine Shootings gefunden',
	);

	$args = array(
		'labels'       => $labels,
		'public'       => true,
		'menu_icon'    => 'dashicons-camera',
		'rewrite'      => array(
			'slug'       => 'fotoshootings-preise',
			'with_front' => false,
		),
		'supports'     => array( 'title', 'thumbnail', 'excerpt' ),
		'show_in_rest' => true,
	);

	register_post_type( 'shooting', $args );
}
add_action( 'init', 'shooting_post_type' );

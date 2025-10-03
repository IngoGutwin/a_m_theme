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

/**
 * Enqueue scripts and styles for production build.
 *
 * Reads the Vite manifest.json and registers the bundled assets.
 *
 * @return void
 */
function am_theme_enqueue_production_scripts(): void {
	$json_manifest = json_decode( file_get_contents( get_template_directory() . '/dist/.vite/manifest.json' ), true );
	$entry_assets  = $json_manifest['resources/app/index.ts'];
	$entry_css     = $entry_assets['css'];
	wp_enqueue_script_module( $entry_assets['name'], get_theme_file_uri( '/dist/' ) . $entry_assets['file'], array(), null );
	wp_enqueue_style( $entry_assets['name'], get_theme_file_uri( '/dist/' ) . $entry_css[0], array(), null );
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
	wp_enqueue_script_module( 'index', $vite_host_url . $resources_path . '/app/index.ts', array(), null );
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
 * Allow SVG uploads in WordPress.
 *
 * @param array<string,string> $svg_mime Existing mime types.
 * @return array<string,string> Modified mime types with SVG support.
 */
function allow_svg( $svg_mime ) {
	$svg_mime['svg'] = 'image/svg+xml';
	return $svg_mime;
}
add_filter( 'upload_mimes', 'allow_svg' );

/**
 * Load ACF blocks and register custom field groups for landing page template.
 *
 * @return void
 */
function load_acf_fields_landing_page(): void {
	$template_name = 'page-landing';
	generate_banner_cta_section( 'Hero Section', $template_name );
	generate_teaser_slides( 'Product Teaser', 10, $template_name );
	generate_prose_block_teaser( 'Teaser Prose Block', $template_name );
	generate_gallery_slider( 'Impressions Gallery One', 10, $template_name );
	generate_prose_block_teaser( 'Info Call to Action', $template_name );
	generate_banner_cta_section( 'Call to Action Banner', $template_name );
	generate_prose_block_teaser( 'Call to Action Banner Message', $template_name );
	generate_gallery_slider( 'Impressions Gallery Two', 10, $template_name );
	generate_prose_block_teaser( 'Advertisement Seo Block', $template_name );
	generate_footer_section( 'Footer Section' );
}

/**
 * Load ACF blocks and register custom field groups for shooting page template.
 *
 * @return void
 */
function load_acf_fields_shooting_page(): void {
	$template_name = 'page-shooting';
	generate_banner_cta_section( 'Hero Section Shooting', $template_name );
	generate_prose_block_teaser( 'Shooting Prices', $template_name );
	generate_gallery_slider( 'Shooting Impressions', 10, $template_name );
	generate_teaser_slides( 'Shooting Products', 10, $template_name );
	generate_prose_block_teaser( 'Shooting Checkup', $template_name );
	generate_banner_cta_section( 'Shooting Advertisement Banner', $template_name );
	generate_gallery_slider( 'Shooting Advertisement Impressions', 10, $template_name );
	generate_prose_block_teaser( 'Shooting Infos', $template_name );
}

/**
 * Load ACF blocks and register custom field groups for landing page template.
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

	load_acf_fields_landing_page();
	load_acf_fields_shooting_page();
}


add_action( 'acf/init', 'load_acf_fields' );

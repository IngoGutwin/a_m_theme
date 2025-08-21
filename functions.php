<?php
/**
 * Theme Functions.
 *
 * Bootstrap for enqueuing scripts, styles, and registering ACF blocks.
 *
 * @package a_m_theme
 */

require_once get_template_directory() . '/include/acf-loader-helpers.php';

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
 * Load ACF blocks and register custom field groups.
 *
 * @return void
 */
function load_acf_blocks(): void {
	/**
	 * Register the modules here
	 */
	$acf_modules = array(
		'hero-section',
		'product-teaser',
	);
	include_acf_modules( $acf_modules );
	/**
	 * Generate the acf-blocks
	 */
	generate_hero_section( 'Hero Section' );
	generate_teaser_slides( 'Product Teaser', 5 );
}
add_action( 'acf/init', 'load_acf_blocks' );

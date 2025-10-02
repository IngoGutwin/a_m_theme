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
 * Load ACF blocks and register custom field groups for landing page template.
 *
 * @return void
 */
function load_acf_blocks_landing_page(): void {
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

	generate_banner_cta_section( 'Hero Section' );
	generate_teaser_slides( 'Product Teaser', 10 );
	generate_prose_block_teaser( 'Teaser Prose Block' );
	generate_gallery_slider( 'Impressions Gallery One', 10 );
	generate_prose_block_teaser( 'Info Call to Action' );
	generate_banner_cta_section( 'Call to Action Banner' );
	generate_prose_block_teaser( 'Call to Action Banner Message' );
	generate_gallery_slider( 'Impressions Gallery Two', 10 );
	generate_prose_block_teaser( 'Advertisment Seo Block' );
	generate_footer_section( 'Footer Section' );
}

/**
 * Return the requested URL.
 *
 * @return string
 */
function get_current_url(): string {
	$scheme = is_ssl() ? 'https://' : 'http://';
	$host   = '';
	if ( isset( $_SERVER['HTTP_HOST'] ) ) {
		$host = sanitize_text_field( wp_unslash( $_SERVER['HTTP_HOST'] ) );
	}
	$uri = '';
	if ( isset( $_SERVER['REQUEST_URI'] ) ) {
		$uri = esc_url_raw( wp_unslash( $_SERVER['REQUEST_URI'] ) );
	}
	return $scheme . $host . $uri;
}

/**
 * Calls the associated acf function which load the acf-fields.
 *
 * @param string $file_name The requested filename.
 * @return void
 */
function call_acf_loading_functions( $file_name ): void {
	if ( str_contains( $file_name, 'page-landing' ) ) {
		load_acf_blocks_landing_page();
	}
}

/**
 * Check if is_admin and call the acf loading functions.
 *
 * @return void
 */
function handle_acf_loading_behaivior(): void {
	if ( is_admin() ) {
		load_acf_blocks_landing_page();
	} else {
		$requested_template_file_name = get_page_template_slug( url_to_postid( get_current_url() ) );
		call_acf_loading_functions( $requested_template_file_name );
	}
}

add_action( 'acf/init', 'handle_acf_loading_behaivior' );

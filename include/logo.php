<?php
if ( ! function_exists( 'get_am_theme_logo' ) ) {
	/**
	 * Return the svg logo.
	 */
	function get_am_theme_logo() {
		$logo_path    = get_template_directory() . '/resources/images/logo.svg';
		$logo_content = file_get_contents( $logo_path );
		$clean_logo   = am_theme_sanitize_svg_markup( $logo_content );
		echo $clean_logo;
	}
}

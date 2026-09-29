<?php
if ( ! function_exists( 'get_am_theme_logo' ) ) {
	/**
	 * Return the svg logo.
	 */

	function get_am_theme_logo() {

        $logo_url = '';

        if (WP_ENVIRONMENT === 'development') {
            $logo_url = '/build/assets/images/logo.svg';
        } else {
            $logo_url = '/assets/images/logo.svg';
        }

		$logo_path    = get_template_directory() . $logo_url;
		$logo_content = file_get_contents( $logo_path );
		$clean_logo   = am_theme_sanitize_svg_markup( $logo_content );
		echo $clean_logo;
	}
}

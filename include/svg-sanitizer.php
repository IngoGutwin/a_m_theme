<?php
if ( ! function_exists( 'am_theme_sanitize_svg_markup' ) ) {

	/**
	 * Sanitize svg-markup for save output.
	 *
	 * @param string $svg_string raw svg markup.
	 * @return string sanitized svg markup.
	 */
	function am_theme_sanitize_svg_markup( $svg_string ) {
		if ( ! class_exists( '\enshrined\svgSanitize\Sanitizer' ) ) {
			return $svg_string;
		}

		$sanitizer = new \enshrined\svgSanitize\Sanitizer();

		$clean_svg = $sanitizer->sanitize( $svg_string );

		if ( $clean_svg === false ) {
			return '';
		}

		return $clean_svg;
	}
}

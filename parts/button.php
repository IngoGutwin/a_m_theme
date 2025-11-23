<?php
/**
 * Button html part
 *
 * @package Theme a_m_theme
 */

/** @var array $args {
 * css_class?: string,
 * button_text?: string,
 * button_url?: string,
 * }
 * */

$css_class   = $args['css_class'];
$button_text = $args['button_text'];
$button_url  = $args['button_url'];
?>
<button
	class="<?php echo esc_html( $css_class ); ?>"
	data-target-url="<?php echo esc_html( $button_url ); ?>">
	<?php echo esc_html( $button_text ); ?>
</button>

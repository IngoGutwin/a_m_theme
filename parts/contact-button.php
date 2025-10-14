<?php
/**
 * Button html part
 *
 * @package Theme a_m_theme
 */
$css_class   = $args['css_class'];
$button_text = $args['button_text'];
?>
<button class="<?php echo esc_html( $css_class ); ?>"><?php echo esc_html( $button_text ); ?></button>

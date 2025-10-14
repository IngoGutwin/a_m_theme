<?php
/**
 * Banner section html part
 *
 * @package Theme a_m_theme
 */

$section           = $args['page_fields'];
$field_group_title = $section['field_group_title'];
$hash              = $section['group_hash'] ?? '';
$css_class         = $args['css_class'] ?? '';
$banner_title      = $section[ "title_{$hash}" ] ?? '';
$sub_title         = $section[ "sub_title_{$hash}" ] ?? '';
$description       = $section[ "description_{$hash}" ] ?? '';
$button_text       = $section[ "button_text_{$hash}" ] ?? '';
$bg_image_xl       = isset( $section[ "bg_image_xl_{$hash}" ] ) ? $section[ "bg_image_xl_{$hash}" ] . ' 1448w' : '';
$bg_image_sm       = isset( $section[ "bg_image_sm_{$hash}" ] ) ? $section[ "bg_image_sm_{$hash}" ] . ' 558w' : '';
?>
<!-- <?php echo esc_html( $field_group_title ); ?> start -->
<section class="<?php echo esc_html( $css_class ); ?>">
	<picture>
		<source media="(min-width:465px)" type="image/jpeg" srcset="<?php echo esc_html( $bg_image_sm ); ?>">
		<source media="(max-width:465px)" type="image/jpeg" srcset="<?php echo esc_html( $bg_image_xl ); ?>">
		<img srcset="<?php echo esc_html( implode( ', ', array( $bg_image_sm, $bg_image_xl ) ) ); ?>" src="<?php echo esc_html( $bg_image_xl ); ?>" alt="" />
	</picture>

	<?php
	if ( ! empty( $button_text ) ) {
		get_template_part(
			'parts/contact-button',
			'',
			array(
				'button_text' => $button_text,
				'css_class'   => 'book-appointment-btn',
			)
		);
	}
	?>

	<div class="banner-intro">
	<?php
	if ( ! empty( $banner_title ) ) {
		?>
			<h1><?php echo esc_html( $banner_title . ' ' . $sub_title ); ?></h1>
		<?php
	}
	if ( ! empty( $sub_title ) ) {
		?>
			<h2><?php echo esc_html( $sub_title ); ?></h2>
		<?php
	}
	if ( ! empty( $description ) ) {
		?>
			<?php echo wp_kses_post( $description ); ?>
		<?php
	}
	?>
	</div>
</section>

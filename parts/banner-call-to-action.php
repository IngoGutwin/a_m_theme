<?php
/**
 * Banner section html part
 *
 * @package Theme a_m_theme
 */

$section      = $args['page_fields'];
$hash         = $section['group_hash'];
$css_class    = $args['css_class'];
$banner_title = $section[ "title_{$hash}" ] ?? '';
$sub_title    = $section[ "sub_title_{$hash}" ] ?? '';
$button_text  = $section[ "button_text_{$hash}" ] ?? '';
$bg_image_sm  = $section[ "bg_image_sm_{$hash}" ] . ' 558w' ?? '';
$bg_image_xl  = $section[ "bg_image_xl_{$hash}" ] . ' 1448w' ?? '';
?>
<!-- banner section start -->
<section class="<?php echo esc_html( $css_class ); ?>">
	<picture>
		<source media="(min-width:465px)" type="image/jpeg" srcset="<?php echo esc_html( $bg_image_sm ); ?>">
		<source media="(max-width:465px)" type="image/jpeg" srcset="<?php echo esc_html( $bg_image_xl ); ?>">
		<img srcset="<?php echo esc_html( implode( ', ', array( $bg_image_sm, $bg_image_xl ) ) ); ?>" src="<?php echo esc_html( $bg_image_xl ); ?>" alt="" />
	</picture>

	<?php
	if ( ! empty( $button_text ) ) {
		?>
		<button class="book-appointment-btn"><?php echo esc_html( $button_text ); ?></button>

		<?php
	}
	?>

	<div class="banner-intro">
	<?php
	if ( ! empty( $banner_title ) ) {
		?>
			<h1><?php echo esc_html( $banner_title ); ?></h1>
		<?php
	}
	if ( ! empty( $sub_title ) ) {
		?>
			<?php echo wp_kses_post( $sub_title ); ?>
		<?php
	}
	?>
	</div>
</section>
<!-- banner section end -->

<?php
/**
 * Hero section html part
 *
 * @package Theme a_m_theme
 */

$hash         = $args['group_hash'];
$section      = $args;
$banner_title = $section[ "title_{$hash}" ] ?? '';
$sub_title    = $section[ "sub_title_{$hash}" ] ?? '';
$button_text  = $section[ "button_text_{$hash}" ] ?? '';
$bg_image_sm  = $section[ "bg_image_sm_{$hash}" ] . ' 558w' ?? '';
$bg_image_xl  = $section[ "bg_image_xl_{$hash}" ] . ' 1448w' ?? '';
?>
<!-- banner section start -->
<section class="banner">
	<picture>
		<source media="(min-width:465px)" type="image/jpeg" srcset="<?php echo esc_html( $bg_image_sm ); ?>">
		<source media="(max-width:465px)" type="image/jpeg" srcset="<?php echo esc_html( $bg_image_xl ); ?>">
		<img srcset="<?php echo esc_html( implode( ', ', array( $bg_image_sm, $bg_image_xl ) ) ); ?>" src="<?php echo esc_html( $bg_image_xl ); ?>" alt="Schwangere Shooting in Bonn von authentische Momente" />
	</picture>

	<button class="book-appointment-btn"><?php echo esc_html( $button_text ); ?></button>
	<?php
	if ( ! empty( $banner_title ) ) {
		?>
		<div class="banner-intro">
			<h1><?php echo esc_html( $banner_title ); ?></h1>
			<?php echo wp_kses_post( $sub_title ); ?>
		</div>
		<?php
	}
	?>
</section>
<!-- banner section end -->

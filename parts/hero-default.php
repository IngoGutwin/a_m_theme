<?php
/**
 * Hero section html part
 *
 * @package a_m_theme
 */

$hero_section = $args;

$hero_title       = $hero_section['hero_title'] ?? '';
$hero_sub_title   = $hero_section['hero_sub_title'] ?? '';
$hero_button_text = $hero_section['hero_button_text'] ?? '';
$hero_bg_image_sm = $hero_section['hero_bg_image_sm'] . ' 558w' ?? '';
$hero_bg_image_xl = $hero_section['hero_bg_image_xl'] . ' 1448w' ?? '';
?>
<!-- hero section start -->
<section class="hero" id="hero-section">
	<picture>
		<source media="(min-width:465px)" type="image/jpeg" srcset="<?php echo esc_html( $hero_bg_image_sm ); ?>">
		<source media="(max-width:465px)" type="image/jpeg" srcset="<?php echo esc_html( $hero_bg_image_xl ); ?>">
		<img srcset="<?php echo esc_html( implode( ', ', array( $hero_bg_image_sm, $hero_bg_image_xl ) ) ); ?>" src="<?php echo esc_html( $hero_bg_image_xl ); ?>" alt="Schwangere Shooting in Bonn von authentische Momente" />
	</picture>

	<button class="book-appointment-btn" id="hero-btn-appointment"><?php echo esc_html( $hero_button_text ); ?></button>
		<h1><?php echo esc_html( $hero_title ); ?></h1>
		<div class="hero-intro">
		<?php echo wp_kses_post( $hero_sub_title ); ?>
	</div>

</section>
<!-- hero section end -->

<?php
/**
 * Gallery Slider part for Photos
 *
 * @package Theme a_m_theme
 */
?>
<!-- Gallery slider section start -->
<section class="swiper gallery-section">
	<div class="swiper-wrapper">
		<?php
		$index = 1;
		foreach ( $args as $slide ) {
			if ( ! empty( $slide['image_url'] ) ) {
				?>
				<div class="swiper-slide gallery-slide">
					<picture>
						<source type="image/webp" srcset="<?php echo esc_html( $slide['image_url'] ); ?>" />
						<img loading="lazy" height="480" src="<?php echo esc_html( $slide['image_url'] ); ?>" srcset="<?php echo esc_html( $slide['image_url'] . ' 558w' ); ?>" />
					</picture>
				</div>
				<?php
					++$index;
			}
		}
		?>
	</div>
	<div class="swiper-button-prev">
	</div>
	<div class="swiper-button-next">
	</div>
</section>

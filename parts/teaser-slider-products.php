<?php
/**
 * Teaser Slider part for Products
 *
 * @package Theme a_m_theme
 */
?>
<!-- teaser slider section start -->
<section class="swiper teaser-section">
	<div class="swiper-wrapper">
		<?php
		// $index slide id.
		$index = 1;
		foreach ( $args as $slide ) {
			if ( ! empty( $slide['url'] ) ) {
				?>
			<div class="swiper-slide teaser-slide">
				<article>
					<a href="<?php echo esc_html( $slide['url'] ); ?>">
						<h2><?php echo esc_html( $slide['title'] ); ?></h2>
						<p><?php echo esc_html( $slide['sub_title'] ); ?></p>
					</a>
				</article>
				<picture>
					<source type="image/webp" srcset="<?php echo esc_html( $slide['image'] ); ?>" />
					<img src="<?php echo esc_html( $slide['image'] ); ?>" srcset="<?php echo esc_html( $slide['image'] . ' 558w' ); ?>" />
				</picture>
			</div>
				<?php
				// count up $index.
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
<!-- teaser slider section end -->

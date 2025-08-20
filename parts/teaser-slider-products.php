<?php
/**
 * Teaser Slider part for Products
 *
 * @package Theme authentische-momente
 */

$teaser_slider_data = $args;
?>
<!-- teaser slider section start -->
<section class="teaser-slider-products-section">
	<div class="teaser-slider-products-container" id="teaser-slider-products-container">
		<ul class="teaser-slider-products">
			<?php
			foreach ( $teaser_slider_data as $slide ) {
				if ( ! empty( $slide ) ) {
					?>
				<li class="product-slide">
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
				</li>
					<?php
				}
			}
			?>
		</ul>
		<button class="teaser-slider-products-btn-prev">
			<svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24">
				<path d="M15.41 7.41L14 6l-6 6 6 6 1.41-1.41L10.83 12z"></path>
			</svg>
		</button>
		<button class="teaser-slider-products-btn-next">
			<svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24">
				<path d="M10 6L8.59 7.41 13.17 12l-4.58 4.59L10 18l6-6z"></path>
			</svg>
		</button>
	</div>
</section>

<?php
/**
 * Teaser Slider part for Products
 *
 * @package Theme authentische-momente
 */

$teaser_slider_data = $args;
?>
<!-- teaser slider section start -->
<section class="product-teaser-slider-section">
	<div class="product-teaser-slider-container" id="product-teaser-slider-container">
		<ul class="product-teaser-slider">
			<?php
			foreach ( $teaser_slider_data as $slide ) {
				?>
				<li class="slide">
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
			<?php } ?>
		</ul>
	</div>
</section>
<!-- teaser slider section start -->

<?php
/**
 * Teaser Slider part for Products
 *
 * @package Theme a_m_theme
 */
$field_group_title = $args['field_group_title'] ?? '';
?>
<!-- <?php echo esc_html( $field_group_title ); ?> start -->
<section class="swiper teaser-section">
	<div class="swiper-wrapper">
		<?php
		// $index slide id.
		$index = 1;
		foreach ( $args as $slide ) {
			if ( ! empty( $slide['url'] ) ) {
				?>
				<div class="swiper-slide teaser-slide">
					<a href="<?php echo esc_html( $slide['url'] ); ?>">
						<article>
								<h3><?php echo esc_html( $slide['title'] ); ?></h3>
								<p><?php echo esc_html( $slide['sub_title'] ); ?></p>
						</article>
						<picture>
							<source type="image/webp" srcset="<?php echo esc_html( $slide['image'] ); ?>" />
							<img src="<?php echo esc_html( $slide['image'] ); ?>" srcset="<?php echo esc_html( $slide['image'] . ' 558w' ); ?>" />
						</picture>
					</a>
				</div>
				<?php
				// count up $index.
				++$index;
			}
		}
		?>
	</div>
	<div class="swiper-button-prev "></div>
	<div class="swiper-button-next"></div>
</section>

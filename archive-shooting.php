<?php
/**
 * Template Name: Archive Shooting
 *
 * @package a_m_theme
 */

$page_id = get_the_ID();

$page_fields = get_page_fields( $page_id );

$hero_section_fields = $page_fields['Hero Section Archive Shootings'] ?? array();

$seo_section_fields = $page_fields['Archive Seo Description'] ?? array();

get_template_part( 'parts/header-default', 'default' );

get_template_part(
	'parts/banner-call-to-action',
	'',
	array(
		'page_fields' => $hero_section_fields,
		'css_class'   => 'banner',
	)
);

$shootings = new WP_Query(
	array(
		'post_type'      => 'shooting',
		'posts_per_page' => -1,
	)
);

if ( $shootings->have_posts() ) {
	?>
		<!-- shootings archive start  -->
		<section class="archive">
			<ul class="archive-list">
				<?php
				while ( $shootings->have_posts() ) :
					$shootings->the_post();
					$the_post_id   = get_the_ID();
					$acf_fields    = get_page_fields( $the_post_id )['Hero Section Shooting'];
					$hash          = $acf_fields['group_hash'];
					$hero_title    = $acf_fields[ "title_{$hash}" ];
					$sub_title     = $acf_fields[ "sub_title_{$hash}" ];
					$thumbnail_url = get_the_post_thumbnail_url( $the_post_id, 'large' );
					?>
					<li>
						<a href="<?php echo esc_html( get_the_permalink( $the_post_id ) ); ?>">
							<article>
								<h3><?php echo esc_html( $hero_title ); ?></h3>
								<p><?php echo esc_html( $sub_title ); ?></p>
							</article>
							<picture>
								<source type="image/webp" srcset="<?php echo esc_html( $thumbnail_url ); ?>" />
								<?php
								the_post_thumbnail(
									$the_post_id,
									'large',
									array(
										'alt' => $hero_title,
									)
								)
								?>
							</picture>
						</a>
					</li>
					<?php
				endwhile;
				wp_reset_postdata();
				?>
			</ul>
		</section>
	<?php
}

get_template_part( 'parts/prose-block', 'default', $seo_section_fields );

get_template_part( 'parts/footer-default' );


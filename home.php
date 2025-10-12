<?php
/**
 * Template Name: Blog Page Template
 * Template Post Type: page
 *
 * @package a_m_theme
 */

$page_id = get_option( 'page_for_posts' );

$page_fields = get_page_fields( $page_id );

$hero_section_fields = $page_fields['Hero Section Blog Page'];

get_template_part( 'parts/header-default', 'default' );

get_template_part( 'parts/navbar' );

$args = array(
	'post_type'      => 'post',
	'posts_per_page' => 10,
);

get_template_part(
	'parts/banner-call-to-action',
	'',
	array(
		'page_fields' => $hero_section_fields,
		'css_class'   => 'banner',
	)
);

$query = new WP_Query( $args );

if ( $query->have_posts() ) :
	?>
	<section class="archive">
		<ul class="archive-list">
			<?php
			while ( $query->have_posts() ) :
				$query->the_post();
				$the_post_id              = get_the_ID();
				$post_hero_section_fields = get_page_fields( $the_post_id )['Hero Section Post'];
				$group_hash               = $post_hero_section_fields['group_hash'];
				$sub_title                = $post_hero_section_fields[ "sub_title_{$group_hash}" ];
				?>
					<li>
						<a href="<?php echo esc_html( get_permalink() ); ?>">
							<article>
								<h2><?php echo esc_html( the_title() ); ?></h2>
								<p><?php echo esc_html( $sub_title ); ?></p>
							</article>
							<picture>
								<?php esc_html( the_post_thumbnail() ); ?>
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
endif;


get_template_part( 'parts/footer-default' );


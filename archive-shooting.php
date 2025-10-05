<?php
/**
 * Archive for shooting post type.
 *
 * @package a_m_theme
 */

$page_id = get_the_ID();

$page_fields = get_page_fields( $page_id );

get_template_part( 'parts/header-default', 'default' );

get_template_part( 'parts/navbar' );

if ( have_posts() ) {
	?>
		<section>
			<?php
			while ( have_posts() ) :
				the_post();
				$acf_fields = get_page_fields( get_the_ID() )['Hero Section Shooting'];
				$hash       = $acf_fields['group_hash'];
				$hero_title = $acf_fields[ "title_{$hash}" ];
				$sub_title  = $acf_fields[ "sub_title_{$hash}" ];
				$thumbnail  = $acf_fields[ "bg_image_sm_{$hash}" ];
				?>
				<article>
					<h2><?php echo esc_html( $hero_title ); ?></h2>
					<p><?php echo esc_html( $sub_title ); ?></p>
					<img src="<?php echo esc_html( $thumbnail ); ?>" />
				</article>
		</section>
				<?php
			endwhile;
}

get_template_part( 'parts/footer-default' );


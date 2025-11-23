<?php
/**
 * Navigation html part
 *
 * @package Theme a_m_theme
 */

$shooting_menu_items   = wp_get_nav_menu_items( 'Shootings' ) ?? array();
$navigation_menu_items = wp_get_nav_menu_items( 'Navigation' ) ?? array();
$shootings_url         = $shooting_menu_items[0]->url;
?>
<!-- nav bar start -->
<nav class="navbar">
	<div>
	<a href="<?php echo esc_html( home_url() ); ?>">
		<div class="logo"><?php get_am_theme_logo(); ?></div>
	</a>
	</div>

	<div class="nav-right" id="navbar-right">
		<a href="<?php echo esc_html( $shootings_url ); ?>">
			Foto-Shootings
		</a>

		<div class="hamburger" id="navbar-toggle" data-is-toggled="false">
			<div></div>
			<div></div>
			<div></div>
		</div>

		<ul
			class="navigation"
			id="navigation-links"
			data-is-toggled="false"
			<?php
			foreach ( $navigation_menu_items as $item ) {
				if ( 'home' === $item->post_title ) {
					continue;
				}
				?>
			<li>
				<a href="<?php echo esc_html( $item->url ); ?>"><?php echo esc_html( $item->title ); ?></a>
			</li>
			<?php } ?>
		</ul>
	</div>
</nav>

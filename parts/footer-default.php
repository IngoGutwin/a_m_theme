<?php
/**
 * Footer html part
 *
 * @package a_m_theme
 */

$front_page_id = get_option( 'page_on_front' );

$footer_fields = get_page_fields( $front_page_id )['Footer Section'];
$field_group_title = $footer_fields['field_group_title'];
$hash      = $footer_fields['group_hash'] ?? '';
$instagram = $footer_fields[ "instagram_{$hash}" ] ?? '';
$facebook  = $footer_fields[ "facebook_{$hash}" ] ?? '';
$impressum = $footer_fields[ "impressum_{$hash}" ] ?? '';
$gdpr      = $footer_fields[ "gdpr_{$hash}" ] ?? '';
$contact   = $footer_fields[ "contact_{$hash}" ] ?? '';
?>

</main>
<!-- <?php echo esc_html( $field_group_title ); ?> start -->
	<footer class="footer">
		<div class="footer-container">
			<div class="social">
				<div class="logo">
					<a href="<?php echo esc_html( home_url() ); ?>">
						<div class="logo"><?php get_am_theme_logo(); ?></div>
					</a>
				</div>
				<ul class="media">
					<li><a href="<?php echo esc_html( $facebook ); ?>">
						<svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32" fill="none" aria-hidden="true">
						<path d="M31.283 16c0-8.563-6.937-15.5-15.5-15.5C7.221.5.283 7.438.283 16c0 7.736 5.668 14.149 13.078 15.313V20.48H9.424V16h3.937v-3.415c0-3.884 2.313-6.03 5.855-6.03 1.696 0 3.47.303 3.47.303v3.812H20.73c-1.925 0-2.526 1.195-2.526 2.42V16h4.299l-.688 4.48h-3.61v10.832C25.615 30.15 31.282 23.736 31.282 16Z" fill="currentColor"></path>
						</svg>
					</a></li>
					<li><a href="<?php echo esc_html( $instagram ); ?>">
						<svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32" fill="none" aria-hidden="true">
						<path d="M16.011 8.812a7.17 7.17 0 0 0-7.182 7.182 7.17 7.17 0 0 0 7.181 7.18 7.169 7.169 0 0 0 7.182-7.18 7.172 7.172 0 0 0-7.18-7.182Zm0 11.85a4.677 4.677 0 0 1-4.67-4.668 4.673 4.673 0 0 1 4.67-4.669 4.673 4.673 0 0 1 4.668 4.669c0 2.575-2.1 4.669-4.668 4.669v-.001Zm9.15-12.142a1.672 1.672 0 0 1-2.605 1.393A1.674 1.674 0 1 1 25.16 8.52Zm4.756 1.7c-.107-2.244-.619-4.232-2.263-5.869-1.637-1.638-3.625-2.15-5.869-2.263-2.312-.13-9.243-.13-11.556 0-2.237.107-4.225.62-5.868 2.257-1.644 1.637-2.15 3.625-2.263 5.869-.13 2.312-.13 9.243 0 11.556.106 2.243.62 4.231 2.263 5.869 1.643 1.637 3.625 2.15 5.868 2.262 2.313.131 9.244.131 11.556 0 2.244-.106 4.232-.619 5.87-2.262 1.637-1.638 2.15-3.626 2.262-5.87.131-2.312.131-9.237 0-11.55v.001ZM26.93 24.25a4.726 4.726 0 0 1-2.662 2.663c-1.844.73-6.219.562-8.256.562-2.038 0-6.42.162-8.257-.563a4.726 4.726 0 0 1-2.662-2.662c-.732-1.844-.563-6.219-.563-8.256 0-2.038-.162-6.42.563-8.257a4.727 4.727 0 0 1 2.662-2.662c1.844-.731 6.22-.563 8.257-.563s6.418-.162 8.256.563a4.728 4.728 0 0 1 2.662 2.662c.732 1.844.563 6.22.563 8.257s.168 6.419-.563 8.256Z" fill="currentColor"></path>
						</svg>
					</a></li>
				</ul>
			</div>
			<ul class="info">
				<li><a href="<?php echo esc_html( $gdpr ); ?>">Datenschutz</a></li>
				<li><a href="<?php echo esc_html( $impressum ); ?>">Impressum</a></li>
				<li><a href="<?php echo esc_html( $contact ); ?>">Kontakt</a></li>
			</ul>
			<p class="copyright">
				©
				<?php echo esc_html( gmdate( 'Y' ) ); ?> Ina Gutwin
				<br>
				Alle Rechte vorbehalten. Alle Preise verstehen sich inkl. MwSt
			</p>
		</div>
	</footer>
	<?php wp_footer(); ?>
</body>

</html>

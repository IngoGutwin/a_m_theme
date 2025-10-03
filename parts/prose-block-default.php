<?php
/**
 * Prose Block part.
 *
 * @package Theme a_m_theme
 */
$prose_hash        = $args['group_hash'] ?? '';
$prose_title       = $args[ "title_{$prose_hash}" ] ?? '';
$prose_description = $args[ "description_{$prose_hash}" ] ?? '';
?>
<!-- prose block section start -->
<section class="prose-block">
	<?php
	if ( ! empty( $prose_title ) ) {
		?>
			<h2>
				<?php echo esc_html( $prose_title ); ?>
			</h2>
		<?php
	}
	?>
	<?php
	if ( ! empty( $prose_description ) ) {
		echo wp_kses_post( $prose_description );
	}
	?>
</section>
<!-- prose block section end -->

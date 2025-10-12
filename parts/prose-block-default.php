<?php
/**
 * Prose Block part.
 *
 * @package Theme a_m_theme
 */
$field_group_title = $args['field_group_title'] ?? '';
$prose_hash        = $args['group_hash'] ?? '';
$prose_title       = $args[ "title_{$prose_hash}" ] ?? '';
$prose_description = $args[ "description_{$prose_hash}" ] ?? '';
?>
<!-- <?php echo esc_html( $field_group_title ); ?> start -->
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

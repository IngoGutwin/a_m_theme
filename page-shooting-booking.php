<?php
/**
 * Template Name: Shooting Booking Page
 * Template Post Type: page
 *
 * @package a_m_theme
 */

$page_id = get_the_ID();

$page_fields = get_page_fields( $page_id );

$footer_section = $page_fields['Footer Section'] ?? array();

get_template_part( 'parts/header-default', '', array( 'shooting_booking_page' => true ) );

?>

<section id="shooting-appoinment-booking-section"></section>

</main>
<?php wp_footer(); ?>
</body>

</html>

<?php
/**
 * Header html part
 *
 * @package a_m_theme
 */
$shooting_booking_page       = $args['shooting_booking_page'] ?? false;
$global_javascript_variables = array();
?>

<!DOCTYPE html>
<html lang="de">

<head>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta charset="UTF-8">
	<title><?php echo esc_html( wp_get_document_title() ); ?></title>
	<?php wp_head(); ?>
</head>

<body>
	<?php
	if ( $shooting_booking_page ) {
		get_template_part( 'parts/shop-navbar' );
	} else {
		get_template_part( 'parts/navbar' );
	}
	?>
<main id="app">
	<?php
	if ( ! empty( $global_javascript_variables ) ) {
		?>
			data-global-variables="<?php echo esc_attr( wp_json_encode( $global_javascript_variables ) ); ?>">
		<?php
	}
	?>

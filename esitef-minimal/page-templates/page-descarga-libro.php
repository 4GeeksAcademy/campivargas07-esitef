<?php
/**
 * Template Name: Descarga libro
 * Template Post Type: page
 *
 * @package esitef-minimal
 */

$queried = get_queried_object();
$match   = ( $queried instanceof WP_Post ) ? esitef_get_libro_by_form_slug( $queried->post_name ) : null;
if ( ! $match ) {
	wp_safe_redirect( home_url( '/libros/' ) );
	exit;
}

$libro_key = $match['key'];
$book      = $match['book'];
$success   = isset( $_GET['enviado'] ) && '1' === $_GET['enviado']; // phpcs:ignore WordPress.Security.NonceVerification.Recommended
$error     = isset( $_GET['error'] ) && '1' === $_GET['error']; // phpcs:ignore WordPress.Security.NonceVerification.Recommended
$pdf_url   = $success ? esitef_get_libro_pdf_url( $libro_key ) : '';

get_header();
?>
<main id="main" class="site-wrapper descarga-libro-page">
<?php
get_template_part(
	'template-parts/pages/descarga-libro',
	'form',
	array(
		'libro_key' => $libro_key,
		'book'      => $book,
		'success'   => $success,
		'error'     => $error,
		'pdf_url'   => $pdf_url,
	)
);
?>
</main>
<?php
get_footer();

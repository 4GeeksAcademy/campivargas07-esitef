<?php
/**
 * Libros — catálogo y formularios de descarga.
 *
 * @package esitef-minimal
 */

/**
 * Registro de libros (ponytail: una fuente; pdf vía filtro o assets/libros/{slug}.pdf).
 *
 * @return array<string, array<string, string>>
 */
function esitef_get_libros() {
	$libros = array(
		'69-ideas' => array(
			'title'      => '69 ideas desde la evidencia para la práctica clínica de los fisioterapeutas',
			'image'      => 'https://esitef.com/online/wp-content/uploads/2026/02/69-ideas.jpg',
			'form_slug'  => 'descarga-libro-69-ideas',
			'pdf'        => '',
		),
		'dolor' => array(
			'title'      => 'DOLOR',
			'image'      => 'https://esitef.com/online/wp-content/uploads/2024/06/Libro-dolor-tomas-bonino.jpg',
			'form_slug'  => 'descarga-libro-dolor',
			'pdf'        => '',
		),
		'movimiento' => array(
			'title'      => 'Fisioterapia desde y para el movimiento',
			'image'      => 'https://esitef.com/online/wp-content/uploads/2022/07/Captura-de-pantalla-2022-07-14-a-las-15.04.24-724x1024.png',
			'form_slug'  => 'descarga-libro',
			'pdf'        => '',
		),
		'musa' => array(
			'title'      => 'A mi musa la invento yo — Carlota Torrents',
			'image'      => 'https://esitef.com/online/wp-content/uploads/2025/07/a-mi-musa-la-invento-yo.jpg',
			'form_slug'  => 'a-mi-musa-la-invento-yo',
			'pdf'        => '',
		),
	);

	return apply_filters( 'esitef_libros', $libros );
}

/**
 * @param string $key Book key.
 * @return array<string, string>|null
 */
function esitef_get_libro( $key ) {
	$libros = esitef_get_libros();
	return isset( $libros[ $key ] ) ? $libros[ $key ] : null;
}

/**
 * @param string $form_slug Page slug.
 * @return array{key: string, book: array<string, string>}|null
 */
function esitef_get_libro_by_form_slug( $form_slug ) {
	foreach ( esitef_get_libros() as $key => $book ) {
		if ( $book['form_slug'] === $form_slug ) {
			return array(
				'key'  => $key,
				'book' => $book,
			);
		}
	}
	return null;
}

/**
 * URL de descarga del PDF (local o externa).
 *
 * @param string $key Book key.
 */
function esitef_get_libro_pdf_url( $key ) {
	$book = esitef_get_libro( $key );
	if ( ! $book ) {
		return '';
	}

	$local = get_template_directory() . '/assets/libros/' . $key . '.pdf';
	if ( is_readable( $local ) ) {
		return esitef_asset_uri( 'libros/' . $key . '.pdf' );
	}

	$pdf = isset( $book['pdf'] ) ? (string) $book['pdf'] : '';
	return (string) apply_filters( 'esitef_libro_pdf_url', $pdf, $key, $book );
}

/**
 * URL del formulario de descarga.
 *
 * @param string $key Book key.
 */
function esitef_get_libro_form_url( $key ) {
	$book = esitef_get_libro( $key );
	if ( ! $book ) {
		return home_url( '/libros/' );
	}
	$page = get_page_by_path( $book['form_slug'] );
	if ( $page ) {
		return get_permalink( $page );
	}
	return home_url( '/' . $book['form_slug'] . '/' );
}

/**
 * Profesiones del formulario.
 *
 * @return string[]
 */
function esitef_get_libro_profesiones() {
	return array(
		'Fisioterapeuta / Kinesiólogo',
		'Preparación / Educación física',
		'Profesiones del movimiento',
		'Otro',
	);
}

/**
 * Procesa el envío del formulario de descarga.
 */
function esitef_handle_descarga_libro() {
	$libro_key = isset( $_POST['libro_key'] ) ? sanitize_key( wp_unslash( $_POST['libro_key'] ) ) : '';
	$book      = esitef_get_libro( $libro_key );

	if ( ! $book || ! isset( $_POST['esitef_descarga_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['esitef_descarga_nonce'] ) ), 'esitef_descarga_libro_' . $libro_key ) ) {
		wp_safe_redirect( home_url( '/libros/' ) );
		exit;
	}

	$nombre    = isset( $_POST['nombre'] ) ? sanitize_text_field( wp_unslash( $_POST['nombre'] ) ) : '';
	$pais      = isset( $_POST['pais'] ) ? sanitize_text_field( wp_unslash( $_POST['pais'] ) ) : '';
	$ciudad    = isset( $_POST['ciudad'] ) ? sanitize_text_field( wp_unslash( $_POST['ciudad'] ) ) : '';
	$telefono  = isset( $_POST['telefono'] ) ? sanitize_text_field( wp_unslash( $_POST['telefono'] ) ) : '';
	$email     = isset( $_POST['email'] ) ? sanitize_email( wp_unslash( $_POST['email'] ) ) : '';
	$edad      = isset( $_POST['edad'] ) ? sanitize_text_field( wp_unslash( $_POST['edad'] ) ) : '';
	$profesion = isset( $_POST['profesion'] ) ? sanitize_text_field( wp_unslash( $_POST['profesion'] ) ) : '';

	if ( '' === $nombre || '' === $pais || '' === $ciudad || '' === $telefono || ! is_email( $email ) || '' === $edad || '' === $profesion ) {
		wp_safe_redirect( add_query_arg( 'error', '1', esitef_get_libro_form_url( $libro_key ) ) );
		exit;
	}

	$allowed = esitef_get_libro_profesiones();
	if ( ! in_array( $profesion, $allowed, true ) ) {
		wp_safe_redirect( add_query_arg( 'error', '1', esitef_get_libro_form_url( $libro_key ) ) );
		exit;
	}

	$body = sprintf(
		"Libro: %s\nNombre: %s\nPaís: %s\nCiudad: %s\nTeléfono: %s\nEmail: %s\nEdad: %s\nProfesión: %s\n",
		$book['title'],
		$nombre,
		$pais,
		$ciudad,
		$telefono,
		$email,
		$edad,
		$profesion
	);

	wp_mail(
		get_option( 'admin_email' ),
		sprintf( '[ESITEF] Descarga libro: %s', $book['title'] ),
		$body,
		array( 'Reply-To: ' . $email )
	);

	$pdf = esitef_get_libro_pdf_url( $libro_key );
	$args = array( 'enviado' => '1' );
	if ( $pdf ) {
		$args['pdf'] = rawurlencode( $pdf );
	}

	wp_safe_redirect( add_query_arg( $args, esitef_get_libro_form_url( $libro_key ) ) );
	exit;
}
add_action( 'admin_post_nopriv_esitef_descarga_libro', 'esitef_handle_descarga_libro' );
add_action( 'admin_post_esitef_descarga_libro', 'esitef_handle_descarga_libro' );

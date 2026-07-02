<?php
/**
 * Artículos — catálogo de PDFs.
 *
 * @package esitef-minimal
 */

/**
 * Registro de artículos (ponytail: una fuente; pdf vía filtro o assets/articulos/{slug}.pdf).
 *
 * @return array<string, array<string, string>>
 */
function esitef_get_articulos() {
	$dummy_pdf = 'https://www.w3.org/WAI/ER/tests/xhtml/testfiles/resources/pdf/dummy.pdf';

	$articulos = array(
		'articulo-1' => array(
			'title' => 'Artículo de ejemplo 1',
			'image' => 'https://placehold.co/260x347/f8f8f8/ccc?text=Art%C3%ADculo+1',
			'pdf'   => $dummy_pdf,
		),
		'articulo-2' => array(
			'title' => 'Artículo de ejemplo 2',
			'image' => 'https://placehold.co/260x347/f8f8f8/ccc?text=Art%C3%ADculo+2',
			'pdf'   => $dummy_pdf,
		),
		'articulo-3' => array(
			'title' => 'Artículo de ejemplo 3',
			'image' => 'https://placehold.co/260x347/f8f8f8/ccc?text=Art%C3%ADculo+3',
			'pdf'   => $dummy_pdf,
		),
		'articulo-4' => array(
			'title' => 'Artículo de ejemplo 4',
			'image' => 'https://placehold.co/260x347/f8f8f8/ccc?text=Art%C3%ADculo+4',
			'pdf'   => $dummy_pdf,
		),
	);

	return apply_filters( 'esitef_articulos', $articulos );
}

/**
 * @param string $key Article key.
 * @return array<string, string>|null
 */
function esitef_get_articulo( $key ) {
	$articulos = esitef_get_articulos();
	return isset( $articulos[ $key ] ) ? $articulos[ $key ] : null;
}

/**
 * URL del PDF (local o externa).
 *
 * @param string $key Article key.
 */
function esitef_get_articulo_pdf_url( $key ) {
	$item = esitef_get_articulo( $key );
	if ( ! $item ) {
		return '';
	}

	$local = get_template_directory() . '/assets/articulos/' . $key . '.pdf';
	if ( is_readable( $local ) ) {
		return esitef_asset_uri( 'articulos/' . $key . '.pdf' );
	}

	$pdf = isset( $item['pdf'] ) ? (string) $item['pdf'] : '';
	return (string) apply_filters( 'esitef_articulo_pdf_url', $pdf, $key, $item );
}

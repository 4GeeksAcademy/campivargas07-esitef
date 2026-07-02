<?php
/**
 * On theme activation — create pages and menu hints (ponytail: run once).
 *
 * @package esitef-minimal
 */

function esitef_minimal_activation_setup() {
	$pages = array(
		'ingresar'    => array( 'title' => 'Ingresar', 'template' => 'page-templates/page-login.php' ),
		'mentorias'   => array( 'title' => 'Mentorías', 'template' => 'page-templates/page-mentorias.php' ),
		'la-escuela'  => array( 'title' => 'La Escuela', 'template' => 'page-templates/page-la-escuela.php' ),
	);

	foreach ( $pages as $slug => $data ) {
		$page = get_page_by_path( $slug );
		if ( $page ) {
			update_post_meta( $page->ID, '_wp_page_template', $data['template'] );
			continue;
		}
		$id = wp_insert_post(
			array(
				'post_title'  => $data['title'],
				'post_name'   => $slug,
				'post_status' => 'publish',
				'post_type'   => 'page',
			)
		);
		if ( $id && ! is_wp_error( $id ) ) {
			update_post_meta( $id, '_wp_page_template', $data['template'] );
		}
	}

	$home = get_page_by_path( 'inicio' );
	if ( $home ) {
		update_option( 'page_on_front', $home->ID );
		update_option( 'show_on_front', 'page' );
	} elseif ( ! get_page_by_path( 'inicio' ) ) {
		$home_id = wp_insert_post(
			array(
				'post_title'  => 'Inicio',
				'post_name'   => 'inicio',
				'post_status' => 'publish',
				'post_type'   => 'page',
			)
		);
		if ( $home_id && ! is_wp_error( $home_id ) ) {
			update_option( 'page_on_front', $home_id );
			update_option( 'show_on_front', 'page' );
		}
	}
}
add_action( 'after_switch_theme', 'esitef_minimal_activation_setup' );

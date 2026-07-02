<?php
/**
 * Disable Elementor Header & Footer Builder — theme provides header/footer.
 *
 * @package esitef-minimal
 */

add_filter( 'hfe_header_enabled', '__return_false' );
add_filter( 'hfe_footer_enabled', '__return_false' );
add_filter( 'hfe_render_header', '__return_false' );
add_filter( 'hfe_render_footer', '__return_false' );
add_filter( 'ehf_header_enabled', '__return_false' );
add_filter( 'ehf_footer_enabled', '__return_false' );

/**
 * Elementor Pro Theme Builder locations — prefer theme templates.
 */
function esitef_disable_elementor_locations( $need_override, $location ) {
	if ( in_array( $location, array( 'header', 'footer' ), true ) ) {
		return false;
	}
	return $need_override;
}
add_filter( 'elementor/theme/need_override_location', 'esitef_disable_elementor_locations', 10, 2 );

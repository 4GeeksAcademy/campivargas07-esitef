<?php
/**
 * ESITEF Minimal functions and definitions
 *
 * @package esitef-minimal
 */

if ( ! defined( 'ESITEF_MINIMAL_VERSION' ) ) {
	define( 'ESITEF_MINIMAL_VERSION', '1.1.0' );
}

function esitef_minimal_setup() {
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 80,
			'width'       => 200,
			'flex-height' => true,
			'flex-width'  => true,
		)
	);

	register_nav_menus(
		array(
			'menu-1' => esc_html__( 'Primary', 'esitef-minimal' ),
			'footer' => esc_html__( 'Footer Menu', 'esitef-minimal' ),
		)
	);

	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		)
	);

	add_theme_support( 'woocommerce' );
	add_theme_support( 'wc-product-gallery-zoom' );
	add_theme_support( 'wc-product-gallery-lightbox' );
	add_theme_support( 'wc-product-gallery-slider' );
	add_theme_support( 'tutor' );
}
add_action( 'after_setup_theme', 'esitef_minimal_setup' );

/**
 * Theme asset URI helper.
 */
function esitef_asset_uri( $path ) {
	return get_template_directory_uri() . '/assets/' . ltrim( $path, '/' );
}

/**
 * Login page URL.
 */
function esitef_get_login_url() {
	$page = get_page_by_path( 'ingresar' );
	if ( $page ) {
		return get_permalink( $page );
	}
	return wp_login_url();
}

/**
 * Dashboard URL after auth.
 */
function esitef_get_dashboard_url() {
	if ( function_exists( 'tutor_utils' ) ) {
		return tutor_utils()->get_tutor_dashboard_page_permalink();
	}
	return home_url( '/dashboard/' );
}

/**
 * Replace hardcoded prototype URLs in extracted HTML.
 */
function esitef_filter_prototype_html( $html ) {
	$replacements = array(
		'https://esitef.com/online' => untrailingslashit( home_url() ),
		'login.html'                => wp_make_link_relative( esitef_get_login_url() ),
	);
	return str_replace( array_keys( $replacements ), array_values( $replacements ), $html );
}

/**
 * Body classes for page templates.
 */
function esitef_body_classes( $classes ) {
	if ( is_page_template( 'page-templates/page-login.php' ) ) {
		$classes[] = 'login-screen';
	}
	return $classes;
}
add_filter( 'body_class', 'esitef_body_classes' );

/**
 * Enqueue scripts and styles.
 */
function esitef_minimal_scripts() {
	$uri = get_template_directory_uri();
	$ver = ESITEF_MINIMAL_VERSION;

	wp_enqueue_style(
		'esitef-fonts',
		'https://fonts.googleapis.com/css2?family=Inconsolata:wght@400;500;600;700&family=Bricolage+Grotesque:opsz,wdth,wght@12..96,75..100,200..800&family=Inter:wght@300;400;500;600&display=swap',
		array(),
		null
	);

	wp_enqueue_style( 'esitef-minimal-style', get_stylesheet_uri(), array( 'esitef-fonts' ), $ver );
	wp_enqueue_style( 'esitef-header', $uri . '/assets/css/header.css', array( 'esitef-minimal-style' ), $ver );
	wp_enqueue_style( 'esitef-navbar-v2', $uri . '/assets/css/navbar-v2.css', array( 'esitef-header' ), $ver );
	wp_enqueue_style( 'esitef-footer', $uri . '/assets/css/footer.css', array( 'esitef-minimal-style' ), $ver );
	wp_enqueue_style( 'esitef-login-transition', $uri . '/assets/css/login-transition.css', array(), $ver );

	if ( is_front_page() ) {
		wp_enqueue_style( 'esitef-front-page', $uri . '/assets/css/front-page.css', array( 'esitef-header' ), $ver );
		wp_enqueue_script( 'esitef-home-front', $uri . '/assets/js/home-front.js', array(), $ver, true );
	}

	if ( is_page_template( 'page-templates/page-login.php' ) ) {
		wp_enqueue_style( 'esitef-auth', $uri . '/assets/css/pages/auth.css', array( 'esitef-header' ), $ver );
		wp_enqueue_script( 'esitef-auth', $uri . '/assets/js/auth.js', array(), $ver, true );
	}

	if ( is_page_template( 'page-templates/page-mentorias.php' ) ) {
		wp_enqueue_style( 'esitef-mentorias', $uri . '/assets/css/pages/mentorias.css', array( 'esitef-header' ), $ver );
		wp_enqueue_script( 'esitef-mentorias', $uri . '/assets/js/mentorias.js', array(), $ver, true );
	}

	if ( is_page_template( 'page-templates/page-la-escuela.php' ) ) {
		wp_enqueue_style( 'esitef-la-escuela', $uri . '/assets/css/pages/la-escuela.css', array( 'esitef-header' ), $ver );
	}

	if ( is_post_type_archive( 'courses' ) || is_page_template( 'page-templates/page-formaciones.php' ) ) {
		wp_enqueue_style( 'esitef-formaciones', $uri . '/assets/css/pages/formaciones.css', array( 'esitef-header' ), $ver );
	}

	wp_enqueue_script( 'esitef-navbar-v2', $uri . '/assets/js/navbar-v2.js', array(), $ver, true );
	wp_enqueue_script( 'esitef-login-transition', $uri . '/assets/js/login-transition.js', array(), $ver, true );
}
add_action( 'wp_enqueue_scripts', 'esitef_minimal_scripts' );

/**
 * Nav menu classes for prototype markup.
 */
function esitef_nav_menu_css_class( $classes, $item, $args ) {
	if ( isset( $args->theme_location ) && 'menu-1' === $args->theme_location ) {
		if ( ! in_array( 'menu-item', $classes, true ) ) {
			$classes[] = 'menu-item';
		}
	}
	return $classes;
}
add_filter( 'nav_menu_css_class', 'esitef_nav_menu_css_class', 10, 3 );

function esitef_minimal_cleanup() {
	remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
	remove_action( 'wp_print_styles', 'print_emoji_styles' );
	remove_action( 'wp_head', 'wlwmanifest_link' );
	remove_action( 'wp_head', 'wp_generator' );
	remove_action( 'wp_head', 'rsd_link' );
}
add_action( 'init', 'esitef_minimal_cleanup' );

require get_template_directory() . '/inc/activation.php';

/**
 * Staging banner (ponytail: only when STAGING constant or URL contains staging).
 */
function esitef_staging_banner() {
	$host = wp_parse_url( home_url(), PHP_URL_HOST );
	if ( ! $host || false === strpos( $host, 'staging' ) ) {
		return;
	}
	echo '<div style="position:fixed;bottom:0;left:0;right:0;z-index:999999;background:#e3203a;color:#fff;text-align:center;padding:8px;font:500 12px Inconsolata,monospace;">ENTORNO DE PRUEBAS — No realizar pagos reales</div>';
}
add_action( 'wp_footer', 'esitef_staging_banner', 1 );

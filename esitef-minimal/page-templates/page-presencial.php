<?php
/**
 * Template Name: Curso Presencial
 * Template Post Type: page
 *
 * @package esitef-minimal
 */

get_header();
?>
<main id="main" class="site-wrapper presencial-page">
<?php
ob_start();
include get_template_directory() . '/template-parts/pages/presencial-content.php';
echo esitef_filter_prototype_html( ob_get_clean() ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
?>
</main>
<?php
get_footer();

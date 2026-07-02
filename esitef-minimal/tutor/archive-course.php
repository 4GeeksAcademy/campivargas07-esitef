<?php
/**
 * Tutor course archive — formaciones online styling
 *
 * @package esitef-minimal
 */

get_header();

$course_filter     = (bool) tutor_utils()->get_option( 'course_archive_filter', false );
$supported_filters = tutor_utils()->get_option( 'supported_course_filters', array() );
if ( $course_filter && count( $supported_filters ) ) {
	$course_filter = true;
}
?>

<main id="main" class="site-wrapper">
  <section class="formaciones-section" aria-label="<? esc_attr_e( 'Nuestras Formaciones Online', 'esitef-minimal' ); ?>">
    <div class="formaciones-inner">
      <h1 class="formaciones-titulo"><? esc_html_e( 'Formaciones Online', 'esitef-minimal' ); ?></h1>
      <p class="formaciones-subtitulo"><? esc_html_e( 'Explora nuestras experiencias formativas desde dónde y cuando quieras.', 'esitef-minimal' ); ?></p>

      <div class="<?php tutor_container_classes(); ?> formaciones-grid-wrap">
        <?php tutor_load_template( 'archive-course-loop' ); ?>
      </div>
    </div>
  </section>
</main>

<?php
get_footer();

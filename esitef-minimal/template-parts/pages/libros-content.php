<?php
/**
 * Libros — grid de descargas.
 *
 * @package esitef-minimal
 */
?>
<section class="libros-section" aria-label="<? esc_attr_e( 'Descarga nuestros libros', 'esitef-minimal' ); ?>">
  <div class="libros-inner">
    <h1 class="libros-titulo"><? esc_html_e( 'Descarga nuestros libros', 'esitef-minimal' ); ?></h1>

    <div class="libros-grid">
      <?php foreach ( esitef_get_libros() as $key => $book ) : ?>
      <article class="libro-card">
        <div class="libro-image">
          <img src="<?php echo esc_url( $book['image'] ); ?>" alt="<?php echo esc_attr( $book['title'] ); ?>" loading="lazy">
        </div>
        <h2 class="libro-title"><?php echo esc_html( $book['title'] ); ?></h2>
        <a class="libro-btn" href="<?php echo esc_url( esitef_get_libro_form_url( $key ) ); ?>">
          <? esc_html_e( 'Descargar', 'esitef-minimal' ); ?>
        </a>
      </article>
      <?php endforeach; ?>
    </div>
  </div>
</section>

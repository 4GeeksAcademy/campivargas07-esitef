<?php
/**
 * Artículos — grid de PDFs.
 *
 * @package esitef-minimal
 */
?>
<section class="articulos-section" aria-label="<? esc_attr_e( 'Artículos', 'esitef-minimal' ); ?>">
  <div class="articulos-inner">
    <h1 class="articulos-titulo"><? esc_html_e( 'Artículos', 'esitef-minimal' ); ?></h1>

    <div class="articulos-grid">
      <?php foreach ( esitef_get_articulos() as $key => $item ) : ?>
      <article class="articulo-card">
        <div class="articulo-image">
          <img src="<?php echo esc_url( $item['image'] ); ?>" alt="<?php echo esc_attr( $item['title'] ); ?>" loading="lazy">
        </div>
        <h2 class="articulo-title"><?php echo esc_html( $item['title'] ); ?></h2>
        <a class="articulo-btn" href="<?php echo esc_url( esitef_get_articulo_pdf_url( $key ) ); ?>" target="_blank" rel="noopener noreferrer">
          <? esc_html_e( 'Ver', 'esitef-minimal' ); ?>
        </a>
      </article>
      <?php endforeach; ?>
    </div>
  </div>
</section>

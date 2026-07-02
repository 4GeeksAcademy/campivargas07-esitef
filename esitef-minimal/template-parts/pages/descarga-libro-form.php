<?php
/**
 * Formulario de descarga de libro.
 *
 * @package esitef-minimal
 *
 * @var string               $libro_key
 * @var array<string,string> $book
 * @var bool                 $success
 * @var bool                 $error
 * @var string               $pdf_url
 */

$args = wp_parse_args(
	$args ?? array(),
	array(
		'libro_key' => '',
		'book'      => array(),
		'success'   => false,
		'error'     => false,
		'pdf_url'   => '',
	)
);

$libro_key = $args['libro_key'];
$book      = $args['book'];
$success   = $args['success'];
$error     = $args['error'];
$pdf_url   = $args['pdf_url'];
?>
<section class="descarga-libro-section" aria-label="<?php echo esc_attr( $book['title'] ); ?>">
  <div class="descarga-libro-inner">
    <div class="descarga-libro-cover">
          <img src="<?php echo esc_url( $book['image'] ); ?>" alt="<?php echo esc_attr( $book['title'] ); ?>" loading="lazy" decoding="async">
    </div>

    <div class="descarga-libro-module esitef-module-shell">
      <div class="descarga-libro-form-wrap esitef-module-card">
      <?php if ( $success ) : ?>
      <div class="descarga-libro-success" id="descarga-libro-success">
        <h1 class="descarga-libro-title"><? esc_html_e( '¡Listo!', 'esitef-minimal' ); ?></h1>
        <p class="descarga-libro-subtitle">
          <?php esc_html_e( 'Gracias por tus datos. Tu descarga comenzará en unos segundos.', 'esitef-minimal' ); ?>
        </p>
        <?php if ( $pdf_url ) : ?>
        <a class="descarga-libro-btn" href="<?php echo esc_url( $pdf_url ); ?>" download>
          <? esc_html_e( 'Descargar de nuevo', 'esitef-minimal' ); ?>
        </a>
        <?php else : ?>
        <p class="descarga-libro-hint">
          <? esc_html_e( 'Te enviaremos el enlace de descarga a tu correo.', 'esitef-minimal' ); ?>
        </p>
        <?php endif; ?>
        <a class="descarga-libro-back" href="<?php echo esc_url( home_url( '/libros/' ) ); ?>">
          <? esc_html_e( 'Volver a libros', 'esitef-minimal' ); ?>
        </a>
      </div>
      <?php else : ?>
      <h1 class="descarga-libro-title">
        <? esc_html_e( 'Por favor, rellena los siguientes datos para descargar el libro gratis', 'esitef-minimal' ); ?>
      </h1>

      <?php if ( $error ) : ?>
      <p class="descarga-libro-error" role="alert">
        <? esc_html_e( 'Revisa los campos e inténtalo de nuevo.', 'esitef-minimal' ); ?>
      </p>
      <?php endif; ?>

      <form class="descarga-libro-form" method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" novalidate>
        <input type="hidden" name="action" value="esitef_descarga_libro">
        <input type="hidden" name="libro_key" value="<?php echo esc_attr( $libro_key ); ?>">
        <?php wp_nonce_field( 'esitef_descarga_libro_' . $libro_key, 'esitef_descarga_nonce' ); ?>

        <div class="descarga-field">
          <label for="descarga-nombre"><? esc_html_e( 'Nombre y apellidos', 'esitef-minimal' ); ?> <span aria-hidden="true">*</span></label>
          <input type="text" id="descarga-nombre" name="nombre" autocomplete="name" required>
        </div>

        <div class="descarga-field">
          <label for="descarga-pais"><? esc_html_e( 'País', 'esitef-minimal' ); ?> <span aria-hidden="true">*</span></label>
          <input type="text" id="descarga-pais" name="pais" autocomplete="country-name" required>
        </div>

        <div class="descarga-field">
          <label for="descarga-ciudad"><? esc_html_e( 'Ciudad', 'esitef-minimal' ); ?> <span aria-hidden="true">*</span></label>
          <input type="text" id="descarga-ciudad" name="ciudad" autocomplete="address-level2" required>
        </div>

        <div class="descarga-field">
          <label for="descarga-telefono"><? esc_html_e( 'Teléfono', 'esitef-minimal' ); ?> <span aria-hidden="true">*</span></label>
          <input type="tel" id="descarga-telefono" name="telefono" autocomplete="tel" required>
        </div>

        <div class="descarga-field">
          <label for="descarga-email"><? esc_html_e( 'Correo electrónico', 'esitef-minimal' ); ?> <span aria-hidden="true">*</span></label>
          <input type="email" id="descarga-email" name="email" autocomplete="email" inputmode="email" spellcheck="false" required>
        </div>

        <div class="descarga-field">
          <label for="descarga-edad"><? esc_html_e( 'Edad', 'esitef-minimal' ); ?> <span aria-hidden="true">*</span></label>
          <input type="text" id="descarga-edad" name="edad" inputmode="numeric" required>
        </div>

        <fieldset class="descarga-field descarga-field--radio descarga-field--full">
          <legend><? esc_html_e( 'Profesión', 'esitef-minimal' ); ?> <span aria-hidden="true">*</span></legend>
          <ul class="descarga-radio-list">
            <?php foreach ( esitef_get_libro_profesiones() as $i => $profesion ) : ?>
            <li>
              <input type="radio" id="descarga-profesion-<?php echo esc_attr( (string) $i ); ?>" name="profesion" value="<?php echo esc_attr( $profesion ); ?>"<?php echo 0 === $i ? ' required' : ''; ?>>
              <label for="descarga-profesion-<?php echo esc_attr( (string) $i ); ?>"><?php echo esc_html( $profesion ); ?></label>
            </li>
            <?php endforeach; ?>
          </ul>
        </fieldset>

        <button type="submit" class="descarga-libro-btn descarga-field--full"><? esc_html_e( 'Enviar', 'esitef-minimal' ); ?></button>
      </form>
      <?php endif; ?>
      </div>
    </div>
  </div>
</section>
<?php if ( $success && $pdf_url ) : ?>
<script>
(function () {
  var link = document.createElement('a');
  link.href = <?php echo wp_json_encode( $pdf_url ); ?>;
  link.download = '';
  document.body.appendChild(link);
  link.click();
  link.remove();
})();
</script>
<?php endif; ?>

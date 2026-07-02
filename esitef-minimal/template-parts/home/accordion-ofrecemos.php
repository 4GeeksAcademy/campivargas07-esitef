<?php
/**
 * Home accordion — Ofrecemos
 *
 * @package esitef-minimal
 */

$items = array(
	array(
		'num'   => '01',
		'title' => __( 'Nuestras formaciones', 'esitef-minimal' ),
		'desc'  => __( 'Capacítate con cursos actualizados y eleva tu nivel profesional en fisioterapia.', 'esitef-minimal' ),
		'img'   => 'https://esitef.com/online/wp-content/uploads/2022/02/Desde-la-camilla-al-movimiento.png',
		'link'  => get_post_type_archive_link( 'courses' ) ?: home_url( '/courses/' ),
	),
	array(
		'num'   => '02',
		'title' => __( 'Mentoría profesional con Tomás', 'esitef-minimal' ),
		'desc'  => __( 'Guía personalizada para llevar tu clínica o carrera profesional al siguiente nivel.', 'esitef-minimal' ),
		'img'   => 'https://esitef.com/online/wp-content/uploads/2022/05/Asesoria-clinicas-fisioterapia_.png',
		'link'  => home_url( '/mentorias/' ),
	),
	array(
		'num'   => '03',
		'title' => __( 'Sesiones Online con Tomás', 'esitef-minimal' ),
		'desc'  => __( 'Consultas y sesiones online para aplicar el ejercicio terapéutico con tus pacientes.', 'esitef-minimal' ),
		'img'   => 'https://esitef.com/online/wp-content/uploads/2022/05/sesiones-online-fisioterapia-.png',
		'link'  => home_url( '/sesiones-online-con-tomas-bonino/' ),
	),
	array(
		'num'   => '04',
		'title' => __( 'Talleres privados clinicas / Instituciones', 'esitef-minimal' ),
		'desc'  => __( 'Entrenamientos prácticos y presenciales para instituciones y grupos de salud.', 'esitef-minimal' ),
		'img'   => 'https://esitef.com/online/wp-content/uploads/2022/02/Evaluacion-funcional-rodilla.png',
		'link'  => home_url( '/talleres-privados-clinicas/' ),
	),
	array(
		'num'   => '05',
		'title' => __( 'Blog', 'esitef-minimal' ),
		'desc'  => __( 'Artículos y actualización científica para tu práctica diaria.', 'esitef-minimal' ),
		'img'   => 'https://esitef.com/online/wp-content/uploads/2022/05/blog-esitef-.png',
		'link'  => home_url( '/blog/' ),
	),
);
?>
<section class="ofrecemos-section" aria-label="<? esc_attr_e( 'Qué ofrecemos', 'esitef-minimal' ); ?>">
  <div class="ofrecemos-inner">
    <h2 class="ofrecemos-titulo"><? esc_html_e( 'Ofrecemos', 'esitef-minimal' ); ?></h2>

    <div class="accordion-container">
      <?php foreach ( $items as $i => $item ) : ?>
      <div class="accordion-item<?php echo 0 === $i ? ' active' : ''; ?>" tabindex="0" data-href="<?php echo esc_url( $item['link'] ); ?>">
        <div class="accordion-content">
          <span class="accordion-number"><?php echo esc_html( $item['num'] ); ?></span>
          <div class="accordion-text">
            <h3><?php echo esc_html( $item['title'] ); ?></h3>
            <p><?php echo esc_html( $item['desc'] ); ?></p>
          </div>
        </div>
        <div class="accordion-image">
          <img src="<?php echo esc_url( $item['img'] ); ?>" alt="<?php echo esc_attr( $item['title'] ); ?>">
        </div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<?php
/**
 * Home blog — staggered cards
 *
 * @package esitef-minimal
 */
?>
<section class="blog-section" aria-label="<? esc_attr_e( 'Últimas entradas del blog', 'esitef-minimal' ); ?>">
  <div class="blog-inner">
    <h2 class="blog-titulo"><? esc_html_e( 'Blog', 'esitef-minimal' ); ?></h2>

    <div class="blog-grid">
      <?php
      $recent_posts = new WP_Query(
        array(
          'posts_per_page' => 3,
          'post_status'    => 'publish',
        )
      );

      if ( $recent_posts->have_posts() ) :
        while ( $recent_posts->have_posts() ) :
          $recent_posts->the_post();
          $author_name = get_the_author();
          $author_role = __( 'Docente ESITEF', 'esitef-minimal' );
          $img_url     = get_the_post_thumbnail_url( get_the_ID(), 'medium' );
          if ( ! $img_url ) {
            $img_url = 'https://esitef.com/online/wp-content/uploads/2022/05/blog-esitef-.png';
          }
          ?>
      <a href="<?php the_permalink(); ?>" class="blog-card">
        <div class="blog-card-quote">“</div>
        <div class="blog-card-content">
          <h3><?php the_title(); ?></h3>
          <p><?php echo esc_html( wp_trim_words( get_the_excerpt(), 20, '...' ) ); ?></p>
        </div>
        <div class="blog-card-footer">
          <div class="blog-card-author">
            <span class="author-name"><?php echo esc_html( $author_name ); ?></span>
            <span class="author-role"><?php echo esc_html( $author_role ); ?></span>
          </div>
          <div class="blog-card-image">
            <img src="<?php echo esc_url( $img_url ); ?>" alt="<?php the_title_attribute(); ?>">
          </div>
        </div>
      </a>
          <?php
        endwhile;
        wp_reset_postdata();
      else :
        ?>
        <p><? esc_html_e( 'No hay artículos en el blog.', 'esitef-minimal' ); ?></p>
        <?php
      endif;
      ?>
    </div>

    <?php if ( $recent_posts->have_posts() ) : ?>
    <div class="blog-ver-todos">
      <a href="<?php echo esc_url( home_url( '/blog/' ) ); ?>" class="blog-ver-todos-btn"><? esc_html_e( 'Ver todos los artículos', 'esitef-minimal' ); ?></a>
    </div>
    <?php endif; ?>
  </div>
</section>

<?php
/**
 * Single post
 *
 * @package esitef-minimal
 */

get_header();
?>

<main id="main" class="site-main container" style="padding: 60px 20px; max-width: 800px; margin: 0 auto;">
	<?php
	while ( have_posts() ) :
		the_post();
		?>
		<article <?php post_class(); ?>>
			<h1><?php the_title(); ?></h1>
			<div class="entry-content"><?php the_content(); ?></div>
		</article>
		<?php
	endwhile;
	?>
</main>

<?php
get_footer();

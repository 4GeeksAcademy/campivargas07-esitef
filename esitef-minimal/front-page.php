<?php
/**
 * Front page
 *
 * @package esitef-minimal
 */

get_header();
?>

<main id="main">
	<?php
	get_template_part( 'template-parts/home/hero' );
	get_template_part( 'template-parts/home/accordion-ofrecemos' );
	get_template_part( 'template-parts/home/blog-staggered' );
	?>
</main>

<?php
get_footer();

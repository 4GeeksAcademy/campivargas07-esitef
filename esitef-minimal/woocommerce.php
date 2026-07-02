<?php
/**
 * WooCommerce wrapper
 *
 * @package esitef-minimal
 */

get_header();
?>

<main id="main" class="site-main woocommerce-page" style="padding: 60px 20px; max-width: var(--container-width, 1200px); margin: 0 auto;">
	<?php woocommerce_content(); ?>
</main>

<?php
get_footer();

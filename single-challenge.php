<?php

/**
 * The template for displaying all single post	
 */
get_header();
?>

<main id="primary" class="site-main">
	<?php get_template_part('template-parts/header-challenge'); ?>
	<div class="page-content">
		<?php
		while (have_posts()) :
			the_post();
			the_content();
		endwhile;
		?>
	</div>
	<?php require_once get_template_directory() . '/template-parts/nav-challenges.php' ?>

</main>

<?php get_footer(); ?>
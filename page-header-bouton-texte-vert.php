<?php

/**
 * Template Name: Page - header avec bouton sous le titre et texte fond vert
 */
get_header();
?>

<main id="primary" class="site-main">
	<?php get_template_part('template-parts/header-bouton-titre-texte-vert'); ?>
	<div class="page-content">
		<?php
		while (have_posts()) :
			the_post();
			the_content();
		endwhile;
		?>
	</div>
</main>

<?php get_footer(); ?>
<?php


get_header();
?>

<main id="primary" class="site-main">
	<?php get_template_part('template-parts/header-page-simple'); ?>

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
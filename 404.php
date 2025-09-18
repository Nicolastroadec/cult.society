<?php

/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package Cland
 */

get_header();
?>

<main id="primary" class="site-main">

	<div class="header-single-and-events">

		<div class="header-content">

			<div class="left-col">
				<?php
				display_custom_breadcrumb();

				?>
				<div class="content">
					<h1 class="page-title"><?php esc_html_e('Vous vous êtes perdu !', 'cland'); ?></h1>
					<div><a href="<?= get_site_url() ?>">Retour à la page d'accueil</a></div>
				</div>

			</div>

			<div class="right-col">

				<div class="post-thumbnail-container">
					<?= the_post_thumbnail(get_the_ID()) ?>

				</div>
			</div>
		</div>
	</div>
</main><!-- #main -->

<?php
get_footer();

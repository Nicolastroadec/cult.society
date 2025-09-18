<?php

/**
 * The template for displaying all single 	
 */
get_header();
?>

<main id="primary" class="site-main">
	<?php get_template_part('template-parts/header-single-video'); ?>

	<div class="wp-block-acf">

		<div class="page-content block block-single-video">
			<?php
			while (have_posts()) :
				the_post();

				// Récupération des données personnalisées
				$lien_de_la_video_youtube = get_field('lien_de_la_video_youtube');
				$auteurs = get_field('auteurs');
				$lien_de_lauteur = get_field('lien_de_lauteur');
				$qualite_des_auteurs = get_field('qualite_des_auteurs');

				// Récupération des termes de taxonomie
				$type_de_challenge_terms = get_the_terms(get_the_ID(), 'type_de_challenge');
				$thematiques_terms = get_the_terms(get_the_ID(), 'thematiques');

				// Construction des classes pour les filtres
				$term_classes = '';
				$data_filters = array();

				if (!empty($type_de_challenge_terms) && !is_wp_error($type_de_challenge_terms)) {
					foreach ($type_de_challenge_terms as $term) {
						$term_classes .= 'filter-' . $term->slug . ' ';
						$data_filters[] = $term->slug;
					}
				}

				if (!empty($thematiques_terms) && !is_wp_error($thematiques_terms)) {
					foreach ($thematiques_terms as $term) {
						$term_classes .= 'filter-' . $term->slug . ' ';
						$data_filters[] = $term->slug;
					}
				}

				$data_filters_attr = implode(',', $data_filters);
			?>
				<div class="card video single-card <?php echo esc_attr(trim($term_classes)); ?>" data-filters="<?php echo esc_attr($data_filters_attr); ?>">

					<?php if (!empty($lien_de_la_video_youtube)) :
						// Récupération de l'ID YouTube
						preg_match('/(?:youtube\.com\/(?:watch\?v=|embed\/)|youtu\.be\/)([a-zA-Z0-9_-]{11})/', $lien_de_la_video_youtube, $matches);
						$video_id = isset($matches[1]) ? $matches[1] : '';
						if ($video_id): ?>
							<div class="video-thumbnail single-video" data-id="<?php echo esc_attr($video_id); ?>">
								<img src="https://img.youtube.com/vi/<?php echo esc_attr($video_id); ?>/maxresdefault.jpg" alt="<?php echo esc_attr(get_the_title()); ?>" loading="lazy">
								<div class="thumbnail-overlay">
									<div class="play-button">
										▶
									</div>
								</div>
							</div>
					<?php endif;
					endif; ?>

					<div class="single-content-wrapper">
						<div class="taxonomies-and-terms">
							<?php if (!empty($type_de_challenge_terms) && !is_wp_error($type_de_challenge_terms)) : ?>
								<?php foreach ($type_de_challenge_terms as $term) {
									$termName = '';

									if ($term->name === "challenge-1") {
										$termName = "Challenge 1";
									} elseif ($term->name === "challenge-2") {
										$termName = "Challenge 2";
									} elseif ($term->name === "challenge-3") {
										$termName = "Challenge 3";
									}
								?>
									<p class="term term-challenge term-<?php echo esc_html($term->name); ?>">
										<?php echo esc_html($termName); ?>
									</p>
								<?php
								} ?>
							<?php endif; ?>

							<?php if (!empty($thematiques_terms) && !is_wp_error($thematiques_terms)) : ?>
								<?php foreach ($thematiques_terms as $term) : ?>
									<p class="term">
										<?php echo esc_html($term->name); ?>
									</p>
								<?php endforeach; ?>
							<?php endif; ?>
						</div>

						<h1 class="single-title">
							<?php the_title(); ?>
						</h1>

						<?php if (!empty($lien_de_lauteur)): ?>
							<a class="auteurs single-auteurs" href="<?php echo esc_url($lien_de_lauteur); ?>">
								<?php if (!empty($auteurs)): ?>
									<?php echo esc_html($auteurs); ?>
								<?php endif; ?>
							</a>
						<?php else: ?>
							<div class="auteurs single-auteurs">
								<?php if (!empty($auteurs)): ?>
									<?php echo esc_html($auteurs); ?>
								<?php endif; ?>
							</div>
						<?php endif; ?>

						<?php if (!empty($qualite_des_auteurs)) : ?>
							<div class="qualite-des-auteurs single-qualite">
								<?php echo wp_kses_post($qualite_des_auteurs ?? ''); ?>
							</div>
						<?php endif; ?>

						<div class="single-content">
							<?php the_content(); ?>
						</div>
					</div>
				</div>

			<?php
			endwhile;
			?>
		</div>
	</div>

	<?php require_once get_template_directory() . '/template-parts/nav-posts.php' ?>

</main>

<?php get_footer(); ?>
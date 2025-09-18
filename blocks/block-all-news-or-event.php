<?php require_once get_template_directory() . '/blocks/options.php';
$options = get_block_options();
$style = $options['style'] ?? '';
$bgColor = $options['bgColor'] ?? '';
if (isset($bgColor)) {
    $bgColor = 'bg-' . $bgColor;
}
$class = $bgColor;
$image = get_field('image');
$titre_du_bloc = get_field('titre_du_bloc', 'option');
$read_more = get_field('texte_du_bouton_read_more', 'option');
$type_contenu = 'post';
$type_contenu = get_field('type_contenu');
$texte_du_bouton_load_more = get_field('texte_du_bouton_load_more');
$nombre_darticles_a_afficher = get_field('nombre_darticles_a_afficher');
if (!$nombre_darticles_a_afficher) {
    $nombre_darticles_a_afficher = 6; // Correction de la variable (il y avait $$ au lieu de $)
} ?>

<div style="<?= esc_attr($style) ?>" class="block-all-news-or-event wp-block-acf <?= esc_html($class) ?>">
    <div class="block">
        <?php
        $args = array(
            'post_type' => $type_contenu, // Type de contenu (ici : article classique) 
            'posts_per_page' => -1, // Nombre de posts à récupérer 
            'orderby' => 'date', // Tri par date 
            'order' => 'DESC' // Du plus récent au plus ancien 
        );
        $latest_posts = new WP_Query($args);
        $post_count = $latest_posts->post_count; // Nombre total d'articles
        ?>

        <div class="articles-content">
            <?php if ($latest_posts->have_posts()) :
                $counter = 0; // Compteur pour les articles
                while ($latest_posts->have_posts()) : $latest_posts->the_post();
                    $counter++;
                    // Ajouter une classe pour masquer les articles au-delà du nombre initial à afficher
                    $hidden_class = $counter > $nombre_darticles_a_afficher ? 'hidden-article' : '';
                    $class = '';
                    if (!has_post_thumbnail()) :
                        $class = "no-image";
                    endif;

            ?>
                    <article class="news-article <?php echo esc_attr($hidden_class) ?>" <?php if ($counter > $nombre_darticles_a_afficher) echo 'style="display: none;"'; ?>>
                        <?php if (has_post_thumbnail()) : ?>
                            <div class="image-container">
                                <?php the_post_thumbnail('medium'); ?>
                            </div>

                        <?php endif; ?>
                        <div class="content <?= esc_attr($class) ?>">
                            <h3><?php the_title(); ?></h3>
                            <p><?php $excerpt = get_the_excerpt();
                                echo mb_strimwidth($excerpt, 0, 150, '...'); ?></p>
                            <a class="link-animated" href="<?php the_permalink(); ?>"><?= esc_html($read_more) ?></a>
                        </div>
                    </article>
                <?php endwhile;
                wp_reset_postdata();

                // Afficher le bouton "Load More" uniquement s'il y a plus d'articles que le nombre initial
                if ($post_count > $nombre_darticles_a_afficher && $texte_du_bouton_load_more) : ?>
                    <div class="load-more-container">
                        <div id="load-more-button"
                            class="load-more-button btn btn-secondary"
                            data-current="<?php echo $nombre_darticles_a_afficher; ?>"
                            data-increment="<?php echo $nombre_darticles_a_afficher; ?>"
                            data-total="<?php echo $post_count; ?>">
                            <?php echo esc_html($texte_du_bouton_load_more); ?>
                        </div>
                    </div>
                <?php endif;

            else : ?>
                <p>Aucun article trouvé.</p>
            <?php endif; ?>
        </div>

        <style>

        </style>

        <script>

        </script>
    </div>
</div>
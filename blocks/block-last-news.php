<?php
require_once get_template_directory() . '/blocks/options.php';

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
$lien_vers_la_page_des_actus = get_field('lien_vers_la_page_des_actus', 'option');

?>
<div style="<?= esc_attr($style) ?>" class="block-last-news wp-block-acf <?= esc_html($class) ?>">
    <div class="block">
        <h2><?= esc_html($titre_du_bloc) ?></h2>
        <?php
        $args = array(
            'post_type'      => 'post',     // Type de contenu (ici : article classique)
            'posts_per_page' => 3,          // Nombre de posts à récupérer
            'orderby'        => 'date',     // Tri par date
            'order'          => 'DESC',
            'status'     // Du plus récent au plus ancien
        );

        $latest_posts = new WP_Query($args); ?>
        <div class="articles-content">
            <?php if ($latest_posts->have_posts()) :
                while ($latest_posts->have_posts()) : $latest_posts->the_post(); ?>
                    <article>
                        <div class="image-container">
                            <?php if (has_post_thumbnail()) : ?>
                                <?php the_post_thumbnail('medium'); ?>
                            <?php endif; ?>
                        </div>
                        <div class="content">
                            <h3>
                                <?php the_title(); ?>
                            </h3>
                            <p><?php $excerpt = get_the_excerpt();
                                echo mb_strimwidth($excerpt, 0, 180, '...');
                                ?></p>
                            <a class="link-animated" href="<?php the_permalink(); ?>"><?= esc_html($read_more) ?></a>
                        </div>

                    </article>
                <?php endwhile;
                wp_reset_postdata();
            else : ?>
                <p>Aucun article trouvé.</p>
            <?php endif; ?>
            <div class="see-all">
                <?php if (is_array($lien_vers_la_page_des_actus) && (!empty($lien_vers_la_page_des_actus))) : ?>
                    <a class="btn btn-secondary" href="<?= esc_url($lien_vers_la_page_des_actus['url']); ?>"><?= esc_html($lien_vers_la_page_des_actus['title']) ?></a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?php
require_once get_template_directory() . '/blocks/options.php';

$options = get_block_options();
$style = $options['style'] ?? '';
$bgColor = $options['bgColor'] ?? '';
if (isset($bgColor)) {
    $bgColor = 'bg-' . $bgColor;
}

$class = $bgColor;

$options = get_field('options');
?>
<div style="<?= esc_attr($style) ?>" class="block-videos block-videos-challenges wp-block-acf <?= esc_html($class) ?>">

    <div id="filters">

        <?php
        $terms = get_terms([
            'taxonomy' => 'thematiques_de_la_video',
            'hide_empty' => true,
        ]);
        if (!empty($terms) && !is_wp_error($terms)) : ?>
            <div class="filter-group" data-filter-group="topic">
                <button data-filter="all" class="active">Show all</button>
                <?php foreach ($terms as $term) :
                    // on s'assure que le slug est un nom de classe valide
                    $slug = esc_attr($term->slug);
                    $name = esc_html($term->name);
                ?>
                    <button data-filter="<?php echo $slug; ?>"><?php echo $name; ?></button>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>


        <div class="display-buttons">
            <div data-number="3" class="button">
                Display 3
            </div>
            <div data-number="6" class="button">
                Display 6
            </div>
            <div data-number="9" class="button">
                Display 9
            </div>


        </div>

    </div>

    <div class="block videos">
        <?php
        $args = array(
            'post_type' => 'video_elearning',
            'posts_per_page' => -1, // ou un nombre spécifique
            'tax_query' => array(
                array(
                    'taxonomy' => 'type_de_video',
                    'field'    => 'slug', // ou 'name' ou 'term_id' selon ton besoin
                    'terms'    => 'fundamentals',
                ),
            ),
        );

        $query = new WP_Query($args);

        if ($query->have_posts()) :
            if ($query->have_posts()) :
                while ($query->have_posts()) : $query->the_post();
                    $id = get_the_ID();
                    $type_de_challenge_terms = get_the_terms($id, 'type_de_challenge');
                    $thematiques_terms = get_the_terms($id, 'thematiques_de_la_video');

                    $auteurs = get_field('auteurs', $id);
                    $qualite_des_auteurs = get_field('qualite_des_auteurs', $id);
                    $lien_de_lauteur = get_field('lien_de_lauteur', $id);
                    $lien_de_la_video_youtube = get_field('lien_de_la_video_youtube', $id);
                    $tags = get_field('tags', $id);

                    // Build class string from taxonomy terms
                    $term_classes = '';
                    $data_filters = [];

                    if (!empty($type_de_challenge_terms) && !is_wp_error($type_de_challenge_terms)) {
                        foreach ($type_de_challenge_terms as $term) {
                            $term_name = sanitize_title($term->name);
                            $term_classes .= $term_name . ' ';
                            $data_filters[] = $term_name;
                        }
                    }
                    if (!empty($thematiques_terms) && !is_wp_error($thematiques_terms)) {
                        foreach ($thematiques_terms as $term) {
                            $term_name = sanitize_title($term->slug);
                            $term_classes .= $term_name . ' ';
                            $data_filters[] = $term_name;
                        }
                    }

                    $data_filters_attr = implode(',', $data_filters);

                    require get_template_directory() . '/blocks/components/video.php';

                endwhile;
            endif;
            wp_reset_postdata();
        endif;
        ?>

    </div>
</div>

<div class="load-more-container">
    <button class="btn btn-primary" id="load-more">Charger plus</button>
</div>
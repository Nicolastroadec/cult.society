<?php
require_once get_template_directory() . '/blocks/options.php';

$options = get_block_options();
$style = $options['style'] ?? '';
$bgColor = $options['bgColor'] ?? '';
if (isset($bgColor)) {
    $bgColor = 'bg-' . $bgColor;
}

$class = $bgColor;

$surtitre = get_field('surtitre');
$titre = get_field('titre');
$type_de_video = get_field('type_de_video'); // ex : 'challenges' ou 'fundamentals'

$args = array(
    'post_type'      => 'video_elearning',
    'post_status'    => 'publish',
    'posts_per_page' => 9,
    'tax_query'      => array(
        array(
            'taxonomy' => 'type_de_video',
            'field'    => 'slug',
            'terms'    => $type_de_video,
        ),
    ),
);

$videos = new WP_Query($args);
$nombre_de_videos = $videos->found_posts;

?>
<div style="<?php echo esc_attr($style); ?>" class="block-videos-slider wp-block-acf <?php echo esc_html($class); ?>">
    <img class="line-light-slide" src="<?= get_template_directory_uri() . '/assets/png/vector-blue-right.png' ?>" alt="">

    <div class="block">
        <div class="slider researchers">

            <div class="cards">
                <?php
                if ($videos->have_posts()) :
                    while ($videos->have_posts()) : $videos->the_post();
                        $post_id = get_the_ID(); // Get the current post ID in the loop

                        $type_de_challenge_terms = get_the_terms($post_id, 'type_de_challenge');
                        $thematiques_terms = get_the_terms($post_id, 'thematiques_de_la_video');

                        $auteurs = get_field('auteurs', $post_id);
                        $qualite_des_auteurs = get_field('qualite_des_auteurs', $post_id);
                        $lien_de_lauteur = get_field('lien_de_lauteur', $post_id);
                        $lien_de_la_video_youtube = get_field('lien_de_la_video_youtube', $post_id);
                        $tags = get_field('tags', $post_id);

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
                    wp_reset_postdata();
                endif;
                ?>
            </div>
        </div>
    </div>
</div>
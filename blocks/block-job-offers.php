<?php
require_once get_template_directory() . '/blocks/options.php';

$options = get_block_options();
$style = $options['style'] ?? '';
$bgColor = $options['bgColor'] ?? '';
if (isset($bgColor)) {
    $bgColor = 'bg-' . $bgColor;
}

$class = $bgColor;

$Nom = get_field('Nom');
$type_demploi = get_field('type_demploi');



?>
<div style="<?= esc_attr($style) ?>" class="block-job-offers wp-block-acf <?= esc_html($class) ?>">
    <div class="block">
        <div class="slider job-offers">
            <div class="cards">
                <?php
                $args = [
                    'post_type'      => 'jobs',
                    'posts_per_page' => -1,
                    'post_status'    => 'publish',
                    'orderby'        => 'date',
                    'order'          => 'DESC',
                    'tax_query'      => [
                        [
                            'taxonomy' => 'type_de_job',
                            'field'    => 'slug', // ou 'term_id' ou 'name'
                            'terms'    => $type_demploi, // ou un tableau de termes ['developpeur', 'designer']
                        ],
                    ],
                ];

                $link_to_job_offers = get_field('link_to_job_offers');
                $job_query = new WP_Query($args);

                if ($job_query->have_posts()) :
                    while ($job_query->have_posts()) : $job_query->the_post();
                        $position = get_field('position', get_the_ID());
                        $location = get_field('location', get_the_ID());
                        $duration = get_field('duration', get_the_ID());
                        $lien_vers_loffre = get_field('lien_vers_loffre', get_the_ID()); ?>
                        <?php require get_template_directory() . '/blocks/components/card-job-offer.php' ?>
                    <?php endwhile;
                    wp_reset_postdata(); ?>
                <?php else: ?>
                    <div class="no-job-offers"><?= get_field('no_job_offers', 'option') ?></div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
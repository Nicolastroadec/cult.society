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

?>
<div style="<?= esc_attr($style) ?>" class="block-last-job-offers wp-block-acf <?= esc_html($class) ?>">
    <div class="block">

        <div class="last-jobs">
            <?php
            $args = [
                'post_type'      => 'jobs',
                'posts_per_page' => 2,
                'post_status'    => 'publish',
                'orderby'        => 'date',
                'order'          => 'DESC',
            ];

            $link_to_job_offers = get_field('link_to_job_offers');
            $job_query = new WP_Query($args);

            if ($job_query->have_posts()) :
                while ($job_query->have_posts()) : $job_query->the_post();
                    $position = get_field('position', get_the_ID());
                    $location = get_field('location', get_the_ID());
                    $duration = get_field('duration', get_the_ID());
                    $lien_vers_loffre = get_field('lien_vers_loffre', get_the_ID());
            ?>

                    <?php require get_template_directory() . '/blocks/components/card-job-offer.php' ?>


                <?php endwhile;
                wp_reset_postdata(); ?>
            <?php else: ?>
                <div class="no-job-offers"><?= get_field('no_job_offers', 'option') ?></div>
            <?php endif; ?>
        </div>

        <div class="see-all">
            <a href="<?= $link_to_job_offers['url'] ?? ''; ?>" class="btn btn-secondary"><?= $link_to_job_offers['title'] ?? '' ?></a>
        </div>

    </div>

</div>
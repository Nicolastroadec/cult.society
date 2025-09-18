<?php
require_once get_template_directory() . '/blocks/options.php';

$options = get_block_options();
$style = $options['style'] ?? '';
$bgColor = $options['bgColor'] ?? '';
if (isset($bgColor)) {
    $bgColor = 'bg-' . $bgColor;
}

$class = $bgColor;
$titre = get_field('titre');
$texte = get_field('texte');
$titre_de_laccordeon = get_field('titre_de_laccordeon');
$options = get_field('options');


$args = array(
    'post_type' => 'researchers',
    'post_status' => 'publish',
    'posts_per_page' => -1,
    'tax_query' => array(
        array(
            'taxonomy' => 'types-de-chercheur',
            'field'    => 'slug',
            'terms'    => array('former-researcher'),
            'operator' => 'IN',
        ),
    ),
);
$former_researchers = new WP_Query($args);

?>
<div style="<?= esc_attr($style) ?>" class="block-our-former-researchers wp-block-acf <?= esc_html($class) ?>">
    <div class="block">
        <h2><?= esc_html($titre) ?></h2>

        <div class="cols">
            <div class="col-left">
                <p><?= wp_kses_post($texte ?? '') ?></p>
            </div>
            <div class="col-right">
                <div class="accordeon-container">
                    <?php

                    $titre = $item['titre'] ?? null;
                    $texte = $item['texte'] ?? null;
                    $titre_deuxieme_section = $item['titre_deuxieme_section'] ?? null;
                    $logos = $item['logo'] ?? null;
                    ?>
                    <div class="accordeon-element accordeon-former-researcher">
                        <div class="accordeon-title">
                            <h3><?= esc_html($titre_de_laccordeon) ?></h3>
                            <div class="cross-accordeon">
                                <?php require get_template_directory() . '/assets/svg/cross-accordeon.php' ?>
                            </div>
                        </div>
                        <div class="accordeon-content">
                            <?php
                            if ($former_researchers->have_posts()) :
                                while ($former_researchers->have_posts()) : $former_researchers->the_post();
                            ?>
                                    <div class="card card-researcher">
                                        <?php if (has_post_thumbnail()): ?>
                                            <?php the_post_thumbnail(get_the_ID() ?? '') ?>
                                        <?php else: ?>
                                            <img src="<?= get_template_directory_uri() . '/assets/png/cland-icon.png' ?>" alt="">
                                        <?php endif ?>
                                        <h3>
                                            <?php the_title() ?>
                                        </h3>
                                        <div class="lien"><a href="<?= the_permalink(get_the_ID()) ?>">Learn more</a></div>
                                    </div>
                            <?php
                                endwhile;
                                wp_reset_postdata();
                            endif;
                            ?>
                        </div>
                    </div>
                    <?php  ?>
                </div>
            </div>
        </div>
    </div>
</div>
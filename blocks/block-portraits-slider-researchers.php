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

$type_de_chercheurs = get_field('type_de_chercheurs');


$intership_annee = get_field('intership_annee'); // tableau d'IDs
if ($intership_annee == true) {

    $term = get_term_by('id', $intership_annee, 'internship_annee');
    if ($term && !is_wp_error($term)) {
        $term = $term->slug;

        $args = array(
            'post_type' => 'researchers',
            'post_status' => 'publish',
            'posts_per_page' => -1,
            'tax_query' => array(
                array(
                    'taxonomy' => 'internship_annee',
                    'field'    => 'slug',
                    'terms'    => array($term),
                    'operator' => 'IN',
                ),
            ),
        );
    }
} else {
    if ($type_de_chercheurs == 'jeunes-chercheurs') {
        $term = 'young-researcher';
    } elseif ($type_de_chercheurs == 'anciens-chercheurs') {
        $term = 'former-researcher';
    }
    if (isset($term)) {
        $args = array(
            'post_type' => 'researchers',
            'post_status' => 'publish',
            'posts_per_page' => -1,
            'tax_query' => array(
                array(
                    'taxonomy' => 'types-de-chercheur',
                    'field'    => 'slug',
                    'terms'    => array($term),
                    'operator' => 'IN',
                ),
            ),
        );
    } else {
        $args = array(
            'post_type' => 'researchers',
            'post_status' => 'publish',
            'posts_per_page' => -1,
        );
    }
}

$team_members = new WP_Query($args);

?>
<div style="<?= esc_attr($style) ?>" class="block-researchers-slider wp-block-acf <?= esc_html($class) ?>">
    <img class="line-light-slide" src="<?= get_template_directory_uri() . '/assets/png/vector-blue-right.png' ?>" alt="">

    <div class="block">
        <div class="slider researchers">
            <div class="cards">
                <?php
                if ($team_members->have_posts()) :
                    while ($team_members->have_posts()) : $team_members->the_post();
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
    </div>
</div>
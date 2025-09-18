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

// Récupération de tous les posts publiés de type "team-members"
$args = array(
    'post_type' => 'team-members',
    'post_status' => 'publish',
    'posts_per_page' => -1,
);

$team_members = new WP_Query($args);

?>
<div style="<?= esc_attr($style) ?>" class="block-portraits-slider wp-block-acf <?= esc_html($class) ?>">
    <div class="surtitre-colore"><?= esc_html($surtitre) ?></div>
    <img class="line-light-slide" src="<?= get_template_directory_uri() . '/assets/png/line-slide-light.png' ?>" alt="">
    <div class="block">
        <div class="left-title">
            <div class="title">
                <div class="decoration-titre">
                </div>
                <?= esc_html($titre) ?>
            </div>
        </div>
        <div class="slider">
            <div class="cards">
                <?php
                if ($team_members->have_posts()) :
                    while ($team_members->have_posts()) : $team_members->the_post();
                        // Récupération des champs ACF pour chaque membre
                        $prenom = get_field('prenom', get_the_ID());
                        $nom = get_field('nom', get_the_ID());
                        $fonction = get_field('fonction', get_the_ID());
                        $linkedin = get_field('linkedin', get_the_ID());
                        $bluesky = get_field('bluesky', get_the_ID());
                        $autre_lien = get_field('autre_lien', get_the_ID());
                ?>
                        <div class="card">
                            <?php if (has_post_thumbnail()): ?>
                                <a href="<?= get_the_permalink(get_the_ID()) ?>">
                                    <?= the_post_thumbnail(get_the_ID() ?? '') ?>
                                </a>
                            <?php else: ?>
                                <img src="<?= get_template_directory_uri() . '/assets/png/cland-icon.png' ?>" alt="">
                            <?php endif; ?>
                            <h3>
                                <a href="<?= get_the_permalink(get_the_ID()) ?>">
                                    <?= esc_html($prenom) ?>
                                    <br>
                                    <?= esc_html($nom) ?>
                                </a>
                            </h3>
                            <div class="fonction">
                                <a href="<?= get_the_permalink(get_the_ID()) ?>">
                                    <?= esc_html($fonction ?? '') ?>
                                </a>
                            </div>
                            <div class="socials">
                                <?php if ($linkedin) : ?>
                                    <div class="picto-container">
                                        <a target="_blank" href="<?= esc_url($linkedin ?? '') ?>">
                                        </a>
                                        <img class="picto-card" src="<?= get_template_directory_uri() . '/assets/png/linkedin.png' ?>">
                                    </div>
                                <?php endif; ?>
                                <?php if ($bluesky) : ?>

                                    <div class="picto-container">
                                        <a target="_blank" href="<?= esc_url($bluesky ?? '') ?>">
                                        </a>
                                        <img class="picto-card" src="<?= get_template_directory_uri() . '/assets/png/bluesky.png' ?>">

                                    </div>
                                <?php endif; ?>
                                <?php if ($bluesky) : ?>

                                    <div class="picto-container">
                                        <a target="_blank" href="<?= esc_url($autre_lien ?? '') ?>">
                                        </a>
                                        <img class="picto-card" src="<?= get_template_directory_uri() . '/assets/png/link.png' ?>">

                                    </div>
                                <?php endif; ?>
                            </div>
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
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
$speakers = get_field('speakers');

?>
<div style="<?= esc_attr($style) ?>" class="  block-portraits-slider  wp-block-acf <?= esc_html($class) ?>">
    <?php require get_template_directory() . '/assets/png/deco-bck.php'; ?>
    <img class="line-light-slide" src="<?= get_template_directory_uri() . '/assets/png/line-slide-light.png' ?>" alt="">

    <div class="surtitre-colore "><?= esc_html($surtitre) ?></div>
    <div class="block">
        <div class="left-title">
            <div class="title">
                <div class="decoration-titre"></div>
                <?= esc_html($titre) ?>
            </div>
        </div>
        <div class="slider">
            <div class="cards">
                <?php

                if (is_array($speakers) && (!empty($speakers))) :

                    foreach ($speakers as $speaker):

                        // Vérification sécurisée de l'existence de la clé 'speaker'
                        if (!isset($speaker['speaker'])) {
                            continue; // Passe à l'itération suivante si 'speaker' n'existe pas
                        }

                        $speaker = $speaker['speaker'];

                        // Vérification supplémentaire que $speaker est un objet valide
                        if (!is_object($speaker) || !isset($speaker->ID)) {
                            continue; // Passe à l'itération suivante si l'objet est invalide
                        }
                        $id = $speaker->ID;
                        $image = get_the_post_thumbnail($id) ?? '';
                        $prenom = get_field('prenom', $id) ?? '';
                        $nom = get_field('nom', $id) ?? '';
                        $fonction = get_field('fonction', $id) ?? '';
                        $linkedin = get_field('linkedin', $id) ?? '';
                        $bluesky = get_field('bluesky', $id) ?? '';
                        $autre_lien = get_field('autre_lien', $id) ?? '';
                        $lien = get_the_permalink($id) ?? '';
                        $lien_vers_une_video_remplacant_limage_du_speaker = get_field('lien_vers_une_video_remplacant_limage_du_speaker', $id) ?? '';

                        // Si un lien est présent, on extrait l'ID
                        $video_id = extraire_id_youtube($lien_vers_une_video_remplacant_limage_du_speaker ?? '');

                        // On prépare l'URL d'intégration (embed)
                        $url_embed = $video_id ? "https://www.youtube.com/embed/" . $video_id : null;
                ?>
                        <div class="card">

                            <?php
                            if ($url_embed):
                            ?>
                                <iframe
                                    src="<?= esc_url($url_embed) ?>"
                                    frameborder="0"
                                    allowfullscreen
                                    allow="autoplay; encrypted-media; fullscreen; picture-in-picture">
                                </iframe>
                            <?php
                            elseif ($image):
                                echo $image;
                            else:  ?>
                                <img src="<?= get_template_directory_uri() . '/assets/png/cland-icon.png' ?>" alt="">
                            <?php endif; ?>
                            <h3>
                                <a href=" <?= $lien ?>">
                                    <?= esc_html($prenom ?? '') ?>
                                    <br>
                                    <?= esc_html($nom ?? '') ?>
                                </a>
                            </h3>
                            <div class="fonction">
                                <a href="<?= $lien ?>">
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
                    endforeach;
                endif;
                ?>
            </div>

        </div>
    </div>
</div>
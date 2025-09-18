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


$surtitre_colore = get_field('surtitre_colore');


$bloc_1_annee = get_field('bloc_1_-_annee');
$bloc_1_titre = get_field('bloc_1_-_titre');
$bloc_1_wysiwyg = get_field('bloc_1_-_wysiwyg');
$bloc_1_lien_bouton_1 = get_field('bloc_1_-_lien_bouton_1');
$bloc_1_lien_bouton_2 = get_field('bloc_1_-_lien_bouton_2');
$bloc_2_annee = get_field('bloc_2_-_annee');
$bloc_2_titre = get_field('bloc_2_-_titre');
$bloc_2_texte = get_field('bloc_2_-_texte');
$bloc_2_lien_bouton_1 = get_field('bloc_2_-_lien_bouton_1');
$bloc_2_lien_bouton_2 = get_field('bloc_2_-_lien_bouton_2');


?>
<div id="calls" style="<?= esc_attr($style) ?>" class="block-call-master-phd wp-block-acf <?= esc_html($class) ?>">

    <div class="block">
        <div class="surtitre-colore"><?= esc_html($surtitre_colore) ?></div>

        <div class="bloc bloc-1">
            <?php if ($bloc_1_annee): ?>
                <div class="annee"><?= esc_html($bloc_1_annee) ?></div>
            <?php endif; ?>

            <?php if ($bloc_1_titre): ?>
                <h2 class="titre"><?= esc_html($bloc_1_titre) ?></h2>
            <?php endif; ?>

            <?php if ($bloc_1_wysiwyg): ?>
                <div class="contenu"><?= wp_kses_post($bloc_1_wysiwyg ?? '') ?></div>
            <?php endif; ?>

            <div class="boutons">
                <?php if ($bloc_1_lien_bouton_1): ?>
                    <a href="<?= esc_url($bloc_1_lien_bouton_1['url']) ?>" class="btn btn-primary"><?= esc_html($bloc_1_lien_bouton_1['title']) ?></a>
                <?php endif; ?>
                <?php if ($bloc_1_lien_bouton_2): ?>
                    <a href="<?= esc_url($bloc_1_lien_bouton_2['url']) ?>" class="btn btn-secondary"><?= esc_html($bloc_1_lien_bouton_2['title']) ?></a>
                <?php endif; ?>
            </div>
        </div>

        <div class="bloc bloc-2">
            <?php if ($bloc_2_annee): ?>
                <div class="annee"><?= esc_html($bloc_2_annee) ?></div>
            <?php endif; ?>

            <?php if ($bloc_2_titre): ?>
                <h2 class="titre"><?= esc_html($bloc_2_titre) ?></h2>
            <?php endif; ?>

            <?php if ($bloc_2_texte): ?>
                <div class="contenu"><?= wp_kses_post($bloc_2_texte ?? '') ?></div>
            <?php endif; ?>

            <div class="boutons">
                <?php if ($bloc_2_lien_bouton_1): ?>
                    <a href="<?= esc_url($bloc_2_lien_bouton_1['url']) ?>" class="btn btn-primary"><?= esc_html($bloc_2_lien_bouton_1['title']) ?></a>
                <?php endif; ?>
                <?php if ($bloc_2_lien_bouton_2): ?>
                    <a href="<?= esc_url($bloc_2_lien_bouton_2['url']) ?>" class="btn btn-secondary"><?= esc_html($bloc_2_lien_bouton_2['title']) ?></a>
                <?php endif; ?>
            </div>
        </div>

    </div>
</div>
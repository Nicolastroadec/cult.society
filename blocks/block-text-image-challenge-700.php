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

if (empty($image)) {
    $class = $class . ' no-image ';
}
$position_de_limage = get_field('position_de_limage');

$surtitre_au_dessus_du_texte = get_field('surtitre_au_dessus_du_texte');
$titre_au_dessus_du_texte = get_field('titre_au_dessus_du_texte');

$texte = get_field('texte');
$bouton = get_field('bouton');
$options = get_field('options');

$couleur_du_challenge = get_field('couleur_du_challenge');

?>
<div style="<?= esc_attr($style) ?>" class="block-texte-image-challenge-700 wp-block-acf <?= esc_html($class) . ' ' . esc_html($couleur_du_challenge) ?> ">
    <div class="block image-<?= $position_de_limage ?>">
        <div class="image <?= esc_html($position_de_limage) ?>">
            <?php if ($image) : ?>
                <img src="<?= esc_url($image['sizes']['large'] ?? $image['url']) ?>" alt="<?= esc_attr($image['alt']) ?>">
            <?php endif; ?>
        </div>
        <div class="text">
            <?php if ($surtitre_au_dessus_du_texte): ?>
                <p class="surtitre"><?= $surtitre_au_dessus_du_texte ?></p>
            <?php endif; ?>
            <?php if ($titre_au_dessus_du_texte): ?>
                <?= $titre_au_dessus_du_texte ?>
            <?php endif; ?>
            <?php if ($texte) : ?>
                <p><?= $texte ?></p>
            <?php endif; ?>
            <?php if ($bouton) : ?>
                <div class="btn-container">
                    <a class="btn btn-secondary" href="<?= $bouton['url'] ?>"><?= $bouton['title'] ?>
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
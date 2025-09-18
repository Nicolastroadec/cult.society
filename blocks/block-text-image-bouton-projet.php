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
$position_de_limage = get_field('position_de_limage');
$titre_au_dessus_du_texte = get_field('titre_au_dessus_du_texte');
$texte = get_field('texte');
$bouton = get_field('bouton');
$options = get_field('options');

$position_de_limage = get_field('position_de_limage');

?>
<div style="<?= esc_attr($style) ?>" class="block-texte-image-bouton-projet wp-block-acf <?= esc_html($class) ?>">
    <div class="block image-<?= $position_de_limage ?>">
        <img class="deco-gauche-haut" src="<?= get_template_directory_uri() . "/assets/png/deco-gauche-haut-bloc.png" ?>" alt="">

        <div class="image <?= esc_html($position_de_limage) ?>">
            <?php if ($image) : ?>
                <img
                    src="<?= esc_url($image['sizes']['medium_large'] ?? $image['url']) ?>"
                    alt="<?= esc_attr($image['alt']) ?>"
                    loading="lazy"
                    width="<?= esc_attr($image['sizes']['medium_large_width'] ?? '') ?>"
                    height="<?= esc_attr($image['sizes']['medium_large_height'] ?? '') ?>">
            <?php endif; ?>
        </div>
        <div class="text">
            <h2><?= $titre_au_dessus_du_texte ?></h2>
            <?= $texte ?>
            <?php if ($bouton) : ?>
                <div class="btn-container">
                    <a class="btn btn-secondary" href="<?= $bouton['url'] ?>">
                        <?= $bouton['title'] ?>
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
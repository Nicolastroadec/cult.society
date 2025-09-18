<?php
require_once get_template_directory() . '/blocks/options.php';

$options = get_block_options();
$style = $options['style'] ?? '';
$bgColor = $options['bgColor'] ?? '';
if (isset($bgColor)) {
    $bgColor = 'bg-' . $bgColor;
}
$class = $bgColor;

$titre = get_field('titre') ?? '';
$texteWysiwyg = get_field('texte-wysiwyg') ?? '';

?>
<div style="<?= esc_attr($style) ?>" class="block-texte-decale-800px wp-block-acf <?= esc_html($class) ?>">
    <?php require get_template_directory() . '/assets/png/deco-bck.php'; ?>
    <div class="block">
        <h2>
            <span class="deco-titre"></span><?= esc_html($titre) ?>
        </h2>
        <div class="texte">
            <?= $texteWysiwyg ?>
        </div>
    </div>
</div>
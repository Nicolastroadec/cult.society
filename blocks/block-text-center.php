<?php
require_once get_template_directory() . '/blocks/options.php';

$options = get_block_options();
$style = $options['style'] ?? '';
$bgColor = $options['bgColor'] ?? '';
if (isset($bgColor)) {
    $bgColor = 'bg-' . $bgColor;
}

$class = $bgColor;

$texte = get_field('texte-wysiwyg') ?? '';
$boutons = get_field('boutons');
$options = get_field('options');
?>
<div style="<?= esc_attr($style) ?>" class="block-texte-center wp-block-acf <?= esc_html($class) ?>">
    <div class="block ">
        <div class="texte">
            <?= $texte ?>
        </div>
    </div>
</div>
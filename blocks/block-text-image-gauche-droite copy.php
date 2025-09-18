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
$titre_au_dessus_du_texte = get_field('titre_au_dessus_du_texte');
$texte = get_field('texte');
$bouton = get_field('bouton');
$options = get_field('options');
?>
<div style="<?= esc_attr($style) ?>" class="block-texte wp-block-acf <?= esc_html($class) ?>">
    <div class="block">
        Lorem ipsum dolor, sit amet consectetur adipisicing elit. Aspernatur ipsa soluta consectetur unde harum quo delectus nulla, quas, placeat necessitatibus fuga alias quod? Odit adipisci cum laboriosam exercitationem itaque commodi!
        <?= $texte ?>
    </div>
</div>
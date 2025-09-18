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
$position_de_texte = get_field('position_de_texte');
$titre_au_dessus_du_texte = get_field('titre_au_dessus_du_texte');
$texte = get_field('texte');
$boutons = get_field('boutons');
$options = get_field('options');
?>
<div style="<?= esc_attr($style) ?>" class="block-texte-boutons wp-block-acf <?= esc_html($class) ?>">
    <div class="block  texte-<?= $position_de_texte ?>">
        <div class="text <?= esc_html($position_de_texte) ?>">
            <h2><?= $titre_au_dessus_du_texte ?></h2>
            <p><?= $texte ?></p>
        </div>
        <div class="boutons">
            <?php
            foreach ($boutons as $bouton) {
                $style = $bouton['style_du_bouton'] ?? '';
                $bouton = $bouton['bouton'];
                if (is_array($bouton)) {
                    $url = $bouton['url'] ?? '';
                    $text = $bouton['title'] ?? ''; ?>
                    <div class="button-container">
                        <a href="<?= esc_url($url) ?>" class="btn <?= esc_attr($style) ?>">
                            <?= esc_html($text) ?>
                        </a>
                    </div> <?php
                        }
                    }
                            ?>
        </div>
    </div>
</div>
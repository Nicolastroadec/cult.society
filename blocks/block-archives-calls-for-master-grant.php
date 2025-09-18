<?php
require_once get_template_directory() . '/blocks/options.php';

$options = get_block_options();
$style = $options['style'] ?? '';
$bgColor = $options['bgColor'] ?? '';
if (isset($bgColor)) {
    $bgColor = 'bg-' . $bgColor;
}

$class = $bgColor;

$titre = get_field('titre');
$boutons_des_annees_darchives = get_field('boutons_des_annees_darchives');

$options = get_field('options');
?>
<div style="<?= esc_attr($style) ?>" class="block-archives-boutons wp-block-acf <?= esc_html($class) ?>">
    <div class="block">
        <?php if ($titre) : ?>
            <h2><?= esc_html($titre) ?></h2>
        <?php endif; ?>
        <div class="boutons">
            <?php

            if (!empty($boutons_des_annees_darchives) && is_array($boutons_des_annees_darchives)):
                foreach ($boutons_des_annees_darchives as $item):
                    $boutonTexte = $item['texte_du_bouton'] ?? '';
                    $bouton = $item['bouton'] ?? '';
                    if ($bouton instanceof WP_Post) {
                        $lien = get_permalink($bouton);
                    } else {
                        $lien = '';
                    }            ?>
                    <div class="bouton">
                        <a href="<?= esc_url($lien) ?>" class="btn btn-primary">
                            <?= esc_html($boutonTexte) ?>
                        </a>
                    </div>
            <?php
                endforeach;
            endif;
            ?>
        </div>
    </div>
</div>
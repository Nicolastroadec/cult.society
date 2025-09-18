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
$texte = get_field('texte');
$accordeon = get_field('accordeon');
$options = get_field('options');
?>
<div style="<?= esc_attr($style) ?>" class="block-texte-dropdown-right wp-block-acf <?= esc_html($class) ?>">
    <div class="block">
        <h2><?= esc_html($titre) ?></h2>

        <div class="cols">
            <div class="col-left">
                <p><?= wp_kses_post($texte ?? '') ?></p>
            </div>
            <div class="col-right">
                <div class="accordeon-container">
                    <?php
                    if (!empty($accordeon) && is_array($accordeon)):
                        foreach ($accordeon as $item): ?>

                            <?php

                            $titre = $item['titre'] ?? null;
                            $texte = $item['texte'] ?? null;
                            $titre_deuxieme_section = $item['titre_deuxieme_section'] ?? null;
                            $logos = $item['logo'] ?? null;
                            ?>
                            <div class="accordeon-element">
                                <div class="accordeon-title">
                                    <h3><?= esc_html($titre) ?></h3>
                                    <div class="cross-accordeon">
                                        <?php require get_template_directory() . '/assets/svg/cross-accordeon.php' ?>
                                    </div>
                                </div>
                                <div class="accordeon-content">
                                    <p><?= wp_kses_post($texte ?? '') ?></p>
                                    <h3><?= esc_html($titre_deuxieme_section) ?></h3>
                                    <div class="logos-container">
                                        <?php

                                        if (!empty($item['logos']) && is_array($item['logos'])):

                                            $logos = $item['logos'];

                                            foreach ($logos as $logo):
                                                $lien_au_clic_sur_le_logo = $logo['lien_au_clic_sur_le_logo'] ?? '';
                                                $logo = $logo['logo'];
                                                $logoUrl = $logo['url'] ?? ''; ?>
                                                <div class="logo-container">
                                                    <?php if ($logoUrl): ?>
                                                        <?php if ($lien_au_clic_sur_le_logo) : ?>
                                                            <a href="<?= $lien_au_clic_sur_le_logo ?>">
                                                                <img class="logo" src="<?= esc_url($logoUrl) ?>" alt="">
                                                            </a>
                                                        <?php else: ?>
                                                            <img class="logo" src="<?= esc_url($logoUrl) ?>" alt="">
                                                        <?php endif; ?>
                                                    <?php endif ?>
                                                </div>
                                        <?php endforeach;
                                        endif;   ?>
                                    </div>
                                </div>
                            </div>
                    <?php endforeach;
                    endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
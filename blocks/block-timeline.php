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

$timeline = get_field('timeline');


?>
<div style="<?= esc_attr($style) ?>" class="block-timeline wp-block-acf <?= esc_html($class) ?>">
    <img class="deco-haut-gauche" src="<?= get_template_directory_uri() . '/assets/png/deco-bck.png' ?>">

    <?php if ($titre): ?>
        <h2>
            <span class="deco-title"></span>
            <?= esc_html($titre) ?>
        </h2>
    <?php endif; ?>
    <div class="block">

        <div class="slider">
            <div class="cards">
                <?php

                if (!empty($timeline) && is_array($timeline)):
                    $number = count($timeline);
                    $i = 0;
                    foreach ($timeline as $item):
                        $date = $item['date'] ?? '';
                        $description = $item['description'] ?? ''; ?>
                        <div class="card timeline-item">
                            <h3><?= esc_html($date) ?></h3>
                            <div class="desc"><?= wp_kses_post($description ?? '') ?></div>
                        </div>
                        <?php $i++;
                        if ($i < $number): ?>
                            <img class="right-arrow" src="<?= get_template_directory_uri() . '/assets/png/vector-right.png' ?>" alt="">
                <?php endif;
                    endforeach;
                endif; ?>
            </div>
        </div>
    </div>
</div>
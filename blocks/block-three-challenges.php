<?php
require_once get_template_directory() . '/blocks/options.php';

$options = get_block_options();
$style = $options['style'] ?? '';
$bgColor = $options['bgColor'] ?? '';
if (isset($bgColor)) {
    $bgColor = 'bg-' . $bgColor;
}

$class = $bgColor;
$challenges = get_field('challenges');

?>
<div style="<?= esc_attr($style) ?>" class="block-three-challenges wp-block-acf <?= esc_html($class) ?>">


    <div class="block">
        <img class="deco-gauche-haut" src="<?= get_template_directory_uri() . "/assets/png/deco-gauche-haut-bloc.png" ?>" alt="">

        <div class="challenges">
            <?php
            if (!empty($challenges) && is_array($challenges)):
                foreach ($challenges as $challenge):
                    $visuel = $challenge['visuel'] ?? null;
                    $surtitre = $challenge['surtitre'] ?? null;
                    $titre = $challenge['titre'] ?? null;
                    $resume = $challenge['resume'] ?? null;
                    $lien = $challenge['lien'];  ?>
                    <div class="challenge">
                        <?php if ($visuel): ?>
                            <img class="visuel" src="<?= esc_url($visuel['url']) ?>" alt="">
                        <?php endif; ?>
                        <p class="surtitre"><?= esc_html($surtitre) ?></p>
                        <h3><?= esc_html($titre) ?></h3>
                        <p class="desc">
                            <?= $resume ?>
                        </p>
                        <?php if ($lien) : ?>
                            <a class="lien" href="<?= esc_url($lien['url']) ?>"><?= esc_html($lien['title']) ?></a>
                        <?php endif; ?>
                    </div>
            <?php endforeach;
            endif;   ?>
        </div>

    </div>
</div>
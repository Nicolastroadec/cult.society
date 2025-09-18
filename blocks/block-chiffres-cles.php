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
$chiffres_cles = get_field('chiffres_cles') ?? '';

?>
<div style="<?= esc_attr($style) ?>" class="block-chiffres-cles wp-block-acf <?= esc_html($class) ?>">
    <img class="deco-droite-bas" src="<?= get_template_directory_uri() . '/assets/png/deco-bck.png' ?>">

    <div class="block">
        <h2>
            <span class="deco-titre"></span><?= esc_html($titre) ?>
        </h2>
        <div class="chiffres-cles">
            <?php
            if (count($chiffres_cles) > 0) {
                foreach ($chiffres_cles as $chiffre_cle) :
                    $pictogramme = $chiffre_cle['pictogramme'] ?? '';
                    $chiffre = $chiffre_cle['chiffre'] ?? '';
                    $unites = $chiffre_cle['unites'] ?? '';
            ?>
                    <div class="chiffre-cle">
                        <?php if ($pictogramme) : ?>
                            <img
                                src="<?= esc_url($pictogramme['sizes']['small'] ?? $pictogramme['url'] ?? '') ?>"
                                alt="<?= esc_attr($pictogramme['alt'] ?? '') ?>"
                                loading="lazy"
                                width="<?= esc_attr($pictogramme['sizes']['medium_large_width'] ?? '') ?>"
                                height="<?= esc_attr($pictogramme['sizes']['medium_large_height'] ?? '') ?>"> <?php endif; ?>
                        <div class="data">
                            <p class="chiffre"><?= esc_html($chiffre) ?></p>
                            <p class="unites"><?= esc_html($unites) ?></p>
                        </div>

                    </div>
            <?php
                endforeach;
            }
            ?>

        </div>
    </div>
</div>
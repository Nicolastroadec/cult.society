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
$cartes = get_field('cartes');

$options = get_field('options');
?>
<div style="<?= esc_attr($style) ?>" class="block-cartes-simples wp-block-acf <?= esc_html($class) ?>">
    <div class="block">
        <h2><?= $titre ?></h2>

        <div class="cartes-container">
            <?php
            if (!empty($cartes) && is_array($cartes)):
                foreach ($cartes as $carte):

            ?>

                    <div class="carte">
                        <?php
                        $wysiwyg = $carte['texte_de_la_carte'] ?? null;
                        if ($wysiwyg):
                            echo $wysiwyg;
                        endif; ?>
                    </div> <?
                        endforeach;
                    endif;
                            ?>

        </div>
    </div>
</div>
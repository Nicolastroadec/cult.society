<?php



$surtitre_blanc = get_field('surtitre_blanc');
$texte_sous_le_surtitre = get_field('texte_sous_le_surtitre');
$bouton_sous_le_titre = get_field('bouton_sous_le_titre');
$titre = get_field('titre');
?>

<div class="header-bouton-sous-titre-texte-vert ">
    <div class="background"></div>

    <div class="header-content">
        <div class="left-col">
            <?php
            display_custom_breadcrumb();

            ?>
            <h1><?= $titre ?? get_the_title(); ?></h1>
            <?php if (is_array($bouton_sous_le_titre) && !empty($bouton_sous_le_titre)) :
                $lien = $bouton_sous_le_titre['url'] ?? '';
                $title = $bouton_sous_le_titre['title'] ?? '';
            ?>
                <div class="btn-container-header">
                    <a class="btn btn-secondary" href="<?= $lien ?>"><?= $title ?></a>
                </div>
            <?php endif; ?>
        </div>

        <div class="right-col">
            <div class="content">
                <div class="surtitre">
                    <?= esc_html($surtitre_blanc) ?>
                </div>
                <div class="texte-sous-surtitre">
                    <?= wp_kses_post($texte_sous_le_surtitre ?? '') ?>
                </div>
            </div>

        </div>
    </div>


</div>
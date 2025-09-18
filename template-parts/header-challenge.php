<?php

$titre_de_la_page = get_field('titre_de_la_page', get_the_ID());
$sous_titre = get_field('sous_titre', get_the_ID());
$visuel_au_dessus_du_titre = get_field('visuel_au_dessus_du_titre', get_the_ID());
$paragraphe_sous_le_titre = get_field('paragraphe_sous_le_titre', get_the_ID());
?>

<div class="header-challenge">

    <div class="header-content">

        <div class="left-col">
            <?php
            display_custom_breadcrumb();

            ?>

            <div class="content">
                <div class="titre">
                    <?= wp_kses_post($titre_de_la_page ?? '') ?>
                </div>
                <div class="sous-titre">
                    <?= esc_html($sous_titre) ?>
                </div>
                <div class="texte-sous-surtitre">
                    <?= wp_kses_post($paragraphe_sous_le_titre ?? '') ?>
                </div>
            </div>

        </div>

        <div class="right-col">
            <?php if ($visuel_au_dessus_du_titre) : ?>
                <div class="visuel-container">
                    <img class="visuel-au-dessus-du-titre" src="<?= $visuel_au_dessus_du_titre['url'] ?>">

                </div>
            <?php endif; ?>
            <div class="post-thumbnail-container">
                <?= the_post_thumbnail(get_the_ID()) ?>

            </div>
        </div>
    </div>


</div>
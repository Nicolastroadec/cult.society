<?php



$surtitre_blanc = get_field('surtitre_blanc');
$texte_sous_le_surtitre = get_field('texte_sous_le_surtitre');
?>

<div class="header-page-default">
    <div class="background"></div>

    <div class="header-content">
        <div class="left-col">
            <?php
            display_custom_breadcrumb();

            ?>
            <h1><?php the_title(); ?></h1>
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
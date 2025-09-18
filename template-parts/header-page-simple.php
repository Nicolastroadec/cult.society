<?php



$texte_sous_le_titre = get_field('texte_sous_le_titre_header_simple');
?>

<div class="header-page-simple">


    <div class="header-content">
        <?php
        display_custom_breadcrumb();
        ?>
        <div class="col">

            <h1>
                <?= the_title() ?>
            </h1>
            <?= wp_kses_post($texte_sous_le_titre ?? '') ?>
        </div>


    </div>


</div>
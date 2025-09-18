<?php

$titre_du_bloc_newsletter = get_field('titre_du_bloc_newsletter', 'option');
$texte_du_bloc_newsletter = get_field('texte_du_bloc_newsletter', 'option');
$texte_du_bouton = get_field('texte_du_bouton', 'option');

$fichier_pdf_de_la_newsletter = get_field('fichier_pdf_de_la_newsletter');

?>

<div class="block-last-newsletter wp-block-acf">
    <?php if (isset($fichier_pdf_de_la_newsletter['url'])) : ?>


        <div class="block">
            <h3><?= $titre_du_bloc_newsletter ?></h3>
            <?= $texte_du_bloc_newsletter ?>
            <div class="btn-container see-last-newsletter">
                <a href="<?= $fichier_pdf_de_la_newsletter['url'] ?>" class="btn btn-secondary"><?= $texte_du_bouton ?></a>
            </div>
            <img class="logo-cland-opacity-50" src="<?= get_template_directory_uri(); ?>/assets/png/cland-logo-opacity-50.png" alt="">
            <?php require_once get_template_directory() . '/assets/svg/newsletter-bottom-left.php' ?>
            <?php require_once get_template_directory() . '/assets/svg/newsletter-bottom-right.php' ?>

        </div>
    <?php else: ?>
        <div class="block">
            <?php
            if (function_exists('pll_current_language')) {
                $lang = pll_current_language();
                if ($lang === 'en') {
                    echo 'No new newsletter';
                } else { // par défaut français
                    echo 'Pas de nouvelle newsletter';
                }
            } else {
                // Si Polylang non actif, on met le français par défaut
                echo 'Pas de nouvelle newsletter';
            }
            ?>
        </div>
    <?php endif; ?>
</div>
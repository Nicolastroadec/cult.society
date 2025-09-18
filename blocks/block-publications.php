<?php
require_once get_template_directory() . '/blocks/options.php';

$options = get_block_options();
$style = $options['style'] ?? '';
$bgColor = $options['bgColor'] ?? '';
if (isset($bgColor)) {
    $bgColor = 'bg-' . $bgColor;
}

$class = $bgColor;
$repeteur_annees = get_field('annee');
?>
<div style="<?= esc_attr($style) ?>" class="block-publications wp-block-acf <?= esc_html($class) ?>">
    <div class="block">

        <?php
        $compteur_annee = 0;

        usort($repeteur_annees, function ($a, $b) {
            $anneeA = $a['annee']['annee'] ?? 0;
            $anneeB = $b['annee']['annee'] ?? 0;
            return $anneeB <=> $anneeA;
        });
        foreach ($repeteur_annees as $annee) {

            if (isset($annee['annee'])) {
                $annee_en_cours = $annee['annee']['annee'] ?? '';
                $texte_titre = $annee['annee']['texte_titre'] ?? '';
                $texte_auteurs = $annee['annee']['texte_auteurs'] ?? '';
                $texte_journal = $annee['annee']['texte_journal'] ?? '';
                $publications_de_lannee = $annee['annee']['publications_de_lannee'] ?? '';
            }


            if (isset($annee_en_cours)): ?>

                <div class="annee annee-<?= $compteur_annee ?>">
                    <h3 class="annee-button" id="annee-<?= $compteur_annee ?>"><?= $annee_en_cours ?></h3>

                    <table>
                        <thead>
                            <tr>
                                <th><?= esc_html($texte_titre ?? '') ?></th>
                                <th><?= esc_html($texte_auteurs ?? '')  ?></th>
                                <th><?= esc_html($texte_journal ?? '')  ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php

                            foreach ($publications_de_lannee as $publication) :
                                $titre_et_lien = $publication['titre_et_lien'] ?? '';
                                $auteur = $publication['auteurs'] ?? '';
                                $journal = $publication['journal'] ?? '';
                            ?>
                                <tr>
                                    <td>
                                        <?php if (isset($titre_et_lien['url']) && isset($titre_et_lien['title'])): ?>
                                            <a href="<?= esc_url($titre_et_lien['url']) ?>"><?= esc_html($titre_et_lien['title']) ?></a>
                                        <?php endif; ?>
                                    </td>
                                    <td><?= esc_html($auteur ?? '') ?></td>
                                    <td><?= esc_html($journal ?? '') ?></td>
                                </tr>

                            <?php endforeach; ?>

                        </tbody>


                    </table>

                </div>

                <?php $compteur_annee++ ?>

        <?php
            endif;
        }
        ?>
        <div class="flou">
            <div class="deco-container">
                <img class="deco" src="<?= get_template_directory_uri() . '/assets/png/descendre.png' ?>" alt="">
            </div>
        </div>

    </div>
</div>
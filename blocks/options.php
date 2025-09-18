<?php
function get_block_options()
{
    $marge_interne_haute = get_field('marge_interne_haute') ?: 0;
    $marge_interne_basse = get_field('marge_interne_basse') ?: 0;
    $marge_externe_haute = get_field('marge_externe_haute') ?: 0;
    $marge_externe_basse = get_field('marge_externe_basse') ?: 0;
    $couleur_de_fond_du_bloc = get_field('couleur_de_fond_du_bloc');

    $pdtop = 'padding-top:' . $marge_interne_haute . 'px; ';
    $mgbottom = 'margin-bottom:' . $marge_externe_basse . 'px; ';
    $mgtop = 'margin-top:' . $marge_externe_haute . 'px; ';
    $pdbottom = 'padding-bottom:' . $marge_interne_basse . 'px; ';


    return [
        'style' => $mgtop . $mgbottom . $pdtop . $pdbottom,
        'bgColor' => $couleur_de_fond_du_bloc,
    ];
}

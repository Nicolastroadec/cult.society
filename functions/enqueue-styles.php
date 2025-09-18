<?php

// enqueue styles assets/css/main.css

// Chargement du CSS principal (Front)
function enqueue_main_css()
{
    wp_enqueue_style(
        'main-custom-css',
        get_template_directory_uri() . '/assets/css/style.css', // Correction du chemin
        array(), // Suppression de la dépendance "generate-style"
        false,
        'all'
    );
}
add_action('wp_enqueue_scripts', 'enqueue_main_css');


// Chargement du CSS dans l'éditeur Gutenberg (Back-office)
function enqueue_main_css_editor()
{
    add_editor_style('assets/css/admin.css'); // Utilisation de add_editor_style()
}
add_action('after_setup_theme', 'enqueue_main_css_editor');

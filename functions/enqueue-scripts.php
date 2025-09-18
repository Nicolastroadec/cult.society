<?php


function generate_js_bundle_if_needed()
{
    $modules_dir = get_template_directory() . '/modules/';
    $bundle_file = get_template_directory() . '/js/bundle.js';

    // Supprime l'ancien fichier s'il existe
    if (file_exists($bundle_file)) {
        unlink($bundle_file);
    }

    $files = scandir($modules_dir);
    $bundle = '';

    foreach ($files as $file) {
        if (pathinfo($file, PATHINFO_EXTENSION) === 'js') {
            $bundle .= file_get_contents($modules_dir . $file) . "\n";
        }
    }

    file_put_contents($bundle_file, $bundle);
}
add_action('init', 'generate_js_bundle_if_needed');


// Enregistrement du script pour le frontend
function register_cland_frontend_scripts()
{
    wp_register_script(
        'bundle-js-frontend',
        get_template_directory_uri() . '/js/bundle.js',
        array('jquery'), // Dépendances frontend classiques
        filemtime(get_template_directory() . '/js/bundle.js'), // Version basée sur la date de modification du fichier
        true
    );
}
add_action('init', 'register_cland_frontend_scripts');

// Enregistrement du script pour l'éditeur Gutenberg
function register_cland_editor_scripts()
{
    wp_register_script(
        'bundle-js-editor',
        get_template_directory_uri() . '/js/bundle.js',
        array('wp-blocks', 'wp-element', 'wp-editor', 'wp-components'),
        filemtime(get_template_directory() . '/js/bundle.js'),
        true
    );
}
add_action('init', 'register_cland_editor_scripts');

// Chargement du script dans le frontend
function enqueue_cland_frontend()
{
    wp_enqueue_script('bundle-js-frontend');
}
add_action('wp_enqueue_scripts', 'enqueue_cland_frontend');

// Chargement du script dans l'éditeur Gutenberg
function enqueue_cland_gutenberg()
{
    wp_enqueue_script('bundle-js-editor');
}
add_action('enqueue_block_editor_assets', 'enqueue_cland_gutenberg');

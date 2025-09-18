<?php

/**
 * Fonction pour charger les CSS et JS dans l'éditeur Gutenberg pour l'aperçu des blocs ACF
 */
function enqueue_custom_admin_assets()
{
    // Vérifier que nous sommes bien dans l'éditeur Gutenberg
    if (
        function_exists('is_gutenberg_page') && is_gutenberg_page() ||
        (function_exists('get_current_screen') && get_current_screen() && get_current_screen()->is_block_editor())
    ) {

        // Obtenez l'URL du thème
        $theme_url = get_stylesheet_directory_uri();

        // Enregistrez et chargez le CSS
        wp_enqueue_style(
            'custom-admin-preview-css',
            $theme_url . '/assets/css/admin.css',
            array(),
            filemtime(get_stylesheet_directory() . '/assets/css/admin.css') // Version basée sur la date de modification
        );
    }
}
add_action('admin_enqueue_scripts', 'enqueue_custom_admin_assets');
add_action('enqueue_block_editor_assets', 'enqueue_custom_admin_assets');

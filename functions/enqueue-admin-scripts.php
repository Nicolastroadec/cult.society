<?php


function charger_script_admin($hook)
{
    // Vérifie si l'utilisateur est administrateur
    if (!current_user_can('manage_options')) {
        return;
    }

    // Charge ton script uniquement dans l'admin
    wp_enqueue_script(
        'mon-script-admin',
        get_template_directory_uri() . '/js/admin-script.js',
        ['jquery'],
        null,
        true
    );
}
add_action('admin_enqueue_scripts', 'charger_script_admin');

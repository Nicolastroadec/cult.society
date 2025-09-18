<?php



function afficher_message_dashboard_personnalise()
{
    if (!function_exists('get_field')) {
        // ACF n'est pas actif
        return;
    }

    $screen = get_current_screen();

    // Vérifie qu'on est bien sur la page d'accueil du dashboard
    if ($screen && $screen->base === 'dashboard') {

        // Récupération du champ ACF sur la page d’options "options-du-site"
        $texte_dashboard = get_field('texte_du_dashboard', 'options');

        if ($texte_dashboard) {
            echo '
			<div class="notice notice-info is-dismissible" style="margin-top:20px;">
				<p>' . wp_kses_post($texte_dashboard) . '</p>
			</div>';
        }
    }
}
add_action('admin_notices', 'afficher_message_dashboard_personnalise');



function definir_widgets_dashboard_par_defaut($user_id)
{
    $meta_key = 'meta-box-order_dashboard'; // ordre des widgets (non utile ici)
    $hidden_key = 'metaboxhidden_dashboard'; // widgets cachés

    // Liste des widgets qu'on veut cacher par défaut
    $widgets_a_cacher = [
        'dashboard_activity',
        'dashboard_quick_press',
        'dashboard_primary',
        'dashboard_site_health',
        'dashboard_right_now'
    ];

    // Vérifie si l'utilisateur a déjà une préférence enregistrée
    $hidden = get_user_meta($user_id, $hidden_key, true);

    if (empty($hidden)) {
        update_user_meta($user_id, $hidden_key, $widgets_a_cacher);
    }
}
add_action('user_register', 'definir_widgets_dashboard_par_defaut'); // pour les nouveaux utilisateurs
add_action('admin_init', function () {
    if (is_user_logged_in()) {
        definir_widgets_dashboard_par_defaut(get_current_user_id());
    }
});

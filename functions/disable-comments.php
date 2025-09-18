<?php
// Désactiver les commentaires partout
function disable_comments_everywhere()
{
    // Ferme les commentaires sur les nouveaux articles
    update_option('default_comment_status', 'closed');
    update_option('default_ping_status', 'closed');

    // Supprime le support des commentaires et trackbacks sur tous les types de contenu
    foreach (get_post_types() as $post_type) {
        if (post_type_supports($post_type, 'comments')) {
            remove_post_type_support($post_type, 'comments');
            remove_post_type_support($post_type, 'trackbacks');
        }
    }
}
add_action('admin_init', 'disable_comments_everywhere');

// Ferme les commentaires sur les contenus existants
function disable_comments_status($open, $post_id)
{
    return false;
}
add_filter('comments_open', 'disable_comments_status', 20, 2);
add_filter('pings_open', 'disable_comments_status', 20, 2);

// Masquer les commentaires existants
function hide_existing_comments($comments)
{
    return array();
}
add_filter('comments_array', 'hide_existing_comments', 10, 2);

// Supprimer le menu des commentaires dans l'admin
function remove_comment_menu()
{
    remove_menu_page('edit-comments.php');
}
add_action('admin_menu', 'remove_comment_menu');

// Rediriger l'accès direct à la page des commentaires
function redirect_comment_admin_page()
{
    global $pagenow;
    if ($pagenow === 'edit-comments.php') {
        wp_redirect(admin_url());
        exit;
    }
}
add_action('admin_init', 'redirect_comment_admin_page');

// Supprimer le widget "Commentaires récents" du tableau de bord
function remove_dashboard_comments_widget()
{
    remove_meta_box('dashboard_recent_comments', 'dashboard', 'normal');
}
add_action('wp_dashboard_setup', 'remove_dashboard_comments_widget');

// Supprimer le lien vers les commentaires dans la barre d'admin
function remove_admin_bar_comments()
{
    if (is_admin_bar_showing()) {
        remove_action('admin_bar_menu', 'wp_admin_bar_comments_menu', 60);
    }
}
add_action('init', 'remove_admin_bar_comments');

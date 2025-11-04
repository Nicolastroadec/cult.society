<?php
// Ajouter dans functions.php

/**
 * Enqueue scripts et localize pour AJAX
 */
function enqueue_favourites_scripts()
{
    wp_enqueue_script('favourites-js', get_template_directory_uri() . '/js/favourites.js', array('jquery'), '1.0.0', true);

    wp_localize_script('favourites-js', 'ajax_object', array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('favourite_nonce')
    ));
}
add_action('wp_enqueue_scripts', 'enqueue_favourites_scripts');

/**
 * Gestionnaire AJAX pour toggle favourite (utilisateur connecté)
 */
function handle_toggle_event_favourite()
{
    // Vérification du nonce
    if (!wp_verify_nonce($_POST['nonce'], 'favourite_nonce')) {
        wp_send_json_error('Nonce invalide');
        return;
    }

    // Vérification de l'utilisateur connecté
    if (!is_user_logged_in()) {
        wp_send_json_error('Utilisateur non connecté');
        return;
    }

    $user_id = get_current_user_id();
    $event_id = intval($_POST['event_id']);
    $action = sanitize_text_field($_POST['favourite_action']);

    // Validation des données
    if (!$event_id || !in_array($action, ['add', 'remove'])) {
        wp_send_json_error('Données invalides');
        return;
    }

    // Vérifier que l'événement existe
    if (!get_post($event_id) || get_post_type($event_id) !== 'tribe_events') {
        wp_send_json_error('Événement introuvable');
        return;
    }

    $result = ($action === 'add') ?
        add_event_to_favourites($user_id, $event_id) :
        remove_event_from_favourites($user_id, $event_id);

    if ($result) {
        wp_send_json_success($action . ' réussi');
    } else {
        wp_send_json_error('Échec de l\'opération');
    }
}
add_action('wp_ajax_toggle_event_favourite', 'handle_toggle_event_favourite');

/**
 * Ajouter un événement aux favoris d'un utilisateur
 */
function add_event_to_favourites($user_id, $event_id)
{
    $favourites = get_user_favourite_events($user_id);

    if (!in_array($event_id, $favourites)) {
        $favourites[] = $event_id;
        return update_user_meta($user_id, 'favourite_events', $favourites);
    }

    return true; // Déjà dans les favoris
}

/**
 * Retirer un événement des favoris d'un utilisateur
 */
function remove_event_from_favourites($user_id, $event_id)
{
    $favourites = get_user_favourite_events($user_id);

    $key = array_search($event_id, $favourites);
    if ($key !== false) {
        unset($favourites[$key]);
        $favourites = array_values($favourites); // Réindexer le tableau
        return update_user_meta($user_id, 'favourite_events', $favourites);
    }

    return true; // Pas dans les favoris
}

/**
 * Récupérer les événements favoris d'un utilisateur
 */
function get_user_favourite_events($user_id)
{
    $favourites = get_user_meta($user_id, 'favourite_events', true);
    return is_array($favourites) ? $favourites : [];
}

/**
 * Vérifier si un événement est dans les favoris d'un utilisateur
 */
function is_event_favourite($user_id, $event_id)
{
    $favourites = get_user_favourite_events($user_id);
    return in_array($event_id, $favourites);
}

/**
 * Fonction helper pour nettoyer les favoris (supprimer les événements supprimés)
 */
function cleanup_user_favourites($user_id)
{
    $favourites = get_user_favourite_events($user_id);
    $valid_favourites = [];

    foreach ($favourites as $event_id) {
        if (get_post($event_id) && get_post_type($event_id) === 'tribe_events') {
            $valid_favourites[] = $event_id;
        }
    }

    if (count($valid_favourites) !== count($favourites)) {
        update_user_meta($user_id, 'favourite_events', $valid_favourites);
    }

    return $valid_favourites;
}

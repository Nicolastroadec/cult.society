<?php

/**
 * Breadcrumb personnalisé avec support Polylang et CPT
 */

// Configuration des CPT et leurs parents
function get_cpt_parent_mapping()
{
    return [
        // Format: 'cpt' => ['parent_slug' => 'parent_slug', 'archive_title' => 'Titre Archive']
        'challenge' => [
            'parent_slug' => 'recherche',
            'parent_slug_en' => 'research',
            'archive_title' => 'Challenges',
            'archive_title_fr' => 'Défis'
        ],
        // Exemple pour un autre CPT
        'cours' => [
            'parent_slug' => 'e-learning',
            'parent_slug_en' => 'e-learning',
            'archive_title' => 'Courses',
            'archive_title_fr' => 'Cours'
        ],
        // Ajoutez d'autres CPT selon vos besoins
    ];
}


function truncate_title($title, $max_length = 25)
{
    if (strlen($title) <= $max_length) {
        return $title;
    }

    $truncated = substr($title, 0, $max_length);
    // Recule jusqu'au dernier espace pour ne pas couper un mot
    $last_space = strrpos($truncated, ' ');
    if ($last_space !== false) {
        $truncated = substr($truncated, 0, $last_space);
    }

    return $truncated . '…';
}
/**
 * Obtient l'URL d'accueil dans la langue actuelle
 */
function get_home_link()
{
    $home_url = function_exists('pll_home_url') ? pll_home_url() : home_url();
    $home_text = is_current_language_french() ? 'Accueil' : 'Home';

    return '<a href="' . esc_url($home_url) . '">' . $home_text . '</a>';
}

/**
 * Vérifie si la langue actuelle est le français
 */
function is_current_language_french()
{
    return function_exists('pll_current_language') && pll_current_language() === 'fr';
}

/**
 * Génère le chemin des ancêtres d'une page
 */
function get_ancestors_path($post_id)
{
    $output = '';
    $ancestors = array_reverse(get_post_ancestors($post_id));

    foreach ($ancestors as $ancestor) {
        $output .= ' &gt; <a href="' . esc_url(get_permalink($ancestor)) . '">' . get_the_title($ancestor) . '</a>';
    }

    return $output;
}

/**
 * Gère le breadcrumb pour les pages
 */
function get_page_breadcrumb()
{
    $output = '';
    $post = get_post();

    if ($post->post_parent) {
        $output .= get_ancestors_path($post->ID);
    }

    $title = truncate_title(get_the_title());

    $output .= ' &gt; <span class="current">' . $title . '</span>';

    return $output;
}

/**
 * Gère le breadcrumb pour les articles de blog
 */
function get_post_breadcrumb()
{
    $output = '';

    // Vérifie si le post avec l'ID 84 existe
    $post_84 = get_post(84);

    if ($post_84 && $post_84->post_status === 'publish') {
        $output .= ' &gt; <a href="' . esc_url(get_permalink(84)) . '">' . get_the_title(84) . '</a>';
    }

    $title = truncate_title(get_the_title());

    // Ajoute le titre courant du post
    $output .= ' &gt; <span class="current">' . $title . '</span>';

    return $output;
}


/**
 * Gère le breadcrumb pour les CPT
 */
function get_cpt_breadcrumb()
{
    $output = '';
    $post_type = get_post_type();
    $cpt_mapping = get_cpt_parent_mapping();

    if (isset($cpt_mapping[$post_type])) {
        $config = $cpt_mapping[$post_type];
        $parent_slug = is_current_language_french() ?
            ($config['parent_slug'] ?? $config['parent_slug_en']) : ($config['parent_slug_en'] ?? $config['parent_slug']);

        // Récupérer la page parent par son slug
        $parent_page = get_page_by_path($parent_slug);

        if ($parent_page) {
            $output .= ' &gt; <a href="' . esc_url(get_permalink($parent_page)) . '">' . get_the_title($parent_page) . '</a>';
        }

        // Si c'est l'archive du CPT
        if (is_post_type_archive()) {
            $archive_title = is_current_language_french() ?
                ($config['archive_title_fr'] ?? $config['archive_title']) :
                $config['archive_title'];

            $output .= ' &gt; <span class="current">' . $archive_title . '</span>';
        }
        // Si c'est un single CPT
        else {
            $archive_title = is_current_language_french() ?
                ($config['archive_title_fr'] ?? $config['archive_title']) :
                $config['archive_title'];

            $archive_url = get_post_type_archive_link($post_type);

            if ($archive_url) {
                $output .= ' &gt; <a href="' . esc_url($archive_url) . '">' . $archive_title . '</a>';
            }

            $title = truncate_title(get_the_title());

            $output .= ' &gt; <span class="current">' . $title  . '</span>';
        }
    } else {
        // CPT non configuré, affichage par défaut
        if (is_post_type_archive()) {

            $title = truncate_title(post_type_archive_title('', false));

            $output .= ' &gt; <span class="current">' . $title . '</span>';
        } else {
            $archive_url = get_post_type_archive_link($post_type);
            $post_type_obj = get_post_type_object($post_type);

            if ($archive_url && $post_type_obj) {
                $output .= ' &gt; <a href="' . esc_url($archive_url) . '">' . $post_type_obj->labels->name . '</a>';
            }

            if (is_singular('call_for_master_gran')) {
                $titrePubli = get_field('titre');
                $surtitre_blanc = get_field('surtitre_blanc');
                $parentPageTitle = get_the_title('82');
                $parentPagePermalink = get_the_permalink('82');
                if ($titrePubli && $surtitre_blanc && $parentPagePermalink) {
                    $output .= ' &gt; <span class="current">' . '<a href="' . $parentPagePermalink  . '">' . $parentPageTitle . '</a></span>' . ' &gt; <span class="current">' . $titrePubli . ' ' . $surtitre_blanc .  '</span>';
                } else {
                    $title = truncate_title(get_the_title());
                    $output .= ' &gt; <span class="current">' . $title .  '</span>';
                }
            } elseif (is_singular('event')) {
                $parentPageTitle = get_the_title('83');
                $parentPagePermalink = get_the_permalink('83');
                if ($parentPageTitle && $parentPagePermalink) {
                    $title = truncate_title(get_the_title());
                    $output .= ' &gt; <span class="current">' . '<a href="' . $parentPagePermalink  . '">' . $parentPageTitle . '</a></span>' . ' &gt; <span class="current">' . $title .  '</span>';
                }
            } elseif (is_singular('video_elearning')) {
                $parentPageTitle = get_the_title('81');
                $parentPagePermalink = get_the_permalink('81');
                if ($parentPageTitle && $parentPagePermalink) {
                    $title = truncate_title(get_the_title());
                    $output .= ' &gt; <span class="current">' . '<a href="' . $parentPagePermalink  . '">' . $parentPageTitle . '</a></span>' . ' &gt; <span class="current">' . $title .  '</span>';
                }
            } else {
                $title = truncate_title(get_the_title());
                $output .= ' &gt; <span class="current">' . $title . '</span>';
            }
        }
    }

    return $output;
}

/**
 * Gère le breadcrumb pour les archives
 */
function get_archive_breadcrumb()
{
    $output = ' &gt; <span class="current">';

    if (is_category()) {
        $output .= single_cat_title('', false);
    } elseif (is_tag()) {
        $output .= single_tag_title('', false);
    } elseif (is_author()) {
        $output .= get_the_author();
    } elseif (is_day()) {
        $output .= get_the_date();
    } elseif (is_month()) {
        $output .= get_the_date('F Y');
    } elseif (is_year()) {
        $output .= get_the_date('Y');
    } elseif (is_post_type_archive()) {
        // Géré par get_cpt_breadcrumb()
        return get_cpt_breadcrumb();
    } else {
        $output .= post_type_archive_title('', false);
    }

    $output .= '</span>';

    return $output;
}

/**
 * Gère le breadcrumb pour les pages de recherche
 */
function get_search_breadcrumb()
{
    $search_text = is_current_language_french() ? 'Résultats de recherche pour' : 'Search results for';
    $title = truncate_title(get_search_query());
    return ' &gt; <span class="current">' . $search_text . ' "' . $title . '"</span>';
}

/**
 * Fonction principale de breadcrumb
 */
function custom_breadcrumb()
{
    // Ne pas afficher sur la page d'accueil
    if (is_front_page()) return;

    $output = '<div id="breadcrumbs">';
    $output .= get_home_link();

    if (is_page() && !is_front_page()) {
        $output .= get_page_breadcrumb();
    } elseif (is_single()) {
        if (is_singular('post')) {
            $output .= get_post_breadcrumb();
        } elseif (is_singular('speaker')) {
            $parentEvent = get_field('a_quel_evenement_est_lie_ce_speaker_', get_the_ID());

            if ($parentEvent instanceof WP_Post) {
                $parentEventTitle = mb_strlen($parentEvent->post_title ?? '') > 20
                    ? mb_substr($parentEvent->post_title, 0, 20) . '…'
                    : $parentEvent->post_title;

                $parentEventURL = get_the_permalink($parentEvent->ID);

                $output .= ' > <a href="' . esc_url($parentEventURL) . '">' . $parentEventTitle . "</a>";
                $output .= get_cpt_breadcrumb();
            } else {
                $output .= get_cpt_breadcrumb();
            }
        } else {
            // C'est un CPT
            $output .= get_cpt_breadcrumb();
        }
    } elseif (is_archive()) {
        $output .= get_archive_breadcrumb();
    } elseif (is_search()) {
        $output .= get_search_breadcrumb();
    }

    $output .= '</div>';

    return $output;
}

/**
 * Fonction pour afficher le breadcrumb
 */
function display_custom_breadcrumb()
{
    echo custom_breadcrumb();
}

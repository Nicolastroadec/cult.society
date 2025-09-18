#!/bin/bash

# Vérifier si le fichier JSON est fourni
if [ "$#" -ne 1 ]; then
    echo "Usage: $0 chemin_vers_fichier.json"
    exit 1
fi

JSON_FILE=$1

# Vérifier si le fichier existe
if [ ! -f "$JSON_FILE" ]; then
    echo "Le fichier $JSON_FILE n'existe pas"
    exit 1
fi

# Fonction pour échapper les guillemets dans les valeurs JSON
escape_quotes() {
    echo "$1" | sed 's/"/\\"/g'
}

# Pour chaque objet dans le tableau JSON
wp eval-file --path=/Users/nicolastroadec/Local\ Sites/cland/app/public - "$JSON_FILE" <<'EOF'
<?php
// Lire le fichier JSON passé en argument
$json_file = $args[0];
$json_content = file_get_contents($json_file);
$videos = json_decode($json_content, true);

if (!$videos || !is_array($videos)) {
    echo "Erreur: Impossible de décoder le fichier JSON ou le contenu n'est pas un tableau.\n";
    exit(1);
}

echo "Traitement de " . count($videos) . " vidéos...\n";

// Vérifier si Polylang est actif
if (!function_exists('pll_set_post_language')) {
    echo "Erreur: Polylang n'est pas actif. Impossible de définir la langue.\n";
    exit(1);
}

// Vérifier si la langue anglaise existe dans Polylang
$english_exists = false;
if (function_exists('pll_languages_list')) {
    $languages = pll_languages_list();
    $english_exists = in_array('en', $languages);
    
    if (!$english_exists) {
        echo "Attention: La langue anglaise (en) n'est pas configurée dans Polylang. Les posts seront créés mais sans langue.\n";
    }
}

foreach ($videos as $index => $video) {
    // Validation des données requises
    if (empty($video['h5'])) {
        echo "Erreur: Titre manquant pour la vidéo à l'index $index. Ignorée.\n";
        continue;
    }
    
    echo "Traitement de la vidéo: " . $video['h5'] . "\n";
    
    // Créer le post
    $post_id = wp_insert_post([
        'post_title' => $video['h5'],
        'post_type' => 'video_elearning',
        'post_status' => 'publish'
    ]);
    
    if (is_wp_error($post_id)) {
        echo "Erreur lors de la création du post: " . $post_id->get_error_message() . "\n";
        continue;
    }
    
    echo "Post créé avec ID: $post_id\n";
    
    // Définir la langue anglaise pour le post
    if ($english_exists) {
        pll_set_post_language($post_id, 'en');
        echo "Post associé à la langue anglaise (en)\n";
    }
    
    // Mettre à jour les champs ACF
    if (!empty($video['authors'])) {
        update_field('auteurs', $video['authors'], $post_id);
    }
    
    if (!empty($video['authorsQuality'])) {
        update_field('qualite_des_auteurs', $video['authorsQuality'], $post_id);
    }
    
    if (!empty($video['authorLink'])) {
        update_field('lien_de_lauteur', $video['authorLink'], $post_id);
    }
    
    if (!empty($video['videoLink'])) {
        update_field('lien_de_la_video_youtube', $video['videoLink'], $post_id);
    }
    
    // Traiter le répéteur de tags
    if (!empty($video['tags']) && is_array($video['tags'])) {
        $rows = [];
        foreach ($video['tags'] as $tag) {
            $rows[] = ['tag' => $tag];
        }
        update_field('tags', $rows, $post_id);
    }
    
    // Gérer les taxonomies avec support Polylang
    if (!empty($video['videoType'])) {
        $term = term_exists($video['videoType'], 'type_de_video');
        if (!$term) {
            $term = wp_insert_term($video['videoType'], 'type_de_video');
            if (!is_wp_error($term) && function_exists('pll_set_term_language')) {
                pll_set_term_language($term['term_id'], 'en');
                echo "Terme '{$video['videoType']}' (type_de_video) créé et associé à la langue anglaise\n";
            }
        }
        if (!is_wp_error($term)) {
            wp_set_object_terms($post_id, intval($term['term_id']), 'type_de_video');
        }
    }
    
    if (!empty($video['challengeType'])) {
        $term = term_exists($video['challengeType'], 'type_de_challenge');
        if (!$term) {
            $term = wp_insert_term($video['challengeType'], 'type_de_challenge');
            if (!is_wp_error($term) && function_exists('pll_set_term_language')) {
                pll_set_term_language($term['term_id'], 'en');
                echo "Terme '{$video['challengeType']}' (type_de_challenge) créé et associé à la langue anglaise\n";
            }
        }
        if (!is_wp_error($term)) {
            wp_set_object_terms($post_id, intval($term['term_id']), 'type_de_challenge');
        }
    }
    
    // Gérer les thématiques avec support Polylang
    if (!empty($video['thematiques']) && is_array($video['thematiques'])) {
        $term_ids = [];
        foreach ($video['thematiques'] as $thematique) {
            $term = term_exists($thematique, 'thematiques_de_la_video');
            if (!$term) {
                $term = wp_insert_term($thematique, 'thematiques_de_la_video');
                if (!is_wp_error($term) && function_exists('pll_set_term_language')) {
                    pll_set_term_language($term['term_id'], 'en');
                    echo "Terme '{$thematique}' (thematiques_de_la_video) créé et associé à la langue anglaise\n";
                }
            }
            if (!is_wp_error($term)) {
                $term_ids[] = intval($term['term_id']);
            }
        }
        if (!empty($term_ids)) {
            wp_set_object_terms($post_id, $term_ids, 'thematiques_de_la_video');
        }
    }
    
    echo "Terminé pour la vidéo: " . $video['h5'] . "\n";
}

echo "Tous les posts ont été créés avec succès!\n";
EOF

echo "Opération terminée!"
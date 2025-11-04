<?php

function get_event_excerpt($event_id, $words = 15)
{
    // 1) Extrait saisi manuellement (champ "Extrait")
    $raw = get_the_excerpt($event_id);

    // 2) Sinon, fabriquer depuis le contenu
    if (empty($raw)) {
        $content = get_post_field('post_content', $event_id);
        // Nettoyage des blocs/shortcodes/HTML
        if (function_exists('excerpt_remove_blocks')) {
            $content = excerpt_remove_blocks($content);
        }
        $content = strip_shortcodes($content);
        $content = wp_strip_all_tags($content);
        $raw = $content;
    }

    // 3) Tronquer proprement
    return wp_trim_words($raw, $words, '…');
}

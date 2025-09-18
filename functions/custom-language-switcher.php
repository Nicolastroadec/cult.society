<?php

function custom_language_switcher_fix()
{
    // Vérifier si la fonction Polylang existe
    if (!function_exists('pll_the_languages')) {
        return;
    }

    // Récupérer le post courant
    $current_post = get_post();

    if ($current_post) {
        // Récupérer les langues configurées
        $languages = pll_languages_list();

        echo '<div class="language-switcher"><ul>';

        foreach ($languages as $lang_code) {
            // Récupérer le post traduit
            $translated_post_id = pll_get_post($current_post->ID, $lang_code);

            if ($translated_post_id) {
                // Obtenir le lien permalink pour le post traduit
                $translation_url = get_permalink($translated_post_id);

                // Obtenir les informations sur la langue
                $lang_info = PLL()->model->get_language($lang_code);

                echo '<li class="' . ($lang_code == pll_current_language() ? 'active' : '') . '">';
                echo '<a href="' . esc_url($translation_url) . '">';
                echo '<img src="' . esc_url($lang_info->flag_url) . '" alt="' . esc_attr($lang_info->name) . '" />';
                echo '</a></li>';
            }
        }

        echo '</ul></div>';
    }
}

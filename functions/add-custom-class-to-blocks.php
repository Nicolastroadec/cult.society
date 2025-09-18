<?php


function add_custom_class_to_blocks($block_content, $block)
{
    // Vérifie si le bloc a du contenu et un nom
    if (!empty($block_content) && isset($block['blockName'])) {
        // Exclure les blocs ACF
        if (strpos($block['blockName'], 'acf/') === 0) {
            return $block_content;
        }

        // Détermine la classe à ajouter
        $custom_class = 'wp-original-block';

        // Ajoute la classe dans l'attribut class=""
        $block_content = preg_replace(
            '/(<[^>]+class=["\'])/', // Recherche l'attribut class dans la balise HTML du bloc
            '$1' . $custom_class . ' ', // Ajoute la classe après l'ouverture de class="
            $block_content,
            1 // Remplace seulement la première occurrence
        );
    }
    return $block_content;
}
add_filter('render_block', 'add_custom_class_to_blocks', 10, 2);


function add_custom_class_to_blocks_editor($editor_settings, $editor_context)
{
    if (!empty($editor_settings['styles'])) {
        $editor_settings['styles'][] = array(
            'css' => '.wp-block:has(.acf-block-component) { width: auto !important; }',
            'name' => 'exclude-acf'
        );
        $editor_settings['styles'][] = array(
            'css' => '.wp-block { width: 1200px; max-width: 100%; }',
            'name' => 'wp-original-block'
        );
    }
    return $editor_settings;
}
add_filter('block_editor_settings_all', 'add_custom_class_to_blocks_editor', 10, 2);

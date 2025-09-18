<?php
class Bulma_Tags_Menu_Walker extends Walker_Nav_Menu
{
    // Pas de sous-niveaux dans cette version (comme ton HTML d'origine)
    public function start_lvl(&$output, $depth = 0, $args = null) {}
    public function end_lvl(&$output, $depth = 0, $args = null) {}

    public function start_el(&$output, $item, $depth = 0, $args = null, $id = 0)
    {
        // Récupérer les classes WP de l’élément (menu-item, menu-item-type-*, etc.)
        $classes = empty($item->classes) ? array() : (array) $item->classes;

        // Nettoyage des classes et suppression de celles inutiles ou vides
        $classes = array_filter(array_map('sanitize_html_class', $classes));

        // Construire la classe du <a>: "tag" + classes WP
        $link_classes = trim('tag ' . implode(' ', $classes));

        // Attributs du lien
        $atts           = array();
        $atts['href']   = ! empty($item->url) ? $item->url : '';
        $atts['class']  = $link_classes;
        $atts['title']  = ! empty($item->attr_title) ? $item->attr_title : '';
        $atts['target'] = ! empty($item->target) ? $item->target : '';
        $atts['rel']    = ! empty($item->xfn) ? $item->xfn : '';

        // Construire la chaîne d’attributs
        $attributes = '';
        foreach ($atts as $attr => $value) {
            if (! empty($value)) {
                $attributes .= ' ' . $attr . '="' . esc_attr($value) . '"';
            }
        }

        // Sortie exacte voulue
        $output .= '<div class="column is-4 mt-gap menuLink">';
        $output .= '<a' . $attributes . '>' . esc_html($item->title) . '</a>';
        $output .= '</div>';
    }

    public function end_el(&$output, $item, $depth = 0, $args = null)
    {
        // Rien à fermer (on a déjà fermé le div ci-dessus)
    }
}


class Bulma_Overlay_Menu_Walker extends Walker_Nav_Menu
{
    // Pas de sous-niveaux ici non plus
    public function start_lvl(&$output, $depth = 0, $args = null) {}
    public function end_lvl(&$output, $depth = 0, $args = null) {}

    public function start_el(&$output, $item, $depth = 0, $args = null, $id = 0)
    {
        // Classes WP de l’item
        $classes = empty($item->classes) ? array() : (array) $item->classes;
        $classes = array_filter(array_map('sanitize_html_class', $classes));

        // Construire les classes de <div>
        $div_classes = 'column is-full border-bottom ' . implode(' ', $classes);

        // Classes du lien (ton HTML original : overlayLink typo-h2 link + classes WP)
        $link_classes = 'overlayLink typo-h2 link ' . implode(' ', $classes);

        // Attributs du lien
        $atts           = array();
        $atts['href']   = ! empty($item->url) ? $item->url : '';
        $atts['class']  = $link_classes;
        $atts['title']  = ! empty($item->attr_title) ? $item->attr_title : '';
        $atts['target'] = ! empty($item->target) ? $item->target : '';
        $atts['rel']    = ! empty($item->xfn) ? $item->xfn : '';

        $attributes = '';
        foreach ($atts as $attr => $value) {
            if (! empty($value)) {
                $attributes .= ' ' . $attr . '="' . esc_attr($value) . '"';
            }
        }

        // Sortie HTML
        $output .= '<div class="' . esc_attr($div_classes) . '">';
        $output .= '<a' . $attributes . '>' . esc_html($item->title) . '</a>';
        $output .= '</div>';
    }

    public function end_el(&$output, $item, $depth = 0, $args = null)
    {
        // Rien à fermer en plus
    }
}

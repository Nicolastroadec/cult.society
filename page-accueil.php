<?php

/**
 * Template Name: Page d'accueil
 */
get_header();
?>

<main id="primary" class="site-main">
    <?php get_template_part('template-parts/header-home'); ?>
    <div class="page-content">
        <?php
        while (have_posts()) :
            the_post();
            the_content();

            // Récupération des événements (The Events Calendar)
            $events = tribe_get_events([
                'start_date'     => 'now',
                'end_date'       => null,
                'posts_per_page' => 10,
                'orderby'        => 'event_date',
                'order'          => 'ASC',
            ]);

            if ($events) : ?>
                <ul class="events-list">
                    <?php foreach ($events as $event) :
                        $event_id  = is_object($event) ? $event->ID : (int) $event;
                        $permalink = get_permalink($event_id);
                        $title     = get_the_title($event_id);

                        // Date de début sans l'heure
                        $start_date = tribe_get_start_date($event, false, 'Y-m-d H:i:s'); // format brut
                        $start_obj  = new DateTime($start_date);

                        // Image
                        $thumb_html = has_post_thumbnail($event_id)
                            ? get_the_post_thumbnail($event_id, 'medium_large', [
                                'class' => 'event-thumb-img',
                                'alt'   => esc_attr($title),
                            ])
                            : '';

                        // Termes (catégories TEC + tags WP)
                        $cats = get_the_terms($event_id, 'tribe_events_cat');
                        $tags = get_the_terms($event_id, 'post_tag');
                        $term_links = [];

                        if ($cats && ! is_wp_error($cats)) {
                            foreach ($cats as $term) {
                                $url = get_term_link($term);
                                if (! is_wp_error($url)) {
                                    $term_links[] = '<a class="term term--cat" href="' . esc_url($url) . '">' . esc_html($term->name) . '</a>';
                                }
                            }
                        }
                        if ($tags && ! is_wp_error($tags)) {
                            foreach ($tags as $term) {
                                $url = get_term_link($term);
                                if (! is_wp_error($url)) {
                                    $term_links[] = '<a class="term term--tag" href="' . esc_url($url) . '">#' . esc_html($term->name) . '</a>';
                                }
                            }
                        }

                        // URL de réservation : site de l’événement s'il existe, sinon ancre tickets
                        $booking_url = function_exists('tribe_get_event_website_url') ? tribe_get_event_website_url($event_id) : '';
                        if (empty($booking_url)) {
                            $booking_url = $permalink . '#tribe-tickets';
                        }
                    ?>
                        <li class="event-item event-row">
                            <div class="col-left">
                                <!-- Colonne 1 : image -->
                                <div class="event-col event-col--media">
                                    <div class="event-thumb">
                                        <?php echo $thumb_html; ?>
                                    </div>
                                </div>

                                <!-- Colonne 2 : date + termes -->
                                <div class="event-col event-col--meta">
                                    <div class="event-date">
                                        <?php echo esc_html($start_obj->format('d/m/y')); ?>
                                    </div>
                                    <a class="event-title-link" href="<?php echo esc_url($permalink); ?>">
                                        <?php echo esc_html($title); ?>
                                    </a>
                                    <?php if (! empty($term_links)) : ?>
                                        <div class="event-terms"><?php echo implode($term_links); ?></div>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <!-- Colonne 3 : titre + boutons -->
                            <div class="event-col col-right">
                                <div class="event-titles">
                                    <p class="event-excerpt">
                                        <?php echo esc_html(get_event_excerpt($event_id, 15)); ?>
                                    </p> <a class="btn btn-primary btn-read" href="<?php echo esc_url($permalink); ?>">
                                        Lire l’article
                                    </a>
                                </div>

                                <div class="event-actions">
                                    <a class="btn btn-accent btn-book" href="<?php echo esc_url($booking_url); ?>" target="_blank" rel="noopener">
                                        Réservez vite votre billet
                                    </a>
                                </div>
                            </div>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php else : ?>
                <p class="events-empty">Aucun événement à venir.</p>
        <?php endif;

        endwhile;
        ?>
    </div>
</main>

<?php get_footer(); ?>


<?php
// Utilitaire : extrait propre depuis un event (fallback sur le contenu)
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
?>
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

    // Récupérer les favoris de l'utilisateur connecté
    $user_favourites = [];
    if (is_user_logged_in()) {
        $user_favourites = get_user_favourite_events(get_current_user_id());
    }

    if ($events) : ?>

        <!-- columns border-bottom pb-gap pt-gap is-flex is-multiline ?> -->
        <ul class="events-list border-bottom pt-gap columns is-multiline">
            <?php foreach ($events as $event) :
                $event_id  = is_object($event) ? $event->ID : (int) $event;
                $permalink = get_permalink($event_id);
                $title     = get_the_title($event_id);

                // Vérifier si cet événement est dans les favoris de l'utilisateur
                $is_favourite = in_array($event_id, $user_favourites);
                $favourite_class = $is_favourite ? 'active' : '';

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
                            $term_links[] = '<a class="term term--cat typo-small" href="' . esc_url($url) . '">' . esc_html($term->name) . '</a>';
                        }
                    }
                }
                if ($tags && ! is_wp_error($tags)) {
                    foreach ($tags as $term) {
                        $url = get_term_link($term);
                        if (! is_wp_error($url)) {
                            $term_links[] = '<a class="term term--tag typo-small" href="' . esc_url($url) . '">#' . esc_html($term->name) . '</a>';
                        }
                    }
                }

                // URL de réservation : site de l'événement s'il existe, sinon ancre tickets
                $booking_url = function_exists('tribe_get_event_website_url') ? tribe_get_event_website_url($event_id) : '';
                if (empty($booking_url)) {
                    $booking_url = $permalink . '#tribe-tickets';
                }
            ?>
                <li class="event-item event-row border-bottom pb-gap" event-id="<?= $event_id ?>">
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
                                <p class="typo-small"><?php echo esc_html($start_obj->format('d/m/y')); ?></p>
                            </div>
                            <a class="event-title-link typo-small" href="<?php echo esc_url($permalink); ?>">
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
                            </p>
                            <a class="tag btn-lire-la-suite" href="<?php echo esc_url($permalink); ?>">
                                Lire l'article
                            </a>
                        </div>

                        <div class="event-actions">
                            <a class="btn btn-accent btn-book" href="<?php echo esc_url($booking_url); ?>" target="_blank" rel="noopener">
                                <svg width="800px" height="800px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M4 12H20M20 12L14 6M20 12L14 18" stroke="#000000ff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                Réservez vite votre billet
                            </a>
                        </div>
                    </div>

                    <?php if (is_user_logged_in()) : ?>
                        <button class="favourite <?php echo esc_attr($favourite_class); ?>"
                            type="button"
                            aria-label="<?php echo $is_favourite ? 'Retirer des favoris' : 'Ajouter aux favoris'; ?>"
                            title="<?php echo $is_favourite ? 'Retirer des favoris' : 'Ajouter aux favoris'; ?>">
                            <svg width="800px" height="800px" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path d="M9.15316 5.40838C10.4198 3.13613 11.0531 2 12 2C12.9469 2 13.5802 3.13612 14.8468 5.40837L15.1745 5.99623C15.5345 6.64193 15.7144 6.96479 15.9951 7.17781C16.2757 7.39083 16.6251 7.4699 17.3241 7.62805L17.9605 7.77203C20.4201 8.32856 21.65 8.60682 21.9426 9.54773C22.2352 10.4886 21.3968 11.4691 19.7199 13.4299L19.2861 13.9372C18.8096 14.4944 18.5713 14.773 18.4641 15.1177C18.357 15.4624 18.393 15.8341 18.465 16.5776L18.5306 17.2544C18.7841 19.8706 18.9109 21.1787 18.1449 21.7602C17.3788 22.3417 16.2273 21.8115 13.9243 20.7512L13.3285 20.4768C12.6741 20.1755 12.3469 20.0248 12 20.0248C11.6531 20.0248 11.3259 20.1755 10.6715 20.4768L10.0757 20.7512C7.77268 21.8115 6.62118 22.3417 5.85515 21.7602C5.08912 21.1787 5.21588 19.8706 5.4694 17.2544L5.53498 16.5776C5.60703 15.8341 5.64305 15.4624 5.53586 15.1177C5.42868 14.773 5.19043 14.4944 4.71392 13.9372L4.2801 13.4299C2.60325 11.4691 1.76482 10.4886 2.05742 9.54773C2.35002 8.60682 3.57986 8.32856 6.03954 7.77203L6.67589 7.62805C7.37485 7.4699 7.72433 7.39083 8.00494 7.17781C8.28555 6.96479 8.46553 6.64194 8.82547 5.99623L9.15316 5.40838Z" stroke="#000000ff" stroke-width="1.5" />
                            </svg>
                        </button>
                    <?php endif; ?>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else : ?>
        <p class="events-empty">Aucun événement à venir.</p>
<?php endif;

endwhile;
?>
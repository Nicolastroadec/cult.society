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

            // Dans un template ou un bloc de code PHP
            $events = tribe_get_events([
                'start_date'     => 'now',     // à partir d'aujourd'hui
                'end_date'       => null,      // pas de fin
                'posts_per_page' => 10,
                'orderby'        => 'event_date',
                'order'          => 'ASC',
            ]);

            if ($events) : ?>
                <ul class="events-list">
                    <?php foreach ($events as $event) : ?>
                        <li class="event-item">
                            <a href="<?php echo esc_url(get_permalink($event)); ?>">
                                <?php echo esc_html(get_the_title($event)); ?>
                            </a>

                            <div class="event-meta">
                                <?php
                                // Dates (respecte le fuseau/format de TEC)
                                echo esc_html(tribe_get_start_date($event, true, 'j F Y H:i'));
                                $end = tribe_get_end_date($event, true, 'j F Y H:i');
                                if ($end) {
                                    echo ' — ' . esc_html($end);
                                }

                                // Lieu (si vous utilisez les lieux de TEC)
                                $venue = tribe_get_venue($event->ID);
                                if ($venue) {
                                    echo ' · ' . esc_html($venue);
                                }
                                ?>
                            </div>

                            <?php if (has_post_thumbnail($event)) : ?>
                                <div class="event-thumb">
                                    <?php echo get_the_post_thumbnail($event, 'medium'); ?>
                                </div>
                            <?php endif; ?>

                            <div class="event-excerpt">
                                <?php echo wp_kses_post(wp_trim_words(get_the_excerpt($event), 25)); ?>
                            </div>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php else : ?>
                <p>Aucun événement à venir.</p>
        <?php endif;

        endwhile;
        ?>
    </div>
</main>

<?php get_footer(); ?>
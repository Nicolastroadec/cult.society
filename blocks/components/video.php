<div class="card video <?php echo esc_attr(trim($term_classes)); ?>" data-filters="<?php echo esc_attr($data_filters_attr); ?>">
    <?php if (!empty($lien_de_la_video_youtube)) :
        // Récupération de l'ID YouTube
        preg_match('/(?:youtube\.com\/(?:watch\?v=|embed\/)|youtu\.be\/)([a-zA-Z0-9_-]{11})/', $lien_de_la_video_youtube, $matches);
        $video_id = isset($matches[1]) ? $matches[1] : '';
        if ($video_id): ?>
            <div class="video-thumbnail" data-id="<?php echo esc_attr($video_id); ?>">
                <img src="https://img.youtube.com/vi/<?php echo esc_attr($video_id); ?>/hqdefault.jpg" alt="Vidéo" loading="lazy">
                <div class="thumbnail-overlay">
                    <div class="play-button">
                        ▶
                    </div>
                </div>
            </div>
    <?php endif;
    endif; ?>

    <div class="taxonomies-and-terms">
        <?php if (!empty($type_de_challenge_terms) && !is_wp_error($type_de_challenge_terms)) : ?>
            <?php foreach ($type_de_challenge_terms as $term) {
                $termName = '';

                if ($term->name === "challenge-1") {
                    $termName = "Challenge 1";
                } elseif ($term->name === "challenge-2") {
                    $termName = "Challenge 2";
                } elseif ($term->name === "challenge-3") {
                    $termName = "Challenge 3";
                }
            ?>
                <p class="term term-challenge term-<?php echo esc_html($term->name); ?>">
                    <?php echo esc_html($termName); ?>
                </p>
            <?php
            } ?>
        <?php endif; ?>

        <?php if (!empty($thematiques_terms) && !is_wp_error($thematiques_terms)) : ?>
            <?php foreach ($thematiques_terms as $term) : ?>
                <p class="term">
                    <?php echo esc_html($term->name); ?>
                </p>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <h3>
        <?php
        $title = get_the_title();
        echo mb_strimwidth($title, 0, 100, '...');
        ?>
    </h3>
    <?php if (!empty($lien_de_lauteur)): ?>
        <a class="auteurs" href="<?php echo esc_url($lien_de_lauteur); ?>">
            <?php if (!empty($auteurs)): ?>
                <?php echo esc_html($auteurs); ?>
            <?php endif; ?>
        </a>
    <?php else: ?>
        <div class="auteurs">
            <?php if (!empty($auteurs)): ?>
                <?php echo esc_html($auteurs); ?>
            <?php endif; ?>
        </div>
    <?php endif; ?>

    <?php if (!empty($qualite_des_auteurs)) : ?>
        <div class="qualite-des-auteurs">
            <?php echo wp_kses_post($qualite_des_auteurs ?? ''); ?>
        </div>
    <?php endif; ?>

    <a class="learn-more" href="<?php echo esc_url(get_permalink(get_the_id())); ?>">Learn more</a>
</div>
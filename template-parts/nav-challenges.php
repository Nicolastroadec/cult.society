<?php
// Récupérer le challenge précédent
$prev = get_previous_post();
$next = get_next_post();
$title = get_field('titre_navigation_challenges', 'option');
// Vérifier si on a un challenge précédent
if ($prev):
    $prev_thumbnail = get_the_post_thumbnail($prev->ID, 'thumbnail'); // Image miniature
    $prev_acf_title = get_field('titre_de_la_page', $prev->ID);
    $prev_title = get_the_title($prev->ID); // Titre
    $prev_url = get_permalink($prev->ID); // Lien
endif;

// Vérifier si on a un challenge suivant
if ($next):
    $next_thumbnail = get_the_post_thumbnail($next->ID, 'thumbnail'); // Image miniature
    $next_acf_title = get_field('titre_de_la_page', $next->ID);
    $next_title = get_the_title($next->ID); // Titre
    $next_url = get_permalink($next->ID); // Lien
endif;
?>


<?php if ($next || $prev) : ?>
    <div class="nav-container">
        <?php if ($title): ?>
            <h2><?= esc_html($title) ?></h2>

        <?php endif; ?>

        <div class="challenge-nav nav-posts">
            <div class="prev-challenge prev">
                <?php if ($prev): ?>

                    <div class="left">
                        <?php echo $prev_thumbnail; ?>

                    </div>
                    <div class="right">
                        <h4>
                            <?= wp_strip_all_tags($prev_acf_title) ?>
                        </h4>
                        <a href="<?php echo esc_url($prev_url); ?>" class="prev-link">
                            <span class="prev-title">
                                <?php
                                $lang = pll_current_language();
                                ?>
                                <span>
                                    <?= $lang === 'fr' ? '< ' . 'Défi précédent' : '< ' . 'Previous challenge'; ?>
                                </span>
                        </a>
                    </div>
                <?php endif; ?>

            </div>

            <div class="next-challenge next">
                <?php if ($next): ?>

                    <div class="left">
                        <h4>
                            <?= wp_strip_all_tags($next_acf_title) ?>
                        </h4>
                        <a href="<?php echo esc_url($next_url); ?>" class="next-link">

                            <?php
                            $lang = pll_current_language();
                            ?>
                            <span>
                                <?= $lang === 'fr' ? 'Défi suivant' . ' >' : 'Next challenge' . ' >'; ?>
                            </span>
                        </a>
                    </div>
                    <div class="right">
                        <?php echo $next_thumbnail; ?>
                    </div>
                <?php endif; ?>

            </div>
        </div>
    </div>
<?php endif; ?>
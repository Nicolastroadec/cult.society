<?php
// Récupérer le challenge précédent
$prev = get_previous_post();
$next = get_next_post();

$postType = $post->post_type;

$titre_navigation_challenges = get_field('titre_navigation_challenges', 'option');
$challenge_precedent = get_field('challenge_precedent', 'option');
$challenge_suivant = get_field('challenge_suivant', 'option');
$titre_navigation_posts = get_field('titre_navigation_posts', 'option');
$article_suivant = get_field('article_suivant', 'option');
$article_precedent = get_field('article_precedent', 'option');
$titre_navigation_team_members = get_field('titre_navigation_team_members', 'option');
$team_member_precedent = get_field('team_member_precedent', 'option');
$team_member_suivant = get_field('team_member_suivant', 'option');
$titre_navigation_video_elearning = get_field('titre_navigation_video_e-learning', 'option');
$video_suivante = get_field('video_suivante', 'option');
$video_precedente = get_field('video_precedente', 'option');
$titre_navigation_researchers = get_field('titre_navigation_researchers', 'option');
$researcher_suivant = get_field('researcher_suivant', 'option');
$researcher_precedent = get_field('researcher_precedent', 'option');
$titre_navigation_jobs = get_field('titre_navigation_jobs', 'option');
$job_suivant = get_field('job_suivant', 'option');
$job_precedent = get_field('job_precedent', 'option');
$titre_navigation_events = get_field('titre_navigation_events', 'option');
$event_precedent = get_field('event_precedent', 'option');
$event_suivant = get_field('event_suivant', 'option');
$titre_navigation_speaker = get_field('titre_navigation_speaker', 'option');
$speaker_precedent = get_field('speaker_precedent', 'option');
$speaker_suivant = get_field('speaker_suivant', 'option');

$titre_navigation_call_for_master_grant = get_field('titre_navigation_call_for_master_grant', 'option');
$call_suivant = get_field('call_suivant', 'option');
$call_precedent = get_field('call_precedent', 'option');

$title = '';
$next_post = '';
$prev_post = '';

$postType = $post->post_type;


// post_type : jobs, team-members, researchers, video_elearning, challenge, event, speaker
if ($postType === 'post') {
    // Type: Articles de blog standard
    $title = $titre_navigation_posts;
    $next_post = $article_suivant;
    $prev_post = $article_precedent;
} elseif ($postType === 'team-members') {
    // Type: Membres de l'équipe
    $title = $titre_navigation_team_members;
    $next_post = $team_member_suivant;
    $prev_post = $team_member_precedent;
} elseif ($postType === 'challenge') {
    // Type: Challenges
    $title = $titre_navigation_challenges;
    $next_post = $challenge_suivant;
    $prev_post = $challenge_precedent;
} elseif ($postType === 'video_elearning') {
    // Type: Vidéos e-learning
    $title = $titre_navigation_video_elearning;
    $next_post = $video_suivante;
    $prev_post = $video_precedente;
} elseif ($postType === 'researchers') {
    // Type: Chercheurs
    $title = $titre_navigation_researchers;
    $next_post = $researcher_suivant;
    $prev_post = $researcher_precedent;
} elseif ($postType === 'jobs') {
    // Type: Offres d'emploi
    $title = $titre_navigation_jobs;
    $next_post = $job_suivant;
    $prev_post = $job_precedent;
} elseif ($postType === 'event') {
    // Type: Événements
    $title = $titre_navigation_events;
    $next_post = $event_suivant;
    $prev_post = $event_precedent;
} elseif ($postType === 'speaker') {
    // Type: Conférenciers
    $title = $titre_navigation_speaker;
    $next_post = $speaker_suivant;
    $prev_post = $speaker_precedent;
} elseif ($postType === 'call_for_master_gran') {
    $titre = get_field('titre', get_the_ID());
    $next_post = $call_suivant;
    $prev_post = $call_precedent;
}
// Vérifier si on a un post précédent
if ($prev):
    $prev_thumbnail = has_post_thumbnail($prev->ID)
        ? get_the_post_thumbnail($prev->ID, 'thumbnail')
        : get_custom_logo();

    $prev_title = get_the_title($prev->ID); // Titre

    $prev_url = get_permalink($prev->ID); // Lien
endif;

// Vérifier si on a un post suivant
if ($next):
    $next_thumbnail = has_post_thumbnail($next->ID)
        ? get_the_post_thumbnail($next->ID, 'thumbnail')
        : get_custom_logo();

    $next_title = get_the_title($next->ID); // Titre
    $next_url = get_permalink($next->ID); // Lien
endif;
?>
<?php if ($next || $prev) : ?>

    <div class="nav-container">
        <?php if ($title): ?>
            <h2><?= esc_html($title) ?></h2>

        <?php endif; ?>

        <div class="posts-nav nav-posts">
            <div class="prev-post prev nav">
                <?php if ($prev): ?>

                    <div class="left">
                        <?php echo $prev_thumbnail; ?>
                    </div>
                    <div class="right">
                        <h4>
                            <a href="<?= $prev_url ?>">
                                <?= $prev_title ?>
                            </a>
                        </h4>
                        <a href="<?php echo esc_url($prev_url); ?>" class="prev-link">
                            <?php
                            $lang = pll_current_language();
                            ?>
                            <span>
                                <?= '< ' . $prev_post; ?>
                            </span>
                        </a>
                    </div>
                <?php endif; ?>

            </div>

            <div class="next-post next nav">
                <?php if ($next): ?>

                    <div class="left">
                        <h4>
                            <a href="<?= $next_url ?>">
                                <?= $next_title ?>
                            </a>
                        </h4>
                        <a href="<?php echo esc_url($next_url); ?>" class="next-link">
                            <?php
                            $lang = pll_current_language();
                            ?>
                            <span>
                                <?= $next_post . ' >'; ?>
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
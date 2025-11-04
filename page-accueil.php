<?php

/**
 * Template Name: Page d'accueil
 */
get_header();
?>

<main id="primary" class="site-main">
    <?php get_template_part('template-parts/header-home'); ?>
    <div class="page-content">
        <?php require get_template_directory() . '/inc/events-list.php'; ?>
    </div>
</main>

<?php get_footer(); ?>


<?php
// Utilitaire : extrait propre depuis un event (fallback sur le contenu)

?>
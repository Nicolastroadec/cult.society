<?php

/**
 * The template for displaying all single post
 */
get_header();

exit;
?>

<?php
function add_noindex_meta_tag()
{
	echo '<meta name="robots" content="noindex, nofollow">' . "\n";
}
add_action('wp_head', 'add_noindex_meta_tag');
?>

<main id="primary" class="site-main">
</main>

<?php get_footer(); ?>
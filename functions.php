<?php

if (! defined('_S_VERSION')) {
	// Replace the version number of the theme on each release.
	define('_S_VERSION', '1.0.0');
}

/**
 * Enqueue scripts and styles.
 */
/* function cland_scripts()
{
	wp_enqueue_style('cland-style', get_stylesheet_uri(), array(), _S_VERSION);
	wp_style_add_data('cland-style', 'rtl', 'replace');


	if (is_singular() && comments_open() && get_option('thread_comments')) {
		wp_enqueue_script('comment-reply');
	}
}
add_action('wp_enqueue_scripts', 'cland_scripts');
 */
/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if (defined('JETPACK__VERSION')) {
	require get_template_directory() . '/inc/jetpack.php';
}


// require_once get_template_directory() . '/functions/add-custom-class-to-blocks.php';
require_once get_template_directory() . '/functions/enqueue-styles.php';
//require_once get_template_directory() . '/functions/register-blocks.php';
require_once get_template_directory() . '/functions/enqueue-admin-scripts.php';
require_once get_template_directory() . '/functions/enqueue-scripts.php';
require_once get_template_directory() . '/functions/enqueue-style-and-js-for-editor.php';
//require_once get_template_directory() . '/functions/dashboard-message.php';
require_once get_template_directory() . '/functions/breadcrumb.php';
require_once get_template_directory() . '/functions/disable-comments.php';
//require_once get_template_directory() . '/functions/reusable-blocks.php';




// Cult.society :

require_once get_template_directory() . '/functions/add-bulma-tags-menu-walker.php';


add_action('init', function () {
	if ($role = get_role('administrator')) {
		$role->add_cap('edit_theme_options');
	}
});


// 1) Le thème doit supporter les images mises en avant
add_action('after_setup_theme', function () {
	add_theme_support('post-thumbnails');
});

// 2) On s'assure que le post type TEC a bien le support 'thumbnail'
add_action('init', function () {
	add_post_type_support('tribe_events', 'thumbnail');
}, 100);

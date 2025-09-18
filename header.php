<?php

/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Cland
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>

<head>
	<meta charset="<?php bloginfo('charset'); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
	<?php wp_body_open(); ?>
	<div id="page" class="container pb-gap">
		<a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e('Skip to content', 'cland'); ?></a>
		<header class="header js-header" role="banner">
			<div class="columns hide-on-mobile pb-gap">

				<?php
				wp_nav_menu(array(
					'menu'       => 'Menu principal', // Nom exact du menu WP
					'container'  => false,            // pas de <div> auto
					'items_wrap' => '<div class="menu column is-20"><div class="columns is-multiline">%3$s</div></div>',
					'walker'     => new Bulma_Tags_Menu_Walker(),
					'depth'      => 1,                // un seul niveau, comme ton HTML source
				));

				?>

				<div class="column is-4 mt-gap mt-gap search-column">
					<div class="columns">
						connexion
					</div>
					<div class="columns">
						<div class="column is-full socials">
							<a target="_blank" href="https://www.linkedin.com/company/cult_news/" title="Cult - Linkedin">
								<svg class="icon" height="43.169" viewBox="0 0 43.169 43.169" width="43.169" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
									<clipPath id="linkedin">
										<path d="m0-41.87h43.169v-43.169h-43.169z" transform="translate(0 85.039)"></path>
									</clipPath>
									<g clip-path="url(#linkedin)">
										<path d="m-9.353 0a9.643 9.643 0 0 0 -9.647 9.644v23.881a9.643 9.643 0 0 0 9.644 9.644h23.884a9.644 9.644 0 0 0 9.644-9.644v-23.881a9.644 9.644 0 0 0 -9.644-9.644z" transform="translate(18.997)"></path>
										<path d="m20.9-59.594h4.552v-3.922h-4.552zm.032 17.394h4.5v-15.241h-4.5zm11.833-15.243h-4.356v15.243h4.5v-8.6c0-1.95 1.174-3.354 2.923-3.354a2.461 2.461 0 0 1 2.552 2.78v9.174h4.467v-10.03c0-3.408-1.947-5.641-5.3-5.641a4.954 4.954 0 0 0 -4.7 2.748h-.086z" fill="#fff" transform="translate(-10.292 74.442)"></path>
									</g>
								</svg>
							</a>

							<a target="_blank" href="https://www.facebook.com/profile.php?id=61550719173415" title="Cult - Facebook">
								<svg class="icon" height="43.169" viewBox="0 0 43.169 43.169" width="43.169" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
									<clipPath id="facebook">
										<path d="m0-41.87h43.169v-43.169h-43.169z" transform="translate(0 85.039)"></path>
									</clipPath>
									<g clip-path="url(#facebook)">
										<path d="m-9.353 0a9.643 9.643 0 0 0 -9.647 9.644v23.881a9.643 9.643 0 0 0 9.644 9.644h23.884a9.644 9.644 0 0 0 9.644-9.644v-23.881a9.644 9.644 0 0 0 -9.644-9.644z" transform="translate(18.997)"></path>
										<path d="m-12.662-13.92.724-4.617h-4.529v-3a2.334 2.334 0 0 1 2.661-2.495h2.059v-3.931a25.676 25.676 0 0 0 -3.655-.312c-3.73 0-6.168 2.211-6.168 6.214v3.519h-4.146v4.617h4.146v11.168a16.834 16.834 0 0 0 2.551.194 16.841 16.841 0 0 0 2.552-.194v-11.163z" fill="#fff" transform="translate(40.315 37.002)"></path>
									</g>
								</svg>
							</a>

							<a target="_blank" href="https://www.instagram.com/cult_news/" title="Cult - Instagram">
								<svg class="icon" height="43.169" viewBox="0 0 43.169 43.169" width="43.169" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
									<clipPath id="insta">
										<path d="m0-41.87h43.169v-43.169h-43.169z" transform="translate(0 85.039)"></path>
									</clipPath>
									<g clip-path="url(#insta)">
										<path d="m-9.354 0a9.643 9.643 0 0 0 -9.646 9.644v23.881a9.643 9.643 0 0 0 9.643 9.644h23.885a9.644 9.644 0 0 0 9.644-9.644v-23.881a9.644 9.644 0 0 0 -9.644-9.644z" transform="translate(18.997)"></path>
										<g fill="#fff">
											<path d="m-11.92-2.175c3.281 0 3.67.013 4.966.073a6.722 6.722 0 0 1 2.282.428 3.814 3.814 0 0 1 1.413.93 3.869 3.869 0 0 1 .92 1.432 6.972 6.972 0 0 1 .423 2.312c.059 1.312.072 1.706.072 5.028s-.012 3.716-.072 5.028a6.969 6.969 0 0 1 -.423 2.31 3.869 3.869 0 0 1 -.919 1.434 3.807 3.807 0 0 1 -1.413.93 6.722 6.722 0 0 1 -2.282.428c-1.3.06-1.684.073-4.966.073s-3.67-.013-4.966-.073a6.722 6.722 0 0 1 -2.282-.428 3.8 3.8 0 0 1 -1.413-.93 3.869 3.869 0 0 1 -.919-1.431 6.955 6.955 0 0 1 -.423-2.31c-.059-1.312-.072-1.706-.072-5.028s.012-3.716.072-5.028a6.958 6.958 0 0 1 .422-2.315 3.869 3.869 0 0 1 .919-1.431 3.81 3.81 0 0 1 1.413-.93 6.722 6.722 0 0 1 2.282-.427c1.3-.06 1.685-.073 4.966-.073m0-2.242c-3.338 0-3.756.015-5.067.075a8.923 8.923 0 0 0 -2.983.578 6.025 6.025 0 0 0 -2.177 1.435 6.1 6.1 0 0 0 -1.417 2.2 9.23 9.23 0 0 0 -.572 3.02c-.06 1.327-.074 1.751-.074 5.13s.014 3.8.074 5.13a9.23 9.23 0 0 0 .572 3.02 6.1 6.1 0 0 0 1.417 2.2 6.019 6.019 0 0 0 2.177 1.435 8.923 8.923 0 0 0 2.983.578c1.311.061 1.73.075 5.067.075s3.756-.014 5.067-.075a8.923 8.923 0 0 0 2.983-.578 6.019 6.019 0 0 0 2.177-1.435 6.1 6.1 0 0 0 1.417-2.2 9.23 9.23 0 0 0 .576-3.017c.06-1.327.074-1.751.074-5.13s-.018-3.803-.074-5.126a9.23 9.23 0 0 0 -.576-3.024 6.1 6.1 0 0 0 -1.417-2.2 6.025 6.025 0 0 0 -2.177-1.44 8.923 8.923 0 0 0 -2.983-.578c-1.311-.06-1.729-.075-5.067-.075" transform="translate(33.504 13.558)"></path>
											<path d="m-5.481 0a5.686 5.686 0 0 0 -5.65 5.721 5.686 5.686 0 0 0 5.65 5.721 5.686 5.686 0 0 0 5.651-5.721 5.686 5.686 0 0 0 -5.651-5.721m0 9.434a3.691 3.691 0 0 1 -3.667-3.713 3.691 3.691 0 0 1 3.667-3.714 3.691 3.691 0 0 1 3.668 3.714 3.691 3.691 0 0 1 -3.668 3.713" transform="translate(27.065 15.863)"></path>
										</g>
									</g>
								</svg>
							</a>

							<a target="_blank" href="https://www.youtube.com/@CultNews" title="Cult - Youtube">
								<svg class="icon" height="43.169" viewBox="0 0 43.169 43.169" width="43.169" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
									<clipPath id="youtube">
										<path d="m0-41.87h43.169v-43.169h-43.169z" transform="translate(0 85.039)"></path>
									</clipPath>
									<g clip-path="url(#youtube)">
										<path d="m-9.353 0a9.643 9.643 0 0 0 -9.647 9.644v23.881a9.643 9.643 0 0 0 9.644 9.644h23.884a9.644 9.644 0 0 0 9.644-9.644v-23.881a9.644 9.644 0 0 0 -9.644-9.644z" transform="translate(18.997)"></path>
										<path d="m-24.789-2.768a3.269 3.269 0 0 0 -2.311-2.307c-2.036-.546-10.2-.546-10.2-.546s-8.162 0-10.2.546a3.268 3.268 0 0 0 -2.3 2.307 33.95 33.95 0 0 0 -.546 6.282 33.955 33.955 0 0 0 .546 6.286 3.268 3.268 0 0 0 2.308 2.308c2.036.546 10.2.546 10.2.546s8.163 0 10.2-.546a3.269 3.269 0 0 0 2.303-2.308 33.955 33.955 0 0 0 .546-6.283 33.95 33.95 0 0 0 -.546-6.282m-15.116 10.2v-7.835l6.781 3.916z" fill="#fff" transform="translate(58.879 18.069)"></path>
									</g>
								</svg>
							</a>

							<a target="_blank" href="https://twitter.com" title="Cult - Twitter">
								<svg class="icon" enable-background="new 0 0 43.2 43.2" viewBox="0 0 43.2 43.2" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
									<clipPath id="twitter">
										<path d="m0 0h43.2v43.2h-43.2z"></path>
									</clipPath>
									<g clip-path="url(#twitter)">
										<path d="m9.6 0c-5.3 0-9.6 4.3-9.6 9.6v23.9c0 5.3 4.3 9.6 9.6 9.6h23.9c5.3 0 9.6-4.3 9.6-9.6v-23.9c0-5.3-4.3-9.6-9.6-9.6z"></path>
										<path d="m24.5 20 9.3-10.9h-2.2l-8.1 9.4-6.5-9.4h-7.4l9.8 14.2-9.8 11.5h2.2l8.6-9.9 6.8 9.9h7.5zm-3 3.5-1-1.4-7.9-11.3h3.4l6.4 9.1 1 1.4 8.3 11.8h-3.4z" fill="#fff"></path>
									</g>
								</svg>
							</a>
						</div>
					</div>
				</div>
			</div>

			<div class="hide-on-desktop menu-mobile-button">
				<div class="column is-half menuLink">
					<a class="tag typo-small js-toggleMenu menu-button">
						<svg class="open" viewBox="0 0 50 16" width="30" xmlns="http://www.w3.org/2000/svg">
							<g stroke="#000" stroke-linecap="round" stroke-width="2">
								<path d="m1 1h48"></path>
								<path d="m1 15h48"></path>
							</g>
						</svg>

						<svg class="close" height="28.909" viewBox="0 0 43.023 28.909" width="30" xmlns="http://www.w3.org/2000/svg">
							<g fill="none" stroke-linecap="round" stroke-width="2">
								<path d="m0 0h48" transform="matrix(.839 .545 -.545 .839 1.383 1.383)"></path>
								<path d="m0 0h48" transform="matrix(.839 -.545 .545 .839 1.383 27.526)"></path>
							</g>
						</svg>
					</a>
				</div>
			</div>

			<div class="columns pb-gap pt-gap is-multiline is-flex has-background-gold-gradient">
				<div class="column is-6 is-10-mobile mb-gap-mobile lh-0" title="Cult">
					<a href="https://cult.society"><?php the_custom_logo(); ?>
					</a>
				</div>
			</div>
			<div class="columns border-bottom pb-gap pt-gap is-flex is-multiline">
				<div class="is-flex column ">
					<h1><a href="https://cult.society" class="tag menu-item menu-item-type-custom menu-item-object-custom h1-item-title">Cult.society</a></h1>
					<div>
						<p class="typo-base">Pour un accès privé aux meilleurs « plans cult » :</p><br>
						<p class="typo-base">Ça c'est Cult !</p>
					</div>

				</div>
			</div>

		</header>





		<?php
		wp_nav_menu(array(
			'menu'       => 'Menu principal', // Nom exact de ton menu WP
			'container'  => false,
			'items_wrap' => '<div class="columns is-multiline overlay js-overlay menu-mobile">%3$s</div>',
			'walker'     => new Bulma_Overlay_Menu_Walker(),
			'depth'      => 1,
		));
		?>
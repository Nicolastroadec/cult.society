<?php

/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Cland
 */


$logos_du_prefooter = get_field('logos_du_prefooter', 'option');
$logo_cland_du_footer = get_field('logo_cland_du_footer', 'option');

$titre_usefull_links = get_field('titre_usefull_links', 'option');
$useful_links = get_field('useful_links', 'option');


$titre_get_in_touch = get_field('titre_get_in_touch', 'option');
$get_in_touch = get_field('get_in_touch', 'option');

$titre_subscribe_to_newsletter = get_field('titre_subscribe_to_newsletter', 'option');
$subscribe_to_the_newsletter = get_field('subscribe_to_the_newsletter', 'option');

$titre_legal_infos = get_field('titre_legal_infos', 'option');
$legal_infos = get_field('legal_infos', 'option');

$signature = get_field('signature', 'option');
$scroll_to_top = get_field('scroll_to_top', 'option');

?>

<footer id="colophon" class="site-footer">
    <div class="pre-footer">
        <div class="logos-container">
            <?php
            if (!empty($logos_du_prefooter) && is_array($logos_du_prefooter)):
                foreach ($logos_du_prefooter as $logo_du_prefooter):
                    if (is_array($logo_du_prefooter)) {
                        $logo = isset($logo_du_prefooter['logo']) && is_array($logo_du_prefooter['logo']) ? $logo_du_prefooter['logo'] : null;

                        if ($logo && isset($logo['url']) && filter_var($logo['url'], FILTER_VALIDATE_URL)) :
            ?>
                            <img src="<?= esc_url($logo['url']) ?>" alt="">
            <?php
                        endif;
                    }
                endforeach;
            endif;
            ?>


        </div>
    </div>
    <div class="footer-content">
        <div class="logo-footer-cland">
            <?php if ($logo_cland_du_footer): ?>
                <img src="<?= esc_url($logo_cland_du_footer['url']) ?? '' ?>" alt="">
            <?php endif; ?>
        </div>
        <div class="menus-footer">
            <div class="col-1 col">
                <h2><?= esc_html($titre_usefull_links) ?></h2>
                <div class="menu-footer">
                    <?php
                    if (!empty($useful_links) && is_array($useful_links)):
                        foreach ($useful_links as $item):
                            $link = $item['lien'] ?? null;
                            if (is_array($link) && !empty($link['url'])): ?>
                                <a href="<?= esc_url($link['url']) ?>">
                                    <?= esc_html($link['title'] ?? '') ?>
                                </a>
                    <?php endif;
                        endforeach;
                    endif;
                    ?>

                </div>
            </div>
            <div class="col-2 col">
                <h2><?= esc_html($titre_get_in_touch) ?></h2>
                <div class="menu-footer">
                    <?php
                    if (!empty($get_in_touch) && is_array($get_in_touch)):
                        foreach ($get_in_touch as $item):
                            $link = $item['lien'] ?? null;
                            if (is_array($link) && !empty($link['url'])): ?>
                                <a href="<?= esc_url($link['url']) ?>">
                                    <?= esc_html($link['title'] ?? '') ?>
                                </a>
                    <?php endif;
                        endforeach;
                    endif;
                    ?>
                </div>
            </div>
            <div class="col-3 col">
                <h2><?= esc_html($titre_subscribe_to_newsletter) ?></h2>
                <div class="menu-footer">

                    <?php
                    if (!empty($subscribe_to_the_newsletter) && is_array($subscribe_to_the_newsletter)):
                        foreach ($subscribe_to_the_newsletter as $item):
                            $link = $item['lien'] ?? null;
                            if (is_array($link) && !empty($link['url'])): ?>
                                <a href="<?= esc_url($link['url']) ?>">
                                    <?= esc_html($link['title'] ?? '') ?>
                                </a>
                    <?php endif;
                        endforeach;
                    endif;
                    ?>

                </div>
            </div>
            <div class="col-4 col">
                <h2><?= esc_html($titre_legal_infos) ?></h2>
                <div class="menu-footer">
                    <?php
                    if (!empty($legal_infos) && is_array($legal_infos)):
                        foreach ($legal_infos as $item):
                            $link = $item['lien'] ?? null;
                            if (is_array($link) && !empty($link['url'])): ?>
                                <a href="<?= esc_url($link['url']) ?>">
                                    <?= esc_html($link['title'] ?? '') ?>
                                </a>
                    <?php endif;
                        endforeach;
                    endif;
                    ?>
                </div>
            </div>
        </div>
        <div class="signature-container">
            <div class="signature">
                <?= wp_kses($signature, [
                    'br' => [],
                    'strong' => [],
                    'em' => [],
                    'a' => ['href' => [], 'title' => []],
                ]) ?? '' ?>
            </div>
        </div>
        <div class="scroll-to-top" id="scroll-to-top">
            <?php if ($scroll_to_top) : ?>
                <img src="<?= $scroll_to_top['url'] ?? '' ?>" alt="">
            <?php endif; ?>
        </div>
    </div>

</footer>
</div><!-- #page -->

<?php wp_footer(); ?>

</body>

</html>
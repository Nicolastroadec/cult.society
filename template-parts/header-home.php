<?php

$slogan = get_field('slogan_page_daccueil');
$bouton_see_events = get_field('bouton_see_events');
$bouton_see_calls = get_field('bouton_see_calls');

?>

<div class="header-home">


    <div class="right-col">
        <div class="thumbnail">
            <?php if (has_post_thumbnail()) : ?>
                <?php the_post_thumbnail(); ?>
            <?php endif; ?>

        </div>

    </div>
    <div class="buttons">
        <?php if ($bouton_see_events) : ?>
            <a href="<?= esc_url($bouton_see_events['url']); ?>" class="btn btn-secondary"><?= esc_html($bouton_see_events['title']); ?></a>
        <?php endif; ?>
        <?php if ($bouton_see_calls): ?>
            <a href="<?= esc_url($bouton_see_calls['url']); ?>" class="btn btn-primary"><?= esc_html($bouton_see_calls['title']); ?></a>
        <?php endif; ?>
    </div>
</div>
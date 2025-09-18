<?php



$texte_wysiwyg = get_field('texte_wysiwyg', get_the_ID());
$boutons = get_field('boutons',  get_the_ID());
$bouton = get_field('bouton',  get_the_ID());
?>

<div class="header-single-and-events">

    <div class="header-content">

        <div class="left-col">
            <?php
            display_custom_breadcrumb();

            ?>

            <div class="content">

                <div class="titre">
                    <h1><?php the_title() ?></h1>
                </div>
                <div class="texte-wysiwyg">
                    <?= wp_kses_post($texte_wysiwyg ?? '') ?>
                </div>
                <div class="boutons">
                    <?php
                    if (!empty($boutons) && is_array($boutons)):
                        foreach ($boutons as $bouton):
                            $bouton = $bouton['bouton'] ?? null;
                            if (is_array($bouton) && !empty($bouton['url'])): ?>
                                <div class="bouton-container">
                                    <a class="btn btn-secondary" href="<?= esc_url($bouton['url']) ?>">
                                        <?= esc_html($bouton['title'] ?? '') ?>
                                    </a>
                                </div>
                    <?php endif;
                        endforeach;
                    endif;
                    ?>
                </div>
            </div>

        </div>

        <div class="right-col">

            <div class="post-thumbnail-container">
                <?= the_post_thumbnail(get_the_ID()) ?>

            </div>
        </div>
    </div>


</div>
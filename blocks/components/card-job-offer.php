<article class="card-job-offer card">
    <?php
    the_post_thumbnail('large');
    ?>
    <div class="under-image">
        <?php if ($position) : ?>
            <p><?= esc_html($position); ?></p>
        <?php endif; ?>
        <?php if ($location) : ?>
            <p><?= esc_html($location); ?></p>
        <?php endif; ?>
    </div>

    <?php if ($duration) : ?>
        <p><?= esc_html($duration); ?></p>
    <?php endif; ?>
    <h3><a class="link" href="<?= esc_url($lien_vers_loffre['url'] ?? ''); ?>"><?php the_title(); ?></a></h3>
    <div class="link-to-offer">
        <a class="link-animated" href="<?= esc_url($lien_vers_loffre['url'] ?? ''); ?>" class="job-link">Explore this offer</a>
    </div>
</article>
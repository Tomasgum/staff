<?php get_header(); ?>

<?php while (have_posts()): the_post(); ?>

<div class="page-hero page-hero--plain">
    <div class="container">
        <?php if ($eyebrow = scaff_get('scaff_about_page_eyebrow', 'APIE MUS')): ?>
        <span class="section-eyebrow"><?php echo esc_html($eyebrow); ?></span>
        <?php endif; ?>
        <h1 class="page-hero__title"><?php the_title(); ?></h1>
    </div>
</div>

<div class="container">
    <div class="page-content">
        <?php the_content(); ?>
    </div>

    <?php
    $about_photos = [];
    for ($i = 1; $i <= 4; $i++) {
        $photo = scaff_get("scaff_about_page_photo_{$i}");
        if ($photo) $about_photos[] = $photo;
    }
    ?>
    <?php if (!empty($about_photos)): ?>
    <div class="about-page-gallery">
        <?php foreach ($about_photos as $idx => $photo): ?>
        <div class="about-page-gallery__item" data-animate="fade-up" data-index="<?php echo $idx; ?>">
            <img src="<?php echo esc_url($photo); ?>" alt="<?php echo esc_attr(get_the_title()); ?>" loading="lazy">
        </div>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>
</div>

<?php endwhile; ?>

<?php get_footer(); ?>

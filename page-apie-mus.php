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

<!-- STATS BAR -->
<section class="stats-bar">
    <div class="container">
        <div class="stats-bar__grid">
            <?php for ($i = 1; $i <= 4; $i++):
                $num   = scaff_get("scaff_stat_{$i}_number", '');
                $label = scaff_get("scaff_stat_{$i}_label", '');
                if (!$num && !$label) continue;
            ?>
            <div class="stat-item" data-animate="count">
                <div class="stat-item__icon"><?php echo scaff_get_icon(scaff_get("scaff_stat_{$i}_icon", 'box')); ?></div>
                <div class="stat-item__content">
                    <span class="stat-item__number" data-target="<?php echo esc_attr(preg_replace('/[^0-9]/', '', $num)); ?>"><?php echo esc_html($num); ?></span>
                    <span class="stat-item__label"><?php echo esc_html($label); ?></span>
                </div>
            </div>
            <?php endfor; ?>
        </div>
    </div>
</section>

<!-- CTA BANNER -->
<section class="cta-banner">
    <div class="cta-banner__bg" aria-hidden="true"></div>
    <div class="container">
        <div class="cta-banner__content" data-animate="fade-up">
            <h2 class="cta-banner__title"><?php echo esc_html(scaff_get('scaff_cta_title', 'Reikia konsultacijos?')); ?></h2>
            <p class="cta-banner__text"><?php echo esc_html(scaff_get('scaff_cta_text', 'Mūsų specialistai pasiruošę padėti pasirinkti tinkamą įrangą jūsų projektui.')); ?></p>
            <div class="cta-banner__actions">
                <?php $phone = scaff_get('scaff_contact_phone', '+370 678 34 889'); ?>
                <a href="tel:<?php echo esc_attr(preg_replace('/\s+/', '', $phone)); ?>" class="btn btn--white btn--lg">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07A19.5 19.5 0 013.07 11.04a19.79 19.79 0 01-3.07-8.67A2 2 0 012 .18h3a2 2 0 012 1.72c.127.96.361 1.903.7 2.81a2 2 0 01-.45 2.11L6.09 7.91a16 16 0 006 6l1.27-1.27a2 2 0 012.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0122 14.92l-.08 2z"/></svg>
                    <?php echo esc_html($phone); ?>
                </a>
                <a href="<?php echo esc_url(get_permalink(get_page_by_path('susisiekti'))); ?>" class="btn btn--outline-light btn--lg">
                    Rašyti žinutę
                </a>
            </div>
        </div>
    </div>
</section>

<?php endwhile; ?>

<?php get_footer(); ?>

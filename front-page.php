<?php get_header(); ?>

<!-- HERO -->
<section class="hero" id="hero">
    <?php if ($hero_img = scaff_get('scaff_hero_image')): ?>
    <div class="hero__bg" style="background-image:url('<?php echo esc_url($hero_img); ?>')"></div>
    <?php endif; ?>
    <div class="hero__overlay"></div>
    <div class="container hero__container">
        <div class="hero__content">
            <span class="hero__eyebrow" data-gsap="eyebrow"><?php echo esc_html(scaff_get('scaff_hero_eyebrow', 'PROFESIONALŲ PASIRINKIMAS')); ?></span>
            <h1 class="hero__title" data-gsap="title"><?php echo esc_html(scaff_get('scaff_hero_title', 'Pastolių įrankiai ir darbo aukštyje įranga')); ?></h1>
            <p class="hero__subtitle" data-gsap="subtitle"><?php echo esc_html(scaff_get('scaff_hero_subtitle', 'Aukščiausios kokybės įrankiai profesionalams. Pristatome visoje Lietuvoje.')); ?></p>
            <div class="hero__actions" data-gsap="actions">
                <?php if ($cta1 = scaff_get('scaff_hero_cta_primary', 'Peržiūrėti katalogą')): ?>
                <a href="<?php echo esc_url(scaff_get('scaff_hero_cta_primary_url', '/katalogas')); ?>" class="btn btn--primary btn--lg hero__cta-primary">
                    <?php echo esc_html($cta1); ?>
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
                </a>
                <?php endif; ?>
                <?php if ($cta2 = scaff_get('scaff_hero_cta_secondary', 'Susisiekti')): ?>
                <a href="<?php echo esc_url(scaff_get('scaff_hero_cta_secondary_url', '/susisiekti')); ?>" class="btn btn--outline-light btn--lg">
                    <?php echo esc_html($cta2); ?>
                </a>
                <?php endif; ?>
            </div>
        </div>

        <div class="hero__visual" data-gsap="visual">
            <?php
            $hero_slides = [];
            for ($i = 1; $i <= 5; $i++) {
                $url = scaff_get("scaff_hero_slide_{$i}");
                if ($url) $hero_slides[] = $url;
            }
            ?>
            <?php if (!empty($hero_slides)): ?>
            <div class="hero-slider" data-hero-slider>
                <div class="hero-slider__track">
                    <?php foreach ($hero_slides as $i => $slide): ?>
                    <div class="hero-slider__slide <?php echo $i === 0 ? 'is-active' : ''; ?>">
                        <img src="<?php echo esc_url($slide); ?>" alt="" loading="<?php echo $i === 0 ? 'eager' : 'lazy'; ?>">
                    </div>
                    <?php endforeach; ?>
                </div>
                <?php if (count($hero_slides) > 1): ?>
                <div class="hero-slider__controls">
                    <button class="hero-slider__btn hero-slider__btn--prev" aria-label="Ankstesnis">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="15 18 9 12 15 6"/></svg>
                    </button>
                    <div class="hero-slider__dots">
                        <?php foreach ($hero_slides as $i => $slide): ?>
                        <button class="hero-slider__dot <?php echo $i === 0 ? 'is-active' : ''; ?>" data-goto="<?php echo $i; ?>" aria-label="Slide <?php echo $i + 1; ?>"></button>
                        <?php endforeach; ?>
                    </div>
                    <button class="hero-slider__btn hero-slider__btn--next" aria-label="Kitas">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 18 15 12 9 6"/></svg>
                    </button>
                </div>
                <?php endif; ?>
            </div>
            <?php endif; ?>
        </div>
    </div>

    <div class="hero__scroll-indicator" aria-hidden="true">
        <span class="hero__scroll-line"></span>
        <span class="hero__scroll-label">Scroll</span>
    </div>
</section>

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

<!-- PRODUCT CATEGORIES -->
<?php
if (class_exists('WooCommerce')) {
    $categories = get_terms([
        'taxonomy'   => 'product_cat',
        'hide_empty' => true,
        'parent'     => 0,
        'number'     => 8,
        'exclude'    => [get_option('default_product_cat')],
    ]);
}
?>
<?php if (!empty($categories) && !is_wp_error($categories)): ?>
<section class="categories-section" id="categories">
    <div class="container">
        <div class="section-header" data-animate="fade-up">
            <span class="section-eyebrow">Mūsų produktai</span>
            <h2 class="section-title">Kategorijos</h2>
            <p class="section-subtitle">Raskite viską, ko reikia darbui aukštyje</p>
        </div>

        <div class="categories-grid">
            <?php foreach ($categories as $idx => $cat):
                $thumb_id  = get_term_meta($cat->term_id, 'thumbnail_id', true);
                $thumb_url = $thumb_id ? wp_get_attachment_image_url($thumb_id, 'medium_large') : '';
                $link      = get_term_link($cat);
            ?>
            <a href="<?php echo esc_url($link); ?>" class="category-card" data-animate="card" data-index="<?php echo $idx; ?>">
                <div class="category-card__image">
                    <?php if ($thumb_url): ?>
                        <img src="<?php echo esc_url($thumb_url); ?>" alt="<?php echo esc_attr($cat->name); ?>" loading="lazy">
                    <?php else: ?>
                        <div class="category-card__placeholder">
                            <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1"><path d="M21 16V8a2 2 0 00-1-1.73l-7-4a2 2 0 00-2 0l-7 4A2 2 0 002 8v8a2 2 0 001 1.73l7 4a2 2 0 002 0l7-4A2 2 0 0021 16z"/></svg>
                        </div>
                    <?php endif; ?>
                    <div class="category-card__overlay"></div>
                </div>
                <div class="category-card__content">
                    <h3 class="category-card__title"><?php echo esc_html($cat->name); ?></h3>
                    <span class="category-card__count"><?php echo $cat->count; ?> produktų</span>
                    <span class="category-card__arrow">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
                    </span>
                </div>
            </a>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- FEATURED PRODUCTS -->
<?php
if (class_exists('WooCommerce')) {
    $featured_products = wc_get_products([
        'status'   => 'publish',
        'limit'    => 8,
        'featured' => true,
        'orderby'  => 'date',
        'order'    => 'DESC',
    ]);

    if (empty($featured_products)) {
        $featured_products = wc_get_products([
            'status'  => 'publish',
            'limit'   => 8,
            'orderby' => 'date',
            'order'   => 'DESC',
        ]);
    }
}
?>
<?php if (!empty($featured_products)): ?>
<section class="products-section" id="products">
    <div class="container">
        <div class="section-header" data-animate="fade-up">
            <span class="section-eyebrow">Rekomenduojami</span>
            <h2 class="section-title">Populiarūs produktai</h2>
        </div>

        <div class="products-grid">
            <?php foreach ($featured_products as $idx => $product):
                $img_id  = $product->get_image_id();
                $img_url = $img_id ? wp_get_attachment_image_url($img_id, 'woocommerce_thumbnail') : wc_placeholder_img_src('woocommerce_thumbnail');
                $phone   = scaff_get('scaff_contact_phone', '+370 678 34 889');
            ?>
            <div class="product-card" data-animate="card" data-index="<?php echo $idx; ?>">
                <a href="<?php echo esc_url(get_permalink($product->get_id())); ?>" class="product-card__image-link">
                    <div class="product-card__image-wrap">
                        <img src="<?php echo esc_url($img_url); ?>" alt="<?php echo esc_attr($product->get_name()); ?>" loading="lazy">
                    </div>
                </a>
                <div class="product-card__body">
                    <?php if ($cats = $product->get_category_ids()): ?>
                    <span class="product-card__cat"><?php echo esc_html(get_term($cats[0])->name ?? ''); ?></span>
                    <?php endif; ?>
                    <h3 class="product-card__title">
                        <a href="<?php echo esc_url(get_permalink($product->get_id())); ?>"><?php echo esc_html($product->get_name()); ?></a>
                    </h3>
                    <div class="product-card__actions">
                        <a href="tel:<?php echo esc_attr(preg_replace('/\s+/', '', $phone)); ?>" class="btn btn--primary btn--sm">Teirautis dėl kainos</a>
                        <a href="<?php echo esc_url(get_permalink($product->get_id())); ?>" class="btn btn--ghost btn--sm">Žiūrėti</a>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>

        <div class="section-footer" data-animate="fade-up">
            <a href="<?php echo esc_url(get_permalink(wc_get_page_id('shop'))); ?>" class="btn btn--outline btn--lg">
                Visi produktai
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
            </a>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- ABOUT SECTION -->
<section class="about-section" id="about">
    <div class="container">
        <div class="about-section__grid">
            <div class="about-section__content" data-animate="fade-right">
                <span class="section-eyebrow"><?php echo esc_html(scaff_get('scaff_about_eyebrow', 'APIE MUS')); ?></span>
                <h2 class="section-title"><?php echo esc_html(scaff_get('scaff_about_title', 'Profesionalams iš profesionalų')); ?></h2>
                <p class="about-section__text"><?php echo esc_html(scaff_get('scaff_about_text', '')); ?></p>

                <ul class="about-checklist">
                    <li><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg> Aukščiausios kokybės produktai</li>
                    <li><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg> Greitas pristatymas visoje Lietuvoje</li>
                    <li><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg> 30 dienų grąžinimo garantija</li>
                    <li><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg> Profesionali konsultacija</li>
                </ul>

                <?php if ($cta = scaff_get('scaff_about_cta')): ?>
                <a href="<?php echo esc_url(scaff_get('scaff_about_cta_url', '/apie-mus')); ?>" class="btn btn--primary btn--lg">
                    <?php echo esc_html($cta); ?>
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
                </a>
                <?php endif; ?>
            </div>

            <div class="about-section__visual" data-animate="fade-left">
                <?php if ($img = scaff_get('scaff_about_image')): ?>
                <img src="<?php echo esc_url($img); ?>" alt="<?php echo esc_html(scaff_get('scaff_about_title', 'Apie mus')); ?>" class="about-section__img">
                <?php else: ?>
                <div class="about-section__placeholder">
                    <div class="about-placeholder__inner">
                        <div class="about-placeholder__accent"></div>
                        <div class="about-placeholder__text">
                            <span class="about-placeholder__year">15+</span>
                            <span>Metų patirtis</span>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<!-- CTA BANNER -->
<section class="cta-banner">
    <div class="cta-banner__bg" aria-hidden="true"></div>
    <div class="container">
        <div class="cta-banner__content" data-animate="fade-up">
            <h2 class="cta-banner__title">Reikia konsultacijos?</h2>
            <p class="cta-banner__text">Mūsų specialistai pasiruošę padėti pasirinkti tinkamą įrangą jūsų projektui.</p>
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

<script>
(function() {
    var slider = document.querySelector('[data-hero-slider]');
    if (!slider) return;
    var slides   = slider.querySelectorAll('.hero-slider__slide');
    var dots     = slider.querySelectorAll('.hero-slider__dot');
    var btnPrev  = slider.querySelector('.hero-slider__btn--prev');
    var btnNext  = slider.querySelector('.hero-slider__btn--next');
    if (slides.length < 2) return;

    var current = 0;
    var timer;

    function goTo(idx) {
        slides[current].classList.remove('is-active');
        if (dots[current]) dots[current].classList.remove('is-active');
        current = (idx + slides.length) % slides.length;
        slides[current].classList.add('is-active');
        if (dots[current]) dots[current].classList.add('is-active');
    }

    function startTimer() {
        clearInterval(timer);
        timer = setInterval(function() { goTo(current + 1); }, 4500);
    }

    dots.forEach(function(dot, i) {
        dot.addEventListener('click', function() { goTo(i); startTimer(); });
    });
    if (btnPrev) btnPrev.addEventListener('click', function() { goTo(current - 1); startTimer(); });
    if (btnNext) btnNext.addEventListener('click', function() { goTo(current + 1); startTimer(); });

    // Pause on hover
    slider.addEventListener('mouseenter', function() { clearInterval(timer); });
    slider.addEventListener('mouseleave', startTimer);

    startTimer();
})();
</script>

<?php get_footer(); ?>

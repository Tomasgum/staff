<?php get_header(); ?>

<?php while (have_posts()): the_post(); ?>

<div class="page-hero page-hero--plain">
    <div class="container">
        <h1 class="page-hero__title"><?php the_title(); ?></h1>
    </div>
</div>

<div class="container">
    <div class="contact-page">

        <div class="contact-page__info">
            <div class="contact-info-card">
                <h3 class="contact-info-card__title">Kontaktinė informacija</h3>

                <ul class="contact-info-list">
                    <?php if ($phone = scaff_get('scaff_contact_phone')): ?>
                    <li>
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07A19.5 19.5 0 013.07 11.04a19.79 19.79 0 01-3.07-8.67A2 2 0 012 .18h3a2 2 0 012 1.72c.127.96.361 1.903.7 2.81a2 2 0 01-.45 2.11L6.09 7.91a16 16 0 006 6l1.27-1.27a2 2 0 012.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0122 14.92l-.08 2z"/></svg>
                        <div>
                            <span class="contact-info-list__label">Telefonas</span>
                            <a href="tel:<?php echo esc_attr(preg_replace('/\s+/', '', $phone)); ?>"><?php echo esc_html($phone); ?></a>
                        </div>
                    </li>
                    <?php endif; ?>

                    <?php if ($email = scaff_get('scaff_contact_email')): ?>
                    <li>
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                        <div>
                            <span class="contact-info-list__label">El. paštas</span>
                            <a href="mailto:<?php echo esc_attr($email); ?>"><?php echo esc_html($email); ?></a>
                        </div>
                    </li>
                    <?php endif; ?>

                    <?php if ($addr = scaff_get('scaff_contact_address')): ?>
                    <li>
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"/><circle cx="12" cy="10" r="3"/></svg>
                        <div>
                            <span class="contact-info-list__label">Adresas</span>
                            <span><?php echo esc_html($addr); ?></span>
                        </div>
                    </li>
                    <?php endif; ?>

                    <?php if ($hours = scaff_get('scaff_contact_hours')): ?>
                    <li>
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                        <div>
                            <span class="contact-info-list__label">Darbo laikas</span>
                            <span><?php echo esc_html($hours); ?></span>
                        </div>
                    </li>
                    <?php endif; ?>
                </ul>

                <?php
                $fb = scaff_get('scaff_footer_fb_url');
                $ig = scaff_get('scaff_footer_ig_url');
                $li = scaff_get('scaff_footer_li_url');
                ?>
                <?php if ($fb || $ig || $li): ?>
                <div class="contact-social">
                    <span class="contact-social__label">Sekite mus</span>
                    <div class="contact-social__links">
                        <?php if ($fb): ?>
                        <a href="<?php echo esc_url($fb); ?>" class="contact-social__link" target="_blank" rel="noopener" aria-label="Facebook">
                            <svg width="22" height="22" viewBox="0 0 24 24" fill="currentColor"><path d="M18 2h-3a5 5 0 00-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 011-1h3z"/></svg>
                        </a>
                        <?php endif; ?>
                        <?php if ($ig): ?>
                        <a href="<?php echo esc_url($ig); ?>" class="contact-social__link" target="_blank" rel="noopener" aria-label="Instagram">
                            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"/><path d="M16 11.37A4 4 0 1112.63 8 4 4 0 0116 11.37z"/><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"/></svg>
                        </a>
                        <?php endif; ?>
                        <?php if ($li): ?>
                        <a href="<?php echo esc_url($li); ?>" class="contact-social__link" target="_blank" rel="noopener" aria-label="LinkedIn">
                            <svg width="22" height="22" viewBox="0 0 24 24" fill="currentColor"><path d="M16 8a6 6 0 016 6v7h-4v-7a2 2 0 00-2-2 2 2 0 00-2 2v7h-4v-7a6 6 0 016-6zM2 9h4v12H2z"/><circle cx="4" cy="4" r="2"/></svg>
                        </a>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </div>

        <div class="contact-page__content">
            <?php the_content(); ?>
        </div>

    </div>
</div>

<?php endwhile; ?>

<?php get_footer(); ?>

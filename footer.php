    </main><!-- #main -->

    <!-- FOOTER -->
    <footer id="colophon" class="site-footer" role="contentinfo">

        <!-- USP BAND -->
        <div class="usp-band">
            <div class="container">
                <div class="usp-band__grid">
                    <?php for ($i = 1; $i <= 4; $i++):
                        $icon  = scaff_get("scaff_usp_{$i}_icon", 'truck');
                        $title = scaff_get("scaff_usp_{$i}_title", '');
                        $text  = scaff_get("scaff_usp_{$i}_text", '');
                        if (!$title) continue;
                    ?>
                    <div class="usp-item" data-animate="fade-up">
                        <div class="usp-item__icon">
                            <?php echo scaff_get_icon($icon); ?>
                        </div>
                        <div class="usp-item__content">
                            <h4 class="usp-item__title"><?php echo esc_html($title); ?></h4>
                            <p class="usp-item__text"><?php echo esc_html($text); ?></p>
                        </div>
                    </div>
                    <?php endfor; ?>
                </div>
            </div>
        </div>

        <!-- FOOTER MAIN -->
        <div class="footer-main">
            <div class="container">
                <div class="footer-main__grid">

                    <!-- BRAND COL -->
                    <div class="footer-brand">
                        <?php if (has_custom_logo()): ?>
                            <?php the_custom_logo(); ?>
                        <?php else: ?>
                            <span class="footer-brand__name"><?php bloginfo('name'); ?></span>
                        <?php endif; ?>
                        <p class="footer-brand__tagline"><?php echo esc_html(scaff_get('scaff_footer_tagline', 'Pastolių įrankiai ir darbo aukštyje įranga profesionalams.')); ?></p>

                        <div class="footer-social">
                            <?php if ($fb = scaff_get('scaff_footer_fb_url')): ?>
                            <a href="<?php echo esc_url($fb); ?>" class="footer-social__link" target="_blank" rel="noopener" aria-label="Facebook">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M18 2h-3a5 5 0 00-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 011-1h3z"/></svg>
                            </a>
                            <?php endif; ?>
                            <?php if ($ig = scaff_get('scaff_footer_ig_url')): ?>
                            <a href="<?php echo esc_url($ig); ?>" class="footer-social__link" target="_blank" rel="noopener" aria-label="Instagram">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"/><path d="M16 11.37A4 4 0 1112.63 8 4 4 0 0116 11.37z"/><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"/></svg>
                            </a>
                            <?php endif; ?>
                            <?php if ($li = scaff_get('scaff_footer_li_url')): ?>
                            <a href="<?php echo esc_url($li); ?>" class="footer-social__link" target="_blank" rel="noopener" aria-label="LinkedIn">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M16 8a6 6 0 016 6v7h-4v-7a2 2 0 00-2-2 2 2 0 00-2 2v7h-4v-7a6 6 0 016-6zM2 9h4v12H2z"/><circle cx="4" cy="4" r="2"/></svg>
                            </a>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- WIDGET COL 2 -->
                    <div class="footer-col">
                        <?php if (has_nav_menu('footer')): ?>
                            <h4 class="footer-widget__title">Informacija</h4>
                            <?php
                            wp_nav_menu([
                                'theme_location' => 'footer',
                                'menu_class'     => 'footer-nav__list',
                                'container'      => false,
                                'fallback_cb'    => false,
                            ]);
                            ?>
                        <?php elseif (is_active_sidebar('footer-2')): ?>
                            <?php dynamic_sidebar('footer-2'); ?>
                        <?php else: ?>
                            <h4 class="footer-widget__title">Informacija</h4>
                            <ul class="footer-nav__list">
                                <li><a href="<?php echo esc_url(get_permalink(get_page_by_path('apie-mus'))); ?>">Apie mus</a></li>
                                <li><a href="<?php echo esc_url(get_permalink(get_page_by_path('pristatymas'))); ?>">Pristatymas</a></li>
                                <li><a href="<?php echo esc_url(get_permalink(get_page_by_path('grazinimas'))); ?>">Grąžinimas</a></li>
                                <li><a href="<?php echo esc_url(get_permalink(get_page_by_path('susisiekti'))); ?>">Susisiekti</a></li>
                            </ul>
                        <?php endif; ?>
                    </div>

                    <!-- CONTACT COL -->
                    <div class="footer-col">
                        <h4 class="footer-widget__title">Kontaktai</h4>
                        <ul class="footer-contact-list">
                            <li>
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07A19.5 19.5 0 013.07 11.04a19.79 19.79 0 01-3.07-8.67A2 2 0 012 .18h3a2 2 0 012 1.72c.127.96.361 1.903.7 2.81a2 2 0 01-.45 2.11L6.09 7.91a16 16 0 006 6l1.27-1.27a2 2 0 012.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0122 14.92l-.08 2z"/></svg>
                                <?php $phone = scaff_get('scaff_contact_phone', '+370 678 34 889'); ?>
                                <a href="tel:<?php echo esc_attr(preg_replace('/\s+/', '', $phone)); ?>"><?php echo esc_html($phone); ?></a>
                            </li>
                            <li>
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                                <?php $email = scaff_get('scaff_contact_email', 'info@scaffshop.lt'); ?>
                                <a href="mailto:<?php echo esc_attr($email); ?>"><?php echo esc_html($email); ?></a>
                            </li>
                            <li>
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"/><circle cx="12" cy="10" r="3"/></svg>
                                <?php echo esc_html(scaff_get('scaff_contact_address', 'Vilnius, Lietuva')); ?>
                            </li>
                            <li>
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                                <?php echo esc_html(scaff_get('scaff_contact_hours', 'I – V: 8:00 – 17:00')); ?>
                            </li>
                        </ul>
                    </div>

                </div>
            </div>
        </div>

        <!-- FOOTER BOTTOM -->
        <div class="footer-bottom">
            <div class="container">
                <p class="footer-bottom__copy"><?php echo esc_html(scaff_get('scaff_footer_copyright', '© 2024 ScaffShop. Visos teisės saugomos.')); ?></p>
                <p class="footer-bottom__credit">Sukurta su <span aria-hidden="true">♥</span> Lietuvoje</p>
            </div>
        </div>
    </footer>

</div><!-- #page -->

<?php wp_footer(); ?>
</body>
</html>

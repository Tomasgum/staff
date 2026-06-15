<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<div id="page" class="site">

    <!-- TOP BAR -->
    <div class="topbar">
        <div class="topbar__container container">
            <div class="topbar__left">
                <span class="topbar__promo"><?php echo esc_html(scaff_get('scaff_topbar_text', 'DĖL ĮMONĖMS SKIRTOS KAINODAROS SUSISIEKITE')); ?></span>
            </div>
            <div class="topbar__right">
                <div class="topbar__hours">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                    <?php echo esc_html(scaff_get('scaff_topbar_hours', 'I – V 8:00 – 17:00')); ?>
                </div>
                <a href="tel:<?php echo esc_attr(preg_replace('/\s+/', '', scaff_get('scaff_topbar_phone', '+37067834889'))); ?>" class="topbar__phone">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07A19.5 19.5 0 013.07 11.04a19.79 19.79 0 01-3.07-8.67A2 2 0 012 .18h3a2 2 0 012 1.72c.127.96.361 1.903.7 2.81a2 2 0 01-.45 2.11L6.09 7.91a16 16 0 006 6l1.27-1.27a2 2 0 012.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0122 14.92l-.08 2z"/></svg>
                    <?php echo esc_html(scaff_get('scaff_topbar_phone', '+370 678 34 889')); ?>
                </a>
                <a href="mailto:<?php echo esc_attr(scaff_get('scaff_topbar_email', 'info@scaffshop.lt')); ?>" class="topbar__email">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                    <?php echo esc_html(scaff_get('scaff_topbar_email', 'info@scaffshop.lt')); ?>
                </a>
            </div>
        </div>
    </div>

    <!-- HEADER -->
    <header id="masthead" class="site-header" role="banner">
        <div class="site-header__container container">

            <!-- LOGO -->
            <div class="site-header__logo">
                <?php if (has_custom_logo()): ?>
                    <?php the_custom_logo(); ?>
                <?php else: ?>
                    <a href="<?php echo esc_url(home_url('/')); ?>" rel="home" class="site-logo-text">
                        <?php bloginfo('name'); ?>
                    </a>
                <?php endif; ?>
            </div>

            <!-- NAV -->
            <nav id="site-navigation" class="main-nav" role="navigation" aria-label="<?php esc_attr_e('Primary Menu', 'scaff'); ?>">
                <?php
                wp_nav_menu([
                    'theme_location' => 'primary',
                    'menu_id'        => 'primary-menu',
                    'menu_class'     => 'main-nav__list',
                    'container'      => false,
                    'fallback_cb'    => false,
                ]);
                ?>
            </nav>

            <!-- HEADER ACTIONS -->
            <div class="site-header__actions">
                <?php if (class_exists('WooCommerce')): ?>
                <a href="<?php echo esc_url(wc_get_cart_url()); ?>" class="header-cart" aria-label="Cart">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 002 1.61h9.72a2 2 0 002-1.61L23 6H6"/></svg>
                    <?php if (WC()->cart && WC()->cart->get_cart_contents_count() > 0): ?>
                        <span class="header-cart__count"><?php echo WC()->cart->get_cart_contents_count(); ?></span>
                    <?php endif; ?>
                </a>
                <?php endif; ?>

                <a href="<?php echo esc_url(get_permalink(get_page_by_path('susisiekti'))); ?>" class="btn btn--primary btn--sm header-contact-btn">
                    Susisiekti
                </a>

                <!-- HAMBURGER -->
                <button class="hamburger" id="hamburger" aria-label="Menu" aria-expanded="false">
                    <span class="hamburger__line"></span>
                    <span class="hamburger__line"></span>
                    <span class="hamburger__line"></span>
                </button>
            </div>
        </div>
    </header>

    <!-- MOBILE MENU OVERLAY -->
    <div class="mobile-menu" id="mobileMenu" role="dialog" aria-modal="true" aria-label="Navigation">
        <div class="mobile-menu__inner">
            <button class="mobile-menu__close" id="mobileMenuClose" aria-label="Close menu">
                <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
            </button>

            <?php
            wp_nav_menu([
                'theme_location' => 'primary',
                'menu_id'        => 'mobile-menu-list',
                'menu_class'     => 'mobile-menu__list',
                'container'      => false,
                'fallback_cb'    => false,
            ]);
            ?>

            <div class="mobile-menu__contact">
                <a href="tel:<?php echo esc_attr(preg_replace('/\s+/', '', scaff_get('scaff_contact_phone', '+37067834889'))); ?>" class="mobile-menu__phone">
                    <?php echo esc_html(scaff_get('scaff_contact_phone', '+370 678 34 889')); ?>
                </a>
                <a href="mailto:<?php echo esc_attr(scaff_get('scaff_contact_email', 'info@scaffshop.lt')); ?>" class="mobile-menu__email">
                    <?php echo esc_html(scaff_get('scaff_contact_email', 'info@scaffshop.lt')); ?>
                </a>
            </div>
        </div>
    </div>
    <div class="mobile-menu__backdrop" id="mobileMenuBackdrop"></div>

    <main id="main" class="site-main">

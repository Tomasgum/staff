<?php

define('SCAFF_VERSION', '1.0.0');
define('SCAFF_DIR', get_template_directory());
define('SCAFF_URI', get_template_directory_uri());

function scaff_setup() {
    load_theme_textdomain('scaff', SCAFF_DIR . '/languages');
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('html5', ['search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script']);
    add_theme_support('custom-logo', [
        'height'      => 60,
        'width'       => 200,
        'flex-height' => true,
        'flex-width'  => true,
    ]);
    add_theme_support('woocommerce', [
        'thumbnail_image_width' => 600,
        'single_image_width'    => 800,
        'product_grid'          => ['default_rows' => 3, 'min_rows' => 1, 'default_columns' => 4, 'min_columns' => 2, 'max_columns' => 4],
    ]);
    // Gallery JS plugins disabled — we use our own simple gallery in content-single-product.php
    add_theme_support('menus');

    register_nav_menus([
        'primary' => __('Primary Menu', 'scaff'),
        'footer'  => __('Footer Menu', 'scaff'),
    ]);
}
add_action('after_setup_theme', 'scaff_setup');

function scaff_enqueue() {
    wp_enqueue_style('scaff-google-fonts', 'https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=Barlow+Condensed:wght@400;600;700;800;900&display=swap', [], null);
    wp_enqueue_style('scaff-main', SCAFF_URI . '/assets/css/main.css', [], time());

    if (is_woocommerce() || is_cart() || is_checkout()) {
        // Load after WooCommerce's own layout CSS so our overrides win without relying on !important
        wp_enqueue_style('scaff-woo', SCAFF_URI . '/assets/css/woocommerce.css', ['woocommerce-layout', 'woocommerce-general'], time());
    }

    wp_enqueue_script('gsap', 'https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js', [], '3.12.5', true);
    wp_enqueue_script('gsap-scrolltrigger', 'https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/ScrollTrigger.min.js', ['gsap'], '3.12.5', true);
    wp_enqueue_script('scaff-main', SCAFF_URI . '/assets/js/main.js', ['gsap', 'gsap-scrolltrigger'], filemtime(SCAFF_DIR . '/assets/js/main.js'), true);

    wp_localize_script('scaff-main', 'scaffData', [
        'ajaxUrl' => admin_url('admin-ajax.php'),
        'nonce'   => wp_create_nonce('scaff_nonce'),
        'siteUrl' => get_site_url(),
    ]);
}
add_action('wp_enqueue_scripts', 'scaff_enqueue');

function scaff_widgets_init() {
    register_sidebar([
        'name'          => __('Footer Column 1', 'scaff'),
        'id'            => 'footer-1',
        'description'   => __('Footer first column', 'scaff'),
        'before_widget' => '<div class="footer-widget">',
        'after_widget'  => '</div>',
        'before_title'  => '<h4 class="footer-widget__title">',
        'after_title'   => '</h4>',
    ]);
    register_sidebar([
        'name'          => __('Footer Column 2', 'scaff'),
        'id'            => 'footer-2',
        'before_widget' => '<div class="footer-widget">',
        'after_widget'  => '</div>',
        'before_title'  => '<h4 class="footer-widget__title">',
        'after_title'   => '</h4>',
    ]);
    register_sidebar([
        'name'          => __('Footer Column 3', 'scaff'),
        'id'            => 'footer-3',
        'before_widget' => '<div class="footer-widget">',
        'after_widget'  => '</div>',
        'before_title'  => '<h4 class="footer-widget__title">',
        'after_title'   => '</h4>',
    ]);
}
add_action('widgets_init', 'scaff_widgets_init');

require_once SCAFF_DIR . '/inc/customizer.php';
require_once SCAFF_DIR . '/inc/catalog.php';
require_once SCAFF_DIR . '/inc/woocommerce-hooks.php';
require_once SCAFF_DIR . '/inc/contact-form.php';

// Outputs the optional uploaded background photo for a section (see
// scaff_add_bg_settings() in inc/customizer.php) — a second layer behind the
// section's own color/tint, with client-controlled opacity.
function scaff_section_bg($prefix) {
    $image = scaff_get("{$prefix}_bg_image");
    if (!$image) return;
    $opacity = (float) scaff_get("{$prefix}_bg_opacity", 0.35);
    ?>
    <div class="section-bg" style="background-image:url('<?php echo esc_url($image); ?>'); opacity:<?php echo esc_attr($opacity); ?>;"></div>
    <?php
}

// Same background-photo + opacity settings, but as CSS custom properties for
// an element (like the catalog page's <h1>) that already uses its own ::after
// for this rather than a separate .section-bg div.
function scaff_section_bg_style_attr($prefix) {
    $image = scaff_get("{$prefix}_bg_image");
    if (!$image) return '';
    $opacity = (float) scaff_get("{$prefix}_bg_opacity", 0.35);
    return sprintf(
        ' style="--section-photo:url(%s); --section-photo-opacity:%s;"',
        esc_url($image),
        esc_attr($opacity)
    );
}

function scaff_get_icon($name) {
    $icons = [
        'truck'       => '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="1" y="3" width="15" height="13"/><polygon points="16 8 20 8 23 11 23 16 16 16 16 8"/><circle cx="5.5" cy="18.5" r="2.5"/><circle cx="18.5" cy="18.5" r="2.5"/></svg>',
        'refresh-cw'  => '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><polyline points="23 4 23 10 17 10"/><polyline points="1 20 1 14 7 14"/><path d="M3.51 9a9 9 0 0114.85-3.36L23 10M1 14l4.64 4.36A9 9 0 0020.49 15"/></svg>',
        'package'     => '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><line x1="16.5" y1="9.4" x2="7.5" y2="4.21"/><path d="M21 16V8a2 2 0 00-1-1.73l-7-4a2 2 0 00-2 0l-7 4A2 2 0 002 8v8a2 2 0 001 1.73l7 4a2 2 0 002 0l7-4A2 2 0 0021 16z"/><polyline points="3.27 6.96 12 12.01 20.73 6.96"/><line x1="12" y1="22.08" x2="12" y2="12"/></svg>',
        'headphones'  => '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M3 18v-6a9 9 0 0118 0v6"/><path d="M21 19a2 2 0 01-2 2h-1a2 2 0 01-2-2v-3a2 2 0 012-2h3zM3 19a2 2 0 002 2h1a2 2 0 002-2v-3a2 2 0 00-2-2H3z"/></svg>',
        'award'       => '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><circle cx="12" cy="8" r="7"/><polyline points="8.21 13.89 7 23 12 20 17 23 15.79 13.88"/></svg>',
        'shield'      => '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>',
        'box'         => '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M21 16V8a2 2 0 00-1-1.73l-7-4a2 2 0 00-2 0l-7 4A2 2 0 002 8v8a2 2 0 001 1.73l7 4a2 2 0 002 0l7-4A2 2 0 0021 16z"/></svg>',
    ];
    return $icons[$name] ?? $icons['box'];
}

function scaff_remove_woo_breadcrumbs() {
    remove_action('woocommerce_before_main_content', 'woocommerce_breadcrumb', 20);
}
add_action('init', 'scaff_remove_woo_breadcrumbs');

function scaff_body_classes($classes) {
    if (is_woocommerce() || is_cart() || is_checkout()) {
        $classes[] = 'woo-page';
    }
    $header_style = get_theme_mod('scaff_header_style', 'default');
    if ($header_style === 'sidebar' || $header_style === 'scroll-sidebar') {
        $classes[] = 'header-style-' . $header_style;
    }
    return $classes;
}
add_filter('body_class', 'scaff_body_classes');

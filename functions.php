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
require_once SCAFF_DIR . '/inc/woocommerce-hooks.php';

function scaff_remove_woo_breadcrumbs() {
    remove_action('woocommerce_before_main_content', 'woocommerce_breadcrumb', 20);
}
add_action('init', 'scaff_remove_woo_breadcrumbs');

function scaff_body_classes($classes) {
    if (is_woocommerce() || is_cart() || is_checkout()) {
        $classes[] = 'woo-page';
    }
    return $classes;
}
add_filter('body_class', 'scaff_body_classes');

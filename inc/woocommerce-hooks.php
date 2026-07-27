<?php

// Replace WooCommerce's default column wrapper with a simple full-width div
remove_action('woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
remove_action('woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);

add_action('woocommerce_before_main_content', function() {
    echo '<div class="woo-inner">';
}, 10);

add_action('woocommerce_after_main_content', function() {
    echo '</div>';
}, 10);

// Remove Divi/page builder shortcode content from shop archive description
remove_action('woocommerce_archive_description', 'woocommerce_taxonomy_archive_description', 10);
remove_action('woocommerce_archive_description', 'woocommerce_product_archive_description', 10);

// Strip Divi/page builder shortcodes from product content
function scaff_strip_builder_shortcodes($content) {
    if (empty($content)) return $content;
    $content = preg_replace('/\[et_pb_[^\]]*\].*?\[\/et_pb_[^\]]*\]/s', '', $content);
    $content = preg_replace('/\[et_pb_[^\]]*\/?\]/', '', $content);
    $content = preg_replace('/\[\/et_pb_[^\]]*\]/', '', $content);
    return trim(preg_replace('/\s{3,}/', "\n\n", $content));
}
add_filter('woocommerce_short_description', 'scaff_strip_builder_shortcodes', 5);
add_filter('the_content', function($content) {
    return scaff_strip_builder_shortcodes($content);
}, 5);

// Remove price
remove_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10);
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_price', 10);

// Remove add-to-cart
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30);
remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10);

// Remove short description (contains Divi remnants causing duplicate title)
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 25);

// Remove rating (loop + single)
remove_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5);
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10);

// Custom CTA buttons in loop
function scaff_loop_cta() {
    global $product;
    $phone = get_theme_mod('scaff_contact_phone', '+370 678 34 889');
    $email = get_theme_mod('scaff_contact_email', 'info@scaffshop.lt');
    ?>
    <div class="product-card__actions">
        <a href="tel:<?php echo esc_attr(preg_replace('/\s+/', '', $phone)); ?>" class="btn btn--primary btn--sm">
            Teirautis dėl kainos
        </a>
        <a href="<?php echo esc_url(get_permalink(get_page_by_path('susisiekti'))); ?>" class="btn btn--outline btn--sm">
            Susisiekti
        </a>
    </div>
    <?php
}
add_action('woocommerce_after_shop_loop_item', 'scaff_loop_cta', 10);

// Custom CTA on single product
function scaff_single_product_cta() {
    global $product;
    $phone = get_theme_mod('scaff_contact_phone', '+370 678 34 889');
    ?>
    <div class="single-product__cta">
        <a href="tel:<?php echo esc_attr(preg_replace('/\s+/', '', $phone)); ?>" class="btn btn--primary btn--lg">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07A19.5 19.5 0 013.07 11.04a19.79 19.79 0 01-3.07-8.67A2 2 0 012 .18h3a2 2 0 012 1.72c.127.96.361 1.903.7 2.81a2 2 0 01-.45 2.11L6.09 7.91a16 16 0 006 6l1.27-1.27a2 2 0 012.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0122 14.92l-.08 2z"/></svg>
            Teirautis dėl kainos
        </a>
        <a href="<?php echo esc_url(get_permalink(get_page_by_path('susisiekti'))); ?>" class="btn btn--outline btn--lg">
            Susisiekti dėl užsakymo
        </a>
    </div>
    <?php
}
add_action('woocommerce_single_product_summary', 'scaff_single_product_cta', 30);

// Customize product card markup wrapper
function scaff_woo_loop_item_open() {
    echo '<div class="product-card__inner">';
}
function scaff_woo_loop_item_close() {
    echo '</div>';
}

// Archive page title override
function scaff_woo_page_title($title) {
    if (is_shop()) {
        $title = get_theme_mod('scaff_shop_title', 'Mūsų katalogas');
    }
    return $title;
}
add_filter('woocommerce_page_title', 'scaff_woo_page_title');

// Rename the Shop page to "Katalogas" everywhere its title is pulled from —
// nav menu links and the browser tab/document title.
add_filter('the_title', function($title, $post_id = null) {
    $shop_id = wc_get_page_id('shop');
    if ($shop_id && (int) $post_id === $shop_id && !is_admin()) {
        return 'Katalogas';
    }
    return $title;
}, 10, 2);

add_filter('wp_nav_menu_objects', function($items) {
    $shop_url = wc_get_page_permalink('shop');
    if (!$shop_url) return $items;
    foreach ($items as $item) {
        if (untrailingslashit($item->url) === untrailingslashit($shop_url)) {
            $item->title = 'Katalogas';
        }
    }
    return $items;
});

add_filter('document_title_parts', function($parts) {
    $shop_id = wc_get_page_id('shop');
    if ($shop_id && is_shop() && get_queried_object_id() === $shop_id) {
        $parts['title'] = 'Katalogas';
    }
    return $parts;
});

// Remove sidebar
remove_action('woocommerce_sidebar', 'woocommerce_get_sidebar', 10);

// Product image wrapper
function scaff_loop_product_thumbnail() {
    echo '<div class="product-card__image-wrap">';
    echo woocommerce_get_product_thumbnail('woocommerce_thumbnail');
    echo '</div>';
}
remove_action('woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10);
add_action('woocommerce_before_shop_loop_item_title', 'scaff_loop_product_thumbnail', 10);

// Category tag on each product card
add_action('woocommerce_before_shop_loop_item_title', function() {
    global $product;
    $terms = get_the_terms($product->get_id(), 'product_cat');
    if ($terms && !is_wp_error($terms)) {
        echo '<div class="product-card__cat-tag">' . esc_html(reset($terms)->name) . '</div>';
    }
}, 15);

// Columns
add_filter('loop_shop_columns', function() { return 4; });
add_filter('loop_shop_per_page', function() { return 12; });

// Category filter tab bar above the product grid
add_action('woocommerce_before_shop_loop', function() {
    $terms = get_terms([
        'taxonomy'   => 'product_cat',
        'hide_empty' => true,
        'parent'     => 0,
        'orderby'    => 'count',
        'order'      => 'DESC',
        'number'     => 10,
        'exclude'    => get_option('default_product_cat'),
    ]);
    if (empty($terms) || is_wp_error($terms)) return;

    $current      = get_queried_object();
    $current_slug = ($current instanceof WP_Term && $current->taxonomy === 'product_cat') ? $current->slug : '';

    echo '<div class="shop-cats-wrap">';
    echo '<button class="shop-cats-arrow shop-cats-arrow--prev" aria-label="Ankstesnės" aria-hidden="true"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="15 18 9 12 15 6"/></svg></button>';
    echo '<nav class="shop-cats" aria-label="Kategorijos">';
    echo '<a href="' . esc_url(get_permalink(wc_get_page_id('shop'))) . '" class="shop-cats__tab' . (!$current_slug ? ' is-active' : '') . '">Visi</a>';
    foreach ($terms as $term) {
        $active = $current_slug === $term->slug ? ' is-active' : '';
        echo '<a href="' . esc_url(get_term_link($term)) . '" class="shop-cats__tab' . $active . '">' . esc_html($term->name) . '</a>';
    }
    echo '</nav>';
    echo '<button class="shop-cats-arrow shop-cats-arrow--next" aria-label="Kitos"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 18 15 12 9 6"/></svg></button>';
    echo '</div>';
}, 5);

// Wrap result-count + ordering in a toolbar div
add_action('woocommerce_before_shop_loop', function() {
    echo '<div class="shop-toolbar">';
}, 18);
add_action('woocommerce_before_shop_loop', function() {
    echo '</div>';
}, 35);

// Remove subcategory injection from the product loop.
// WooCommerce adds this filter inside its init() method hooked at priority 0,
// so we must remove it at priority >= 1, after WooCommerce's init runs.
add_action('init', function() {
    remove_filter('woocommerce_product_loop_start', 'woocommerce_maybe_show_product_subcategories');
}, 1);

// Remove result count and ordering from default position (we place custom)
// remove_action('woocommerce_before_shop_loop', 'woocommerce_result_count', 20);

// Breadcrumbs defaults
add_filter('woocommerce_breadcrumb_defaults', function($args) {
    $args['delimiter'] = '<span class="sep">/</span>';
    return $args;
});

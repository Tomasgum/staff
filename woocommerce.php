<?php get_header(); ?>

<div class="woo-page-wrap">
    <?php do_action('woocommerce_before_main_content'); ?>

    <?php
    // "Katalogas" opens on a category grid instead of every product at once.
    // A category page shows its subcategories (if any) above its product grid.
    // Everything else (cart, checkout, account, tags, "visi produktai") keeps
    // WooCommerce's normal content() behavior.
    $scaff_show_all = isset($_GET['rodyti']) && sanitize_text_field(wp_unslash($_GET['rodyti'])) === 'visi';

    if (is_shop() && !is_product_category() && !is_product_tag() && !$scaff_show_all) {

        if (apply_filters('woocommerce_show_page_title', true)) {
            echo '<h1 class="page-title">';
            woocommerce_page_title();
            echo '</h1>';
        }

        $cats = scaff_get_catalog_categories(0);

        if (!empty($cats)) {
            ?>
            <section class="catalog-landing">
                <?php scaff_render_category_grid($cats); ?>
                <p class="catalog-landing__all">
                    <a href="<?php echo esc_url(add_query_arg('rodyti', 'visi', get_permalink(wc_get_page_id('shop')))); ?>" class="btn btn--outline btn--lg">
                        Žiūrėti visus produktus
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
                    </a>
                </p>
            </section>
            <?php
        } else {
            do_action('woocommerce_no_products_found');
        }

    } elseif (is_product_category()) {

        if (apply_filters('woocommerce_show_page_title', true)) {
            echo '<h1 class="page-title">';
            woocommerce_page_title();
            echo '</h1>';
        }

        do_action('woocommerce_archive_description');

        $subcats = scaff_get_catalog_categories(get_queried_object_id());
        if (!empty($subcats)) {
            scaff_render_category_grid($subcats, ['size' => 'sm']);
        }

        if (woocommerce_product_loop()) {
            do_action('woocommerce_before_shop_loop');
            woocommerce_product_loop_start();
            if (wc_get_loop_prop('total')) {
                while (have_posts()) {
                    the_post();
                    do_action('woocommerce_shop_loop');
                    wc_get_template_part('content', 'product');
                }
            }
            woocommerce_product_loop_end();
            do_action('woocommerce_after_shop_loop');
        } else {
            do_action('woocommerce_no_products_found');
        }

    } else {
        woocommerce_content();
    }
    ?>

    <?php do_action('woocommerce_after_main_content'); ?>
</div>

<?php get_footer(); ?>

<?php get_header(); ?>

<div class="woo-page-wrap">
    <?php do_action('woocommerce_before_main_content'); ?>
    <?php woocommerce_content(); ?>
    <?php do_action('woocommerce_after_main_content'); ?>
</div>

<?php get_footer(); ?>

<?php get_header(); ?>

<?php while (have_posts()): the_post(); ?>

<div class="page-hero page-hero--plain">
    <div class="container">
        <?php $news_page_id = (int) get_option('page_for_posts'); ?>
        <?php if ($news_page_id): ?>
        <a href="<?php echo esc_url(get_permalink($news_page_id)); ?>" class="single-post__back">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
            Naujienos
        </a>
        <?php endif; ?>
        <h1 class="page-hero__title"><?php the_title(); ?></h1>
        <span class="single-post__date"><?php echo get_the_date(); ?></span>
    </div>
</div>

<div class="container">
    <div class="page-content single-post__content">
        <?php if (has_post_thumbnail()): ?>
        <div class="single-post__thumbnail">
            <?php the_post_thumbnail('large'); ?>
        </div>
        <?php endif; ?>
        <?php the_content(); ?>
    </div>
</div>

<?php endwhile; ?>

<?php get_footer(); ?>

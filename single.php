<?php get_header(); ?>

<?php while (have_posts()): the_post(); ?>

<div class="page-hero page-hero--plain">
    <div class="container">
        <h1 class="page-hero__title"><?php the_title(); ?></h1>
        <span class="post-card__date"><?php echo get_the_date(); ?></span>
    </div>
</div>

<div class="container">
    <div class="page-content" style="padding-top:48px;padding-bottom:80px;max-width:800px;">
        <?php if (has_post_thumbnail()): ?>
        <div style="margin-bottom:2rem;border-radius:12px;overflow:hidden;">
            <?php the_post_thumbnail('large', ['style' => 'width:100%;height:auto;display:block;']); ?>
        </div>
        <?php endif; ?>
        <?php the_content(); ?>
    </div>
</div>

<?php endwhile; ?>

<?php get_footer(); ?>

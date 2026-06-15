<?php get_header(); ?>

<div class="page-hero page-hero--plain">
    <div class="container">
        <?php the_archive_title('<h1 class="page-hero__title">', '</h1>'); ?>
        <?php the_archive_description('<div class="archive-description">', '</div>'); ?>
    </div>
</div>

<div class="container">
    <div class="content-wrap" style="padding:48px 0 80px">
        <?php if (have_posts()): ?>
        <div class="posts-grid">
            <?php while (have_posts()): the_post(); ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class('post-card'); ?> data-animate="card">
                <?php if (has_post_thumbnail()): ?>
                <a href="<?php the_permalink(); ?>" class="post-card__image">
                    <?php the_post_thumbnail('large'); ?>
                </a>
                <?php endif; ?>
                <div class="post-card__body">
                    <span class="post-card__date"><?php echo get_the_date(); ?></span>
                    <h2 class="post-card__title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                    <div class="post-card__excerpt"><?php the_excerpt(); ?></div>
                    <a href="<?php the_permalink(); ?>" class="btn btn--outline btn--sm">Skaityti daugiau</a>
                </div>
            </article>
            <?php endwhile; ?>
        </div>
        <?php the_posts_pagination(['mid_size' => 2]); ?>
        <?php else: ?>
        <p><?php esc_html_e('Nieko nerasta.', 'scaff'); ?></p>
        <?php endif; ?>
    </div>
</div>

<?php get_footer(); ?>

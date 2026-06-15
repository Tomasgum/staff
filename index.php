<?php get_header(); ?>

<div class="page-hero page-hero--plain">
    <div class="container">
        <h1 class="page-hero__title"><?php
            if (is_home())         echo esc_html(get_bloginfo('name'));
            elseif (is_archive())  echo get_the_archive_title();
            elseif (is_search())   printf(__('Paieška: "%s"', 'scaff'), get_search_query());
            else                   echo esc_html(get_bloginfo('name'));
        ?></h1>
    </div>
</div>

<div class="container">
    <div class="content-wrap">
        <?php if (have_posts()): while (have_posts()): the_post(); ?>
        <article id="post-<?php the_ID(); ?>" <?php post_class('post-card'); ?>>
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
        <?php endwhile; else: ?>
        <p class="no-results"><?php esc_html_e('Nieko nerasta.', 'scaff'); ?></p>
        <?php endif; ?>

        <?php the_posts_pagination(['mid_size' => 2, 'prev_text' => '&larr;', 'next_text' => '&rarr;']); ?>
    </div>
</div>

<?php get_footer(); ?>

<?php get_header(); ?>

<?php while (have_posts()): the_post(); ?>

<?php if (!is_front_page()): ?>
<div class="page-hero page-hero--plain">
    <div class="container">
        <h1 class="page-hero__title"><?php the_title(); ?></h1>
    </div>
</div>
<?php endif; ?>

<div class="container">
    <div class="page-content">
        <?php the_content(); ?>
    </div>
</div>

<?php endwhile; ?>

<?php get_footer(); ?>

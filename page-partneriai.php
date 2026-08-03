<?php get_header(); ?>

<?php while (have_posts()): the_post(); ?>

<div class="page-hero page-hero--plain">
    <div class="container">
        <h1 class="page-hero__title"><?php the_title(); ?></h1>
    </div>
</div>

<?php
$featured_partners = [];
for ($i = 1; $i <= 3; $i++) {
    $photo = scaff_get("scaff_partner_featured_{$i}_photo");
    $name  = scaff_get("scaff_partner_featured_{$i}_name");
    if ($photo || $name) {
        $featured_partners[] = [
            'photo' => $photo,
            'name'  => $name,
            'role'  => scaff_get("scaff_partner_featured_{$i}_role"),
            'url'   => scaff_get("scaff_partner_featured_{$i}_url"),
        ];
    }
}
?>
<?php if (!empty($featured_partners)): ?>
<section class="partners-featured">
    <div class="container">
        <div class="section-header" data-animate="fade-up">
            <span class="section-eyebrow">PAGRINDINIAI ATSTOVAI</span>
        </div>
        <div class="partners-featured__grid">
            <?php foreach ($featured_partners as $idx => $p):
                $tag = $p['url'] ? 'a' : 'div';
            ?>
            <<?php echo $tag; ?> <?php if ($p['url']): ?>href="<?php echo esc_url($p['url']); ?>" target="_blank" rel="noopener noreferrer"<?php endif; ?> class="partner-featured-card" data-animate="fade-up" data-index="<?php echo $idx; ?>">
                <div class="partner-featured-card__photo">
                    <?php if ($p['photo']): ?>
                        <img src="<?php echo esc_url($p['photo']); ?>" alt="<?php echo esc_attr($p['name']); ?>" loading="lazy">
                    <?php else: ?>
                        <div class="partner-featured-card__placeholder">
                            <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                        </div>
                    <?php endif; ?>
                </div>
                <?php if ($p['name']): ?><h3 class="partner-featured-card__name"><?php echo esc_html($p['name']); ?></h3><?php endif; ?>
                <?php if ($p['role']): ?><span class="partner-featured-card__role"><?php echo esc_html($p['role']); ?></span><?php endif; ?>
            </<?php echo $tag; ?>>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<?php
$partners = [];
for ($i = 1; $i <= 8; $i++) {
    $logo = scaff_get("scaff_partner_{$i}_logo");
    if ($logo) {
        $partners[] = ['logo' => $logo, 'url' => scaff_get("scaff_partner_{$i}_url")];
    }
}
?>
<?php if (!empty($partners)): ?>
<section class="partners-section partners-section--page">
    <div class="container">
        <div class="section-header" data-animate="fade-up">
            <span class="section-eyebrow"><?php echo esc_html(scaff_get('scaff_partners_eyebrow', 'MŪSŲ PARTNERIAI')); ?></span>
            <h2 class="section-title"><?php echo esc_html(scaff_get('scaff_partners_title', 'Partneriai')); ?></h2>
        </div>

        <div class="partners-grid">
            <?php foreach ($partners as $partner): ?>
                <?php if ($partner['url']): ?>
                <a href="<?php echo esc_url($partner['url']); ?>" class="partner-logo" target="_blank" rel="noopener noreferrer">
                    <img src="<?php echo esc_url($partner['logo']); ?>" alt="Partneris" loading="lazy">
                </a>
                <?php else: ?>
                <div class="partner-logo">
                    <img src="<?php echo esc_url($partner['logo']); ?>" alt="Partneris" loading="lazy">
                </div>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php elseif (empty($featured_partners)): ?>
<div class="container">
    <div class="page-content">
        <?php the_content(); ?>
    </div>
</div>
<?php endif; ?>

<?php endwhile; ?>

<?php get_footer(); ?>

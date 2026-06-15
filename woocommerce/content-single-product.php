<?php
defined('ABSPATH') || exit;

global $product;

do_action('woocommerce_before_single_product');

$main_image_id = $product->get_image_id();
$gallery_ids   = $product->get_gallery_image_ids();
$all_image_ids = $main_image_id ? array_merge([$main_image_id], $gallery_ids) : $gallery_ids;
$phone         = get_theme_mod('scaff_contact_phone', '+370 678 34 889');
$phone_clean   = preg_replace('/\s+/', '', $phone);
$contact_url   = get_permalink(get_page_by_path('susisiekti'));
$cat_ids       = $product->get_category_ids();
?>

<div id="product-<?php the_ID(); ?>" <?php wc_product_class('scaff-single-product', $product); ?>>

    <div class="scaff-product-inner">

        <!-- ── GALLERY ───────────────────────────────────────── -->
        <div class="scaff-product-gallery-col">
            <?php if (!empty($all_image_ids)): ?>
            <div class="scaff-gallery" data-gallery>
                <div class="scaff-gallery__main">
                    <?php
                    $first_id = $all_image_ids[0];
                    $full_url = wp_get_attachment_image_url($first_id, 'full');
                    echo wp_get_attachment_image($first_id, 'woocommerce_single', false, [
                        'class'     => 'scaff-gallery__main-img',
                        'id'        => 'scaff-gallery-main',
                        'data-full' => esc_url($full_url),
                    ]);
                    ?>
                    <?php if (count($all_image_ids) > 1): ?>
                    <button class="scaff-gallery__nav scaff-gallery__nav--prev" aria-label="Previous image">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="15 18 9 12 15 6"/></svg>
                    </button>
                    <button class="scaff-gallery__nav scaff-gallery__nav--next" aria-label="Next image">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 18 15 12 9 6"/></svg>
                    </button>
                    <?php endif; ?>
                    <button class="scaff-gallery__zoom" id="scaff-gallery-zoom" aria-label="Padidinti vaizdą">
                        <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/><line x1="11" y1="8" x2="11" y2="14"/><line x1="8" y1="11" x2="14" y2="11"/></svg>
                    </button>
                </div>

                <?php if (count($all_image_ids) > 1): ?>
                <div class="scaff-gallery__thumbs">
                    <?php foreach ($all_image_ids as $idx => $img_id): ?>
                    <button class="scaff-gallery__thumb <?php echo $idx === 0 ? 'is-active' : ''; ?>"
                            data-index="<?php echo $idx; ?>"
                            data-src="<?php echo esc_url(wp_get_attachment_image_url($img_id, 'woocommerce_single')); ?>"
                            data-full="<?php echo esc_url(wp_get_attachment_image_url($img_id, 'full')); ?>"
                            aria-label="Image <?php echo $idx + 1; ?>">
                        <?php echo wp_get_attachment_image($img_id, 'thumbnail', false, ['class' => 'scaff-gallery__thumb-img']); ?>
                    </button>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>
            </div>
            <?php else: ?>
            <div class="scaff-gallery scaff-gallery--placeholder">
                <?php echo wc_placeholder_img('woocommerce_single'); ?>
            </div>
            <?php endif; ?>
        </div>

        <!-- ── SUMMARY ───────────────────────────────────────── -->
        <div class="scaff-product-summary-col">

            <?php if (!empty($cat_ids)): ?>
            <div class="scaff-product-cats">
                <?php foreach (array_slice($cat_ids, 0, 3) as $cat_id):
                    $cat_obj = get_term($cat_id, 'product_cat');
                    if (!$cat_obj || is_wp_error($cat_obj)) continue;
                ?>
                <a href="<?php echo esc_url(get_term_link($cat_obj)); ?>" class="scaff-product-cat-pill">
                    <?php echo esc_html($cat_obj->name); ?>
                </a>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>

            <div class="summary entry-summary">
                <?php do_action('woocommerce_single_product_summary'); ?>
            </div>

            <div class="scaff-product-trust">
                <div class="trust-badge">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="1" y="3" width="15" height="13" rx="1"/><polygon points="16 8 20 8 23 13 23 16 16 16 16 8"/><circle cx="5.5" cy="18.5" r="2.5"/><circle cx="18.5" cy="18.5" r="2.5"/></svg>
                    <span>Pristatymas visoje LT</span>
                </div>
                <div class="trust-badge">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><polyline points="1 4 1 10 7 10"/><path d="M3.51 15a9 9 0 1 0 .49-3.22"/></svg>
                    <span>30 d. grąžinimas</span>
                </div>
                <div class="trust-badge">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                    <span>Kokybės garantija</span>
                </div>
            </div>

        </div>

    </div><!-- .scaff-product-inner -->

    <?php do_action('woocommerce_after_single_product_summary'); ?>

</div>

<?php do_action('woocommerce_after_single_product'); ?>

<script>
(function() {
    var gallery = document.querySelector('[data-gallery]');
    if (!gallery) return;

    var mainImg = gallery.querySelector('#scaff-gallery-main');
    var thumbs  = gallery.querySelectorAll('.scaff-gallery__thumb');
    var btnPrev = gallery.querySelector('.scaff-gallery__nav--prev');
    var btnNext = gallery.querySelector('.scaff-gallery__nav--next');
    var btnZoom = document.getElementById('scaff-gallery-zoom');
    var current = 0;

    function goTo(idx) {
        if (!thumbs.length) return;
        idx = (idx + thumbs.length) % thumbs.length;
        current = idx;
        var thumb = thumbs[idx];
        mainImg.style.opacity = '0';
        setTimeout(function() {
            mainImg.src = thumb.dataset.src;
            mainImg.dataset.full = thumb.dataset.full;
            mainImg.style.opacity = '1';
        }, 150);
        thumbs.forEach(function(t) { t.classList.remove('is-active'); });
        thumb.classList.add('is-active');
        thumb.scrollIntoView({ behavior: 'smooth', block: 'nearest', inline: 'center' });
    }

    thumbs.forEach(function(thumb, idx) {
        thumb.addEventListener('click', function() { goTo(idx); });
    });

    if (btnPrev) btnPrev.addEventListener('click', function() { goTo(current - 1); });
    if (btnNext) btnNext.addEventListener('click', function() { goTo(current + 1); });

    function openLightbox() {
        var overlay = document.createElement('div');
        overlay.className = 'scaff-lightbox';
        overlay.innerHTML = '<div class="scaff-lightbox__inner"><img src="' + (mainImg.dataset.full || mainImg.src) + '" alt=""><button class="scaff-lightbox__close" aria-label="Uždaryti"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg></button></div>';
        document.body.appendChild(overlay);
        requestAnimationFrame(function() { overlay.classList.add('is-open'); });
        overlay.querySelector('.scaff-lightbox__close').addEventListener('click', function() {
            overlay.classList.remove('is-open');
            setTimeout(function() { document.body.removeChild(overlay); }, 300);
        });
        overlay.addEventListener('click', function(e) {
            if (e.target === overlay) {
                overlay.classList.remove('is-open');
                setTimeout(function() { document.body.removeChild(overlay); }, 300);
            }
        });
        document.addEventListener('keydown', function handler(e) {
            if (e.key === 'Escape') {
                overlay.classList.remove('is-open');
                setTimeout(function() {
                    if (document.body.contains(overlay)) document.body.removeChild(overlay);
                }, 300);
                document.removeEventListener('keydown', handler);
            }
        });
    }

    mainImg.style.cursor = 'zoom-in';
    mainImg.style.transition = 'opacity 0.15s';
    mainImg.addEventListener('click', openLightbox);
    if (btnZoom) btnZoom.addEventListener('click', openLightbox);
})();
</script>

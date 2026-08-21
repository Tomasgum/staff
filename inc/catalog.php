<?php
// Katalogas restructuring: category-first browsing instead of one flat product grid.
//
// Brand names (North Pro, Scafftools, Skylotec, ...) were entered as product_cat
// terms instead of a real brand field, so they must never appear as catalog
// categories. Keep this list in sync if new brand terms get added before the
// client finishes moving them to the dedicated brand field.
function scaff_catalog_excluded_slugs() {
    return apply_filters('scaff_catalog_excluded_slugs', [
        'north-pro',
        'scafftools',
        'skylotec',
        'be-kategorijos',
    ]);
}

// Client-specified display order for the main product groups (by name, not slug,
// since these were renamed/consolidated directly in wp-admin). Anything not in
// this list falls back after it, in whatever order WordPress returns it.
function scaff_catalog_category_order() {
    return apply_filters('scaff_catalog_category_order', [
        'apraišai',
        'kritimo sulaikymo įranga',
        'gelbėjimo įranga',
        'įrankiai',
        'pirštinės',
        'odiniai įrankių laikikliai ir diržai',
        'darbui su pastoliais',
        'apsaugos priemonės',
        'pvc kuprinės ir tašės',
    ]);
}

function scaff_get_catalog_categories($parent_id = 0) {
    $terms = get_terms([
        'taxonomy'   => 'product_cat',
        'hide_empty' => true,
        'parent'     => $parent_id,
        'exclude'    => [(int) get_option('default_product_cat')],
    ]);

    if (empty($terms) || is_wp_error($terms)) return [];

    $excluded = scaff_catalog_excluded_slugs();
    $terms = array_values(array_filter($terms, function($term) use ($excluded) {
        return !in_array($term->slug, $excluded, true);
    }));

    $order = scaff_catalog_category_order();
    usort($terms, function($a, $b) use ($order) {
        $posA = array_search(mb_strtolower($a->name), $order, true);
        $posB = array_search(mb_strtolower($b->name), $order, true);
        if ($posA === false) $posA = count($order) + $a->term_id;
        if ($posB === false) $posB = count($order) + $b->term_id;
        return $posA <=> $posB;
    });

    return $terms;
}

function scaff_category_icon($term) {
    $icons = [
        'apsauga-nuo-kritimo'          => '<rect x="7" y="3" width="10" height="16" rx="5"/><line x1="17" y1="9" x2="20" y2="9"/>',
        'irankiu-apsauga-nuo-kritimo'  => '<circle cx="7" cy="17" r="3"/><circle cx="17" cy="17" r="3"/><line x1="9.5" y1="14.5" x2="14.5" y2="14.5" stroke-width="2.5"/><path d="M12 12V5a2 2 0 114 0"/>',
        'apsaugines-pirstines'         => '<rect x="7" y="10" width="10" height="10" rx="3"/><rect x="8" y="4" width="2.6" height="8" rx="1.3"/><rect x="11" y="3" width="2.6" height="9" rx="1.3"/><rect x="14" y="4" width="2.6" height="8" rx="1.3"/>',
        'apsauginiai-akiniai'          => '<circle cx="6.5" cy="12" r="3.5"/><circle cx="17.5" cy="12" r="3.5"/><path d="M10 12h4M2.5 10L5 9M21.5 10L19 9"/>',
        'galvos-zibintai'              => '<circle cx="12" cy="12" r="3.5"/><path d="M12 3v2.5M12 18.5V21M4.2 4.2l1.8 1.8M18 18l1.8 1.8M3 12h2.5M18.5 12H21M4.2 19.8L6 18M18 6l1.8-1.8"/>',
        'irankiai-pastolininkams'      => '<rect x="3" y="9" width="18" height="10" rx="2"/><path d="M8 9V6a2 2 0 012-2h4a2 2 0 012 2v3"/><line x1="3" y1="13" x2="21" y2="13"/>',
        'irankiai'                     => '<circle cx="6" cy="6" r="3"/><circle cx="18" cy="18" r="3"/><line x1="8.1" y1="8.1" x2="15.9" y2="15.9" stroke-width="3"/>',
        'plaktukai'                    => '<rect x="2.5" y="2.5" width="6" height="10" rx="1.5" transform="rotate(45 5.5 7.5)"/><line x1="9" y1="11" x2="19" y2="21" stroke-width="2.5"/>',
        'znyples'                      => '<line x1="5" y1="5" x2="15" y2="19"/><line x1="19" y1="5" x2="9" y2="19"/><circle cx="12" cy="12" r="1.8" fill="currentColor" stroke="none"/>',
        'pastoliu-montavimo-raktai'    => '<circle cx="7" cy="7" r="4"/><line x1="10" y1="10" x2="20" y2="20"/><line x1="15" y1="15" x2="17" y2="13"/><line x1="18" y1="18" x2="20" y2="16"/>',
        'matavimo-irankiai'            => '<rect x="2" y="9" width="20" height="6" rx="1"/><line x1="6" y1="9" x2="6" y2="12"/><line x1="10" y1="9" x2="10" y2="13"/><line x1="14" y1="9" x2="14" y2="12"/><line x1="18" y1="9" x2="18" y2="13"/>',
        'salmai'                       => '<path d="M4 15a8 8 0 0116 0"/><rect x="2" y="15" width="20" height="3" rx="1.5"/><line x1="12" y1="4" x2="12" y2="7"/>',
        'irankiu-laikikliai'           => '<path d="M6 8a2 2 0 012-2h8a2 2 0 012 2v10a4 4 0 01-4 4h-4a4 4 0 01-4-4V8z"/><line x1="9" y1="6" x2="9" y2="3"/><line x1="15" y1="6" x2="15" y2="3"/>',
        'radijo-stoteles-racijos'      => '<rect x="7" y="6" width="10" height="16" rx="2"/><line x1="16" y1="6" x2="19" y2="1"/><circle cx="12" cy="11" r="1.4" fill="currentColor" stroke="none"/><line x1="9" y1="16" x2="15" y2="16"/><line x1="9" y1="19" x2="15" y2="19"/>',
        'priedai'                      => '<path d="M9 2v4M15 2v4M6 8h12l-1 5a5 5 0 01-10 0L6 8z"/><line x1="12" y1="17" x2="12" y2="22"/>',
        'kelimo-iranga'                => '<path d="M8 3v10a4 4 0 008 0"/><circle cx="16" cy="17" r="2.5"/>',
        'odiniai-irankiu-dirzai'       => '<rect x="2" y="10" width="20" height="4" rx="1"/><rect x="9" y="8" width="6" height="8" rx="1"/>',
        'pastoliu-tvirtinimo-detales'  => '<circle cx="12" cy="12" r="3"/><path d="M12 3v3M12 18v3M21 12h-3M6 12H3M18.4 5.6l-2.1 2.1M7.7 16.3l-2.1 2.1M18.4 18.4l-2.1-2.1M7.7 7.7L5.6 5.6"/>',
        'virves'                       => '<path d="M4 12a8 8 0 1116 0 6 6 0 01-12 0 4 4 0 018 0 2 2 0 01-4 0"/>',
    ];

    $fallback = '<path d="M21 16V8a2 2 0 00-1-1.73l-7-4a2 2 0 00-2 0l-7 4A2 2 0 002 8v8a2 2 0 001 1.73l7 4a2 2 0 002 0l7-4A2 2 0 0021 16z"/>';
    $inner = $icons[$term->slug] ?? apply_filters('scaff_category_icon_fallback', $fallback, $term);

    return '<svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round">' . $inner . '</svg>';
}

// Renders a grid of category tiles (icon + name + product count).
function scaff_render_category_grid($terms, $args = []) {
    if (empty($terms)) return;

    $defaults = ['size' => 'lg'];
    $args = wp_parse_args($args, $defaults);
    $size_class = $args['size'] === 'sm' ? ' catalog-cat-grid--sm' : '';
    ?>
    <div class="catalog-cat-grid<?php echo esc_attr($size_class); ?>">
        <?php foreach ($terms as $term):
            $thumb_id  = get_term_meta($term->term_id, 'thumbnail_id', true);
            $thumb_url = $thumb_id ? wp_get_attachment_image_url($thumb_id, 'thumbnail') : '';
        ?>
        <a href="<?php echo esc_url(get_term_link($term)); ?>" class="catalog-cat-card">
            <span class="catalog-cat-card__icon">
                <?php if ($thumb_url): ?>
                    <img src="<?php echo esc_url($thumb_url); ?>" alt="" loading="lazy">
                <?php else: ?>
                    <?php echo scaff_category_icon($term); ?>
                <?php endif; ?>
            </span>
            <span class="catalog-cat-card__name"><?php echo esc_html($term->name); ?></span>
            <span class="catalog-cat-card__count"><?php echo (int) $term->count; ?> produktų</span>
        </a>
        <?php endforeach; ?>
    </div>
    <?php
}

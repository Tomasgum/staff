<?php

function scaff_customizer_register($wp_customize) {

    // ════════════════════════════════════════════════════════════════════════
    // PANEL: ANTRAŠTĖ (HEADER)
    // ════════════════════════════════════════════════════════════════════════
    $wp_customize->add_panel('scaff_panel_header', [
        'title'    => __('Antraštė', 'scaff'),
        'priority' => 5,
    ]);

    // ── ANTRAŠTĖS STILIUS ───────────────────────────────────────────────────
    $wp_customize->add_section('scaff_header_style_section', [
        'title'    => __('Antraštės stilius', 'scaff'),
        'panel'    => 'scaff_panel_header',
        'priority' => 1,
    ]);

    $wp_customize->add_setting('scaff_header_style', [
        'default'           => 'default',
        'sanitize_callback' => 'scaff_sanitize_header_style',
        'transport'         => 'refresh',
    ]);
    $wp_customize->add_control('scaff_header_style', [
        'label'   => __('Desktop meniu stilius', 'scaff'),
        'section' => 'scaff_header_style_section',
        'type'    => 'radio',
        'choices' => [
            'default'        => __('Kaip dabar (top juosta)', 'scaff'),
            'sidebar'        => __('Meniu visada kairėje', 'scaff'),
            'scroll-sidebar' => __('Top juosta, slenkant žemyn → kairėje', 'scaff'),
        ],
    ]);

    // ── VIRŠUTINĖ JUOSTA (TOP BAR) ───────────────────────────────────────────
    $wp_customize->add_section('scaff_topbar', [
        'title'    => __('Viršutinė juosta', 'scaff'),
        'panel'    => 'scaff_panel_header',
        'priority' => 2,
    ]);

    scaff_add_setting($wp_customize, 'scaff_topbar_text', 'DĖL ĮMONĖMS SKIRTOS KAINODAROS SUSISIEKITE', 'scaff_topbar', 'text');
    scaff_add_setting($wp_customize, 'scaff_topbar_phone', '+370 678 34 889', 'scaff_topbar', 'text');
    scaff_add_setting($wp_customize, 'scaff_topbar_email', 'info@scaffshop.lt', 'scaff_topbar', 'text');

    // Social icons (left corner of top bar) — up to 3, each with a selectable network + URL.
    $topbar_social_defaults = [1 => 'facebook', 2 => 'instagram', 3 => 'linkedin'];
    foreach ($topbar_social_defaults as $i => $icon) {
        $wp_customize->add_setting("scaff_topbar_social_{$i}_icon", [
            'default'           => $icon,
            'sanitize_callback' => 'scaff_sanitize_social_icon',
            'transport'         => 'refresh',
        ]);
        $wp_customize->add_control("scaff_topbar_social_{$i}_icon", [
            'label'   => sprintf(__('Soc. ikona %d – tinklas', 'scaff'), $i),
            'section' => 'scaff_topbar',
            'type'    => 'select',
            'choices' => scaff_social_icon_choices(),
        ]);

        scaff_add_setting($wp_customize, "scaff_topbar_social_{$i}_url", '', 'scaff_topbar', 'url');
    }

    // ════════════════════════════════════════════════════════════════════════
    // PANEL: PAGRINDINIS PUSLAPIS (HOME PAGE)
    // ════════════════════════════════════════════════════════════════════════
    $wp_customize->add_panel('scaff_panel_home', [
        'title'    => __('Pagrindinis puslapis', 'scaff'),
        'priority' => 10,
    ]);

    // ── HERO ─────────────────────────────────────────────────────────────────
    $wp_customize->add_section('scaff_hero', [
        'title'    => __('Hero', 'scaff'),
        'panel'    => 'scaff_panel_home',
        'priority' => 1,
    ]);

    scaff_add_setting($wp_customize, 'scaff_hero_eyebrow', 'PROFESIONALŲ PASIRINKIMAS', 'scaff_hero', 'text');
    scaff_add_setting($wp_customize, 'scaff_hero_title', 'Pastolių įrankiai ir darbo aukštyje įranga', 'scaff_hero', 'text');
    scaff_add_setting($wp_customize, 'scaff_hero_subtitle', 'Aukščiausios kokybės įrankiai profesionalams. Pristatome visoje Lietuvoje.', 'scaff_hero', 'text');
    scaff_add_setting($wp_customize, 'scaff_hero_cta_primary', 'Peržiūrėti katalogą', 'scaff_hero', 'text');
    scaff_add_setting($wp_customize, 'scaff_hero_cta_primary_url', '/katalogas', 'scaff_hero', 'url');
    scaff_add_setting($wp_customize, 'scaff_hero_cta_secondary', 'Susisiekti', 'scaff_hero', 'text');
    scaff_add_setting($wp_customize, 'scaff_hero_cta_secondary_url', '/susisiekti', 'scaff_hero', 'url');
    scaff_add_setting($wp_customize, 'scaff_hero_image', '', 'scaff_hero', 'image');
    scaff_add_setting($wp_customize, 'scaff_hero_video_url', '', 'scaff_hero', 'url');

    // Hero slider images (right column)
    for ($i = 1; $i <= 5; $i++) {
        scaff_add_setting($wp_customize, "scaff_hero_slide_{$i}", '', 'scaff_hero', 'image');
    }

    // ── APIE MUS (SEKA) — trumpa santrauka pagrindiniame puslapyje ─────────────
    $wp_customize->add_section('scaff_about', [
        'title'    => __('Apie mus (seka)', 'scaff'),
        'panel'    => 'scaff_panel_home',
        'priority' => 2,
        'description' => __('Trumpa "Apie mus" santrauka pagrindiniame puslapyje. Pilnas tekstas ir nuotraukos redaguojami atskirame "Apie mus" skydelyje.', 'scaff'),
    ]);

    scaff_add_setting($wp_customize, 'scaff_about_eyebrow', 'APIE MUS', 'scaff_about', 'text');
    scaff_add_setting($wp_customize, 'scaff_about_title', 'Profesionalams iš profesionalų', 'scaff_about', 'text');
    scaff_add_setting($wp_customize, 'scaff_about_text', 'ScaffShop – specializuota parduotuvė, siūlanti pastolių įrankius ir darbo aukštyje įrangą. Dirbame su geriausiomis pasaulinėmis prekės ženklais ir garantuojame aukščiausią kokybę kiekvienam produktui.', 'scaff_about', 'textarea');
    scaff_add_setting($wp_customize, 'scaff_about_image', '', 'scaff_about', 'image');
    scaff_add_setting($wp_customize, 'scaff_about_cta', 'Sužinoti daugiau', 'scaff_about', 'text');
    scaff_add_setting($wp_customize, 'scaff_about_cta_url', '/apie-mus', 'scaff_about', 'url');

    // ── KITOS SEKCIJOS — statistika, USP blokai, CTA juosta ────────────────────
    $wp_customize->add_section('scaff_home_other', [
        'title'    => __('Kitos sekcijos', 'scaff'),
        'panel'    => 'scaff_panel_home',
        'priority' => 3,
    ]);

    for ($i = 1; $i <= 4; $i++) {
        scaff_add_setting($wp_customize, "scaff_stat_{$i}_number", ['1' => '500+', '2' => '15+', '3' => '', '4' => '100%'][$i], 'scaff_home_other', 'text');
        scaff_add_setting($wp_customize, "scaff_stat_{$i}_label", ['1' => 'Produktų kataloge', '2' => 'Metų patirtis', '3' => '', '4' => 'Kokybės garantija'][$i], 'scaff_home_other', 'text');
        scaff_add_setting($wp_customize, "scaff_stat_{$i}_icon", ['1' => 'box', '2' => 'award', '3' => 'refresh-cw', '4' => 'shield'][$i], 'scaff_home_other', 'text');
    }

    $usp_defaults = [
        1 => ['icon' => 'truck', 'title' => 'Greitas pristatymas', 'text' => 'Pristatome visoje Lietuvoje per 1–3 darbo dienas'],
        2 => ['icon' => 'refresh-cw', 'title' => '30 dienų grąžinimas', 'text' => 'Nepatiko? Grąžinkite per 30 dienų be jokių klausimų'],
        3 => ['icon' => 'package', 'title' => 'Atsiėmimas nemokamai', 'text' => 'Atsiimkite prekes nemokamai iš mūsų sandėlio'],
        4 => ['icon' => 'headphones', 'title' => 'Ekspertų konsultacija', 'text' => 'Mūsų specialistai padės pasirinkti tinkamą įrangą'],
    ];
    for ($i = 1; $i <= 4; $i++) {
        scaff_add_setting($wp_customize, "scaff_usp_{$i}_icon", $usp_defaults[$i]['icon'], 'scaff_home_other', 'text');
        scaff_add_setting($wp_customize, "scaff_usp_{$i}_title", $usp_defaults[$i]['title'], 'scaff_home_other', 'text');
        scaff_add_setting($wp_customize, "scaff_usp_{$i}_text", $usp_defaults[$i]['text'], 'scaff_home_other', 'textarea');
    }

    scaff_add_setting($wp_customize, 'scaff_cta_title', 'Reikia konsultacijos?', 'scaff_home_other', 'text');
    scaff_add_setting($wp_customize, 'scaff_cta_text', 'Mūsų specialistai pasiruošę padėti pasirinkti tinkamą įrangą jūsų projektui.', 'scaff_home_other', 'textarea');

    scaff_add_setting($wp_customize, 'scaff_categories_eyebrow', 'Mūsų produktai', 'scaff_home_other', 'text');
    scaff_add_setting($wp_customize, 'scaff_categories_title', 'Kategorijos', 'scaff_home_other', 'text');
    scaff_add_setting($wp_customize, 'scaff_categories_subtitle', 'Raskite viską, ko reikia darbui aukštyje', 'scaff_home_other', 'text');

    scaff_add_setting($wp_customize, 'scaff_products_eyebrow', 'Rekomenduojami', 'scaff_home_other', 'text');
    scaff_add_setting($wp_customize, 'scaff_products_title', 'Populiarūs produktai', 'scaff_home_other', 'text');

    scaff_add_setting($wp_customize, 'scaff_home_news_eyebrow', 'Naujienos', 'scaff_home_other', 'text');
    scaff_add_setting($wp_customize, 'scaff_home_news_title', 'Naujausi įrašai', 'scaff_home_other', 'text');

    // ════════════════════════════════════════════════════════════════════════
    // PANEL: APIE MUS (puslapis)
    // ════════════════════════════════════════════════════════════════════════
    $wp_customize->add_panel('scaff_panel_apie_mus', [
        'title'    => __('Apie mus', 'scaff'),
        'priority' => 15,
    ]);

    $wp_customize->add_section('scaff_about_page', [
        'title'    => __('Apie mus puslapis', 'scaff'),
        'panel'    => 'scaff_panel_apie_mus',
        'priority' => 1,
    ]);

    scaff_add_setting($wp_customize, 'scaff_about_page_eyebrow', 'APIE MUS', 'scaff_about_page', 'text', 'Viršutinė antraštė (eyebrow)');
    scaff_add_setting($wp_customize, 'scaff_about_page_text', "ScaffShop – specializuota parduotuvė, siūlanti pastolių įrankius ir darbo aukštyje įrangą.\n\nDirbame su geriausiomis pasaulinėmis prekės ženklais ir garantuojame aukščiausią kokybę kiekvienam produktui.", 'scaff_about_page', 'textarea', 'Pagrindinis tekstas (tuščia eilutė = nauja pastraipa)');
    for ($i = 1; $i <= 4; $i++) {
        scaff_add_setting($wp_customize, "scaff_about_page_photo_{$i}", '', 'scaff_about_page', 'image', "Nuotrauka {$i}");
    }

    // ── STATISTIKA IR CTA — tie patys duomenys, kaip Pagrindinis puslapis → Kitos sekcijos ──
    $wp_customize->add_section('scaff_about_page_extra', [
        'title'       => __('Statistika ir CTA', 'scaff'),
        'panel'       => 'scaff_panel_apie_mus',
        'priority'    => 2,
        'description' => __('Šie laukai bendri su pagrindiniu puslapiu (Pagrindinis puslapis → Kitos sekcijos) — pakeitus čia, atsinaujina abi vietos.', 'scaff'),
    ]);

    foreach ([1, 2, 4] as $i) {
        $wp_customize->add_control("scaff_about_extra_stat_{$i}_number", [
            'settings' => "scaff_stat_{$i}_number",
            'label'    => sprintf(__('Statistika %d — skaičius', 'scaff'), $i),
            'section'  => 'scaff_about_page_extra',
            'type'     => 'text',
        ]);
        $wp_customize->add_control("scaff_about_extra_stat_{$i}_label", [
            'settings' => "scaff_stat_{$i}_label",
            'label'    => sprintf(__('Statistika %d — tekstas', 'scaff'), $i),
            'section'  => 'scaff_about_page_extra',
            'type'     => 'text',
        ]);
    }

    $wp_customize->add_control('scaff_about_extra_cta_title', [
        'settings' => 'scaff_cta_title',
        'label'    => __('CTA antraštė', 'scaff'),
        'section'  => 'scaff_about_page_extra',
        'type'     => 'text',
    ]);
    $wp_customize->add_control('scaff_about_extra_cta_text', [
        'settings' => 'scaff_cta_text',
        'label'    => __('CTA tekstas', 'scaff'),
        'section'  => 'scaff_about_page_extra',
        'type'     => 'textarea',
    ]);

    // ════════════════════════════════════════════════════════════════════════
    // PANEL: PARTNERIAI (puslapis)
    // ════════════════════════════════════════════════════════════════════════
    $wp_customize->add_panel('scaff_panel_partneriai', [
        'title'    => __('Partneriai', 'scaff'),
        'priority' => 16,
    ]);

    // ── PAGRINDINIAI ATSTOVAI — rodomi per centrą, iškart po puslapio antraštės ─
    $wp_customize->add_section('scaff_partners_featured', [
        'title'       => __('Pagrindiniai atstovai', 'scaff'),
        'panel'       => 'scaff_panel_partneriai',
        'priority'    => 1,
        'description' => __('Iki 3 pagrindinių atstovų — rodomi didesni, per puslapio centrą, virš viso partnerių sąrašo.', 'scaff'),
    ]);

    for ($i = 1; $i <= 3; $i++) {
        scaff_add_setting($wp_customize, "scaff_partner_featured_{$i}_photo", '', 'scaff_partners_featured', 'image');
        scaff_add_setting($wp_customize, "scaff_partner_featured_{$i}_name", '', 'scaff_partners_featured', 'text');
        scaff_add_setting($wp_customize, "scaff_partner_featured_{$i}_role", '', 'scaff_partners_featured', 'text');
        scaff_add_setting($wp_customize, "scaff_partner_featured_{$i}_url", '', 'scaff_partners_featured', 'url');
    }

    // ── VISI PARTNERIAI — logotipų tinklelis (naudojamas ir pagrindiniame puslapyje) ─
    $wp_customize->add_section('scaff_partners', [
        'title'    => __('Visi partneriai', 'scaff'),
        'panel'    => 'scaff_panel_partneriai',
        'priority' => 2,
    ]);

    scaff_add_setting($wp_customize, 'scaff_partners_eyebrow', 'MŪSŲ PARTNERIAI', 'scaff_partners', 'text');
    scaff_add_setting($wp_customize, 'scaff_partners_title', 'Partneriai', 'scaff_partners', 'text');

    // Up to 8 partner logos. Leave a logo empty to remove that slot.
    for ($i = 1; $i <= 8; $i++) {
        scaff_add_setting($wp_customize, "scaff_partner_{$i}_logo", '', 'scaff_partners', 'image');
        scaff_add_setting($wp_customize, "scaff_partner_{$i}_url", '', 'scaff_partners', 'url');
    }

    // ── NAUJIENOS (puslapis) ─────────────────────────────────────────────────
    $wp_customize->add_section('scaff_news', [
        'title'    => __('Naujienos', 'scaff'),
        'priority' => 17,
    ]);

    scaff_add_setting($wp_customize, 'scaff_news_intro', '', 'scaff_news', 'textarea');

    // ── KONTAKTAI ─────────────────────────────────────────────────────────────
    $wp_customize->add_section('scaff_contact', [
        'title'    => __('Kontaktai', 'scaff'),
        'priority' => 20,
    ]);

    scaff_add_setting($wp_customize, 'scaff_contact_form_title', 'Parašykite mums', 'scaff_contact', 'text');
    scaff_add_setting($wp_customize, 'scaff_contact_form_subtitle', 'Atsakysime per 1 darbo dieną.', 'scaff_contact', 'text');
    scaff_add_setting($wp_customize, 'scaff_contact_phone', '+370 678 34 889', 'scaff_contact', 'text');
    scaff_add_setting($wp_customize, 'scaff_contact_email', 'info@scaffshop.lt', 'scaff_contact', 'text');
    scaff_add_setting($wp_customize, 'scaff_contact_address', 'Vilnius, Lietuva', 'scaff_contact', 'text');
    scaff_add_setting($wp_customize, 'scaff_contact_hours', 'I – V: 8:00 – 17:00', 'scaff_contact', 'text');
    scaff_add_setting($wp_customize, 'scaff_footer_fb_url', '', 'scaff_contact', 'url');
    scaff_add_setting($wp_customize, 'scaff_footer_ig_url', '', 'scaff_contact', 'url');
    scaff_add_setting($wp_customize, 'scaff_footer_li_url', '', 'scaff_contact', 'url');

    // ── FOOTER ───────────────────────────────────────────────────────────────
    $wp_customize->add_section('scaff_footer', [
        'title'    => __('Footer', 'scaff'),
        'priority' => 21,
    ]);

    scaff_add_setting($wp_customize, 'scaff_footer_tagline', 'Pastolių įrankiai ir darbo aukštyje įranga profesionalams.', 'scaff_footer', 'textarea');
    scaff_add_setting($wp_customize, 'scaff_footer_copyright', '© 2024 ScaffShop. Visos teisės saugomos.', 'scaff_footer', 'text');

    // ── COLORS ───────────────────────────────────────────────────────────────
    $wp_customize->add_section('scaff_colors', [
        'title'    => __('Theme Colors', 'scaff'),
        'priority' => 22,
    ]);

    scaff_add_color_setting($wp_customize, 'scaff_color_accent', '#FF6A00', 'scaff_colors', 'Accent Color');
    scaff_add_color_setting($wp_customize, 'scaff_color_dark', '#0D0D0D', 'scaff_colors', 'Dark Background');
    scaff_add_color_setting($wp_customize, 'scaff_color_surface', '#161616', 'scaff_colors', 'Surface Color');
}
add_action('customize_register', 'scaff_customizer_register');

function scaff_sanitize_header_style($value) {
    $allowed = ['default', 'sidebar', 'scroll-sidebar'];
    return in_array($value, $allowed, true) ? $value : 'default';
}

function scaff_social_icon_choices() {
    return [
        'facebook'  => __('Facebook', 'scaff'),
        'instagram' => __('Instagram', 'scaff'),
        'linkedin'  => __('LinkedIn', 'scaff'),
        'youtube'   => __('YouTube', 'scaff'),
        'tiktok'    => __('TikTok', 'scaff'),
        'whatsapp'  => __('WhatsApp', 'scaff'),
        'x'         => __('X (Twitter)', 'scaff'),
    ];
}

function scaff_sanitize_social_icon($value) {
    $allowed = array_keys(scaff_social_icon_choices());
    return in_array($value, $allowed, true) ? $value : 'facebook';
}

function scaff_social_icon_svg($type) {
    $icons = [
        'facebook'  => '<svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M18 2h-3a5 5 0 00-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 011-1h3z"/></svg>',
        'instagram' => '<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"/><path d="M16 11.37A4 4 0 1112.63 8 4 4 0 0116 11.37z"/><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"/></svg>',
        'linkedin'  => '<svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M16 8a6 6 0 016 6v7h-4v-7a2 2 0 00-2-2 2 2 0 00-2 2v7h-4v-7a6 6 0 016-6zM2 9h4v12H2z"/><circle cx="4" cy="4" r="2"/></svg>',
        'youtube'   => '<svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M22.54 6.42a2.78 2.78 0 00-1.94-2C18.88 4 12 4 12 4s-6.88 0-8.6.42a2.78 2.78 0 00-1.94 2A29 29 0 001 11.75a29 29 0 00.46 5.33 2.78 2.78 0 001.94 2c1.72.42 8.6.42 8.6.42s6.88 0 8.6-.42a2.78 2.78 0 001.94-2 29 29 0 00.46-5.33 29 29 0 00-.46-5.33z"/><path d="M9.75 15.02l5.75-3.27-5.75-3.27v6.54z" fill="var(--dark,#0D0D0D)"/></svg>',
        'tiktok'    => '<svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M16.6 5.82a4.28 4.28 0 01-3.28-3.82h-3.06v13.5a2.6 2.6 0 11-2.6-2.6c.15 0 .3.01.44.03V9.85a5.62 5.62 0 00-.44-.02A5.6 5.6 0 106.6 15.5V9.9a7.3 7.3 0 004.3 1.38V8.2a4.27 4.27 0 001.7.37V5.82z"/></svg>',
        'whatsapp'  => '<svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M17.5 14.4c-.3-.15-1.7-.85-2-.95-.27-.1-.46-.15-.66.15-.2.3-.75.95-.92 1.15-.17.2-.34.22-.63.07-.3-.15-1.24-.46-2.36-1.46-.87-.78-1.46-1.74-1.63-2.04-.17-.3-.02-.46.13-.6.13-.13.3-.34.44-.5.15-.17.2-.3.3-.5.1-.2.05-.37-.02-.52-.07-.15-.66-1.6-.9-2.2-.24-.58-.48-.5-.66-.5h-.56c-.2 0-.52.07-.79.37-.27.3-1.04 1.02-1.04 2.48s1.07 2.87 1.22 3.07c.15.2 2.1 3.2 5.08 4.48.71.3 1.26.49 1.7.62.71.23 1.36.2 1.87.12.57-.09 1.7-.7 1.94-1.37.24-.68.24-1.26.17-1.38-.07-.13-.26-.2-.56-.35z"/><path d="M12 2a10 10 0 00-8.5 15.2L2 22l4.9-1.4A10 10 0 1012 2zm0 18.2a8.2 8.2 0 01-4.2-1.15l-.3-.18-3.1.9.9-3-.2-.3A8.2 8.2 0 1112 20.2z"/></svg>',
        'x'         => '<svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M18.9 2h3.3l-7.2 8.2L23.5 22h-6.7l-5.2-6.8L5.6 22H2.3l7.7-8.8L1.5 2h6.9l4.7 6.2L18.9 2zm-1.2 18h1.8L7.4 4H5.5l12.2 16z"/></svg>',
    ];
    return $icons[$type] ?? $icons['facebook'];
}


function scaff_add_setting($wp_customize, $id, $default, $section, $type = 'text', $label = null) {
    $wp_customize->add_setting($id, [
        'default'           => $default,
        'sanitize_callback' => $type === 'url' ? 'esc_url_raw' : ($type === 'textarea' ? 'sanitize_textarea_field' : 'sanitize_text_field'),
        'transport'         => 'refresh',
    ]);

    $control_args = [
        'label'   => $label ?? ucwords(str_replace(['scaff_', '_'], ['', ' '], $id)),
        'section' => $section,
        'type'    => in_array($type, ['text', 'url', 'textarea']) ? ($type === 'textarea' ? 'textarea' : 'text') : 'text',
    ];

    if ($type === 'image') {
        $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, $id, array_merge($control_args, ['type' => 'image'])));
    } else {
        $wp_customize->add_control($id, $control_args);
    }
}

function scaff_add_color_setting($wp_customize, $id, $default, $section, $label) {
    $wp_customize->add_setting($id, [
        'default'           => $default,
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'refresh',
    ]);
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, $id, [
        'label'   => $label,
        'section' => $section,
    ]));
}

function scaff_customizer_css() {
    $accent  = get_theme_mod('scaff_color_accent', '#FF6A00');
    $dark    = get_theme_mod('scaff_color_dark', '#0D0D0D');
    $surface = get_theme_mod('scaff_color_surface', '#161616');

    // Convert hex to RGB for rgba usage
    list($r, $g, $b) = sscanf($accent, '#%02x%02x%02x');

    echo "<style>
    :root {
        --accent: {$accent};
        --accent-rgb: {$r}, {$g}, {$b};
        --dark: {$dark};
        --surface: {$surface};
    }
    </style>\n";
}
add_action('wp_head', 'scaff_customizer_css');

function scaff_get($key, $default = '') {
    return get_theme_mod($key, $default);
}

<?php

function scaff_customizer_register($wp_customize) {

    // ── TOP BAR ──────────────────────────────────────────────────────────────
    $wp_customize->add_section('scaff_topbar', [
        'title'    => __('Top Bar', 'scaff'),
        'priority' => 30,
    ]);

    scaff_add_setting($wp_customize, 'scaff_topbar_text', 'DĖL ĮMONĖMS SKIRTOS KAINODAROS SUSISIEKITE', 'scaff_topbar', 'text');
    scaff_add_setting($wp_customize, 'scaff_topbar_hours', 'I – V 8:00 – 17:00', 'scaff_topbar', 'text');
    scaff_add_setting($wp_customize, 'scaff_topbar_phone', '+370 678 34 889', 'scaff_topbar', 'text');
    scaff_add_setting($wp_customize, 'scaff_topbar_email', 'info@scaffshop.lt', 'scaff_topbar', 'text');

    // ── HERO ─────────────────────────────────────────────────────────────────
    $wp_customize->add_section('scaff_hero', [
        'title'    => __('Hero Section', 'scaff'),
        'priority' => 31,
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

    // ── STATS BAR ────────────────────────────────────────────────────────────
    $wp_customize->add_section('scaff_stats', [
        'title'    => __('Stats / Features Bar', 'scaff'),
        'priority' => 32,
    ]);

    for ($i = 1; $i <= 4; $i++) {
        scaff_add_setting($wp_customize, "scaff_stat_{$i}_number", ['1' => '500+', '2' => '15+', '3' => '30', '4' => '100%'][$i], 'scaff_stats', 'text');
        scaff_add_setting($wp_customize, "scaff_stat_{$i}_label", ['1' => 'Produktų kataloge', '2' => 'Metų patirtis', '3' => 'Dienų grąžinimas', '4' => 'Kokybės garantija'][$i], 'scaff_stats', 'text');
        scaff_add_setting($wp_customize, "scaff_stat_{$i}_icon", ['1' => 'box', '2' => 'award', '3' => 'refresh-cw', '4' => 'shield'][$i], 'scaff_stats', 'text');
    }

    // ── ABOUT ────────────────────────────────────────────────────────────────
    $wp_customize->add_section('scaff_about', [
        'title'    => __('About Section', 'scaff'),
        'priority' => 33,
    ]);

    scaff_add_setting($wp_customize, 'scaff_about_eyebrow', 'APIE MUS', 'scaff_about', 'text');
    scaff_add_setting($wp_customize, 'scaff_about_title', 'Profesionalams iš profesionalų', 'scaff_about', 'text');
    scaff_add_setting($wp_customize, 'scaff_about_text', 'ScaffShop – specializuota parduotuvė, siūlanti pastolių įrankius ir darbo aukštyje įrangą. Dirbame su geriausiomis pasaulinėmis prekės ženklais ir garantuojame aukščiausią kokybę kiekvienam produktui.', 'scaff_about', 'textarea');
    scaff_add_setting($wp_customize, 'scaff_about_image', '', 'scaff_about', 'image');
    scaff_add_setting($wp_customize, 'scaff_about_cta', 'Sužinoti daugiau', 'scaff_about', 'text');
    scaff_add_setting($wp_customize, 'scaff_about_cta_url', '/apie-mus', 'scaff_about', 'url');

    // ── USP BLOCKS ───────────────────────────────────────────────────────────
    $wp_customize->add_section('scaff_usp', [
        'title'    => __('USP Blocks', 'scaff'),
        'priority' => 34,
    ]);

    $usp_defaults = [
        1 => ['icon' => 'truck', 'title' => 'Greitas pristatymas', 'text' => 'Pristatome visoje Lietuvoje per 1–3 darbo dienas'],
        2 => ['icon' => 'refresh-cw', 'title' => '30 dienų grąžinimas', 'text' => 'Nepatiko? Grąžinkite per 30 dienų be jokių klausimų'],
        3 => ['icon' => 'package', 'title' => 'Atsiėmimas nemokamai', 'text' => 'Atsiimkite prekes nemokamai iš mūsų sandėlio'],
        4 => ['icon' => 'headphones', 'title' => 'Ekspertų konsultacija', 'text' => 'Mūsų specialistai padės pasirinkti tinkamą įrangą'],
    ];

    for ($i = 1; $i <= 4; $i++) {
        scaff_add_setting($wp_customize, "scaff_usp_{$i}_icon", $usp_defaults[$i]['icon'], 'scaff_usp', 'text');
        scaff_add_setting($wp_customize, "scaff_usp_{$i}_title", $usp_defaults[$i]['title'], 'scaff_usp', 'text');
        scaff_add_setting($wp_customize, "scaff_usp_{$i}_text", $usp_defaults[$i]['text'], 'scaff_usp', 'textarea');
    }

    // ── CONTACT ──────────────────────────────────────────────────────────────
    $wp_customize->add_section('scaff_contact', [
        'title'    => __('Contact Info', 'scaff'),
        'priority' => 35,
    ]);

    scaff_add_setting($wp_customize, 'scaff_contact_address', 'Vilnius, Lietuva', 'scaff_contact', 'text');
    scaff_add_setting($wp_customize, 'scaff_contact_phone', '+370 678 34 889', 'scaff_contact', 'text');
    scaff_add_setting($wp_customize, 'scaff_contact_email', 'info@scaffshop.lt', 'scaff_contact', 'text');
    scaff_add_setting($wp_customize, 'scaff_contact_hours', 'I – V: 8:00 – 17:00', 'scaff_contact', 'text');

    // ── FOOTER ───────────────────────────────────────────────────────────────
    $wp_customize->add_section('scaff_footer', [
        'title'    => __('Footer', 'scaff'),
        'priority' => 36,
    ]);

    scaff_add_setting($wp_customize, 'scaff_footer_tagline', 'Pastolių įrankiai ir darbo aukštyje įranga profesionalams.', 'scaff_footer', 'textarea');
    scaff_add_setting($wp_customize, 'scaff_footer_copyright', '© 2024 ScaffShop. Visos teisės saugomos.', 'scaff_footer', 'text');
    scaff_add_setting($wp_customize, 'scaff_footer_fb_url', '', 'scaff_footer', 'url');
    scaff_add_setting($wp_customize, 'scaff_footer_ig_url', '', 'scaff_footer', 'url');
    scaff_add_setting($wp_customize, 'scaff_footer_li_url', '', 'scaff_footer', 'url');

    // ── COLORS ───────────────────────────────────────────────────────────────
    $wp_customize->add_section('scaff_colors', [
        'title'    => __('Theme Colors', 'scaff'),
        'priority' => 37,
    ]);

    scaff_add_color_setting($wp_customize, 'scaff_color_accent', '#FF6A00', 'scaff_colors', 'Accent Color');
    scaff_add_color_setting($wp_customize, 'scaff_color_dark', '#0D0D0D', 'scaff_colors', 'Dark Background');
    scaff_add_color_setting($wp_customize, 'scaff_color_surface', '#161616', 'scaff_colors', 'Surface Color');
}
add_action('customize_register', 'scaff_customizer_register');


function scaff_add_setting($wp_customize, $id, $default, $section, $type = 'text') {
    $wp_customize->add_setting($id, [
        'default'           => $default,
        'sanitize_callback' => $type === 'url' ? 'esc_url_raw' : ($type === 'textarea' ? 'sanitize_textarea_field' : 'sanitize_text_field'),
        'transport'         => 'refresh',
    ]);

    $control_args = [
        'label'   => ucwords(str_replace(['scaff_', '_'], ['', ' '], $id)),
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

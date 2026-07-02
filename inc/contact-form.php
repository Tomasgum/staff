<?php

add_action('wp_ajax_scaff_contact', 'scaff_handle_contact_form');
add_action('wp_ajax_nopriv_scaff_contact', 'scaff_handle_contact_form');

function scaff_handle_contact_form() {
    if (!check_ajax_referer('scaff_nonce', 'nonce', false)) {
        wp_send_json_error(['message' => 'Saugumo klaida. Pabandykite dar kartą.']);
    }

    $name    = sanitize_text_field($_POST['contact_name'] ?? '');
    $email   = sanitize_email($_POST['contact_email'] ?? '');
    $phone   = sanitize_text_field($_POST['contact_phone'] ?? '');
    $message = sanitize_textarea_field($_POST['contact_message'] ?? '');

    if (!$name || !$email || !$message) {
        wp_send_json_error(['message' => 'Prašome užpildyti visus privalomus laukus.']);
    }

    if (!is_email($email)) {
        wp_send_json_error(['message' => 'Neteisingas el. pašto adresas.']);
    }

    $to      = get_theme_mod('scaff_contact_email', get_option('admin_email'));
    $subject = 'Naujas užklausimas nuo ' . $name;
    $body    = "Vardas: {$name}\nEl. paštas: {$email}\nTelefonas: {$phone}\n\nŽinutė:\n{$message}";
    $headers = [
        'Content-Type: text/plain; charset=UTF-8',
        'Reply-To: ' . $name . ' <' . $email . '>',
    ];

    if (wp_mail($to, $subject, $body, $headers)) {
        wp_send_json_success(['message' => 'Ačiū! Jūsų žinutė išsiųsta. Susisieksime kuo greičiau.']);
    } else {
        wp_send_json_error(['message' => 'Klaida siunčiant žinutę. Susisiekite tiesiogiai telefonu arba el. paštu.']);
    }
}

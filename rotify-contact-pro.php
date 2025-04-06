<?php
/*
Plugin Name: Rotify Contact Pro
Description: A professional plugin to add WhatsApp and Telegram order buttons with customizable shortcodes.
Version: 1.1
Author: hosein rotivand
License: GPL-2.0+
*/

// جلوگیری از دسترسی مستقیم
defined('ABSPATH') or die('No direct access allowed!');

// اضافه کردن اسکریپت آپلودر
add_action('admin_enqueue_scripts', 'rotify_contact_pro_enqueue_scripts');
function rotify_contact_pro_enqueue_scripts($hook) {
    if ($hook !== 'toplevel_page_rotify-contact-pro') return;
    wp_enqueue_media();
    wp_enqueue_script('rotify-upload-script', plugin_dir_url(__FILE__) . 'upload.js', ['jquery'], '1.1', true);
}

// اضافه کردن منوی تنظیمات
add_action('admin_menu', 'rotify_contact_pro_menu');
function rotify_contact_pro_menu() {
    add_menu_page(
        'Rotify Contact Pro',
        'Rotify Contact Pro',
        'manage_options',
        'rotify-contact-pro',
        'rotify_contact_pro_settings_page',
        'dashicons-admin-generic'
    );
}

// صفحه تنظیمات
function rotify_contact_pro_settings_page() {
    ?>
    <div class="wrap">
        <h1>Rotify Contact Pro</h1>
        <p>برای آموزش استفاده از افزونه، <a href="https://yourwebsite.com/rotify-contact-pro-guide" target="_blank">اینجا کلیک کنید</a>.</p>
        <form method="post" action="options.php">
            <?php
            settings_fields('rotify_contact_pro_group');
            do_settings_sections('rotify-contact-pro');
            submit_button();
            ?>
        </form>
    </div>
    <?php
}

// ثبت تنظیمات
add_action('admin_init', 'rotify_contact_pro_register_settings');
function rotify_contact_pro_register_settings() {
    register_setting('rotify_contact_pro_group', 'rotify_whatsapp_enabled', ['sanitize_callback' => 'sanitize_text_field']);
    register_setting('rotify_contact_pro_group', 'rotify_whatsapp_number', ['sanitize_callback' => 'sanitize_text_field']);
    register_setting('rotify_contact_pro_group', 'rotify_whatsapp_text', ['sanitize_callback' => 'sanitize_text_field']);
    register_setting('rotify_contact_pro_group', 'rotify_whatsapp_button_color', ['sanitize_callback' => 'sanitize_hex_color']);
    register_setting('rotify_contact_pro_group', 'rotify_whatsapp_text_color', ['sanitize_callback' => 'sanitize_hex_color']);
    register_setting('rotify_contact_pro_group', 'rotify_whatsapp_border', ['sanitize_callback' => 'sanitize_text_field']);
    register_setting('rotify_contact_pro_group', 'rotify_whatsapp_padding', ['sanitize_callback' => 'sanitize_text_field']);
    register_setting('rotify_contact_pro_group', 'rotify_whatsapp_icon', ['sanitize_callback' => 'esc_url_raw']);
    register_setting('rotify_contact_pro_group', 'rotify_whatsapp_icon_position', ['sanitize_callback' => 'sanitize_text_field']);
    register_setting('rotify_contact_pro_group', 'rotify_whatsapp_button_text', ['sanitize_callback' => 'sanitize_text_field']);

    register_setting('rotify_contact_pro_group', 'rotify_telegram_enabled', ['sanitize_callback' => 'sanitize_text_field']);
    register_setting('rotify_contact_pro_group', 'rotify_telegram_id', ['sanitize_callback' => 'sanitize_text_field']);
    register_setting('rotify_contact_pro_group', 'rotify_telegram_text', ['sanitize_callback' => 'sanitize_text_field']);
    register_setting('rotify_contact_pro_group', 'rotify_telegram_button_color', ['sanitize_callback' => 'sanitize_hex_color']);
    register_setting('rotify_contact_pro_group', 'rotify_telegram_text_color', ['sanitize_callback' => 'sanitize_hex_color']);
    register_setting('rotify_contact_pro_group', 'rotify_telegram_border', ['sanitize_callback' => 'sanitize_text_field']);
    register_setting('rotify_contact_pro_group', 'rotify_telegram_padding', ['sanitize_callback' => 'sanitize_text_field']);
    register_setting('rotify_contact_pro_group', 'rotify_telegram_icon', ['sanitize_callback' => 'esc_url_raw']);
    register_setting('rotify_contact_pro_group', 'rotify_telegram_icon_position', ['sanitize_callback' => 'sanitize_text_field']);
    register_setting('rotify_contact_pro_group', 'rotify_telegram_button_text', ['sanitize_callback' => 'sanitize_text_field']);

    // بخش واتساپ
    add_settings_section('rotify_whatsapp_section', 'تنظیمات واتساپ', null, 'rotify-contact-pro');
    add_settings_field('whatsapp_enabled', 'فعال کردن واتساپ', 'rotify_whatsapp_enabled_callback', 'rotify-contact-pro', 'rotify_whatsapp_section');
    add_settings_field('whatsapp_number', 'شماره واتساپ (با کد کشور)', 'rotify_whatsapp_number_callback', 'rotify-contact-pro', 'rotify_whatsapp_section');
    add_settings_field('whatsapp_text', 'متن پیش‌فرض پیام', 'rotify_whatsapp_text_callback', 'rotify-contact-pro', 'rotify_whatsapp_section');
    add_settings_field('whatsapp_button_color', 'رنگ پس‌زمینه دکمه', 'rotify_whatsapp_button_color_callback', 'rotify-contact-pro', 'rotify_whatsapp_section');
    add_settings_field('whatsapp_text_color', 'رنگ متن دکمه', 'rotify_whatsapp_text_color_callback', 'rotify-contact-pro', 'rotify_whatsapp_section');
    add_settings_field('whatsapp_border', 'اندازه بوردر دکمه (px)', 'rotify_whatsapp_border_callback', 'rotify-contact-pro', 'rotify_whatsapp_section');
    add_settings_field('whatsapp_padding', 'فضای داخلی دکمه (px)', 'rotify_whatsapp_padding_callback', 'rotify-contact-pro', 'rotify_whatsapp_section');
    add_settings_field('whatsapp_icon', 'آیکون دکمه', 'rotify_whatsapp_icon_callback', 'rotify-contact-pro', 'rotify_whatsapp_section');
    add_settings_field('whatsapp_icon_position', 'جایگاه آیکون', 'rotify_whatsapp_icon_position_callback', 'rotify-contact-pro', 'rotify_whatsapp_section');
    add_settings_field('whatsapp_button_text', 'متن دکمه', 'rotify_whatsapp_button_text_callback', 'rotify-contact-pro', 'rotify_whatsapp_section');

    // بخش تلگرام
    add_settings_section('rotify_telegram_section', 'تنظیمات تلگرام', null, 'rotify-contact-pro');
    add_settings_field('telegram_enabled', 'فعال کردن تلگرام', 'rotify_telegram_enabled_callback', 'rotify-contact-pro', 'rotify_telegram_section');
    add_settings_field('telegram_id', 'آیدی تلگرام یا شماره (با کد کشور)', 'rotify_telegram_id_callback', 'rotify-contact-pro', 'rotify_telegram_section');
    add_settings_field('telegram_text', 'متن پیش‌فرض پیام', 'rotify_telegram_text_callback', 'rotify-contact-pro', 'rotify_telegram_section');
    add_settings_field('telegram_button_color', 'رنگ پس‌زمینه دکمه', 'rotify_telegram_button_color_callback', 'rotify-contact-pro', 'rotify_telegram_section');
    add_settings_field('telegram_text_color', 'رنگ متن دکمه', 'rotify_telegram_text_color_callback', 'rotify-contact-pro', 'rotify_telegram_section');
    add_settings_field('telegram_border', 'اندازه بوردر دکمه (px)', 'rotify_telegram_border_callback', 'rotify-contact-pro', 'rotify_telegram_section');
    add_settings_field('telegram_padding', 'فضای داخلی دکمه (px)', 'rotify_telegram_padding_callback', 'rotify-contact-pro', 'rotify_telegram_section');
    add_settings_field('telegram_icon', 'آیکون دکمه', 'rotify_telegram_icon_callback', 'rotify-contact-pro', 'rotify_telegram_section');
    add_settings_field('telegram_icon_position', 'جایگاه آیکون', 'rotify_telegram_icon_position_callback', 'rotify-contact-pro', 'rotify_telegram_section');
    add_settings_field('telegram_button_text', 'متن دکمه', 'rotify_telegram_button_text_callback', 'rotify-contact-pro', 'rotify_telegram_section');
}

// توابع Callback برای تنظیمات
function rotify_whatsapp_enabled_callback() { echo '<input type="checkbox" name="rotify_whatsapp_enabled" value="1" ' . checked(1, get_option('rotify_whatsapp_enabled'), false) . ' />'; }
function rotify_whatsapp_number_callback() { echo '<input type="text" name="rotify_whatsapp_number" value="' . esc_attr(get_option('rotify_whatsapp_number', '')) . '" />'; }
function rotify_whatsapp_text_callback() { echo '<input type="text" name="rotify_whatsapp_text" value="' . esc_attr(get_option('rotify_whatsapp_text', 'سلام، من این محصول رو می‌خوام')) . '" style="width:300px;" />'; }
function rotify_whatsapp_button_color_callback() { echo '<input type="color" name="rotify_whatsapp_button_color" value="' . esc_attr(get_option('rotify_whatsapp_button_color', '#25D366')) . '" />'; }
function rotify_whatsapp_text_color_callback() { echo '<input type="color" name="rotify_whatsapp_text_color" value="' . esc_attr(get_option('rotify_whatsapp_text_color', '#ffffff')) . '" />'; }
function rotify_whatsapp_border_callback() { echo '<input type="number" name="rotify_whatsapp_border" value="' . esc_attr(get_option('rotify_whatsapp_border', '10')) . '" min="0" />'; }
function rotify_whatsapp_padding_callback() { echo '<input type="number" name="rotify_whatsapp_padding" value="' . esc_attr(get_option('rotify_whatsapp_padding', '10')) . '" min="0" />'; }
function rotify_whatsapp_icon_callback() { 
    $icon = esc_attr(get_option('rotify_whatsapp_icon', '')); 
    echo '<input type="url" id="rotify_whatsapp_icon" name="rotify_whatsapp_icon" value="' . $icon . '" style="width:300px;" />';
    echo '<button type="button" class="button rotify-upload-button" data-input="rotify_whatsapp_icon">آپلود</button>';
    echo '<p>آدرس URL آیکون را وارد کنید یا از دکمه آپلود استفاده کنید.</p>';
}
function rotify_whatsapp_icon_position_callback() {
    $position = get_option('rotify_whatsapp_icon_position', 'after');
    echo '<select name="rotify_whatsapp_icon_position">';
    echo '<option value="before" ' . selected($position, 'before', false) . '>قبل از متن</option>';
    echo '<option value="after" ' . selected($position, 'after', false) . '>بعد از متن</option>';
    echo '</select>';
}
function rotify_whatsapp_button_text_callback() { 
    echo '<input type="text" name="rotify_whatsapp_button_text" value="' . esc_attr(get_option('rotify_whatsapp_button_text', 'ثبت سفارش')) . '" />'; 
    echo '<p>شورت‌کد: <code>[rotify]</code></p>'; 
}

function rotify_telegram_enabled_callback() { echo '<input type="checkbox" name="rotify_telegram_enabled" value="1" ' . checked(1, get_option('rotify_telegram_enabled'), false) . ' />'; }
function rotify_telegram_id_callback() { echo '<input type="text" name="rotify_telegram_id" value="' . esc_attr(get_option('rotify_telegram_id', '')) . '" />'; }
function rotify_telegram_text_callback() { echo '<input type="text" name="rotify_telegram_text" value="' . esc_attr(get_option('rotify_telegram_text', 'سلام، من این محصول رو می‌خوام')) . '" style="width:300px;" />'; }
function rotify_telegram_button_color_callback() { echo '<input type="color" name="rotify_telegram_button_color" value="' . esc_attr(get_option('rotify_telegram_button_color', '#0088cc')) . '" />'; }
function rotify_telegram_text_color_callback() { echo '<input type="color" name="rotify_telegram_text_color" value="' . esc_attr(get_option('rotify_telegram_text_color', '#ffffff')) . '" />'; }
function rotify_telegram_border_callback() { echo '<input type="number" name="rotify_telegram_border" value="' . esc_attr(get_option('rotify_telegram_border', '10')) . '" min="0" />'; }
function rotify_telegram_padding_callback() { echo '<input type="number" name="rotify_telegram_padding" value="' . esc_attr(get_option('rotify_telegram_padding', '10')) . '" min="0" />'; }
function rotify_telegram_icon_callback() { 
    $icon = esc_attr(get_option('rotify_telegram_icon', '')); 
    echo '<input type="url" id="rotify_telegram_icon" name="rotify_telegram_icon" value="' . $icon . '" style="width:300px;" />';
    echo '<button type="button" class="button rotify-upload-button" data-input="rotify_telegram_icon">آپلود</button>';
    echo '<p>آدرس URL آیکون را وارد کنید یا از دکمه آپلود استفاده کنید.</p>';
}
function rotify_telegram_icon_position_callback() {
    $position = get_option('rotify_telegram_icon_position', 'after');
    echo '<select name="rotify_telegram_icon_position">';
    echo '<option value="before" ' . selected($position, 'before', false) . '>قبل از متن</option>';
    echo '<option value="after" ' . selected($position, 'after', false) . '>بعد از متن</option>';
    echo '</select>';
}
function rotify_telegram_button_text_callback() { 
    echo '<input type="text" name="rotify_telegram_button_text" value="' . esc_attr(get_option('rotify_telegram_button_text', 'ثبت سفارش')) . '" />'; 
    echo '<p>شورت‌کد: <code>[rotify_telegram]</code></p>'; 
}

// شورت‌کد واتساپ
add_shortcode('rotify', 'rotify_whatsapp_shortcode');
function rotify_whatsapp_shortcode() {
    if (!get_option('rotify_whatsapp_enabled')) return '';

    $product_title = (function_exists('is_product') && is_product()) ? get_the_title() : '';
    $whatsapp_number = esc_attr(get_option('rotify_whatsapp_number', ''));
    $whatsapp_text = esc_attr(get_option('rotify_whatsapp_text', 'سلام، من این محصول رو می‌خوام'));
    $button_color = esc_attr(get_option('rotify_whatsapp_button_color', '#25D366'));
    $text_color = esc_attr(get_option('rotify_whatsapp_text_color', '#ffffff'));
    $border = esc_attr(get_option('rotify_whatsapp_border', '10'));
    $padding = esc_attr(get_option('rotify_whatsapp_padding', '10'));
    $icon_url = esc_url(get_option('rotify_whatsapp_icon', ''));
    $icon_position = esc_attr(get_option('rotify_whatsapp_icon_position', 'after'));
    $button_text = esc_attr(get_option('rotify_whatsapp_button_text', 'ثبت سفارش'));

    $message = rawurlencode($whatsapp_text . ' - ' . $product_title);
    $whatsapp_link = "https://wa.me/{$whatsapp_number}?text={$message}";

    $icon_html = $icon_url ? '<img src="' . $icon_url . '" style="width:20px; height:20px; vertical-align:middle; margin-' . ($icon_position === 'before' ? 'right' : 'left') . ':5px;" />' : '';
    $button_content = $icon_position === 'before' ? $icon_html . $button_text : $button_text . $icon_html;

    return '<a href="' . $whatsapp_link . '" target="_blank" class="rotify-button" style="background-color:' . $button_color . '; color:' . $text_color . '; border-radius:' . $border . 'px; padding:' . $padding . 'px 20px;">' . $button_content . '</a>';
}

// شورت‌کد تلگرام
add_shortcode('rotify_telegram', 'rotify_telegram_shortcode');
function rotify_telegram_shortcode() {
    if (!get_option('rotify_telegram_enabled')) return '';

    $product_title = (function_exists('is_product') && is_product()) ? get_the_title() : '';
    $telegram_id = esc_attr(get_option('rotify_telegram_id', ''));
    $telegram_text = esc_attr(get_option('rotify_telegram_text', 'سلام، من این محصول رو می‌خوام'));
    $button_color = esc_attr(get_option('rotify_telegram_button_color', '#0088cc'));
    $text_color = esc_attr(get_option('rotify_telegram_text_color', '#ffffff'));
    $border = esc_attr(get_option('rotify_telegram_border', '10'));
    $padding = esc_attr(get_option('rotify_telegram_padding', '10'));
    $icon_url = esc_url(get_option('rotify_telegram_icon', ''));
    $icon_position = esc_attr(get_option('rotify_telegram_icon_position', 'after'));
    $button_text = esc_attr(get_option('rotify_telegram_button_text', 'ثبت سفارش'));

    $message = rawurlencode($telegram_text . ' - ' . $product_title);
    $telegram_link = strpos($telegram_id, '@') === 0 ? "https://t.me/{$telegram_id}?text={$message}" : "https://t.me/+{$telegram_id}?text={$message}";

    $icon_html = $icon_url ? '<img src="' . $icon_url . '" style="width:20px; height:20px; vertical-align:middle; margin-' . ($icon_position === 'before' ? 'right' : 'left') . ':5px;" />' : '';
    $button_content = $icon_position === 'before' ? $icon_html . $button_text : $button_text . $icon_html;

    return '<a href="' . $telegram_link . '" target="_blank" class="rotify-button" style="background-color:' . $button_color . '; color:' . $text_color . '; border-radius:' . $border . 'px; padding:' . $padding . 'px 20px;">' . $button_content . '</a>';
}

// استایل دکمه‌ها
add_action('wp_enqueue_scripts', 'rotify_contact_pro_styles');
function rotify_contact_pro_styles() {
    wp_add_inline_style('style', '
        .rotify-button {
            text-decoration: none;
            display: inline-block;
            transition: background-color 0.3s;
        }
        .rotify-button:hover {
            filter: brightness(90%);
        }
    ');
}

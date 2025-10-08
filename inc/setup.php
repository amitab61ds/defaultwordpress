<?php
function mobi_theme_setup(): void {
    load_theme_textdomain('mobi', get_template_directory() . '/languages');

    add_theme_support('automatic-feed-links');
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('html5', [
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
        'style',
        'script',
    ]);
    add_theme_support('custom-logo', [
        'height'      => 120,
        'width'       => 120,
        'flex-height' => true,
        'flex-width'  => true,
    ]);
    add_theme_support('customize-selective-refresh-widgets');
    add_theme_support('responsive-embeds');
    add_theme_support('align-wide');
    add_theme_support('editor-styles');
    add_editor_style('assets/css/editor.css');

    remove_theme_support('core-block-patterns');

    register_nav_menus([
        'primary' => __('Primary Menu', 'mobi'),
        'footer'  => __('Footer Menu', 'mobi'),
        'utility' => __('Utility Menu', 'mobi'),
    ]);
}
add_action('after_setup_theme', 'mobi_theme_setup');

function mobi_set_content_width(): void {
    $GLOBALS['content_width'] = apply_filters('mobi_content_width', 1200);
}
add_action('after_setup_theme', 'mobi_set_content_width', 0);

function mobi_register_acf_options(): void {
    if (!function_exists('acf_add_options_page')) {
        return;
    }

    $locales = mobi_detect_locales();
    $single  = count($locales) <= 1;

    foreach ($locales as $locale) {
        $suffix = $single ? '' : '-' . sanitize_title($locale);
        $label  = $single
            ? __('Global Settings', 'mobi')
            : sprintf(
                /* translators: %s: locale name */
                __('Global Settings — %s', 'mobi'),
                mobi_format_locale($locale)
            );

        $args = [
            'page_title' => $label,
            'menu_title' => $label,
            'menu_slug'  => 'mobi-global-settings' . $suffix,
            'post_id'    => $single ? 'options' : 'mobi_global_settings_' . sanitize_key($locale),
            'capability' => 'edit_posts',
            'redirect'   => false,
        ];

        $args = apply_filters('mobi_acf_options_page_args', $args, $locale, $single);

        acf_add_options_page($args);
    }
}
add_action('acf/init', 'mobi_register_acf_options');

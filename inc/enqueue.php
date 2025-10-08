<?php
function mobi_enqueue_scripts(): void {
    $theme_version = MOBI_THEME_VERSION;

    wp_enqueue_style(
        'mobi-style',
        get_stylesheet_uri(),
        [],
        $theme_version
    );

    $main_stylesheet      = 'assets/css/main.css';
    $main_stylesheet_path = get_template_directory() . '/' . $main_stylesheet;

    if (file_exists($main_stylesheet_path)) {
        wp_enqueue_style(
            'mobi-main',
            get_template_directory_uri() . '/' . $main_stylesheet,
            [],
            mobi_asset_version($main_stylesheet)
        );
    }

    if (!is_admin() && !is_user_logged_in()) {
        wp_deregister_style('dashicons');
    }

    $script_path = 'assets/js/main.js';
    $script_uri  = get_template_directory_uri() . '/' . $script_path;

    if (file_exists(get_template_directory() . '/' . $script_path)) {
        wp_enqueue_script(
            'mobi-main',
            $script_uri,
            [],
            mobi_asset_version($script_path),
            true
        );
        wp_script_add_data('mobi-main', 'defer', true);
    }

    if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }
}
add_action('wp_enqueue_scripts', 'mobi_enqueue_scripts');

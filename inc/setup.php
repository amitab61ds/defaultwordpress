<?php
function mobi_theme_setup() {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('html5', ['search-form', 'gallery', 'caption']);
    add_theme_support('custom-logo');
    register_nav_menus([
        'primary' => __('Primary Menu', 'mobi')
    ]);
}
add_action('after_setup_theme', 'mobi_theme_setup');

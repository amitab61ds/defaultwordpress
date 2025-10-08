<?php
function mobi_enqueue_scripts() {
    // CSS
    wp_enqueue_style('mobi-style', get_stylesheet_uri(), [], '1.0', 'all');
    wp_enqueue_style('mobi-main', get_template_directory_uri() . '/assets/css/main.css', [], '1.0', 'all');

    // JS
    wp_enqueue_script('mobi-main', get_template_directory_uri() . '/assets/js/main.js', [], '1.0', true);
}
add_action('wp_enqueue_scripts', 'mobi_enqueue_scripts');

<?php
function mobi_cleanup_head(): void {
    remove_action('wp_head', 'wp_generator');
    remove_action('wp_head', 'wlwmanifest_link');
    remove_action('wp_head', 'rsd_link');
    remove_action('wp_head', 'rest_output_link_wp_head');
    remove_action('wp_head', 'wp_shortlink_wp_head');
    remove_action('wp_head', 'print_emoji_detection_script', 7);
    remove_action('wp_print_styles', 'print_emoji_styles');
    remove_action('wp_head', 'wp_oembed_add_discovery_links');
}
add_action('init', 'mobi_cleanup_head');

function mobi_disable_emojis(): void {
    remove_action('admin_print_scripts', 'print_emoji_detection_script');
    remove_action('admin_print_styles', 'print_emoji_styles');
    remove_filter('the_content_feed', 'wp_staticize_emoji');
    remove_filter('comment_text_rss', 'wp_staticize_emoji');
    remove_filter('wp_mail', 'wp_staticize_emoji_for_email');

    add_filter('emoji_svg_url', '__return_false');
    add_filter('tiny_mce_plugins', 'mobi_disable_emojis_tinymce');
}
add_action('init', 'mobi_disable_emojis');

function mobi_disable_emojis_tinymce($plugins) {
    if (is_array($plugins)) {
        return array_diff($plugins, ['wpemoji']);
    }

    return [];
}

function mobi_remove_dns_prefetch(array $urls, string $relation_type): array {
    if ('dns-prefetch' === $relation_type) {
        $emoji_cdn = apply_filters('emoji_svg_url', false);

        if ($emoji_cdn) {
            $urls = array_filter($urls, static function ($url) use ($emoji_cdn) {
                return $url !== $emoji_cdn;
            });
        }
    }

    return $urls;
}
add_filter('wp_resource_hints', 'mobi_remove_dns_prefetch', 10, 2);

function mobi_optimize_scripts(): void {
    if (!is_admin()) {
        wp_deregister_script('wp-embed');
    }
}
add_action('wp_footer', 'mobi_optimize_scripts', 1);

function mobi_remove_jquery_migrate($scripts): void {
    if (!is_admin() && isset($scripts->registered['jquery'])) {
        $jquery = $scripts->registered['jquery'];

        if ($jquery->deps) {
            $jquery->deps = array_diff($jquery->deps, ['jquery-migrate']);
        }
    }
}
add_action('wp_default_scripts', 'mobi_remove_jquery_migrate');

function mobi_dequeue_block_styles(): void {
    if (!is_admin() && apply_filters('mobi_disable_block_styles', true)) {
        wp_dequeue_style('global-styles');
        wp_dequeue_style('wp-block-library');
        wp_dequeue_style('wp-block-library-theme');
    }
}
add_action('wp_enqueue_scripts', 'mobi_dequeue_block_styles', 20);

add_filter('the_generator', '__return_empty_string');

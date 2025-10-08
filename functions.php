<?php
if (!defined('MOBI_THEME_VERSION')) {
    $theme = wp_get_theme(get_template());
    define('MOBI_THEME_VERSION', $theme->get('Version'));
}

require get_template_directory() . '/inc/i18n.php';
require get_template_directory() . '/inc/setup.php';
require get_template_directory() . '/inc/enqueue.php';
require get_template_directory() . '/inc/cleanup.php';

if (!function_exists('mobi_asset_version')) {
    /**
     * Provide a cache-busting version string for assets.
     */
    function mobi_asset_version(string $relative_path): string {
        $absolute_path = get_template_directory() . '/' . ltrim($relative_path, '/');

        if (file_exists($absolute_path)) {
            return (string) filemtime($absolute_path);
        }

        return MOBI_THEME_VERSION;
    }
}

<?php
/**
 * Internationalisation helpers.
 */

function mobi_detect_locales(): array {
    $locales = [];

    if (function_exists('pll_languages_list')) {
        $locales = pll_languages_list([
            'hide_empty' => false,
            'fields'     => 'locale',
        ]);
    }

    if (!$locales) {
        $wpml_languages = apply_filters('wpml_active_languages', null, ['skip_missing' => 0]);

        if ($wpml_languages === null) {
            $wpml_languages = apply_filters('wpml_active_languages', null, 'skip_missing=0');
        }

        if (is_array($wpml_languages)) {
            foreach ($wpml_languages as $language) {
                if (!empty($language['default_locale'])) {
                    $locales[] = $language['default_locale'];
                    continue;
                }

                if (!empty($language['language_code'])) {
                    $locales[] = $language['language_code'];
                }
            }
        }
    }

    if (!$locales) {
        $site_locale = get_locale();

        if ($site_locale) {
            $locales[] = $site_locale;
        }
    }

    $locales = apply_filters('mobi_available_locales', $locales);

    $locales = array_filter(array_map('sanitize_text_field', $locales));

    return array_values(array_unique($locales));
}

function mobi_format_locale(string $locale): string {
    $normalized = str_replace(['_', '.'], ['-', ''], $locale);

    if (function_exists('locale_get_display_name')) {
        $display = locale_get_display_name($locale, $locale);

        if (is_string($display) && $display !== '') {
            return $display;
        }
    }

    return strtoupper($normalized);
}

add_filter('acf/settings/l10n', '__return_true');
add_filter('acf/settings/l10n_textdomain', static function () {
    return 'mobi';
});

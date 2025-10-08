<?php
/**
 * Default template for rendering content.
 */

get_header();

if (have_posts()) {
    do_action('mobi_before_loop');

    while (have_posts()) {
        the_post();

        do_action('mobi_before_entry', get_post_type());

        the_title();
        the_content();

        wp_link_pages([
            'before' => '',
            'after'  => '',
        ]);

        do_action('mobi_after_entry', get_post_type());
    }

    do_action('mobi_after_loop');
} else {
    /**
     * Allow projects to provide custom empty-state behaviour.
     */
    if (has_action('mobi_no_results')) {
        do_action('mobi_no_results');
    } else {
        echo esc_html__('No content available yet.', 'mobi');
    }
}

get_footer();

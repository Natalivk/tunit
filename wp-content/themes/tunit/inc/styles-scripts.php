<?php
/* Enqueue Scripts */

add_action('wp_enqueue_scripts', 'enqueue_static_content');
function enqueue_static_content()
{
    global $custom_blocks;

    $styles = array(
        'main',
    );
    foreach ($styles as $style) {
        wp_enqueue_style(
            $style,
            TEMPLATE_DIRECTORY_URI . '/assets/css/' . $style . '.css',
            array(),
            APP_VERSION,
            'all'
        );
    }
    if ($custom_blocks) {
        foreach ($custom_blocks as $path => $label) {
            $name = substr($path, 4);
            $file_css = get_theme_file_path("/assets/css/{$name}.css");
            if (file_exists($file_css) && has_block($path)) {
                wp_enqueue_style(
                    $name,
                    TEMPLATE_DIRECTORY_URI . '/assets/css/' . $name . '.css',
                    array(),
                    APP_VERSION,
                    'all'
                );

                if ($name === 'block-flexible-content') {
                    wp_enqueue_style(
                        'flexible',
                        TEMPLATE_DIRECTORY_URI . '/assets/css/single.css',
                        array(),
                        APP_VERSION,
                        'all');
                }
            }
        }
    }
    if (is_single()) {
        wp_enqueue_style(
            'single',
            TEMPLATE_DIRECTORY_URI . '/assets/css/single.css',
            array(),
            APP_VERSION,
            'all'
        );
    }




    $scripts = array(
        'general',
    );

    foreach ($scripts as $script) {
        wp_enqueue_script(
            $script,
            TEMPLATE_DIRECTORY_URI . '/assets/js/dist/' . $script . '.js',
            array(),
            APP_VERSION,
            true
        );
    }
    if ($custom_blocks) {
        foreach ($custom_blocks as $path => $label) {
            $name = substr($path, 4);
            $file_js = get_theme_file_path("/assets/js/dist/{$name}.js");

            if (file_exists($file_js) && has_block($path)) {
                // Enqueue the script
                wp_enqueue_script(
                    $name,
                    get_template_directory_uri() . '/assets/js/dist/' . $name . '.js',
                    array(),
                    APP_VERSION,
                    true
                );

                // Localize the script to pass ajaxurl
                wp_localize_script($name, 'movies_ajax', [
                    'ajaxurl' => admin_url('admin-ajax.php'),
                ]);
            }
        }
    }

    $hpscripts = array();

    if (is_front_page()) {
        foreach ($hpscripts as $script) {
            wp_enqueue_script(
                $script,
                TEMPLATE_DIRECTORY_URI . '/assets/js/dist/' . $script . '.js',
                array(),
                APP_VERSION,
                true
            );
        }
    }
}

/**
 * Disable the emoji's
 */
function disable_emojis()
{
    remove_action('wp_head', 'print_emoji_detection_script', 7);
    remove_action('admin_print_scripts', 'print_emoji_detection_script');
    remove_action('wp_print_styles', 'print_emoji_styles');
    remove_action('admin_print_styles', 'print_emoji_styles');
    remove_filter('the_content_feed', 'wp_staticize_emoji');
    remove_filter('comment_text_rss', 'wp_staticize_emoji');
    remove_filter('wp_mail', 'wp_staticize_emoji_for_email');

    // Remove from TinyMCE
    add_filter('tiny_mce_plugins', 'disable_emojis_tinymce');
}

add_action('init', 'disable_emojis');

/**
 * Disable Phone country
 */
remove_action('wp_enqueue_scripts', 'nb_cpf_embedCssJs');

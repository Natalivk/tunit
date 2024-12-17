<?php

global $custom_blocks;
$custom_blocks = [
    'acf/banner-hero' => 'Banner: Hero',
    'acf/block-movies' => 'Block: Movies',
];


// sort acf blocks
ksort($custom_blocks);

add_filter('allowed_block_types', 'tunit_allowed_block_types', 10, 2);
function tunit_allowed_block_types($allowed_blocks)
{
    global $custom_blocks;
    return array_keys($custom_blocks);
}

add_action('acf/init', 'tunit_acf_init');
function tunit_acf_init()
{
    if (function_exists('acf_register_block')) {
        global $custom_blocks;
        foreach ($custom_blocks as $name => $label) {
            $name = substr($name, 4);
            acf_register_block(array(
                'name' => $name,
                'title' => $label,
                'render_callback' => 'tunit_acf_block_render',
            ));
        }
    }
}

function tunit_acf_block_render($block)
{
    global $get_started_number;
    $file = get_theme_file_path("/template-parts/{$block['name']}.php");
    if (file_exists($file)) {
        include($file);
    }
}
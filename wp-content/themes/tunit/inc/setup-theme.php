<?php
/* Setup Theme */
add_action('after_setup_theme', 'sandbox_theme_setup');
function sandbox_theme_setup(){
    load_theme_textdomain('sandbox');

    /* Image Sizes */
    add_image_size('640x570', 640, 570, true);
    add_image_size('1296x570', 1296, 570, true);
    add_image_size('1920x952', 1920, 952, true);

    /*
     * Enable support for Post Thumbnails on posts and pages.
     *
     * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
     */
    add_theme_support( 'post-thumbnails' );

    /* Navigation Menus */
    register_nav_menus([
        'header-nav'           => __('Header Navigation', 'design'),
    ]);
}

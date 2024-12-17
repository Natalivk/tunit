<?php
/**
 * Design Theme functions and definitions
 */

remove_action('wp_head', 'wp_generator');

define('TEMPLATE_DIRECTORY', get_template_directory());
define('TEMPLATE_DIRECTORY_URI', get_template_directory_uri());
define('STYLESHEET_URI', get_stylesheet_uri());
define('STYLESHEET_DIRECTORY', get_stylesheet_directory());
define('APP_VERSION', '1.7');

/* Autoload theme files */
$folders = array(
    'inc', 'custom-fields'
);
foreach ($folders as $folder) {
    $folder = get_template_directory() . DIRECTORY_SEPARATOR . $folder;
    if (is_dir($folder)) {
        foreach (scandir($folder) as $file) {
            if ($file == '.' || $file == '..') {
                continue;
            }
            $filepath = $folder . DIRECTORY_SEPARATOR . $file;
            $pathinfo = pathinfo($filepath);
            if (isset($pathinfo['extension']) && $pathinfo['extension'] == 'php') {
                include_once $filepath;
            }
        }
    }
}





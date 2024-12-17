<?php

add_filter( 'wp_nav_menu_objects', 'my_wp_nav_menu_objects', 10, 2 );

function my_wp_nav_menu_objects( $items ) {
    foreach ($items as &$item ) {
        $icon = get_field( 'icon', $item );
        $text = get_field( 'text', $item );
        if($icon && !$text) {
            $item->title = '<span class="header-icon"><img src="' . $icon['url'] . '" data-src="' . $icon['url'] . '" alt="menu-icon"></span>' . $item->title;
        }
        if($text && !$icon) {
            $item->title = $item->title .'<p>' . $text . '</p>';
        }
        if($icon && $text) {
            $item->title = '<span class="header-icon"><img src="' . $icon['url'] . '" data-src="' . $icon['url'] . '" alt="menu-icon"></span>' . $item->title .'<p>' . $text . '</p>';
        }
    }

    return $items;
}

add_filter('wp_nav_menu_items', 'my_wp_nav_menu_items', 10, 2);

function my_wp_nav_menu_items( $items, $args ) {
    $menu = wp_get_nav_menu_object($args->menu);

    if( $args->theme_location == 'product-nav' ) {

//        $article_object = get_field('article_object', $menu);
//        $article_html = get_template_part('/template-parts/helpers/cards/single-card', 'article-card', ['post' => $article_object]);
     //   $items =  $items . $article_html;
    }

    return $items;

}
function get_field_by_location($location, $field_name){
    $menu_name = wp_get_nav_menu_name($location);
    $menu_object = wp_get_nav_menu_object($menu_name);
    $post_res = get_field($field_name, $menu_object);

    return $post_res;
}
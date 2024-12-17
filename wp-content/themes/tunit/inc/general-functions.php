<?php
/* SVG Support */
add_filter('upload_mimes', 'cc_mime_types');
add_action('admin_head', 'fix_svg');
function cc_mime_types($mimes) {
    $mimes['svg'] = 'image/svg+xml';
    return $mimes;
}
function fix_svg() {
    echo "<style type=\"text/css\">
           .attachment-266x266, .thumbnail img {
                width: 100% !important;
                height: auto !important;
           }
        </style>";
}

/* General Functions */
function get_copyright_text() {
    return str_replace('{{year}}', date('Y'), get_field('copyright_text', 'options'));
}

/* General Options */
if (function_exists('acf_add_options_page')) {
    acf_add_options_page([
        'page_title' => 'General Settings',
        'menu_title' => 'General Settings',
        'menu_slug'  => 'general_settings',
        'capability' => 'manage_options',
        'redirect'   => true,
    ]);
}

/* Register Custom Query */
function get_query_param($param, $default = '') {
    return !empty($_GET[$param]) ? $_GET[$param] : $default;
}

/* Google Map */
function my_acf_init() {
    acf_update_setting('google_api_key', 'AIzaSyA_G3MwlAbA0ROQaVm3Rwf9PiH3CcYgm6E');
}
add_action('acf/init', 'my_acf_init');

/* Socials List */
function get_socials_list() {
    return [
        'twitter', 'youtube', 'instagram', 'linkedin', 'vimeo', 'facebook'
    ];
}

/* Generating sliced image URL */
function get_url_image_by_size($image_arr, $size = false){
    if (!$image_arr) return;
    if($size){
        if($image_arr['sizes'][$size]){
            return $image_arr['sizes'][$size];
        }else{
            return $image_arr['url'];
        }
    }else{
        return $image_arr['url'];
    }
}

/* Get Link Target */
function get_link_target($link){
    return $link['target'] ? $link['target'] : '_self';
}

/* Get ALT Image */

function get_alt_image($image, $ID){
    return $image['alt'] ? $image['alt'] : get_the_title($ID);
}

add_action('admin_init', function () {
    // Redirect any user trying to access comments page
    global $pagenow;

    if ($pagenow === 'edit-comments.php') {
        wp_safe_redirect(admin_url());
        exit;
    }

    // Remove comments metabox from dashboard
    remove_meta_box('dashboard_recent_comments', 'dashboard', 'normal');

    // Disable support for comments and trackbacks in post types
    foreach (get_post_types() as $post_type) {
        if (post_type_supports($post_type, 'comments')) {
            remove_post_type_support($post_type, 'comments');
            remove_post_type_support($post_type, 'trackbacks');
        }
    }
});

// Close comments on the front-end
add_filter('comments_open', '__return_false', 20, 2);
add_filter('pings_open', '__return_false', 20, 2);

// Hide existing comments
add_filter('comments_array', '__return_empty_array', 10, 2);

// Remove comments page in menu
add_action('admin_menu', function () {
    remove_menu_page('edit-comments.php');
});

// Remove comments links from admin bar
add_action('init', function () {
    if (is_admin_bar_showing()) {
        remove_action('admin_bar_menu', 'wp_admin_bar_comments_menu', 60);
    }
});

//Disable emojis in WordPress
add_action( 'init', 'smartwp_disable_emojis' );

function smartwp_disable_emojis() {
    remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
    remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
    remove_action( 'wp_print_styles', 'print_emoji_styles' );
    remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
    remove_action( 'admin_print_styles', 'print_emoji_styles' );
    remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
    remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
    add_filter( 'tiny_mce_plugins', 'disable_emojis_tinymce' );
}

function disable_emojis_tinymce( $plugins ) {
    if ( is_array( $plugins ) ) {
        return array_diff( $plugins, array( 'wpemoji' ) );
    } else {
        return array();
    }
}

function get_posts_filter(array $filter_taxonomies, ? bool $show_order = true): string {
    $filter_array = [];

    // get filter
    foreach ($filter_taxonomies as $taxonomy => $settings){

        $params = get_query_param($taxonomy);

        $params_array = !empty($params) ? explode(',', $params) : false;

        if($params_array){
            $filter_array[$taxonomy] = $params_array;
        }

    }
    $sort_orders = [
        'post_date:desc' => 'Date (Newest)',
        'post_date:asc' => 'Date (Oldest)',
        'title:asc' => 'Name (A-Z)',
        'title:desc' => 'Name (Z-A)',
    ];
    $sort_filter = get_query_param('sort') ? $sort_filter = get_query_param('sort') : 'post_date:desc';

    ob_start();
    ?>
    <nav class="filter js-filter">
        <form class="filter__inner js-filter-form">
            <div class="filter__items">
                <?php
                foreach ($filter_taxonomies as  $taxonomy => $settings):

                    if($settings['term'] == 'category'){
                        $filter_categories =  get_terms([
                            'taxonomy'  => $taxonomy,
                            'hide_empty' => true,
                        ]);
                    }else{
                        $filter_categories =  get_posts([
                            'post_type'      => $taxonomy,
                            'posts_per_page' => -1,
                            'post_status'    =>'publish',
                        ]);
                    }
                    if($filter_categories):
                        ?>
                        <div class="filter__item js-filter-item">
                            <p class="filter__item-title"><?php echo !empty($settings['name']) ? $settings['name'] : 'Type'; ?>:</p>
                            <div class="filter__item-inner">
                                <button class="filter__item-btn btn-clear" type="button">
                                    <span class="filter__item-btn-title js-filter-item-title"><?php echo __('All', 'kiw'); ?></span>
                                    <svg class="filter__item-btn-icon">
                                        <use xlink:href="#icon-plus"></use>
                                    </svg>
                                </button>
                                <ul class="filter__list">
                                    <?php
                                    $i = 0;
                                    foreach ($filter_categories as $key => $cat): ?>
                                        <?php if(!empty($settings['type'] === 'radio')) : ?>
                                            <?php
                                            // show all properties
                                            $value = $cat->slug ? $cat->slug : $cat->post_name;
                                            $name = $cat->name ? $cat->name : $cat->post_title;
                                            if($i === 0) : ?>
                                                <li class="filter__list-item">
                                                    <input
                                                        class="filter__list-item-input js-filter-input"
                                                        id="all-<?php echo !empty($settings['name']) ? wordwrap(strtolower($settings['name']), 1, '-', 0) : 'all-type'; ?>"
                                                        type="radio"
                                                        value="all"
                                                        name="<?php echo $filter_categories[$key]->taxonomy; ?>"
                                                        <?php
                                                        if(!isset($filter_array[$settings['type']])){
                                                            echo 'checked';
                                                        }
                                                        ?>
                                                    >
                                                    <label class="filter__list-item-label js-filter-label" for="all-<?php echo !empty($settings['name']) ? wordwrap(strtolower($settings['name']), 1, '-', 0) : 'all-type'; ?>"><?php echo __('All', 'kiw'); ?></label>
                                                </li>
                                            <?php endif; ?>
                                            <li class="filter__list-item">
                                                <input
                                                    class="filter__list-item-input js-filter-input"
                                                    id="input-<?php echo $value; ?>"
                                                    type="radio"
                                                    value="<?php echo $value; ?>"
                                                    name="<?php echo $filter_categories[$key]->taxonomy; ?>"
                                                    <?php
                                                    if(isset($filter_array[$taxonomy]) && in_array($value, $filter_array[$taxonomy])){
                                                        echo 'checked';
                                                    }
                                                    ?>
                                                >
                                                <label class="filter__list-item-label js-filter-label" for="input-<?php echo $value; ?>"><?php echo $name; ?></label>
                                            </li>
                                        <?php else : ?>
                                            <li class="filter__list-item">
                                                <input
                                                    class="filter__list-item-input js-filter-input"
                                                    id="input-<?php echo $value; ?>"
                                                    type="checkbox"
                                                    value="input-<?php echo $value; ?>"
                                                    name="<?php echo $taxonomy; ?>"
                                                    <?php
                                                    if(isset($filter_array[$taxonomy]) && in_array($value, $filter_array[$taxonomy])){
                                                        echo 'checked';
                                                    }
                                                    ?>
                                                >
                                                <label class="filter__list-item-label js-filter-label" for="input-<?php echo $value; ?>"><?php echo $name; ?></label>
                                            </li>
                                        <?php endif; ?>
                                        <?php
                                        $i++;
                                    endforeach; ?>
                                </ul>
                            </div>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>

                <?php if($show_order):
                    $order = get_query_param('order') ?? false;
                    ?>
                    <div class="filter__item">
                        <p class="filter__item-title"><?php echo __('Sort by:', 'kiw'); ?></p>
                        <div class="filter__item-inner js-sort">
                            <?php foreach($sort_orders as $value => $label) : ?>
                                <?php if($sort_filter == $value):?>
                                    <button class="filter__item-btn btn-clear" type="button">
                                        <span class="filter__item-btn-title js-active-sort"><?php echo $label;?></span>
                                        <svg class="filter__item-btn-icon">
                                            <use xlink:href="#icon-plus"></use>
                                        </svg>
                                    </button>
                                <?php endif; ?>
                            <?php endforeach; ?>
                            <ul class="filter__list js-sort-drop-down">
                                <?php foreach($sort_orders as $value => $label) : ?>
                                    <li class="filter__list-item js-drop-down-item">
                                        <input class="filter__list-item-input js-filter-input js-filter-form-input-sort" id="sort-<?= $value; ?>" type="radio" name="sort" value="<?php echo $value; ?>" <?php if($sort_filter == $value):?>checked="checked"<?php endif; ?>>
                                        <label class="filter__list-item-label js-drop-down-label" for="sort-<?= $value; ?>"><?php echo $label;?></label>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
            <div class="filter__search">
                <div class="filter__search-inner">
                    <label class="filter__search-label hidden" for="filter_search_input"><?php echo __('Search form', 'kiw'); ?></label>
                    <input class="filter__search-input js-filter-input"
                           id="filter_search_input"
                           type="search"
                           value="<?php echo isset($_GET['s-list']) ? sanitize_text_field($_GET['s-list']) : ''; ?>"
                           placeholder="Search..."
                           name="s-list"
                           autocomplete="off"
                    >
                </div>
                <button class="filter__search-btn btn-clear" type="submit" aria-label="<?php echo __('Submit search form', 'kiw'); ?>">
                    <svg class="filter__search-btn-icon">
                        <use xlink:href="#icon-search"></use>
                    </svg>
                </button>
            </div>
        </form>
    </nav>
    <?php
    return ob_get_clean();
}

add_filter( 'pll_custom_flag', 'pll_custom_flag', 10, 2 );
function pll_custom_flag( $flag, $code ) {

    $flag['url']    = "http://1xbet-latam.partners/wp-content/polylang/{$code}.png";
    $flag['width']  = 20;
    $flag['height'] = 20;
    return $flag;
}
/* Debugger */
function dd($e){
    echo '<pre>';
    echo var_dump($e);
    echo '</pre>';
    die();
}
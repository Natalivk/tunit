<?php
//Hide Post Editor
function wph_hide_editor()
{
    remove_post_type_support('post', 'editor');
}

add_action('admin_init', 'wph_hide_editor');

add_action( 'init', 'new_default_post_type', 1 );
function new_default_post_type() {

    register_post_type( 'post', array(
        'labels' => array(
            'name_admin_bar' => 'Articles',
            'singular_name'  => 'Article',
            'menu_name'      => 'Articles',
        ),
        'description'       => 'Article Items',
        'public'            => true,
        'menu_position'     => 3,
        'supports'          => array('title', 'custom-fields'),
        'has_archive'       => false,
        'show_in_admin_bar' => true,
        'show_in_nav_menus' => true,
        // 'taxonomies'        => array(),
        'rewrite'           => array('slug' => 'article'),
    ) );
}

add_action( 'admin_menu', 'remove_default_post_type' );

function remove_default_post_type() {
    remove_menu_page( 'edit.php' );
}

function get_post_items($type, $quantity, $exclude_id = false, $category = false){
    $args = [
        'post_type'      => $type,
        'posts_per_page' => $quantity,
        'post_status'    =>'publish',
        'orderby'        => 'date',
        'order'          => 'DESC'
    ];

    if($exclude_id){
        $args['exclude'] = $exclude_id;
    }

    if($category){
        $args['tax_query'] = [
            [
                'taxonomy' => $category->taxonomy,
                'field'    => 'term_id',
                'terms'    => $category->term_id,
            ]
        ];
    }

    return get_posts($args);
}

function get_query_post_items($type, $s = false, $quantity = false, $exclude = false){

    $args = [
        'post_type'      => $type,
        'tax_query'      => ['relation' => 'AND'],
    ];

    if ($quantity){
        $args['posts_per_page'] = $quantity;
    }

    if($s){
        $args['s'] = $s;
    }

    $args['paged'] = get_query_var('paged') ? get_query_var('paged') : 1;

    if($exclude){
        $args['post__not_in'] = [$exclude->ID];
    }

    $query = new WP_Query($args);

    if(get_query_param('s-list')){
        // when searching the list, search only by the current blog ID
        $query->set('searchblogs', get_current_blog_id());

        // relevanssi search
        relevanssi_do_query($query);
    }

    return $query;
}

// load_more_search action
add_action('wp_ajax_load_more_search', 'load_more_search');
add_action('wp_ajax_nopriv_load_more_search', 'load_more_search');
function load_more_search(){
    $post_type = $_POST['postType'];
    $s = $_POST['s'];

    $query = get_query_post_items($post_type, $s, -1);

    ob_start();
    if($query->have_posts()){
        $search_page = get_field('search_page', 'option');
        while($query->have_posts()){
            $query->the_post(); ?>

            <?php if ($post_type == 'guidelines'): ?>
                <div class="post-item">
                    <div class="post-item__nav-item-inner">
                        <div class="post-item__nav-item-img-wrap col-center">
                            <?php if ($icon = get_field('icon')): ?>
                                <?php echo get_render_image($icon, 'full'); ?>
                            <?php endif; ?>
                        </div>
                        <a href="<?php the_permalink(); ?>" class="post-item__accordion-link">  <?php the_title(); ?></a>
                    </div>
                </div>
            <?php elseif ($post_type == 'faqs'): ?>
                <div class="post-item">
                    <a class="post-item__title-link" target="_blank" href="<?php echo $search_page; ?>?faq=<?php echo get_the_ID(); ?>">
                        <?php the_title(); ?>
                    </a>
                </div>
            <?php endif; ?>

        <?php }
    }
    wp_reset_postdata();
    $content = ob_get_clean();

    wp_send_json_success($content);
}


function get_sort_orders(){
    $args = [
        'post_date:desc' => 'date (Newest)',
        'post_date:asc' => 'date (Oldest)',
        'title:asc' => 'A - Z',
        'title:desc' => 'Z - A',
    ];
    return $args;
}
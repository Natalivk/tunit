<?php


function register_movies_post_type()
{
    register_post_type('movies', array(
        'labels' => array(
            'name' => __('Movies'),
            'singular_name' => __('Movie'),
        ),
        'public' => true,
        'supports' => array('title', 'custom-fields'),
        'menu_icon' => 'dashicons-video-alt2',
        'has_archive' => true,
    ));

    register_taxonomy('genre', 'movies', array(
        'labels' => array(
            'name' => __('Genres'),
            'singular_name' => __('Genre'),
        ),
        'public' => true,
        'hierarchical' => true,
    ));
}

add_action('init', 'register_movies_post_type');

function get_unique_years($order = 'ASC')
{
    global $wpdb;
    return $wpdb->get_col("
        SELECT DISTINCT meta_value 
        FROM {$wpdb->postmeta} 
        WHERE meta_key = 'year' 
        ORDER BY meta_value+0 $order
    ");
}

function fetch_movies_callback()
{
    $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
    $genre = isset($_POST['genre']) ? sanitize_text_field($_POST['genre']) : '';
    $year_from = isset($_POST['year_from']) ? intval($_POST['year_from']) : '';
    $year_to = isset($_POST['year_to']) ? intval($_POST['year_to']) : '';
    $sort_by = isset($_POST['sort_by']) ? sanitize_text_field($_POST['sort_by']) : 'rating_desc';
    $search = isset($_POST['search']) ? sanitize_text_field($_POST['search']) : '';

    $args = [
        'post_type' => 'movies',
        'posts_per_page' => 10,
        'paged' => $page,
        'meta_query' => ['relation' => 'AND'],
        'tax_query' => [],
        's' => $search, // Search by title
    ];

    // Genre Filter
    if (!empty($genre)) {
        $args['tax_query'][] = [
            'taxonomy' => 'genre',
            'field' => 'slug',
            'terms' => $genre,
        ];
    }

    // Year Range Filter
    if (!empty($year_from)) {
        $args['meta_query'][] = [
            'key' => 'year',
            'value' => $year_from,
            'compare' => '>=',
            'type' => 'NUMERIC',
        ];
    }
    if (!empty($year_to)) {
        $args['meta_query'][] = [
            'key' => 'year',
            'value' => $year_to,
            'compare' => '<=',
            'type' => 'NUMERIC',
        ];
    }

    // Sorting Logic
    switch ($sort_by) {
        case 'rating_desc':
            $args['meta_key'] = 'rating';
            $args['orderby'] = 'meta_value_num';
            $args['order'] = 'DESC';
            break;

        case 'rating_asc':
            $args['meta_key'] = 'rating';
            $args['orderby'] = 'meta_value_num';
            $args['order'] = 'ASC';
            break;

        case 'year_desc':
            $args['meta_key'] = 'year';
            $args['orderby'] = 'meta_value_num';
            $args['order'] = 'DESC';
            break;

        case 'year_asc':
            $args['meta_key'] = 'year';
            $args['orderby'] = 'meta_value_num';
            $args['order'] = 'ASC';
            break;

        default:
            $args['orderby'] = 'date';
            $args['order'] = 'DESC';
            break;
    }

    // Query Movies
    $query = new WP_Query($args);
    $has_more_posts = $query->max_num_pages > $page;

    ob_start();
    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            $poster = get_field('poster');
            $rating = get_field('rating');
            $year = get_field('year');
            ?>
            <div class="movie-item">
                <?php if ($poster): ?>
                    <div class="movie-item-image-container">
                        <div class="movie-item-rating">
                            <p><?php echo esc_html($rating); ?></p>
                            <svg width="15" height="14" viewBox="0 0 15 14" fill="none"
                                 xmlns="http://www.w3.org/2000/svg">
                                <path d="M7.36363 1.53594C7.55029 1.0436 8.25671 1.0436 8.44396 1.53594L9.65146 4.88077C9.69358 4.98973 9.76776 5.08335 9.8642 5.14928C9.96064 5.2152 10.0748 5.25033 10.1916 5.25002H13.159C13.7074 5.25002 13.9465 5.93252 13.5155 6.26677L11.4038 8.16669C11.3092 8.2394 11.2401 8.34021 11.2063 8.45465C11.1726 8.56909 11.176 8.69128 11.216 8.80369L11.9871 12.0721C12.175 12.5971 11.5671 13.048 11.1075 12.7249L8.23921 10.9049C8.14098 10.8358 8.02385 10.7988 7.90379 10.7988C7.78373 10.7988 7.6666 10.8358 7.56838 10.9049L4.70013 12.7249C4.24104 13.048 3.63263 12.5965 3.82046 12.0721L4.59163 8.80369C4.63163 8.69128 4.635 8.56909 4.60126 8.45465C4.56751 8.34021 4.49838 8.2394 4.40379 8.16669L2.29213 6.26677C1.86046 5.93252 2.10079 5.25002 2.64796 5.25002H5.61538C5.73221 5.25041 5.84641 5.21531 5.94287 5.14938C6.03932 5.08344 6.11349 4.98978 6.15554 4.88077L7.36304 1.53594H7.36363Z"
                                      fill="#FFD057" stroke="#FFD057" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>

                        </div>
                        <img src="<?php echo esc_url($poster['url']); ?>" alt="<?php echo esc_attr($poster['alt']); ?>">
                    </div>

                <?php endif; ?>
                <h3><?php the_title(); ?></h3>
                <div class="movie-item-btn">
                    <a class="btn-secondary" href="<?php the_permalink(); ?>"> Read more</a>

                </div>
                <!--                <p>Year: --><?php //echo esc_html($year); ?><!--</p>-->
            </div>
            <?php
        }
        wp_reset_postdata();
    } else {
        echo '<p class="no-movies-found">No movies found.</p>';
    }

    wp_send_json([
        'html' => ob_get_clean(),
        'has_more_posts' => $has_more_posts,
    ]);

    wp_die();
}

add_action('wp_ajax_fetch_movies', 'fetch_movies_callback');
add_action('wp_ajax_nopriv_fetch_movies', 'fetch_movies_callback');



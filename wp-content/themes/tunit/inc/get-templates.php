<?php
/**
 * Get image
 * @param array|int|null $attachment
 * @param string $size
 * @param string|null $img_title
 * @param string|null $class
 * @param bool $skipLazyLoad
 * @param array $attr
 * @return string
 */
function get_render_image(
    $attachment = null,
    string $size = 'thumbnail',
    string $img_title = null,
    string $class = null,
    bool $skipLazyLoad = false,
    array $attr = []
): string {

    // get id
    $attachment_id = is_array($attachment) ? $attachment['ID'] : $attachment;

    // return placeholder if attachment doesn't exist
    if (empty($attachment_id)) {
        $placeholder = get_field('placeholder', 'option');
        if($placeholder){
            $img = wp_get_attachment_image($placeholder['ID'], $size);
        } else {
            $img = 'No placeholder';
        }
    } else {
        $attachment_obj = get_post($attachment_id);

        // get title
        $default_title = $img_title ?? (!empty($attachment_obj->post_title) ? $attachment_obj->post_title : $attachment_obj->post_name);

        // set alt and title if don't exist
        $attr['alt'] = !empty($attachment['alt']) ? $attachment['alt'] : $default_title;
        $attr['title'] = $default_title;

        // Add the class to the attributes
        if (!empty($class)) {
            $attr['class'] = $class;
        }

        $attr['data-img-id'] = $attachment_id;

        // Remove lazy loading attributes if $skipLazyLoad is true
        if ($skipLazyLoad) {
            unset($attr['loading']);
            unset($attr['decoding']);
        }

        $img =  wp_get_attachment_image($attachment_id, $size, false, $attr);
    }

    return $img;
}

/**
 * Displays pagination.
 *
 * @param WP_Query $query_obj The WP_Query object.
 * @param bool $custom_page Flag to indicate a custom page.
 * @return string
 */
function the_pagination($query_obj, $custom_page = false): string {
    $big = 999999999;
    $current_page = $custom_page ?: get_query_var('paged');

    $args = array(
        'base'         => str_replace( $big, '%#%', get_pagenum_link( $big, false ) ),
        'format'       => '?paged=%#%',
        'current'      => max( 1,  $current_page),
        'total'        => $query_obj->max_num_pages,
        'add_args'     => false,
        'prev_text'    => is_rtl() ? '<i class="icon-chevron-right"></i>' : '<i class="icon-chevron-left"></i>',
        'next_text'    => is_rtl() ? '<i class="icon-chevron-left"></i>' : '<i class="icon-chevron-right"></i>',
        'type'         => 'list',
        'end_size'     => 0,
        'mid_size'     => 1,
    );

    $result = paginate_links( $args );

    return '<nav class="pagination">' . $result . '</nav>';
}

/**
 * Generate a heading based on the block index and class.
 *
 * @param string $title    The title for the heading.
 * @param string $class    The CSS class for the heading.
 * @param int    $index    The index of the block.
 *
 * @return string The generated HTML heading.
 */
function get_heading(string $title, string $class, int $index = 0): string{
    $tag = ($index == 0) ? 'h1' : 'h2';
    return "<$tag class='$class'>$title</$tag>";
}

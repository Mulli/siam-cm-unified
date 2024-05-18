<?php
// Same as get_page_by_title() that is deprecated

function siam_get_page_by_title($title){
    $query = new WP_Query(
        array(
            'post_type'              => 'page',
            'title'                  => $title,
            'post_status'            => 'publish',
            'posts_per_page'         => 1,
            'no_found_rows'          => true,
            'ignore_sticky_posts'    => true,
            'update_post_term_cache' => false,
            'update_post_meta_cache' => false,
            'orderby'                => 'post_date ID',
            'order'                  => 'ASC',
        )
    );
     
    if ( ! empty( $query->post ) )
        return ($query->post);
    return null;
}
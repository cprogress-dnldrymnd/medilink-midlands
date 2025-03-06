<?php
function ajax_post_loader_load_more()
{

    $paged = isset($_POST['paged']) ? intval($_POST['paged']) : 1;
  

    $args = array(
        'post_status' => 'publish',
        'post_type' => 'wpsl_stores',
        'posts_per_page' => 10,
        'paged' => $paged,
        'orderby' => 'title',
        'order' => 'ASC'
    );

    if ($search_var) {
        $args['s'] = $search_var;
    }
    $query = new WP_Query($args);

    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            echo membership_listing();
        }
        wp_reset_postdata();
        wp_die();
    } else {
        wp_die('no_more_posts');
    }
}
add_action('wp_ajax_nopriv_ajax_post_loader_load_more', 'ajax_post_loader_load_more');
add_action('wp_ajax_ajax_post_loader_load_more', 'ajax_post_loader_load_more');

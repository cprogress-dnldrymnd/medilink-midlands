<?php
function ajax_post_loader_load_more()
{
    check_ajax_referer('ajax_post_loader_nonce', 'security');

    $paged = isset($_POST['paged']) ? intval($_POST['paged']) : 1;
    $is_filter = isset($_POST['is_filter']) ? $_POST['is_filter'] : 'false';
    $search_var = isset($_POST['search_var']) ? $_POST['search_var'] : false;
    $directory_filter = isset($_POST['directory_filter']) ? $_POST['directory_filter'] : false;

    if ($is_filter == 'true') {
        $paged = 1;
    }

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

    if ($directory_filter) {

        if (in_array('1-9', $directory_filter)) {
            $directory_filter[] = 1;
            $directory_filter[] = 2;
            $directory_filter[] = 3;
            $directory_filter[] = 4;
            $directory_filter[] = 5;
            $directory_filter[] = 6;
            $directory_filter[] = 7;
            $directory_filter[] = 8;
            $directory_filter[] = 9;
        }
        $args['meta_query'] = array(
            array(
                'key' => 'first_letter',
                'value' => $directory_filter,
            ),
        );
    }
    $query = new WP_Query($args);


    if ($query->have_posts()) {
        if ($is_filter == 'true') {
            echo '<div class="row row-flex">';
        }
        while ($query->have_posts()) {
            $query->the_post();

            echo membership_listing();
        }
        wp_reset_postdata();
        echo '</div>';
        wp_die();
    } else {
        wp_die('no_more_posts');
    }
}
add_action('wp_ajax_nopriv_ajax_post_loader_load_more', 'ajax_post_loader_load_more');
add_action('wp_ajax_ajax_post_loader_load_more', 'ajax_post_loader_load_more');

function getFirstLetter($string)
{
    if (empty($string)) {
        return ""; // Return an empty string if the input is empty
    }

    return $string[0]; // Access the first character using array-like notation
}

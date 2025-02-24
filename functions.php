<?php
function wikb_child_scripts()
{
    wp_enqueue_style('wikb-parent-style', get_template_directory_uri() . '/style.css');

    wp_enqueue_style('wikb-swiper', 'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css');
    wp_enqueue_script('wikb-swiper', 'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js');
}
add_action('wp_enqueue_scripts', 'wikb_child_scripts');

add_action('carbon_fields_register_fields', 'cv_register_custom_fields');

function cv_register_custom_fields()
{
    require_once dirname(__FILE__) . '/includes/post-meta.php';
}
require_once('includes/shortcodes.php');
require_once('includes/post-types.php');


function change_mt_listing_slug($args, $post_type)
{
    if ('mt_listing' === $post_type) {
        $args['rewrite']['slug'] = 'resources';
    }
    return $args;
}
add_filter('register_post_type_args', 'change_mt_listing_slug', 10, 2);


function change_mt_listing_category2_slug($args, $taxonomy)
{
    if ('mt-listing-category2' === $taxonomy) {
        $args['rewrite']['slug'] = 'resources-category';
    }
    return $args;
}
add_filter('register_taxonomy_args', 'change_mt_listing_category2_slug', 10, 2);


function memberplace_marketplace()
{
    ob_start();
?>
    
    <?php
    return ob_get_clean();
}

function _author_email($post_author)
{
    $user = get_userdata($post_author);
    if ($user && isset($user->user_email)) {
        return $user->user_email;
    } else {
        return false; // Or handle the error as needed
    }
}


function _author_company($post_author)
{
    $organisation = get_user_meta($post_author, 'organisation', true);

    if ($organisation) {
        return $organisation;
    } else {
        return false; // Or handle the absence of the meta value as needed
    }
}


function _author_name($post_author)
{
    $user = get_userdata($post_author);

    if ($user) {
        $first_name = $user->first_name;
        $last_name  = $user->last_name;

        if (! empty($first_name) && ! empty($last_name)) {
            return $first_name . ' ' . $last_name;
        } elseif (! empty($first_name)) {
            return $first_name;
        } elseif (!empty($last_name)) {
            return $last_name;
        } else {
            return $user->display_name; // Fallback to display name if first/last names are empty
        }
    } else {
        return false; // Or handle the error as needed
    }
}

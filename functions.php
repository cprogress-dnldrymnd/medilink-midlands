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
    <div class="post-box-holder flex-row">
        <div class="row">
            <?php while (have_posts()) {
                the_post() ?>
                <?php
                $post_author = get_the_author_meta( 'ID' );
                echo $post_author;
                ?>
                <div class="col-lg-4">
                    <div class="post-box">
                        <div class="top">
                            <div class="desc">
                                <h3>
                                    <?php the_title() ?>
                                </h3>
                            </div>
                            <?php if (get_the_excerpt()) { ?>
                                <div class="offer-details">
                                    <?= wpautop(get_the_excerpt()) ?>
                                </div>
                            <?php } ?>
                        </div>
                        <div class="bottom">
                            <div class="modeltheme_button">
                                <a class="button-winona button-green btn btn-sm wow-modal-id-1 claim-offer-button" offer_owner_company="<?= _author_company($post_author) ?>" offer_owner_email="<?= _author_email($post_author) ?>" offer_details="<?= wpautop($featured->post_content) ?>" offer_image="<?= $offer_image ?>" offer_owner="<?= _author_name($post_author) ?>" offer_title="<?= $featured->post_title ?>">Claim Offer</a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
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

function _author_logo($post_author)
{


    if (!$post_author) {
        return false; // No user ID, or not logged in.
    }

    // Check if Ultimate Member is active.
    if (!function_exists('um_profile')) {
        return false; // Ultimate Member not active.
    }

    $image_id = um_user('organisation_logo', $post_author); // Get the image ID from the field.

    if (!$image_id) {
        return false; // No image ID found.
    }

    $image_url = wp_get_attachment_url($image_id);

    if (!$image_url) {
        return false; // Image URL could not be retrieved.
    }

    return $image_url;
}

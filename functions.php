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
                $post_author = get_the_author_meta('ID');
                $offer_image = get_the_post_thumbnail_url(get_the_ID(), 'large');
                ?>
                <div class="col-lg-4">
                    <div class="post-box">
                        <div class="top">
                            <div class="image-box">
                                <img src="<?= _author_logo($post_author) ?>">
                            </div>
                            <div class="post-author">
                                <p><?= do_shortcode("[user_field key='organisation' author_id=$post_author]") ?></p>
                            </div>
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
                                <a class="button-winona button-green btn btn-sm wow-modal-id-1 claim-offer-button" offer_owner_company="<?= _author_company($post_author) ?>" offer_owner_email="<?= _author_email($post_author) ?>" offer_details="<?= wpautop(get_the_content()) ?>" offer_image="<?= $offer_image ?>" offer_owner="<?= _author_name($post_author) ?>" offer_title="<?= get_the_title() ?>">Claim Offer</a>
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
    $organisation = get_user_meta($post_author, 'organisation_logo', true);
    $member_folder = "/wp-content/uploads/ultimatemember/$post_author/";
    if ($organisation) {
        return $member_folder . $organisation;
    } else {
        return false; // Or handle the absence of the meta value as needed
    }
}


/**
 * Saves Contact Form 7 data to a custom post type based on the form ID.
 *
 * @param WPCF7_ContactForm $contact_form The Contact Form 7 object.
 */
function save_cf7_to_custom_post($contact_form)
{
    $form_id = $contact_form->id();
    $submission = WPCF7_Submission::get_instance();

    if (!$submission) {
        return; // No submission data.
    }

    $posted_data = $submission->get_posted_data();

    if ($form_id == 50054) {
        // Sanitize and validate data (crucial!).
        $post_title = isset($posted_data['submit_offer_title']) ? sanitize_text_field($posted_data['submit_offer_title']) : 'Contact Form Submission'; // Example
        $post_content = isset($posted_data['submit_offer_details']) ? wp_kses_post($posted_data['submit_offer_details']) : ''; // Example
        $submit_offer_supporting_resource = isset($posted_data['submit_offer_supporting_resource']) ? $posted_data['submit_offer_supporting_resource'] : false; // Example
        $submit_offer_supporting_image = isset($posted_data['submit_offer_supporting_image']) ? $posted_data['submit_offer_supporting_image'][0]  : false; // Example
        $submit_offer_category = isset($posted_data['submit_offer_category']) ? $posted_data['submit_offer_category'][0] : false; // Example

        $post_data = array();

        $post_data['post_title'] = $post_title;
        if ($post_content) {
            $post_data['post_content'] = get_current_user_id();
        }
        $post_data['post_type'] = 'membersmarketplace';
        $post_data['post_status'] = 'pending';
        $post_data['post_author'] = get_current_user_id();

        $post_id = wp_insert_post($post_data);

        if ($post_id) {
            if ($submit_offer_supporting_image) {
                $featured_image = upload_file($submit_offer_supporting_image, $post_id);
                set_post_thumbnail($post_id, $featured_image);
            }
            if ($submit_offer_supporting_resource) {
                foreach ($submit_offer_supporting_resource as $key => $resource) {
                    $resource_file = upload_file($resource, $post_id);
                    carbon_set_post_meta($post_id, "submit_offer_supporting_resource[$key]/resource", $resource_file);
                }
            }
            if ($submit_offer_category) {
                wp_set_post_terms($post_id, $submit_offer_category, 'membersmarketplace_category');
            }
        }
    }
}

add_action('wpcf7_mail_sent', 'save_cf7_to_custom_post'); // Use wpcf7_mail_sent instead of wpcf7_submit


/**
 * Uploads a file to the WordPress media library from a URL.
 *
 * @param string $file_url The URL of the file to upload.
 * @param int    $post_id  Optional. The ID of the post to attach the media to.
 * @return int|WP_Error The attachment ID on success, WP_Error on failure.
 */
function upload_file($file_url, $post_id = 0)
{
    require_once ABSPATH . 'wp-admin/includes/media.php';
    require_once ABSPATH . 'wp-admin/includes/file.php';
    require_once ABSPATH . 'wp-admin/includes/image.php';

    // Download file to temp location.
    $temp_file = download_url($file_url);

    if (is_wp_error($temp_file)) {
        return $temp_file; // Return WP_Error on failure.
    }

    // Array based on $_FILE format.
    $file_array = array(
        'name'     => basename($file_url),
        'tmp_name' => $temp_file,
    );

    // Check for upload errors.
    $upload_overrides = array(
        'test_form' => false,
        'test_size' => true,
    );

    $movefile = wp_handle_sideload($file_array, $upload_overrides);

    if (isset($movefile['error'])) {
        @unlink($file_array['tmp_name']); //remove the temp file
        return new WP_Error('upload_error', $movefile['error']);
    }

    $attachment_id = wp_insert_attachment(
        array(
            'guid'           => $movefile['url'],
            'post_mime_type' => $movefile['type'],
            'post_title'     => preg_replace('/\.[^.]+$/', '', basename($movefile['file'])),
            'post_content'   => '',
            'post_status'    => 'inherit',
        ),
        $movefile['file'],
        $post_id
    );

    if (is_wp_error($attachment_id)) {
        @unlink($file_array['tmp_name']); //remove the temp file
        return $attachment_id;
    }

    // Generate attachment metadata.
    require_once ABSPATH . 'wp-admin/includes/image.php';
    wp_update_attachment_metadata($attachment_id, wp_generate_attachment_metadata($attachment_id, $movefile['file']));

    return $attachment_id;
}

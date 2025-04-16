<?php
function delete_post_type()
{
    unregister_post_type('mt_portfolio');
    unregister_post_type('mt_changelog');
    unregister_post_type('clients');
    unregister_post_type('member');
}
add_action('init', 'delete_post_type');
function wikb_child_scripts()
{
    wp_enqueue_style('wikb-parent-style', get_template_directory_uri() . '/style.css');

    wp_enqueue_style('wikb-swiper', 'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css');
    wp_enqueue_script('wikb-swiper', 'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js');

    wp_enqueue_script('main', get_stylesheet_directory_uri() . '/assets/js/main.js');
    wp_localize_script('main', 'ajax_post_loader_params', array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'paged' => 2,
        'nonce' => wp_create_nonce('ajax_post_loader_nonce'),
    ));
}
add_action('wp_enqueue_scripts', 'wikb_child_scripts');

add_action('carbon_fields_register_fields', 'cv_register_custom_fields');

function cv_register_custom_fields()
{
    require_once dirname(__FILE__) . '/includes/post-meta.php';
}
require_once('includes/shortcodes.php');
require_once('includes/post-types.php');
require_once('includes/ajax.php');
require_once('redux-framework/redux-framework.php');


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
        $post_title = isset($posted_data['submit_offer_title']) ? sanitize_text_field($posted_data['submit_offer_title']) : 'Contact Form Submission';
        $post_content = isset($posted_data['submit_offer_details']) ? wp_kses_post($posted_data['submit_offer_details']) : '';
        $submit_offer_supporting_resource = isset($posted_data['submit_offer_supporting_resource']) ? $posted_data['submit_offer_supporting_resource'] : false;
        $submit_offer_supporting_image = isset($posted_data['submit_offer_supporting_image']) ? $posted_data['submit_offer_supporting_image'][0]  : false;
        $submit_offer_category = isset($posted_data['submit_offer_category']) ? $posted_data['submit_offer_category'] : false;
        $submit_offer_user_id = isset($posted_data['submit_offer_user_id']) ? $posted_data['submit_offer_user_id'] : false;

        $post_data = array();

        $post_data['post_title'] = $post_title;
        if ($post_content) {
            $post_data['post_content'] = $post_content;
        }
        $post_data['post_type'] = 'membersmarketplace';
        $post_data['post_status'] = 'pending';
        $post_data['post_author'] = $submit_offer_user_id;

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
                $submit_offer_category_arr = explode(',', $submit_offer_category);
                wp_set_post_terms($post_id, $submit_offer_category_arr, 'membersmarketplace_category');
            }
        }
    } else if ($form_id == 50282) {
        // Sanitize and validate data (crucial!).
        $post_title = isset($posted_data['submit_blog_title']) ? sanitize_text_field($posted_data['submit_blog_title']) : 'Contact Form Submission';
        $post_content = isset($posted_data['submit_blog_content']) ? wp_kses_post($posted_data['submit_blog_content']) : '';
        $submit_blog_featured_image = isset($posted_data['submit_blog_featured_image']) ? $posted_data['submit_blog_featured_image'][0]  : false;
        $submit_blog_user_id = isset($posted_data['submit_blog_user_id']) ? $posted_data['submit_blog_user_id'] : false;
        $submit_blog_category = isset($posted_data['submit_blog_category']) ? $posted_data['submit_blog_category'][0] : false;

        $post_data = array();

        $post_data['post_title'] = $post_title;
        if ($post_content) {
            $post_data['post_content'] = $post_content;
        }
        $post_data['post_type'] = 'post';
        $post_data['post_status'] = 'pending';

        if (is_user_logged_in()) {
            $post_data['post_author'] = $submit_blog_user_id;
        } else {
            $submit_blog_full_name = isset($posted_data['submit_blog_full_name']) ? wp_kses_post($posted_data['submit_blog_full_name']) : '';
            $submit_blog_email_address = isset($posted_data['submit_blog_email_address']) ? wp_kses_post($posted_data['submit_blog_email_address']) : '';
            $submit_blog_organisation = isset($posted_data['submit_blog_organisation']) ? wp_kses_post($posted_data['submit_blog_organisation']) : '';
            $submit_blog_phone_number = isset($posted_data['submit_blog_phone_number']) ? wp_kses_post($posted_data['submit_blog_phone_number']) : '';


            $post_data['meta_input'] = [];
            $post_data['meta_input']['_submit_blog_full_name'] = $submit_blog_full_name;
            $post_data['meta_input']['_submit_blog_email_address'] = $submit_blog_email_address;
            $post_data['meta_input']['_submit_blog_organisation'] = $submit_blog_organisation;
            $post_data['meta_input']['_submit_blog_phone_number'] = $submit_blog_phone_number;
        }
        $post_id = wp_insert_post($post_data);

        if ($post_id) {
            if ($submit_blog_featured_image) {
                $featured_image = upload_file($submit_blog_featured_image, $post_id);
                set_post_thumbnail($post_id, $featured_image);
            }
            if ($submit_blog_category) {
                wp_set_post_terms($post_id, $submit_blog_category, 'category');
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


function wikb_header_title_breadcrumbs_v2($heading, $desc)
{
    ob_start();
?>
    <div class="header-title-breadcrumb header-title-breadcrumb-custom relative">
        <div class="header-title-breadcrumb-overlay text-center">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12 text-left">
                        <h1><?= $heading ?></h1>

                        <ol class="breadcrumb text-left">
                            <li><a href="https://medilink.theprogressteam.com/">Home</a></li>
                            <li class="active"><?= $heading ?></li>
                        </ol>
                        <div class="desc">
                            <?= wpautop($desc) ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
    return ob_get_clean();
}

function action_wp_body_class() {}

add_filter('body_class', 'custom_class');
function custom_class($classes)
{
    $header_title_style = get_post_meta(get_the_ID(), 'header_title_style', true);

    if ($header_title_style) {
        $classes[] = 'header-title-' . $header_title_style;
    }
    return $classes;
}

function action_wp_footer()
{
    $title_area_description = get_post_meta(get_the_ID(), 'title_area_description', true);
    $title_area_button_text = get_post_meta(get_the_ID(), 'title_area_button_text', true);
    $title_area_button_link = get_post_meta(get_the_ID(), 'title_area_button_link', true);
    if ($title_area_description || $title_area_button_text) { ?>
        <script>
            jQuery(document).ready(function() {
                <?php if ($title_area_description) { ?>
                    jQuery('<div class="title-area-desc"><?= $title_area_description ?></div>').insertAfter('.breadcrumb');
                <?php } ?>
                <?php if ($title_area_button_text) { ?>
                    jQuery('<div class="modeltheme_button "> <a href="<?= $title_area_button_link ?>" class="button-winona button-green btn btn-sm"> <?= $title_area_button_text ?> </a> </div>').insertAfter('.breadcrumb');
                <?php } ?>
            });
        </script>
    <?php
    }
}

add_action('wp_footer', 'action_wp_footer');


add_filter('wpcf7_form_elements', 'mycustom_wpcf7_form_elements');
function mycustom_wpcf7_form_elements($form)
{
    $form = do_shortcode($form);
    return $form;
}


function action_admin_head()
{
    ?>
    <style>
        #toplevel_page_WikbChild {
            display: none;
        }
    </style>
<?php
}
add_action('admin_head', 'action_admin_head');

add_filter('wp_prepare_themes_for_js', function ($themes) {

    $sc = get_stylesheet_directory_uri() . '/screenshot-theme.png';

    $themes['wikb']['screenshot'][0] = $sc;
    $themes['wikb']['name'] = 'Medilink Midlands';
    $themes['wikb']['description'] = '';
    $themes['wikb']['authorAndUri'] = 'Digitally Disruptive';
    $themes['wikb']['tags'] = '';


    $themes['wikb-child']['name'] = 'Medilink Midlands Child';
    $themes['wikb-child']['description'] = '';
    $themes['wikb-child']['authorAndUri'] = 'Digitally Disruptive';
    $themes['wikb-child']['tags'] = '';
    $themes['wikb-child']['screenshot'][0] = $sc;


    return $themes;
});



/**
 * Notify admin when a user updates their account details.
 *
 * @param int   $user_id The ID of the updated user.
 * @param array $changes An array of the changes made to the user's account.
 */
function um_notify_admin_on_account_update($user_id, $changes)
{
    // Get admin email address
    $ultimate_member_options = get_option('um_options');
    if (isset($ultimate_member_options['admin_email'])) {
        $admin_email =  $ultimate_member_options['admin_email'];
    }

    if ($admin_email) {
        $user_info = get_userdata($user_id);
        $username  = $user_info->user_login;
        $user_email = $user_info->user_email;

        $subject = sprintf('[%s] User Account Updated', get_bloginfo('name'));
        $message = sprintf('A user has updated their account details on %s.', get_bloginfo('name')) . "\r\n\r\n";
        $message .= sprintf('Username: %s (%s)', $username, $user_email) . "\r\n\r\n";
        $message .= "Changes:\r\n";

        if (! empty($changes)) {
            foreach ($changes as $key => $value) {
                $old_value = get_user_meta($user_id, $key, true);
                $message .= sprintf('- %s: Old Value - %s, New Value - %s', $key, maybe_serialize($old_value), maybe_serialize($value)) . "\r\n";
            }
        } else {
            $message .= 'No specific changes data available.';
        }
        $user_meta = get_user_meta($user_id, 'user_meta_previous');

        error_log(print_r($changes, true));
        error_log(print_r($user_meta, true));

        // Send the email
        //wp_mail($admin_email, $subject, $message);
    }
}
add_action('um_after_user_updated', 'um_notify_admin_on_account_update', 10, 2);

add_action('um_user_before_updating_profile', 'my_user_before_updating_profile', 10, 1);
function my_user_before_updating_profile($userinfo)
{
    $user_meta = get_user_meta($userinfo->ID);
    update_user_meta($userinfo->ID, 'user_meta_previous', $user_meta);
    error_log(print_r($userinfo, true));
}

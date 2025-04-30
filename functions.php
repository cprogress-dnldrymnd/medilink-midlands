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
    wp_localize_script('main', 'ajax_params', array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'paged'    => 2,
        'nonce'    => wp_create_nonce('ajax_nonce'),
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


function member_marketplace()
{
    ob_start();
?>
    <div id="results">
        <div class="post-box-holder flex-row">
            <div class="row">
                <?php
                while (have_posts()) {
                    the_post();
                    echo member_marketplace_grid(get_the_ID());
                }
                ?>
            </div>
        </div>
    </div>
<?php
    return ob_get_clean();
}

function member_marketplace_grid($id, $hide_button = false, $button_text = 'Claim Offer')
{
    ob_start();
    $post = get_post($id);
    $post_author = $post->post_author;
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
                        <?= get_the_title($id) ?>
                    </h3>
                </div>
                <?php if (get_the_excerpt($id)) { ?>
                    <div class="offer-details">
                        <?= wpautop(get_the_excerpt($id)) ?>
                    </div>
                <?php } ?>
            </div>
            <?php if ($hide_button == false) { ?>
                <div class="bottom">
                    <div class="modeltheme_button">
                        <?= _claim_offer_button($id, $button_text) ?>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
<?php
    return ob_get_clean();
}

function membership_listing($id = false, $allow_edit = false)
{
    ob_start();

    if ($id == false) {
        $post_id = get_the_ID();
    } else {
        $post_id = $id;
    }

    $wpsl_url = get_post_meta($post_id, 'wpsl_url', true);
    $wpsl_phone = get_post_meta($post_id, 'wpsl_phone', true);
    $wpsl_email = get_post_meta($post_id, 'wpsl_email', true);
    $url = addHttpsToUrl($wpsl_url);
    if (has_term(112, 'wpsl_store_category', $post_id)) {
        $class = 'col-lg-10';
        $is_patron = true;
    } else {
        $class = 'col-lg-12';
        $is_patron = false;
    }

    $title = get_the_title($post_id);
    $content = get_the_content(NULL, false, $post_id);

    $content_clean = preg_replace('//', '', $content);

    // Remove HTML tags
    $content_clean = strip_tags($content);
?>

    <?php if ($allow_edit == true && isset($_GET['edit']) && $_GET['edit'] == $post_id) { ?>

        <?php if ($_GET['submitted'] == 'true') { ?>
            <?php
            $edit_id = $_GET['edit'];
            $new_title = $_GET['title'];
            $new_content = $_GET['content'];
            $new_wpsl_phone = $_GET['wpsl_phone'];
            $new_wpsl_email = $_GET['wpsl_email'];
            $new_wpsl_url = $_GET['wpsl_url'];

            update_post_meta($edit_id, '_pending_description', $new_content);

            if ($title != $new_title) {
                update_post_meta($edit_id, '_pending_title', $new_title);
            } else {
                update_post_meta($edit_id, '_pending_title', '');
            }
            if ($new_wpsl_phone != $wpsl_phone) {
                update_post_meta($edit_id, '_pending_phone', $new_wpsl_phone);
            } else {
                update_post_meta($edit_id, '_pending_phone', '');
            }
            if ($new_wpsl_email != $wpsl_email) {
                update_post_meta($edit_id, '_pending_email', $new_wpsl_email);
            } else {
                update_post_meta($edit_id, '_pending_email', '');
            }
            if ($new_wpsl_url != $wpsl_url) {
                update_post_meta($edit_id, '_pending_website', $new_wpsl_url);
            } else {
                update_post_meta($edit_id, '_pending_website', '');
            }
            notify_admin_on_member_directory_update($post_id);
            ?>
            <div class="message">Information succesfully submitted and needs to be review.</div>
        <?php } else { ?>
            <?php
            $_pending_title = get_post_meta($post_id, '_pending_title', true);
            $_pending_description = get_post_meta($post_id, '_pending_description', true);
            $_pending_phone = get_post_meta($post_id, '_pending_phone', true);
            $_pending_email = get_post_meta($post_id, '_pending_email', true);
            $_pending_website = get_post_meta($post_id, '_pending_website', true);
            ?>
        <?php } ?>

        <?php
        $title_val = $_pending_title ? $_pending_title : ($new_title ? $new_title : $title);
        $description_val = $_pending_description ? $_pending_description : ($new_content ? $new_content : $content_clean);
        $phone_val = $_pending_phone ? $_pending_phone : ($new_wpsl_phone ? $new_wpsl_phone : $wpsl_phone);
        $email_val = $_pending_email ? $_pending_email : ($new_wpsl_email ? $new_wpsl_email : $wpsl_email);
        $website_val = $_pending_website ? $_pending_website : ($new_wpsl_url ? $new_wpsl_url : $wpsl_url);
        ?>
        <form method="GET" class="form-style-new">
            <input type="hidden" name="profiletab" value="directory">
            <input type="hidden" name="edit" value="<?= $id ?>">
            <input type="hidden" name="submitted" value="true">
            <div class="form-group">
                <label class="form-control"><span>Organisation: </span><input type="text" name="title" id="title" value="<?= $title_val ?>"></label>
                <label class="form-control"><span>Description: </span><textarea name="content" id="content"><?= $description_val ?></textarea></label>
                <label class="form-control"><span>Phone: </span><input type="tel" name="wpsl_phone" id="wpsl_phone" value="<?= $phone_val ?>"></label>
                <label class="form-control"><span>Email: </span><input type="email" name="wpsl_email" id="wpsl_email" value="<?= $email_val ?>"></label>
                <label class="form-control"><span>Website: </span><input type="url" name="wpsl_url" id="wpsl_url" value="<?= $website_val ?>"></label>
            </div>
            <div class="button-box text-right">
                <button type="submit" class="button-winona button-accent btn btn-sm">
                    Submit
                </button>
            </div>
        </form>
    <?php } else { ?>
        <div class="col-lg-12 post-item" id="post-<?= $id ?>">
            <div class="listing">
                <div class="top">
                    <div class="row row-flex logo-heading">
                        <?php if ($is_patron) { ?>
                            <div class="col-lg-2 logo-box">
                                <?= wp_get_attachment_image(50188, 'medium') ?>
                            </div>
                        <?php } ?>
                        <div class="<?= $class ?> heading-description">
                            <div class="heading-box">
                                <h3>
                                    <?= $title ?>
                                </h3>
                            </div>
                            <div class="description-box">
                                <?= $content ?>
                            </div>
                            <div class="meta-details">
                                <ul>
                                    <?php if ($wpsl_phone) { ?>
                                        <li>
                                            <a href="tel:<?= $wpsl_phone ?>">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                                    class="bi bi-telephone-fill" viewBox="0 0 16 16">
                                                    <path fill-rule="evenodd"
                                                        d="M1.885.511a1.745 1.745 0 0 1 2.61.163L6.29 2.98c.329.423.445.974.315 1.494l-.547 2.19a.68.68 0 0 0 .178.643l2.457 2.457a.68.68 0 0 0 .644.178l2.189-.547a1.75 1.75 0 0 1 1.494.315l2.306 1.794c.829.645.905 1.87.163 2.611l-1.034 1.034c-.74.74-1.846 1.065-2.877.702a18.6 18.6 0 0 1-7.01-4.42 18.6 18.6 0 0 1-4.42-7.009c-.362-1.03-.037-2.137.703-2.877z" />
                                                </svg>
                                                <?= $wpsl_phone ?>
                                            </a>
                                        </li>
                                    <?php } ?>
                                    <?php if ($wpsl_email) { ?>
                                        <li>
                                            <a href="mailto:<?= $wpsl_email ?>">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                                    class="bi bi-envelope-fill" viewBox="0 0 16 16">
                                                    <path
                                                        d="M.05 3.555A2 2 0 0 1 2 2h12a2 2 0 0 1 1.95 1.555L8 8.414zM0 4.697v7.104l5.803-3.558zM6.761 8.83l-6.57 4.027A2 2 0 0 0 2 14h12a2 2 0 0 0 1.808-1.144l-6.57-4.027L8 9.586zm3.436-.586L16 11.801V4.697z" />
                                                </svg>
                                                <?= $wpsl_email ?>
                                            </a>
                                        </li>
                                    <?php } ?>

                                    <?php if ($wpsl_url) { ?>
                                        <li>
                                            <a href="<?= $url ?>" target="_blank">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                                    class="bi bi-globe" viewBox="0 0 16 16">
                                                    <path
                                                        d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8m7.5-6.923c-.67.204-1.335.82-1.887 1.855A8 8 0 0 0 5.145 4H7.5zM4.09 4a9.3 9.3 0 0 1 .64-1.539 7 7 0 0 1 .597-.933A7.03 7.03 0 0 0 2.255 4zm-.582 3.5c.03-.877.138-1.718.312-2.5H1.674a7 7 0 0 0-.656 2.5zM4.847 5a12.5 12.5 0 0 0-.338 2.5H7.5V5zM8.5 5v2.5h2.99a12.5 12.5 0 0 0-.337-2.5zM4.51 8.5a12.5 12.5 0 0 0 .337 2.5H7.5V8.5zm3.99 0V11h2.653c.187-.765.306-1.608.338-2.5zM5.145 12q.208.58.468 1.068c.552 1.035 1.218 1.65 1.887 1.855V12zm.182 2.472a7 7 0 0 1-.597-.933A9.3 9.3 0 0 1 4.09 12H2.255a7 7 0 0 0 3.072 2.472M3.82 11a13.7 13.7 0 0 1-.312-2.5h-2.49c.062.89.291 1.733.656 2.5zm6.853 3.472A7 7 0 0 0 13.745 12H11.91a9.3 9.3 0 0 1-.64 1.539 7 7 0 0 1-.597.933M8.5 12v2.923c.67-.204 1.335-.82 1.887-1.855q.26-.487.468-1.068zm3.68-1h2.146c.365-.767.594-1.61.656-2.5h-2.49a13.7 13.7 0 0 1-.312 2.5m2.802-3.5a7 7 0 0 0-.656-2.5H12.18c.174.782.282 1.623.312 2.5zM11.27 2.461c.247.464.462.98.64 1.539h1.835a7 7 0 0 0-3.072-2.472c.218.284.418.598.597.933M10.855 4a8 8 0 0 0-.468-1.068C9.835 1.897 9.17 1.282 8.5 1.077V4z" />
                                                </svg>
                                                <?= getDomain($url) ?>
                                            </a>
                                        </li>
                                    <?php } ?>

                                </ul>
                            </div>
                            <div class="modeltheme_button view-all">
                                <a href="<?= $url ?>" target="_blank" class="button-winona button-green btn btn-sm">
                                    Visit Website
                                </a>

                                <?php if ($allow_edit == true && !isset($_GET['edit']) && is_user_logged_in()) { ?>
                                    <a href="?profiletab=directory&edit=<?= $id ?>" class="button-winona button-accent btn btn-sm">
                                        Edit
                                    </a>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>

<?php
    return ob_get_clean();
}

function post__grid($posts): bool|string
{
    ob_start(); ?>
    <div class="blog-posts blog-posts-v2 flex-row simple-posts blog-posts-shortcode wow">
        <div class="row">
            <?php foreach ($posts as $post) { ?>
                <?php
                $permalink = get_the_permalink($post->ID);
                $title = $post->post_title;
                $date = get_the_date('', $post->ID);
                $image = get_the_post_thumbnail_url($post->ID, 'large');
                $category = get_the_category($post->ID);

                if (!$image) {
                    $image = wp_get_attachment_image_url(50874, 'large');
                }
                ?>
                <div class="vc_col-sm-4">
                    <article class="single-post list-view">

                        <div class="blog_custom">

                            <!-- POST THUMBNAIL -->

                            <div class="post-thumbnail">

                                <a class="relative" href="<?= $permalink ?>">

                                    <div class="featured_image_blog">
                                        <img decoding="async" class="blog_post_image" src="<?= $image ?>" alt="<?= $title ?>">
                                        <div class="terms-box">
                                            <?php foreach ($category as $cat) { ?>
                                                <?php if ($cat->slug != 'featured-articles') { ?>
                                                    <span><?= $cat->name ?></span>
                                                <?php } ?>
                                            <?php } ?>
                                        </div>
                                    </div>

                                </a>

                            </div>

                            <!-- POST DETAILS -->

                            <div class="post-details text-left">

                                <div class="post-date">
                                    <?= $date ?>
                                </div>

                                <h3 class="post-name">

                                    <a href="<?= $permalink ?>" title="<?= $title ?>"><?= $title ?></a>

                                </h3>

                                <div class="post-excerpt">

                                    <div class="text-element content-element">

                                        <p> <a class="more-link" href="<?= $permalink ?>">Read More <svg
                                                    xmlns="http://www.w3.org/2000/svg"
                                                    viewBox="0 0 512 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.-->
                                                    <path
                                                        d="M470.6 278.6c12.5-12.5 12.5-32.8 0-45.3l-160-160c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L402.7 256 265.4 393.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0l160-160zm-352 160l160-160c12.5-12.5 12.5-32.8 0-45.3l-160-160c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L210.7 256 73.4 393.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0z" />
                                                </svg></a></p>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </article>

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
        $last_name = $user->last_name;

        if (!empty($first_name) && !empty($last_name)) {
            return $first_name . ' ' . $last_name;
        } elseif (!empty($first_name)) {
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
        $submit_offer_supporting_image = isset($posted_data['submit_offer_supporting_image']) ? $posted_data['submit_offer_supporting_image'][0] : false;
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
        $submit_blog_featured_image = isset($posted_data['submit_blog_featured_image']) ? $posted_data['submit_blog_featured_image'][0] : false;
        $submit_blog_user_id = isset($posted_data['submit_blog_user_id']) ? $posted_data['submit_blog_user_id'] : false;
        $submit_blog_category = isset($posted_data['submit_blog_category']) ? $posted_data['submit_blog_category'] : false;

        $post_data = array();

        $post_data['post_title'] = $post_title;
        if ($post_content) {
            $post_data['post_content'] = $post_content;
        }
        $post_data['post_type'] = 'post';
        $post_data['post_status'] = 'pending';

        $post_data['post_author'] = $submit_blog_user_id;

        $submit_blog_full_name = isset($posted_data['submit_blog_full_name']) ? wp_kses_post($posted_data['submit_blog_full_name']) : '';
        $submit_blog_email_address = isset($posted_data['submit_blog_email_address']) ? wp_kses_post($posted_data['submit_blog_email_address']) : '';
        $submit_blog_organisation = isset($posted_data['submit_blog_organisation']) ? wp_kses_post($posted_data['submit_blog_organisation']) : '';
        $submit_blog_phone_number = isset($posted_data['submit_blog_phone_number']) ? wp_kses_post($posted_data['submit_blog_phone_number']) : '';


        $post_data['meta_input'] = [];
        $post_data['meta_input']['_submit_blog_full_name'] = $submit_blog_full_name;
        $post_data['meta_input']['_submit_blog_email_address'] = $submit_blog_email_address;
        $post_data['meta_input']['_submit_blog_organisation'] = $submit_blog_organisation;
        $post_data['meta_input']['_submit_blog_phone_number'] = $submit_blog_phone_number;
        $post_id = wp_insert_post($post_data);

        if ($post_id) {
            if ($submit_blog_featured_image) {
                $featured_image = upload_file($submit_blog_featured_image, $post_id);
                set_post_thumbnail($post_id, $featured_image);
            }
            if ($submit_blog_category) {
                $submit_blog_category_arr = explode(',', $submit_blog_category);
                wp_set_post_terms($post_id, $submit_blog_category_arr, 'category');
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
                            <li><a href="<?= get_site_url() ?>/">Home</a></li>
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

    if (isset($_GET['profiletab']) && $_GET['profiletab'] == 'marketplace') {
        $classes[] = 'marketplace-active-tab';
    }

    $user = wp_get_current_user();

    // Check if the user is logged in and has a role.
    if ($user && is_object($user) && isset($user->roles) && is_array($user->roles)) {
        // Get the user's bbPress role.  We'll check for the most specific role.
        $bbp_role = '';
        if (in_array('bbp_keymaster', $user->roles)) {
            $bbp_role = 'bbp_keymaster';
        } elseif (in_array('bbp_moderator', $user->roles)) {
            $bbp_role = 'bbp_moderator';
        } elseif (in_array('bbp_participant', $user->roles)) {
            $bbp_role = 'bbp_participant';
        } elseif (in_array('bbp_spectator', $user->roles)) {
            $bbp_role = 'bbp_spectator';
        } elseif (in_array('subscriber', $user->roles)) {
            $bbp_role = 'subscriber'; //often treated as a default role in bbPress
        }

        // If a bbPress role was found, add it as a body class.
        if (!empty($bbp_role)) {
            $classes[] = 'bbp-role-' . $bbp_role;
        }
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
        $admin_email = $ultimate_member_options['admin_email'];
    }

    $user_meta_previous = get_user_meta($user_id, 'user_meta_previous', true);
    $changes_html = '';

    if ($admin_email) {
        $user_info = get_userdata($user_id);
        $username = $user_info->user_login;
        $user_email = $user_info->user_email;

        $subject = sprintf('[%s] User Account Updated', get_bloginfo('name'));
        $message = sprintf('A user has updated their account details on %s.', get_bloginfo('name')) . "\r\n\r\n";
        $message .= sprintf('Username: %s (%s)', $username, $user_email) . "\r\n\r\n";
        $message .= "Changes:\r\n";
        foreach ($user_meta_previous as $key_previous => $previous) {
            $prev_val = $previous;
            $new_val = $changes[$key_previous];
            if ($prev_val != $new_val) {
                $changes_html .= "<tr>";
                $changes_html .= "<td style='padding: 10px; text-align: left; font-weight: 400'>$prev_val</td>";
                $changes_html .= "<td style='padding: 10px; text-align: left; font-weight: 400'>$new_val</td>";
                $changes_html .= "</tr>";
            }
        }

        if ($changes_html != '') {
            $email_html = "<table style='width: 100%'>";
            $email_html .= "<tr><th style='padding: 10px; text-align: left'>Previous Value</th><th style='padding: 10px; text-align: left'>New Value</th></tr>";
            $email_html .= $changes_html;
            $email_html .= "</table>";
        }

        // Send the email
        wp_mail($admin_email, $subject, email_template($username, $email_html));
    }
}
add_action('um_after_user_updated', 'um_notify_admin_on_account_update', 10, 2);

add_action('um_user_before_updating_profile', 'my_user_before_updating_profile', 10, 1);
function my_user_before_updating_profile($userinfo)
{
    $user_meta_previous['job_role'] = get_user_meta($userinfo['ID'], 'job_role', true);
    $user_meta_previous['organisation'] = get_user_meta($userinfo['ID'], 'organisation', true);
    $user_meta_previous['phone_number'] = get_user_meta($userinfo['ID'], 'phone_number', true);
    $user_meta_previous['address'] = get_user_meta($userinfo['ID'], 'address', true);
    $user_meta_previous['ttle'] = get_user_meta($userinfo['ID'], 'ttle', true);
    $user_meta_previous['organisation_description'] = get_user_meta($userinfo['ID'], 'organisation_description', true);

    update_user_meta($userinfo['ID'], 'user_meta_previous', $user_meta_previous);
}

function email_template($display_name, $changes, $max_width = '560px', $message = '')
{
    ob_start();
    if (!$message) {
        $message_val = $display_name . ' has just updated their information.';
    } else {
        $message_val = $message;
    }

    $site_name = 'Medilink Midlands';
    $site_url = get_site_url();
?>
    <div
        style='max-width: <?= $max_width ?>;padding: 20px;background: #ffffff;border-radius: 5px;margin: 40px auto;font-family: Open Sans,Helvetica,Arial;font-size: 15px;color: #666'>
        <div style='color: #444444;font-weight: normal'>
            <div style='text-align: center'><img src='https://portal.medilinkmidlands.com/wp-content/uploads/2025/01/medlink-logo-1.png'
                    alt='' /></div>
            <div
                style='text-align: center;font-weight: 600;font-size: 26px;padding: 10px 0;border-bottom: solid 3px #eeeeee'>
                <?= $site_name ?>
            </div>
            <div style='clear: both'> </div>
        </div>
        <div style='padding: 0 30px 30px 30px;border-bottom: 3px solid #eeeeee'>
            <div style='padding: 30px 0;font-size: 24px;text-align: center;line-height: 40px'><?= $message_val ?></div>

            <div style='padding: 0 0 15px 0'>
                <div
                    style='background: #eee;color: #444;padding: 12px 15px;border-radius: 3px;font-weight: bold;font-size: 16px'>
                    Here are the changes on the account:<br /><br />
                    <?= $changes ?>
                </div>
            </div>
        </div>
        <div style='color: #999;padding: 20px 30px'>
            <div>Thank you!</div>
            <div>The <a style='color: #3ba1da;text-decoration: none' href='<?= $site_url ?>'><?= $site_name ?></a> Team
            </div>
        </div>
    </div>
<?php
    return ob_get_clean();
}

function wpse27856_set_content_type()
{
    return "text/html";
}
add_filter('wp_mail_content_type', 'wpse27856_set_content_type');

function um_change_posts_text($translation, $text, $domain)
{
    if ('ultimate-member' === $domain) {
        if ('Posts' === $text) {
            return 'Articles';
        } elseif ('View Posts' === $text) {
            return 'View Articles';
        } elseif ('No Posts Yet.' === $text) {
            return 'No Articles Yet.';
        } elseif ('load more posts' === $text) {
            return 'load more articles';
        }
        // Add more conditions as needed for other instances of "Posts"
    }
    return $translation;
}
add_filter('gettext', 'um_change_posts_text', 20, 3);
add_filter('ngettext', 'um_change_posts_text', 20, 3);

function add_forum_posts_admin_link()
{
    add_menu_page(
        'Forum Posts',        // Page title
        'Forum Posts',        // Menu title
        'manage_options',     // Capability required to see this menu
        'forum_posts',        // Menu slug (unique identifier)
        'forum_posts_page',   // Function to display the page content (we'll just redirect)
        'dashicons-admin-post', // Icon to use (optional - see WordPress Dashicons)
        25                    // Position in the menu order (adjust as needed)
    );
}
add_action('admin_menu', 'add_forum_posts_admin_link');

function forum_posts_page()
{
    $redirect_url = '/pending-forum-posts/';
    echo '<script type="text/javascript">window.location = "' . esc_url($redirect_url) . '";</script>';
    echo '<noscript><meta http-equiv="refresh" content="0;url=' . esc_url($redirect_url) . '"></noscript>';
    echo '<p>Redirecting to <a href="' . esc_url($redirect_url) . '">' . esc_html($redirect_url) . '</a>...</p>';
}

function add_custom_links_to_menu($items, $args)
{
    // Check if the current menu ID matches the target menu ID.
    if (isset($args->menu->term_id) && $args->menu->term_id == 182) { // Use term_id
        // Define the custom links you want to add.
        if (is_user_logged_in()) {
            $custom_links = array(
                array(
                    'title' => 'Profile',
                    'url'   => do_shortcode('[um_author_profile_link raw=1 user_id=' . get_current_user_id() . ']'), // Or use home_url() for the site's home page
                    'id'    => 'custom-menu-item-profile', // Unique ID
                ),
                array(
                    'title' => 'Edit Profile',
                    'url'   => esc_url(um_edit_profile_url()), // Or use home_url() for the site's home page
                    'id'    => 'custom-menu-item-edit-profile', // Unique ID
                ),
                array(
                    'title' => 'Log Out',
                    'url'   => esc_url(wp_logout_url(home_url())), // Replace with your desired URL
                    'id'    => 'custom-menu-item-logout',
                ),

                // Add more links as needed.
            );
        } else {
            $custom_links = array(
                array(
                    'title' => 'Sign In',
                    'url'   => '/login/', // Or use home_url() for the site's home page
                    'id'    => 'custom-menu-item-profile', // Unique ID
                ),
                array(
                    'title' => 'Register',
                    'url'   => '/register/', // Or use home_url() for the site's home page
                    'id'    => 'custom-menu-item-edit-profile', // Unique ID
                ),
                // Add more links as needed.
            );
        }
        // Calculate the insertion point (e.g., after the first item).
        $insert_after = 1; // Insert after the first existing item.
        $index = 0;

        // Loop through the custom links and add them to the menu items array.
        foreach ($custom_links as $link_data) {
            $menu_item = (object) array(
                'ID'               => $link_data['id'],
                'title'            => $link_data['title'],
                'url'              => $link_data['url'],
                'menu_order'       => 0, // Set to 0, and WordPress will handle ordering
                'menu_item_parent' => 0,
                'type'             => 'custom',
                'object'           => 'custom',
                'db_id'            => 0, // Set to 0 for new items
            );

            // Insert the new item at the correct position
            array_splice($items, $index + $insert_after, 0, array($menu_item));
            $index++; // Increment, since we are inserting *after* existing elements
        }
    }
    return $items;
}
add_filter('wp_nav_menu_objects', 'add_custom_links_to_menu', 10, 2);


function _claim_offer_button($id, $button_text = 'Claim Offer')
{
    ob_start();
    $post = get_post($id);
    $post_author = $post->post_author;
    $offer_image = get_the_post_thumbnail_url($post->ID, 'large');
    $documents = carbon_get_post_meta($post->ID, 'submit_offer_supporting_resource');
    if ($documents) {
        $documents_html = "<div class='offer-documents-holder'>";
        $documents_html .= "<div class='offer-documents'>";
        $documents_html .= '<h4>Supporting Documents</h4>';
        foreach ($documents as $document) {
            $doc_url = wp_get_attachment_url($document["resource"]);
            $file_path = get_attached_file($document["resource"]);
            $file_name = basename($file_path);
            $documents_html .= "<div class='offer-document'> <a href='$doc_url' target='_blank'> <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-file-text' viewBox='0 0 16 16'> <path d='M5 4a.5.5 0 0 0 0 1h6a.5.5 0 0 0 0-1zm-.5 2.5A.5.5 0 0 1 5 6h6a.5.5 0 0 1 0 1H5a.5.5 0 0 1-.5-.5M5 8a.5.5 0 0 0 0 1h6a.5.5 0 0 0 0-1zm0 2a.5.5 0 0 0 0 1h3a.5.5 0 0 0 0-1z'/> <path d='M2 2a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2zm10-1H4a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1'/> </svg>$file_name </a> </div>";
        }
        $documents_html .= "</div>";
        $documents_html .= "</div>";
    }
?>
    <button class="button-winona button-green btn btn-sm wow-modal-id-1 claim-offer-button"
        offer_owner_company="<?= _author_company($post_author) ?>" offer_owner_email="<?= _author_email($post_author) ?>"
        offer_details="<?= esc_html(wpautop($post->post_content)) ?>" offer_image="<?= $offer_image ?>"
        offer_owner="<?= _author_name($post_author) ?>" offer_title="<?= $post->post_title ?>"
        documents="<?= $documents_html ?>">
        <?= $button_text ?>
    </button>
<?php
    return ob_get_clean();
}


function my_custom_posts_per_page($query)
{
    if (!is_admin() && $query->is_main_query()) {
        if ($query->get('post_type') === 'membersmarketplace' || $query->is_tax('membersmarketplace_category')) {
            $query->set('posts_per_page', 12); // Change 10 to your desired number
        }
    }
}
add_action('pre_get_posts', 'my_custom_posts_per_page');


function remove_private_protected_prefix($title)
{
    $title = str_replace('Private: ', '', $title);
    $title = str_replace('Protected: ', '', $title);
    return $title;
}
add_filter('the_title', 'remove_private_protected_prefix');


function my_admin_edit_post_function()
{
    if (isset($_GET['approve_changes']) && $_GET['approve_changes'] == 'true') {
        $post_id = $_GET['post'];
        $args['ID'] = $post_id;

        $_pending_title = get_post_meta($post_id, '_pending_title', true);
        $_pending_description = get_post_meta($post_id, '_pending_description', true);
        $_pending_phone = get_post_meta($post_id, '_pending_phone', true);
        $_pending_email = get_post_meta($post_id, '_pending_email', true);
        $_pending_website = get_post_meta($post_id, '_pending_website', true);
        $meta_inputs = [];

        if ($_pending_title) {
            $args['post_title'] = $_pending_title;
        }
        if ($_pending_description) {
            $args['post_content'] = $_pending_description;
        }

        if ($_pending_phone) {
            $meta_inputs['wpsl_phone'] = $_pending_phone;
        }

        if ($_pending_email) {
            $meta_inputs['wpsl_email'] = $_pending_email;
        }

        if ($_pending_website) {
            $meta_inputs['wpsl_url'] = $_pending_website;
        }

        if ($meta_inputs) {
            $args['meta_input'] = $meta_inputs;
        }
        wp_update_post($args);

        update_post_meta($post_id, '_pending_description', '');
        update_post_meta($post_id, '_pending_title', '');

        update_post_meta($post_id, '_pending_phone', '');

        update_post_meta($post_id, '_pending_email', '');
        update_post_meta($post_id, '_pending_website', '');
    } else  if (isset($_GET['approve_listing']) && $_GET['approve_listing'] == 'true') {
        $post_id = $_GET['post'];
        $args['ID'] = $post_id;
        wp_update_post(array(
            'ID' => $post_id,
            'post_status' => 'publish',
        ));
    }
}
add_action('load-post.php', 'my_admin_edit_post_function');


function notify_admin_on_member_directory_update($post_id, $new = false)
{
    $ultimate_member_options = get_option('um_options');
    if (isset($ultimate_member_options['admin_email'])) {
        $admin_email = $ultimate_member_options['admin_email'];
    }

    $user_info = get_userdata(get_current_user_id());
    $username = $user_info->user_login;
    if ($username) {
        $changes_html = '';

        $_pending_title = get_post_meta($post_id, '_pending_title', true);
        $_pending_description = get_post_meta($post_id, '_pending_description', true);
        $_pending_phone = get_post_meta($post_id, '_pending_phone', true);
        $_pending_email = get_post_meta($post_id, '_pending_email', true);
        $_pending_website = get_post_meta($post_id, '_pending_website', true);


        if ($new == true) {
            $subject = sprintf('[%s] A user has submitted a member directory entry.', get_bloginfo('name'));
            $message = sprintf('%s has submitted their directory details - %s.', $username, get_the_title($post_id)) . "\r\n\r\n";
            $button_url = 'https://portal.medilinkmidlands.com/wp-admin/post.php?post=' . $post_id . '&action=edit&approve_listing=true';
        } else {
            $subject = sprintf('[%s] User Member Directory Updated', get_bloginfo('name'));
            $message = sprintf('%s updated their directory details - %s.', $username, get_the_title($post_id)) . "\r\n\r\n";
            $button_url = 'https://portal.medilinkmidlands.com/wp-admin/post.php?post=' . $post_id . '&action=edit&approve_changes=true';
        }


        if ($new == true) {
            $current_title = get_the_title($post_id);
            $changes_html .= "<tr>";
            $changes_html .= "<td style='padding: 10px; text-align: left; font-weight: 400'><b>Organisation</b></td>";
            $changes_html .= "<td style='padding: 10px; text-align: left; font-weight: 400'>$current_title</td>";
            $changes_html .= "</tr>";

            $current_content = get_the_content(NULL, false, $post_id);
            $changes_html .= "<tr>";
            $changes_html .= "<td style='padding: 10px; text-align: left; font-weight: 400'><b>Description</b></td>";
            $changes_html .= "<td style='padding: 10px; text-align: left; font-weight: 400'>$current_content</td>";
            $changes_html .= "</tr>";

            $wpsl_phone = get_post_meta($post_id, 'wpsl_phone', true);
            $changes_html .= "<tr>";
            $changes_html .= "<td style='padding: 10px; text-align: left; font-weight: 400'><b>Phone</b></td>";
            $changes_html .= "<td style='padding: 10px; text-align: left; font-weight: 400'>$wpsl_phone</td>";
            $changes_html .= "</tr>";

            $wpsl_email = get_post_meta($post_id, 'wpsl_email', true);
            $changes_html .= "<tr>";
            $changes_html .= "<td style='padding: 10px; text-align: left; font-weight: 400'><b>Email</b></td>";
            $changes_html .= "<td style='padding: 10px; text-align: left; font-weight: 400'>$wpsl_email</td>";
            $changes_html .= "</tr>";

            $wpsl_url = get_post_meta($post_id, 'wpsl_url', true);
            $changes_html .= "<tr>";
            $changes_html .= "<td style='padding: 10px; text-align: left; font-weight: 400'><b>Website</b></td>";
            $changes_html .= "<td style='padding: 10px; text-align: left; font-weight: 400'>$wpsl_url</td>";
            $changes_html .= "</tr>";

            if ($changes_html != '') {
                $email_html = "<table style='width: 100%'>";
                $email_html .= "<tr><th style='padding: 10px; text-align: left'>Label</th><th style='padding: 10px; text-align: left'>Value</th></tr>";
                $email_html .= $changes_html;
                $email_html .= '<tr><td colspan="3" style="padding-top: 30px"><div style="padding: 10px 0 50px 0; text-align: center;" data-mce-style="padding: 10px 0 50px 0; text-align: center;"><a href="' . $button_url . '"  style="background: #555555; color: #fff; padding: 12px 30px; text-decoration: none; border-radius: 3px; letter-spacing: 0.3px;" data-mce-style="background: #555555; color: #fff; padding: 12px 30px; text-decoration: none; border-radius: 3px; letter-spacing: 0.3px;" data-mce-selected="inline-boundary">Approve Directory Listing</a></div></td></tr>';
                $email_html .= "</table>";
            }
        } else {
            if ($_pending_title) {
                $current_title = get_the_title($post_id);
                $changes_html .= "<tr>";
                $changes_html .= "<td style='padding: 10px; text-align: left; font-weight: 400'><b>Organisation</b></td>";
                $changes_html .= "<td style='padding: 10px; text-align: left; font-weight: 400'>$current_title</td>";
                $changes_html .= "<td style='padding: 10px; text-align: left; font-weight: 400'>$_pending_title</td>";
                $changes_html .= "</tr>";
            }
            if ($_pending_description) {
                $current_content = get_the_content(NULL, false, $post_id);
                $changes_html .= "<tr>";
                $changes_html .= "<td style='padding: 10px; text-align: left; font-weight: 400'><b>Description</b></td>";
                $changes_html .= "<td style='padding: 10px; text-align: left; font-weight: 400'>$current_content</td>";
                $changes_html .= "<td style='padding: 10px; text-align: left; font-weight: 400'>$_pending_description</td>";
                $changes_html .= "</tr>";
            }

            if ($_pending_phone) {
                $wpsl_phone = get_post_meta($post_id, 'wpsl_phone', true);
                $changes_html .= "<tr>";
                $changes_html .= "<td style='padding: 10px; text-align: left; font-weight: 400'><b>Phone</b></td>";
                $changes_html .= "<td style='padding: 10px; text-align: left; font-weight: 400'>$wpsl_phone</td>";
                $changes_html .= "<td style='padding: 10px; text-align: left; font-weight: 400'>$_pending_phone</td>";
                $changes_html .= "</tr>";
            }
            if ($_pending_email) {
                $wpsl_email = get_post_meta($post_id, 'wpsl_email', true);
                $changes_html .= "<tr>";
                $changes_html .= "<td style='padding: 10px; text-align: left; font-weight: 400'><b>Email</b></td>";
                $changes_html .= "<td style='padding: 10px; text-align: left; font-weight: 400'>$wpsl_email</td>";
                $changes_html .= "<td style='padding: 10px; text-align: left; font-weight: 400'>$_pending_email</td>";
                $changes_html .= "</tr>";
            }
            if ($_pending_website) {
                $wpsl_url = get_post_meta($post_id, 'wpsl_url', true);
                $changes_html .= "<tr>";
                $changes_html .= "<td style='padding: 10px; text-align: left; font-weight: 400'><b>Website</b></td>";
                $changes_html .= "<td style='padding: 10px; text-align: left; font-weight: 400'>$wpsl_url</td>";
                $changes_html .= "<td style='padding: 10px; text-align: left; font-weight: 400'>$_pending_website</td>";
                $changes_html .= "</tr>";
            }

            if ($changes_html != '') {
                $email_html = "<table style='width: 100%'>";
                $email_html .= "<tr><th style='padding: 10px; text-align: left'>Label</th><th style='padding: 10px; text-align: left'>Current Value</th><th style='padding: 10px; text-align: left'>New Value</th></tr>";
                $email_html .= $changes_html;
                $email_html .= '<tr><td colspan="3" style="padding-top: 30px"><div style="padding: 10px 0 50px 0; text-align: center;" data-mce-style="padding: 10px 0 50px 0; text-align: center;"><a href="' . $button_url . '"  style="background: #555555; color: #fff; padding: 12px 30px; text-decoration: none; border-radius: 3px; letter-spacing: 0.3px;" data-mce-style="background: #555555; color: #fff; padding: 12px 30px; text-decoration: none; border-radius: 3px; letter-spacing: 0.3px;" data-mce-selected="inline-boundary">Approve Changes</a></div></td></tr>';
                $email_html .= "</table>";
            }
        }


        $headers = 'Content-Type: text/html; charset=UTF-8';
        wp_mail($admin_email, $subject, email_template($username, $email_html, '700px', $message), $headers);
    }
}

function update_first_letter_meta( $post_id ) {
    // Check if it's a 'wpsl_stores' post type.  Important to prevent errors.
    if ( get_post_type( $post_id ) === 'wpsl_stores' ) {
        // Get the post title.
        $post_title = get_the_title( $post_id );

        // Extract the first letter.
        $first_letter = strtoupper( substr( $post_title, 0, 1 ) ); // Make it uppercase

        // Update the post meta.
        update_post_meta( $post_id, 'first_letter', $first_letter );
    }
}

// Hook the function to 'save_post' to catch both new and updated posts.
add_action( 'post_updated', 'update_first_letter_meta' );

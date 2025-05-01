<?php
function featured_articles()
{
    ob_start();
    $posts = get_posts(array(
        'post_type'  => 'post',
        'numberpost' => 3,
        'category'   => 95
    ));
?>
    <div class="title-subtile-holder wow bounce text_left" style="animation-name: bounce; margin-bottom: 35px">
        <h2 class="section-title light_title">Featured Articles</h2>
    </div>
    <?= post__grid($posts) ?>
    <?php if (!is_home()) { ?>
        <div class="text-center modeltheme_button wow bounce" style="animation-name: bounce; margin-top: 40px"><a
                href="<?= get_site_url() ?>/latest-articles/" class="button-winona button-green btn btn-sm">VIEW
                ALL</a></div>

    <?php } ?>
<?php
    return ob_get_clean();
}

add_shortcode('featured_articles', 'featured_articles');



function testimonials()
{
    ob_start();
    $posts = get_posts(array(
        'post_type'  => 'testimonial',
        'numberpost' => 10,
    ));
?>
    <div class="testimonial-slider">
        <div class="testimonial-wrapper">
            <div class="swiper swiper-testimonial">
                <div class="swiper-wrapper">
                    <?php foreach ($posts as $post) { ?>
                        <div class="swiper-slide">
                            <div class="inner">
                                <div class="testimonial-content">
                                    <?= wpautop($post->post_content) ?>
                                </div>
                                <div class="testimonial-author">
                                    <div class="name-title">
                                        <h4><?= $post->post_title ?></h4>
                                        <div class="position"><?= get_post_meta($post->ID, 'job-position', true) ?></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
                <div class="swiper-navigation">
                    <div class="swiper-button-next"></div>
                    <div class="swiper-button-prev"></div>
                </div>
            </div>

        </div>
    </div>
    <script>
        var swiper = new Swiper(".swiper-testimonial", {
            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev",
            },
            breakpoints: {
                0: {
                    slidesPerView: 1,
                },
                768: {
                    slidesPerView: 2,
                },

            },
        });
    </script>
<?php
    return ob_get_clean();
}
add_shortcode('testimonials', 'testimonials');

function join_us_old()
{
    ob_start();
    $plans = get_posts(array(
        'post_type'   => 'umm_stripe',
        'numberposts' => -1,
    ));
?>
    <div class="packages">
        <div class="row row-flex">
            <?php for ($x = 1; $x <= 6; $x++) { ?>
                <?php foreach ($plans as $plan) { ?>
                    <?php
                    $short_description = get_post_meta($plan->ID, 'short_description', true);
                    $core_benefits = get_post_meta($plan->ID, 'core_benefits', true);
                    $core_benefits_title = get_post_meta($plan->ID, 'core_benefits_title', true);
                    $additional_benefits = get_post_meta($plan->ID, 'additional_benefits', true);
                    $discounts = get_post_meta($plan->ID, 'discounts', true);
                    ?>
                    <div class="col-lg-2">
                        <div class="inner">
                            <div class="package-title">
                                <h3><?= $plan->post_title ?></h3>
                            </div>
                            <div class="package-desc">
                                <?= wpautop($short_description) ?>
                            </div>
                            <div class="package-price">
                                <div class="price-inner">
                                    <span class="currency">£</span><span class="price-val">275</span>
                                </div>
                                <span class="month"> Annual Payment</span>
                            </div>
                            <div class="benefits">
                                <div class="benefits-inner">
                                    <div class="div-title"><strong><?= $core_benefits_title ?></strong></div>
                                    <div class="benefits checklist">
                                        <?= wpautop($core_benefits) ?>
                                    </div>

                                </div>
                                <div class="addition-benefits-inner">
                                    <div class="div-title"><strong>Additional Benefits</strong></div>
                                    <div class="benefits checklist">
                                        <?= wpautop($core_benefits) ?>
                                    </div>
                                </div>
                            </div>
                            <div class="discounts">
                                <div class="discounts-inner checklist">
                                    <div class="div-title"><strong>Discounts</strong></div>
                                    <?= wpautop($discounts) ?>
                                </div>
                            </div>

                            <div class="text-center modeltheme_button wow bounce" style="animation-name: bounce; margin-top: 40px">
                                <a href="#" class="button-winona button-green btn btn-sm">GET STARTED</a>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            <?php } ?>
        </div>
    </div>
<?php
    return ob_get_clean();
}

function join_us()
{
    ob_start();

    $plans = carbon_get_theme_option('packages');

?>
    <div class="packages">
        <div class="row row-flex">
            <?php foreach ($plans as $plan) { ?>
                <?php
                $package_name = $plan['package_name'];
                $short_description = $plan['package_short_description'];
                $core_benefits = $plan['package_core_benefits'];
                $core_benefits_title = $plan['package_core_benefits_title'];
                $additional_benefits = $plan['package_additional_benefits'];
                $discounts = $plan['package_discounts'];
                $package_member_level = $plan['package_member_level'];
                $package_price = $plan['package_price'];
                ?>
                <div class="col-lg-2">
                    <div class="inner">
                        <div class="top">
                            <div class="package-main-details">
                                <div class="package-price-main-details-inner">
                                    <div class="package-price-desc">
                                        <div class="package-title">
                                            <h3><?= $package_name ?></h3>
                                        </div>
                                        <div class="package-desc">
                                            <?= wpautop($short_description) ?>
                                        </div>
                                    </div>
                                    <div class="package-price">
                                        <div class="price-inner">
                                            <?php if ($package_price) { ?>
                                                <span class="currency">£</span><span class="price-val"><?= $package_price ?></span>
                                            <?php } else { ?>
                                                <span class="price-val">No Fee</span>
                                            <?php } ?>

                                        </div>
                                        <?php if ($package_price) { ?>
                                            <span class="month"> Annual Payment</span>
                                        <?php } ?>
                                    </div>
                                </div>
                                <div class="benefits">
                                    <?php if ($core_benefits || $core_benefits_title) { ?>
                                        <div class="benefits-inner">
                                            <div class="div-title"><strong><?= $core_benefits_title ?></strong></div>
                                            <?php if ($core_benefits) { ?>

                                                <div class="benefits checklist">
                                                    <?= wpautop($core_benefits) ?>
                                                </div>
                                            <?php } ?>
                                        </div>
                                    <?php } ?>


                                </div>
                            </div>


                            <div class="learn-more">
                                <a href="#">Learn More</a>
                            </div>
                        </div>
                        <div class="bottom">
                            <?php if ($additional_benefits) { ?>
                                <div class="addition-benefits-inner">
                                    <div class="div-title"><strong>Additional Benefits</strong></div>
                                    <div class="benefits checklist">
                                        <?= wpautop($additional_benefits) ?>
                                    </div>
                                </div>
                            <?php } ?>
                            <div class="discounts">
                                <div class="discounts-inner checklist">
                                    <div class="div-title"><strong>Discounts</strong></div>
                                    <?= wpautop($discounts) ?>
                                </div>
                            </div>
                            <?php if ($package_member_level) { ?>
                                <div class="member-level">
                                    <div class="div-title"><strong><?= $package_member_level ?></strong></div>
                                </div>
                            <?php } ?>


                            <div class="text-center modeltheme_button wow bounce"
                                style="animation-name: bounce; margin-top: 40px"><a
                                    href="https://www.medilinkmidlands.com/online-membership-form/"
                                    class="button-winona button-green btn btn-sm">GET STARTED</a></div>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
<?php
    return ob_get_clean();
}

add_shortcode('join_us', 'join_us');

function member_marketplace_form()
{
    ob_start();
?>
    <div class="member-marketplace-form box-shadow-style" id="member-marketplace-form">
        <div class="container">
            <div class="inner">
                <div class="heading-title-desc mt-0 mb-4">
                    <h2><?= carbon_get_theme_option('member_marketplace_form_heading') ?></h2>
                    <?= do_shortcode(wpautop(carbon_get_theme_option('member_marketplace_form_description'))) ?>
                </div>
                <br><br>
                <?php if (is_user_logged_in()) { ?>
                    <?= do_shortcode('[contact-form-7 id="af104d5" title="Submit an Offer"]') ?>
                <?php } else { ?>
                    <div class="login-notice">
                        <div class="inner">
                            <p>
                                Please login before you can submit.
                            </p>
                        </div>
                    </div>
                <?php } ?>
            </div>

        </div>
    </div>
<?php
    return ob_get_clean();
}
add_shortcode('member_marketplace_form', 'member_marketplace_form');


function submit_blog_form()
{
    ob_start();
?>
    <div class="member-marketplace-form box-shadow-style" id="member-marketplace-form">
        <div class="container">
            <div class="inner">
                <h2>Submit an Article</h2>
                <?php if (is_user_logged_in()) { ?>
                    <?= do_shortcode('[contact-form-7 id="83cfac2" title="Submit a Blog"]') ?>
                <?php } else { ?>
                    <div class="login-notice">
                        <div class="inner">
                            <p>
                                Please login before you can submit.
                            </p>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
<?php
    return ob_get_clean();
}


function submit_blog_form_no_login()
{
    ob_start();
?>
    <div class="member-marketplace-form box-shadow-style" id="member-marketplace-form">
        <div class="container">
            <div class="inner">
                <h2>Submit an Article</h2>
                <?= do_shortcode('[contact-form-7 id="83cfac2" title="Submit a Blog"]') ?>
            </div>
        </div>
    </div>
<?php
    return ob_get_clean();
}
add_shortcode('submit_blog_form', 'submit_blog_form');



function user_field($atts)
{
    extract(
        shortcode_atts(
            array(
                'key'       => '',
                'author_id' => 'current',
            ),
            $atts
        )
    );

    if ($author_id == 'current') {
        $user_id = get_current_user_id();
    } else {
        $user_id = $author_id;
    }
    if ($key == 'user_email') {
        $user_info = get_userdata($user_id);
        return $user_info->user_email;
    } else if ($key == 'first_and_last_name') {
        $first_name = get_user_meta($user_id, 'first_name', true);
        $last_name = get_user_meta($user_id, 'last_name', true);
        return $first_name . ' ' . $last_name;
    } else if ($key == 'user_id') {
        return $user_id;
    } else if ($key == 'first_name') {
        return get_user_meta($user_id, 'first_name', true);
    } else if ($key == 'last_name') {
        return get_user_meta($user_id, 'last_name', true);
    } else {
        return get_user_meta($user_id, $key, true);
    }
}
add_shortcode('user_field', 'user_field');

function claim_offer_form($atts)
{
    ob_start();
    extract(
        shortcode_atts(
            array(
                'is_single' => 0,
            ),
            $atts
        )
    );
    if ($is_single) {
        $image_url = get_the_post_thumbnail_url(get_the_ID());
    }
?>
    <div class="claim-offer-form">
        <div class="row row-flex">
            <div class="col-md-6">
                <div class="post-box">
                    <div class="top">
                        <div class="image-box offer-image">
                            <img src="<?= $image_url ?>" alt="">
                        </div>
                        <p class="offer-author"></p>
                        <h3 class="offer-title"></h3>
                        <div class="offer-details"></div>
                    </div>

                </div>
            </div>
            <div class="col-md-6">
                <?php
                if (is_user_logged_in()) {
                    echo do_shortcode('[contact-form-7 id="6c2d6fd" title="Claim Offer Form"]');
                } else {
                    echo '<div class="login-notice">
                        <div class="inner">
                            <p> Please login before you can claim an offer. </p>
                        </div>
                    </div>';
                }
                ?>
            </div>
            <div class="col-lg-12 supporting-documents">

            </div>
        </div>
    </div>
    <script>
        jQuery(document).ready(function() {

            jQuery("body").on("click", ".modal-window__close", function() {
                jQuery('body').removeClass('modal-window-active');
                console.log('xsds');
            });
        });
    </script>
<?php

    return ob_get_clean();
}

add_shortcode('claim_offer_form', 'claim_offer_form');


function member_directory()
{
    ob_start();
    $args = array(
        'post_status' => 'publish',
        'post_type'   => 'wpsl_stores',
        'numberposts' => 10,
        'orderby'     => 'title',
        'order'       => 'ASC'
    );
    $the_query = new WP_Query($args);
    $filters = array("1-9", "A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R", "S", "T", "U", "V", "W", "Y", "Z");
?>

    <div class="membership-directory ajax-result">
        <div class="row row-flex">
            <div class="col-lg-3">
                <div class="member-directory-filters-holder">
                    <div class="filter-title">Member Profile Filter</div>
                    <div class="member-directory-search">
                        <input type="text" placeholder="Search..." name="search_var">
                    </div>
                    <div class="member-directory-filters">
                        <?php foreach ($filters as $filter) { ?>
                            <div class="member-directory-filter">
                                <label><input value="<?= $filter ?>" type="checkbox"
                                        name="directory-filter[]"><span><?= $filter ?></span></label>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="member-directory-filter-submit">
                        <div class="modeltheme_button view-all">
                            <a href="#" class="button-winona button-green btn btn-sm submit-directory-filter">
                                Search
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-9">
                <div class="listings">
                    <div id="results">
                        <div class="row row-flex">
                            <?php if ($the_query->have_posts()) { ?>
                                <?php while ($the_query->have_posts()) { ?>
                                    <?php
                                    $the_query->the_post();
                                    echo membership_listing();
                                    ?>
                                <?php } ?>
                                <?php wp_reset_postdata() ?>
                            <?php } ?>
                        </div>
                    </div>
                </div>
                <div class="loader"><span class="wpcf7-spinner"></span></div>

                <div class="modeltheme_button load-more-holder">
                    <a href="#" class="button-winona button-green btn btn-sm load-more-directory">
                        Load More
                    </a>
                </div>
            </div>
        </div>
    </div>

<?php
    return ob_get_clean();
}

add_shortcode('member_directory', 'member_directory');



function offer_category()
{
    $terms = get_terms(array(
        'taxonomy'   => 'membersmarketplace_category',
        'hide_empty' => false,
    ));
    $select = '<select name="offer_category_pseudo[]" id="offer_category_pseudo" multiple>';
    $select .= '<option>Select Category</option>';
    foreach ($terms as $term) {
        $select .= '<option value="' . $term->term_id . '">';
        $select .= $term->name;
        $select .= '</option>';
    }
    $select .= '</select>';
    return $select;
}
add_shortcode('offer_category', 'offer_category');

function blog_category()
{
    $terms = get_terms(array(
        'taxonomy'   => 'category',
        'hide_empty' => false,
    ));
    $select = '<select name="blog_category_pseudo[]" id="blog_category_pseudo" multiple>';
    $select .= '<option>Select Category</option>';
    foreach ($terms as $term) {
        $select .= '<option value="' . $term->term_id . '">';
        $select .= $term->name;
        $select .= '</option>';
    }
    $select .= '</select>';
    return $select;
}
add_shortcode('blog_category', 'blog_category');

/*
function blog_category()
{
    $terms = get_terms(array(
        'taxonomy'   => 'category',
        'hide_empty' => false,
    ));
    $select = '<option>Select Category</option>';
    foreach ($terms as $term) {
        $select .= '<option value="' . $term->term_id . '">';
        //$select[$term->term_id] = $term->name;
        $select .= $term->name;
        $select .= '</option>';
    }

    return $select;
}
add_shortcode('blog_category', 'blog_category');
*/
function template($atts)
{
    extract(
        shortcode_atts(
            array(
                'template_id' => '',
            ),
            $atts
        )
    );

    $style = '<style type="text/css" data-type="vc_shortcodes-custom-css"> ' . get_post_meta($template_id, '_wpb_shortcodes_custom_css', true) . ' </style>';

    $content_post = get_post($template_id);
    $content = $content_post->post_content;
    $content = apply_filters('the_content', $content);
    $content = str_replace(']]>', ']]&gt;', $content);

    return $style . $content;
}

add_shortcode('template', 'template');


function auto_renewal()
{
    ob_start();
?>
    <div class="auto-renewal-information wow-modal-id-2">
        <span class="text">Auto Renewal Information</span>
        <span class="icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-question-circle"
                viewBox="0 0 16 16">
                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16" />
                <path
                    d="M5.255 5.786a.237.237 0 0 0 .241.247h.825c.138 0 .248-.113.266-.25.09-.656.54-1.134 1.342-1.134.686 0 1.314.343 1.314 1.168 0 .635-.374.927-.965 1.371-.673.489-1.206 1.06-1.168 1.987l.003.217a.25.25 0 0 0 .25.246h.811a.25.25 0 0 0 .25-.25v-.105c0-.718.273-.927 1.01-1.486.609-.463 1.244-.977 1.244-2.056 0-1.511-1.276-2.241-2.673-2.241-1.267 0-2.655.59-2.75 2.286m1.557 5.763c0 .533.425.927 1.01.927.609 0 1.028-.394 1.028-.927 0-.552-.42-.94-1.029-.94-.584 0-1.009.388-1.009.94" />
            </svg>
        </span>
    </div>
<?php
    return ob_get_clean();
}
add_shortcode('auto_renewal', 'auto_renewal');

function cb_value($post_id, $name)
{
    $meta = carbon_get_post_meta($post_id, $name);
    if ($meta) {
        return $meta;
    } else {
        return '';
    }
}

function join_us_v2()
{
    ob_start();

    $taxonomy = 'packages_category';
    $packages = get_posts(array(
        'post_type'   => 'packages',
        'numberposts' => -1,
    ));
    $packages_benefits = get_terms(array(
        'taxonomy'   => $taxonomy,
        'hide_empty' => false,
        'parent'     => 113,
        'order'      => 'ASC',

    ));
    $packages_members_only = get_terms(array(
        'taxonomy'   => $taxonomy,
        'hide_empty' => false,
        'parent'     => 187,
        'order'      => 'ASC',

    ));
    $patrons = get_terms(array(
        'taxonomy'   => $taxonomy,
        'hide_empty' => false,
        'parent'     => 164,
        'order'      => 'ASC',

    ));

    $packages_marketing = get_terms(array(
        'taxonomy'   => $taxonomy,
        'hide_empty' => false,
        'parent'     => 134,
        'order'      => 'ASC',
    ));


    $discounts = get_terms(array(
        'taxonomy'   => $taxonomy,
        'hide_empty' => false,
        'parent'     => 172,
        'order'      => 'ASC',
    ));

    $benefits_title = get_term_by('term_id', 113, 'packages_category')->name;
    $members_only_title = get_term_by('term_id', 187, 'packages_category')->name;
    $discounts_title = get_term_by('term_id', 172, 'packages_category')->name;
    $marketing_title = get_term_by('term_id', 134, 'packages_category')->name;
    $patron_title = get_term_by('term_id', 164, 'packages_category')->name;

?>
    <div class="join-us-v2">
        <table>
            <thead>
                <tr class="top-row">
                    <th style="width: 20%" class="no-border no-bg">

                    </th>
                    <?php foreach ($packages as $package) { ?>
                        <?php
                        $price = carbon_get_post_meta($package->ID, 'price');
                        ?>
                        <th class="text-center package-title-th">
                            <div class="package-title-holder">
                                <?= $package->post_title ?>
                            </div>
                            <div class="price">
                                <div class="price-text">
                                    <?= $price ?>
                                </div>
                                <div class="per">
                                    Annually
                                </div>
                                <div class="text-center modeltheme_button wow bounce">
                                    <a href="/online-membership-form/" class="button-winona button-green btn btn-sm">GET
                                        STARTED</a>
                                </div>
                            </div>
                            <div class="excerpt">
                                <?= $package->post_excerpt ?>
                            </div>
                        </th>
                    <?php } ?>
                </tr>
            </thead>
            <tbody>

                <!-- benefits-->
                <tr class="top-left-first">
                    <td class="title-data" colspan="<?= count($packages) + 1 ?>">
                        <?= $benefits_title ?>
                    </td>
                </tr>

                <?php foreach ($packages_benefits as $benefits) { ?>
                    <tr>
                        <td>
                            <?= $benefits->name ?>
                        </td>
                        <?php foreach ($packages as $package) { ?>
                            <?php
                            $class = '';
                            $taxonomy_terms_custom_text = carbon_get_post_meta($package->ID, 'taxonomy_terms_custom_text');
                            $taxonomy_terms_custom_text_array = [];
                            foreach ($taxonomy_terms_custom_text as $custom_text) {
                                $taxonomy_terms_custom_text_array[$custom_text['term_slug']] = $custom_text['custom_text'];
                            }

                            if (has_term($benefits->slug, $taxonomy, $package->ID)) {
                                $class = 'tick-active';
                            }
                            if (isset($taxonomy_terms_custom_text_array[$benefits->slug])) {
                                $text = $taxonomy_terms_custom_text_array[$benefits->slug];
                                $class = '';
                            } else {
                                $text = '<span></span>';
                            }
                            ?>
                            <td class="tick <?= $class ?>">
                                <?= $text ?>
                            </td>
                        <?php } ?>
                    </tr>
                <?php } ?>

                <!-- end of benefits-->

                <!-- Discounts-->
                <tr>
                    <td class="title-data" colspan="<?= count($packages) + 1 ?>">
                        <?= $discounts_title ?>
                    </td>
                </tr>

                <?php foreach ($discounts as $discount) { ?>
                    <tr>
                        <td>
                            <?= $discount->name ?>
                        </td>
                        <?php foreach ($packages as $package) { ?>
                            <?php
                            $class = '';

                            $taxonomy_terms_custom_text = carbon_get_post_meta($package->ID, 'taxonomy_terms_custom_text');
                            $taxonomy_terms_custom_text_array = [];
                            foreach ($taxonomy_terms_custom_text as $custom_text) {
                                $taxonomy_terms_custom_text_array[$custom_text['term_slug']] = $custom_text['custom_text'];
                            }


                            if (has_term($discount->slug, $taxonomy, $package->ID)) {
                                $class = 'tick-active';
                            }
                            if (isset($taxonomy_terms_custom_text_array[$discount->slug])) {
                                $text = $taxonomy_terms_custom_text_array[$discount->slug];
                                $class = '';
                            } else {
                                $text = '<span></span>';
                            }
                            ?>
                            <td class="tick <?= $class ?>">
                                <?= $text ?>
                            </td>
                        <?php } ?>
                    </tr>
                <?php } ?>

                <!-- end of Discounts-->

                <!-- memebers only-->
                <tr>
                    <td class="title-data" colspan="<?= count($packages) + 1 ?>">
                        <?= $members_only_title ?>
                    </td>
                </tr>


                <?php foreach ($packages_members_only as $members_only) { ?>
                    <tr>
                        <td>
                            <?= $members_only->name ?>
                        </td>
                        <?php foreach ($packages as $package) { ?>
                            <?php
                            $class = '';

                            $taxonomy_terms_custom_text = carbon_get_post_meta($package->ID, 'taxonomy_terms_custom_text');
                            $taxonomy_terms_custom_text_array = [];
                            foreach ($taxonomy_terms_custom_text as $custom_text) {
                                $taxonomy_terms_custom_text_array[$custom_text['term_slug']] = $custom_text['custom_text'];
                            }

                            if (has_term($members_only->slug, $taxonomy, $package->ID)) {
                                $class = 'tick-active';
                            }
                            if (isset($taxonomy_terms_custom_text_array[$members_only->slug])) {
                                $text = $taxonomy_terms_custom_text_array[$members_only->slug];
                                $class = '';
                            } else {
                                $text = '<span></span>';
                            }
                            ?>
                            <td class="tick <?= $class ?>">
                                <?= $text ?>
                            </td>
                        <?php } ?>
                    </tr>
                <?php } ?>

                <!-- end of memebers only-->

                <!-- patrons -->
                <tr>
                    <td class="title-data" colspan="<?= count($packages) + 1 ?>">
                        <?= $patron_title ?>
                    </td>
                </tr>


                <?php foreach ($patrons as $patron) { ?>
                    <tr>
                        <td>
                            <?= $patron->name ?>
                        </td>
                        <?php foreach ($packages as $package) { ?>
                            <?php
                            $class = '';

                            $taxonomy_terms_custom_text = carbon_get_post_meta($package->ID, 'taxonomy_terms_custom_text');
                            $taxonomy_terms_custom_text_array = [];
                            foreach ($taxonomy_terms_custom_text as $custom_text) {
                                $taxonomy_terms_custom_text_array[$custom_text['term_slug']] = $custom_text['custom_text'];
                            }


                            if (has_term($patron->slug, $taxonomy, $package->ID)) {
                                $class = 'tick-active';
                            }
                            if (isset($taxonomy_terms_custom_text_array[$patron->slug])) {
                                $text = $taxonomy_terms_custom_text_array[$patron->slug];
                                $class = '';
                            } else {
                                $text = '<span></span>';
                            }
                            ?>
                            <td class="tick <?= $class ?>">
                                <?= $text ?>
                            </td>
                        <?php } ?>
                    </tr>
                <?php } ?>

                <!-- end of patrons-->





                <!-- marketing-->

                <tr>
                    <td class="title-data">
                        <strong><?= $marketing_title ?></strong>
                    </td>
                    <?php foreach ($packages as $package) { ?>
                        <?php
                        $marketing_level = cb_value($package->ID, 'marketing_level');
                        $marketing_level_custom_text = cb_value($package->ID, 'marketing_level_custom_text');
                        if ($marketing_level_custom_text) {
                            $marketing_text = $marketing_level_custom_text;
                        } else {
                            $marketing_text = $marketing_level;
                        }
                        ?>
                        <td class="text-center bg-orange">
                            <span><?= $marketing_text ?></span>
                        </td>
                    <?php } ?>
                </tr>

                <?php foreach ($packages_marketing as $marketing) { ?>
                    <tr>
                        <td>
                            <?= $marketing->name ?>
                        </td>
                        <?php foreach ($packages as $package) { ?>
                            <?php
                            $class = '';
                            $taxonomy_terms_custom_text = carbon_get_post_meta($package->ID, 'taxonomy_terms_custom_text');
                            $taxonomy_terms_custom_text_array = [];

                            foreach ($taxonomy_terms_custom_text as $custom_text) {
                                $taxonomy_terms_custom_text_array[$custom_text['term_slug']] = $custom_text['custom_text'];
                            }
                            if (has_term($marketing->slug, $taxonomy, $package->ID)) {
                                $class = 'tick-active';
                            }
                            if (isset($taxonomy_terms_custom_text_array[$marketing->slug])) {
                                $text = $taxonomy_terms_custom_text_array[$marketing->slug];
                                $class = '';
                            } else {
                                $text = '<span></span>';
                            }
                            ?>
                            <td class="tick <?= $class ?>">
                                <?= $text ?>
                            </td>
                        <?php } ?>
                    </tr>
                <?php } ?>
                <!-- end of marketing-->


            </tbody>
        </table>
    </div>
    <div class="join-us-mobile">
        <div class="package-mobile-holder">
            <?php foreach ($packages as $package) { ?>
                <?php
                $taxonomy_terms_custom_text = carbon_get_post_meta($package->ID, 'taxonomy_terms_custom_text');
                $taxonomy_terms_custom_text_array = [];
                foreach ($taxonomy_terms_custom_text as $custom_text) {
                    $taxonomy_terms_custom_text_array[$custom_text['term_slug']] = $custom_text['custom_text'];
                }
                $price = carbon_get_post_meta($package->ID, 'price');

                ?>
                <div class="package-mobile-item" id="package-mobile-<?= $package->ID ?>">
                    <div class="package-title-price">
                        <div class="package-title">
                            <?= $package->post_title ?>
                        </div>
                        <div class="price">
                            <div class="price-text">
                                <?= $price ?>
                            </div>
                            <div class="per">
                                Annually
                            </div>
                        </div>
                        <div class="excerpt">
                            <?= $package->post_excerpt ?>
                        </div>
                        <div class="text-center modeltheme_button wow bounce">
                            <a href="/online-membership-form/" class="button-winona button-green btn btn-sm">GET STARTED</a>
                        </div>
                    </div>
                    <?php $term_val = ''; ?>
                    <div class="features-mobile-holder">
                        <div class="feature feature-benefits">
                            <div class="feature-title">
                                <?= $benefits_title ?>
                            </div>
                            <ul class="checklist-ul">
                                <?php foreach ($packages_benefits as $benefits) { ?>
                                    <?php

                                    if (isset($taxonomy_terms_custom_text_array[$benefits->slug])) {
                                        $text = $taxonomy_terms_custom_text_array[$benefits->slug];
                                    } else {
                                        $text = false;
                                    }

                                    if ($text && $text != '&nbsp;') {
                                        $name = $benefits->name;
                                        echo "<li><span><strong>$name: </strong>$text</li>";
                                        $term_val .= 'has_term';
                                    } else {
                                        if (has_term($benefits->slug, $taxonomy, $package->ID)) {
                                            $text = $benefits->name;
                                            $term_val .= 'has_term';
                                            echo "<li>$text</li>";
                                        }
                                    }
                                    if (!str_contains($term_val, 'has_term')) {
                                        echo '<style> #package-mobile-' . $package->ID . ' .feature-benefits { display: none } </style>';
                                    }
                                    ?>
                                <?php } ?>
                            </ul>
                        </div>
                        <?php $term_val = ''; ?>
                        <div class="feature feature-member-only">
                            <div class="feature-title">
                                <?= $members_only_title ?>
                            </div>
                            <ul class="checklist-ul">
                                <?php foreach ($packages_members_only as $members_only) { ?>
                                    <?php

                                    if (isset($taxonomy_terms_custom_text_array[$members_only->slug])) {
                                        $text = $taxonomy_terms_custom_text_array[$members_only->slug];
                                    } else {
                                        $text = false;
                                    }

                                    if ($text && $text != '&nbsp;') {
                                        $name = $members_only->name;
                                        echo "<li><span><strong>$name: </strong>$text</li>";
                                        $term_val .= 'has_term';
                                    } else {
                                        if (has_term($members_only->slug, $taxonomy, $package->ID)) {
                                            $text = $members_only->name;
                                            echo "<li>$text</li>";
                                        }
                                    }

                                    ?>
                                <?php } ?>
                                <?php
                                if (!str_contains($term_val, 'has_term')) {
                                    echo '<style> #package-mobile-' . $package->ID . ' .feature-member-only { display: none } </style>';
                                }
                                ?>
                            </ul>
                        </div>
                        <?php $term_val = ''; ?>
                        <div class="feature feature-patrons">
                            <div class="feature-title">
                                &nbsp;
                            </div>
                            <ul class="checklist-ul">
                                <?php foreach ($patrons as $patron) { ?>
                                    <?php
                                    if (isset($taxonomy_terms_custom_text_array[$patron->slug])) {
                                        $text = $taxonomy_terms_custom_text_array[$patron->slug];
                                    } else {
                                        $text = false;
                                    }

                                    if ($text && $text != '&nbsp;') {
                                        $name = $patron->name;
                                        echo "<li><span><strong>$name: </strong>$text</li>";
                                        $term_val .= 'has_term';
                                    } else {
                                        if (has_term($patron->slug, $taxonomy, $package->ID)) {
                                            $text = $patron->name;
                                            $term_val .= 'has_term';
                                            echo "<li>$text</li>";
                                        }
                                    }
                                    ?>
                                <?php } ?>
                                <?php
                                if (!str_contains($term_val, 'has_term')) {
                                    echo '<style> #package-mobile-' . $package->ID . ' .feature-patrons { display: none } </style>';
                                }
                                ?>
                            </ul>
                        </div>
                        <?php $term_val = ''; ?>

                        <div class="feature feature-discounts">

                            <div class="feature-title">
                                <?= $discounts_title ?>
                            </div>
                            <ul class="checklist-ul">
                                <?php foreach ($discounts as $discount) { ?>
                                    <?php
                                    if (isset($taxonomy_terms_custom_text_array[$discount->slug])) {
                                        $text = $taxonomy_terms_custom_text_array[$discount->slug];
                                    } else {
                                        $text = false;
                                    }

                                    if ($text && $text != '&nbsp;') {
                                        $name = $discount->name;
                                        echo "<li><span><strong>$name: </strong>$text</li>";
                                        $term_val .= 'has_term';
                                    } else {
                                        if (has_term($discount->slug, $taxonomy, $package->ID)) {
                                            $text = $discount->name;
                                            $term_val .= 'has_term';
                                            echo "<li>$text</li>";
                                        }
                                    }
                                    ?>
                                <?php } ?>
                                <?php
                                if (!str_contains($term_val, 'has_term')) {
                                    echo '<style> #package-mobile-' . $package->ID . ' .feature-discounts { display: none } </style>';
                                }
                                ?>
                                <!-- end of Discounts-->
                            </ul>
                        </div>

                        <?php $term_val = ''; ?>

                        <?php
                        $marketing_level = cb_value($package->ID, 'marketing_level');
                        $marketing_level = cb_value($package->ID, 'marketing_level');
                        $marketing_level_custom_text = cb_value($package->ID, 'marketing_level_custom_text');
                        if ($marketing_level_custom_text) {
                            $marketing_text = $marketing_level_custom_text;
                        } else {
                            $marketing_text = $marketing_level;
                        }
                        ?>
                        <div class="feature feature-marketing">
                            <div class="feature-title">
                                <?= $marketing_title ?>: <?= $marketing_text ?>
                            </div>
                            <ul class="checklist-ul">
                                <?php foreach ($packages_marketing as $marketing) { ?>
                                    <?php

                                    if (isset($taxonomy_terms_custom_text_array[$marketing->slug])) {
                                        $text = $taxonomy_terms_custom_text_array[$marketing->slug];
                                    } else {
                                        $text = false;
                                    }

                                    if ($text && $text != '&nbsp;') {
                                        $name = $marketing->name;
                                        echo "<li><span><strong>$name: </strong>$text</span></li>";
                                        $term_val .= 'has_term';
                                    } else {
                                        if (has_term($marketing->slug, $taxonomy, $package->ID)) {
                                            $text = $marketing->name;
                                            $term_val .= 'has_term';
                                            echo "<li>$text</li>";
                                        }
                                    }

                                    ?>
                                <?php } ?>

                                <?php
                                if (!str_contains($term_val, 'has_term')) {
                                    echo '<style> #package-mobile-' . $package->ID . ' .feature-marketing { display: none } </style>';
                                }
                                ?>
                            </ul>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>

    </div>
    <?php
    return ob_get_clean();
}
add_shortcode('join_us_v2', 'join_us_v2');

function join_us_v3()
{
    if (current_user_can('administrator')) {
        ob_start();

        $taxonomy = 'packages_category';
        $packages = get_posts(array(
            'post_type'   => 'packages',
            'numberposts' => -1,
        ));
        $packages_category = get_terms(array(
            'taxonomy'   => $taxonomy,
            'hide_empty' => false,
            'parent'     => 0,
            'order'      => 'ASC',
        ));



    ?>
        <div class="join-us-v2">
            <table>
                <thead>
                    <tr class="top-row">
                        <th style="width: 20%" class="no-border no-bg">

                        </th>
                        <?php foreach ($packages as $package) { ?>
                            <?php
                            $price = carbon_get_post_meta($package->ID, 'price');
                            ?>
                            <th class="text-center package-title-th">
                                <div class="package-title-holder">
                                    <?= $package->post_title ?>
                                </div>
                                <div class="price">
                                    <div class="price-text">
                                        <?= $price ?>
                                    </div>
                                    <div class="per">
                                        Annually
                                    </div>
                                    <div class="text-center modeltheme_button wow bounce">
                                        <a href="/online-membership-form/" class="button-winona button-green btn btn-sm">GET
                                            STARTED</a>
                                    </div>
                                </div>
                                <div class="excerpt">
                                    <?= $package->post_excerpt ?>
                                </div>
                            </th>
                        <?php } ?>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($packages_category as $package_category) { ?>
                        <?php
                        $package_category_subcategories = get_terms(array(
                            'taxonomy'   => $taxonomy,
                            'hide_empty' => false,
                            'parent'     => $package_category->term_id,
                            'order'      => 'ASC',

                        ));
                        ?>

                        <!-- benefits-->
                        <tr class="top-left-first">
                            <td class="title-data"
                                colspan="<?= $package_category->slug == 'marketing' ? '' : count($packages) + 1 ?>">
                                <?= $package_category->name ?>
                            </td>
                            <?php if ($package_category->slug == 'marketing') { ?>
                                <?php foreach ($packages as $package) { ?>
                                    <?php
                                    $marketing_level = cb_value($package->ID, 'marketing_level');
                                    $marketing_level_custom_text = cb_value($package->ID, 'marketing_level_custom_text');
                                    if ($marketing_level_custom_text) {
                                        $marketing_text = $marketing_level_custom_text;
                                    } else {
                                        $marketing_text = $marketing_level;
                                    }
                                    ?>
                                    <td class="text-center bg-orange">
                                        <span><?= $marketing_text ?></span>
                                    </td>
                                <?php } ?>
                            <?php } ?>
                        </tr>

                        <?php foreach ($package_category_subcategories as $subcategory) { ?>
                            <tr>
                                <td>
                                    <?= $subcategory->name ?>
                                </td>
                                <?php foreach ($packages as $package) { ?>
                                    <?php
                                    $class = '';
                                    $taxonomy_terms_custom_text = carbon_get_post_meta($package->ID, 'taxonomy_terms_custom_text');
                                    $taxonomy_terms_custom_text_array = [];
                                    foreach ($taxonomy_terms_custom_text as $custom_text) {
                                        $taxonomy_terms_custom_text_array[$custom_text['term_slug']] = $custom_text['custom_text'];
                                    }

                                    if (has_term($subcategory->slug, $taxonomy, $package->ID)) {
                                        $class = 'tick-active';
                                    }
                                    if (isset($taxonomy_terms_custom_text_array[$subcategory->slug])) {
                                        $text = $taxonomy_terms_custom_text_array[$subcategory->slug];
                                        $class = '';
                                    } else {
                                        $text = '<span></span>';
                                    }
                                    ?>
                                    <td class="tick <?= $class ?>">
                                        <?= $text ?>
                                    </td>
                                <?php } ?>
                            </tr>
                        <?php } ?>

                    <?php } ?>





                </tbody>
            </table>
        </div>
        <div class="join-us-mobile">
            <div class="package-mobile-holder">
                <?php foreach ($packages as $package) { ?>
                    <?php
                    $taxonomy_terms_custom_text = carbon_get_post_meta($package->ID, 'taxonomy_terms_custom_text');
                    $taxonomy_terms_custom_text_array = [];
                    foreach ($taxonomy_terms_custom_text as $custom_text) {
                        $taxonomy_terms_custom_text_array[$custom_text['term_slug']] = $custom_text['custom_text'];
                    }
                    $price = carbon_get_post_meta($package->ID, 'price');

                    ?>
                    <div class="package-mobile-item" id="package-mobile-<?= $package->ID ?>">
                        <div class="package-title-price">
                            <div class="package-title">
                                <?= $package->post_title ?>
                            </div>
                            <div class="price">
                                <div class="price-text">
                                    <?= $price ?>
                                </div>
                                <div class="per">
                                    Annually
                                </div>
                            </div>
                            <div class="excerpt">
                                <?= $package->post_excerpt ?>
                            </div>
                            <div class="text-center modeltheme_button wow bounce">
                                <a href="/online-membership-form/" class="button-winona button-green btn btn-sm">GET STARTED</a>
                            </div>
                        </div>
                        <?php $term_val = ''; ?>
                        <div class="features-mobile-holder">
                            <div class="feature feature-benefits">
                                <div class="feature-title">
                                    <?= $benefits_title ?>
                                </div>
                                <ul class="checklist-ul">
                                    <?php foreach ($packages_benefits as $benefits) { ?>
                                        <?php

                                        if (isset($taxonomy_terms_custom_text_array[$benefits->slug])) {
                                            $text = $taxonomy_terms_custom_text_array[$benefits->slug];
                                        } else {
                                            $text = false;
                                        }

                                        if ($text && $text != '&nbsp;') {
                                            $name = $benefits->name;
                                            echo "<li><span><strong>$name: </strong>$text</li>";
                                            $term_val .= 'has_term';
                                        } else {
                                            if (has_term($benefits->slug, $taxonomy, $package->ID)) {
                                                $text = $benefits->name;
                                                $term_val .= 'has_term';
                                                echo "<li>$text</li>";
                                            }
                                        }
                                        if (!str_contains($term_val, 'has_term')) {
                                            echo '<style> #package-mobile-' . $package->ID . ' .feature-benefits { display: none } </style>';
                                        }
                                        ?>
                                    <?php } ?>
                                </ul>
                            </div>
                            <?php $term_val = ''; ?>
                            <div class="feature feature-member-only">
                                <div class="feature-title">
                                    <?= $members_only_title ?>
                                </div>
                                <ul class="checklist-ul">
                                    <?php foreach ($packages_members_only as $members_only) { ?>
                                        <?php

                                        if (isset($taxonomy_terms_custom_text_array[$members_only->slug])) {
                                            $text = $taxonomy_terms_custom_text_array[$members_only->slug];
                                        } else {
                                            $text = false;
                                        }

                                        if ($text && $text != '&nbsp;') {
                                            $name = $members_only->name;
                                            echo "<li><span><strong>$name: </strong>$text</li>";
                                            $term_val .= 'has_term';
                                        } else {
                                            if (has_term($members_only->slug, $taxonomy, $package->ID)) {
                                                $text = $members_only->name;
                                                echo "<li>$text</li>";
                                            }
                                        }

                                        ?>
                                    <?php } ?>
                                    <?php
                                    if (!str_contains($term_val, 'has_term')) {
                                        echo '<style> #package-mobile-' . $package->ID . ' .feature-member-only { display: none } </style>';
                                    }
                                    ?>
                                </ul>
                            </div>
                            <?php $term_val = ''; ?>
                            <div class="feature feature-patrons">
                                <div class="feature-title">
                                    &nbsp;
                                </div>
                                <ul class="checklist-ul">
                                    <?php foreach ($patrons as $patron) { ?>
                                        <?php
                                        if (isset($taxonomy_terms_custom_text_array[$patron->slug])) {
                                            $text = $taxonomy_terms_custom_text_array[$patron->slug];
                                        } else {
                                            $text = false;
                                        }

                                        if ($text && $text != '&nbsp;') {
                                            $name = $patron->name;
                                            echo "<li><span><strong>$name: </strong>$text</li>";
                                            $term_val .= 'has_term';
                                        } else {
                                            if (has_term($patron->slug, $taxonomy, $package->ID)) {
                                                $text = $patron->name;
                                                $term_val .= 'has_term';
                                                echo "<li>$text</li>";
                                            }
                                        }
                                        ?>
                                    <?php } ?>
                                    <?php
                                    if (!str_contains($term_val, 'has_term')) {
                                        echo '<style> #package-mobile-' . $package->ID . ' .feature-patrons { display: none } </style>';
                                    }
                                    ?>
                                </ul>
                            </div>
                            <?php $term_val = ''; ?>

                            <div class="feature feature-discounts">

                                <div class="feature-title">
                                    <?= $discounts_title ?>
                                </div>
                                <ul class="checklist-ul">
                                    <?php foreach ($discounts as $discount) { ?>
                                        <?php
                                        if (isset($taxonomy_terms_custom_text_array[$discount->slug])) {
                                            $text = $taxonomy_terms_custom_text_array[$discount->slug];
                                        } else {
                                            $text = false;
                                        }

                                        if ($text && $text != '&nbsp;') {
                                            $name = $discount->name;
                                            echo "<li><span><strong>$name: </strong>$text</li>";
                                            $term_val .= 'has_term';
                                        } else {
                                            if (has_term($discount->slug, $taxonomy, $package->ID)) {
                                                $text = $discount->name;
                                                $term_val .= 'has_term';
                                                echo "<li>$text</li>";
                                            }
                                        }
                                        ?>
                                    <?php } ?>
                                    <?php
                                    if (!str_contains($term_val, 'has_term')) {
                                        echo '<style> #package-mobile-' . $package->ID . ' .feature-discounts { display: none } </style>';
                                    }
                                    ?>
                                    <!-- end of Discounts-->
                                </ul>
                            </div>

                            <?php $term_val = ''; ?>

                            <?php
                            $marketing_level = cb_value($package->ID, 'marketing_level');
                            $marketing_level = cb_value($package->ID, 'marketing_level');
                            $marketing_level_custom_text = cb_value($package->ID, 'marketing_level_custom_text');
                            if ($marketing_level_custom_text) {
                                $marketing_text = $marketing_level_custom_text;
                            } else {
                                $marketing_text = $marketing_level;
                            }
                            ?>
                            <div class="feature feature-marketing">
                                <div class="feature-title">
                                    <?= $marketing_title ?>: <?= $marketing_text ?>
                                </div>
                                <ul class="checklist-ul">
                                    <?php foreach ($packages_marketing as $marketing) { ?>
                                        <?php

                                        if (isset($taxonomy_terms_custom_text_array[$marketing->slug])) {
                                            $text = $taxonomy_terms_custom_text_array[$marketing->slug];
                                        } else {
                                            $text = false;
                                        }

                                        if ($text && $text != '&nbsp;') {
                                            $name = $marketing->name;
                                            echo "<li><span><strong>$name: </strong>$text</span></li>";
                                            $term_val .= 'has_term';
                                        } else {
                                            if (has_term($marketing->slug, $taxonomy, $package->ID)) {
                                                $text = $marketing->name;
                                                $term_val .= 'has_term';
                                                echo "<li>$text</li>";
                                            }
                                        }

                                        ?>
                                    <?php } ?>

                                    <?php
                                    if (!str_contains($term_val, 'has_term')) {
                                        echo '<style> #package-mobile-' . $package->ID . ' .feature-marketing { display: none } </style>';
                                    }
                                    ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>

        </div>
        <?php
        return ob_get_clean();
    }
}
add_shortcode('join_us_v3', 'join_us_v3');

function user_posts()
{
    ob_start();
    $posts = get_posts(array(
        'post_type'   => 'post',
        'numberposts' => -1,
        'author'      => um_user('ID'),
        'post_status' => array('publish', 'pending')
    ));
    echo '<div class="user-posts">';
    echo '<h3 class="main-heading">Articles Posted</h3>';
    if ($posts) {
        echo post__grid($posts);
    } else {
        echo '<div class="um-profile-note um-profile-note-real" style="display: block;">
			<span>
				This user has not created any posts.			</span>
		</div>';
    }
    echo '</div>';
    return ob_get_clean();
}
add_shortcode('user_posts', 'user_posts');

function user_marketplace()
{
    ob_start();
    $membersmarketplace = get_posts(array(
        'post_type'   => 'membersmarketplace',
        'numberposts' => -1,
        'author'      => um_user('ID'),
        'post_status' => array('publish')
    ));

    echo '<div class="user-posts marketplace-posts">';
    echo '<h3 class="main-heading">Marketplace</h3>';
    if ($membersmarketplace && count($membersmarketplace) != 0) {
        echo '<div class="post-box-holder flex-row"> <div class="row">';
        foreach ($membersmarketplace as $post) {
            echo member_marketplace_grid($post->ID, false, 'View Offer');
        }
        echo '</div></div>';
    } else {
        echo '<div class="um-profile-note um-profile-note-real" style="display: block !important;">
			<span>
				This user has not posted any offer.			</span>
		</div>';
    }
    echo '</div>';
    return ob_get_clean();
}
add_shortcode('user_marketplace', 'user_marketplace');

function user_directory()
{
    ob_start();
    $membersmarketplace = get_posts(array(
        'post_type'   => 'wpsl_stores',
        'numberposts' => -1,
        'author'      => um_user('ID'),
        'post_status' => array('publish', 'private', 'pending')
    ));

    echo get__current_user_email();
    echo 'xx';
    echo get__current_user_username();
    echo '<div class="user-posts marketplace-posts">';
    echo '<h3 class="main-heading">Membership Directory</h3>';
    echo '<div class="membership-directory">';
    echo '<div class="listings text-left">';
    if ($membersmarketplace && count($membersmarketplace) != 0) {
        echo '<div class="post-box-holder flex-row"> <div class="row">';
        foreach ($membersmarketplace as $post) {
            echo membership_listing($post->ID, (get_current_user_id() == um_user('ID') ? true : false));
        }
        echo '</div></div>';
    } else {
        if (is_user_logged_in() && get_current_user_id() == um_user('ID')) {

            if (isset($_GET['new_entry']) && $_GET['new_entry'] == 'true' && check_if_user_has_directory_entry() == false) {

                if (isset($_GET['submitted']) && $_GET['submitted'] == 'true') {
                    $new_title = $_GET['title'];
                    $new_content = $_GET['content'];
                    $new_wpsl_phone = $_GET['wpsl_phone'];
                    $new_wpsl_email = $_GET['wpsl_email'];
                    $new_wpsl_url = $_GET['wpsl_url'];
                    $meta_inputs = [];

                    $args['post_status'] = 'pending';
                    $args['post_type'] = 'wpsl_stores';
                    $args['post_author'] = um_user('ID');

                    if ($new_title) {
                        $args['post_title'] = $new_title;
                    }
                    if ($new_content) {
                        $args['post_content'] = $new_content;
                    }

                    if ($new_wpsl_phone) {
                        $meta_inputs['wpsl_phone'] = $new_wpsl_phone;
                    }

                    if ($new_wpsl_email) {
                        $meta_inputs['wpsl_email'] = $new_wpsl_email;
                    }

                    if ($new_wpsl_url) {
                        $meta_inputs['wpsl_url'] = $new_wpsl_url;
                    }

                    if ($meta_inputs) {
                        $args['meta_input'] = $meta_inputs;
                    }
                    $post_id = wp_insert_post($args);
                    member_directory_submission_email($post_id, true);
                    notify_user_on_member_directory_update($post_id, true);
                    wp_redirect('?profiletab=directory');
                    exit;
                }
                $organisation = get_user_meta(um_user('ID'), 'organisation', true);
                $phone_number = get_user_meta(um_user('ID'), 'phone_number', true);
                $website_url = get_user_meta(um_user('ID'), 'website_url', true);
                $email = um_user('user_email');
                $organisation_description = get_user_meta(um_user('ID'), 'organisation_description', true);
        ?>
                <form method="GET" class="form-style-new">
                    <input type="hidden" name="profiletab" value="directory">
                    <input type="hidden" name="submitted" value="true">
                    <input type="hidden" name="new_entry" value="true">
                    <div class="form-group">
                        <label class="form-control"><span>Organisation: </span><input type="text" name="title" id="title"
                                value="<?= $organisation ?>"></label>
                        <label class="form-control"><span>Description: </span><textarea name="content"
                                id="content"><?= $organisation_description ?></textarea></label>
                        <label class="form-control"><span>Phone: </span><input type="tel" name="wpsl_phone" id="wpsl_phone"
                                value="<?= $phone_number ?>"></label>
                        <label class="form-control"><span>Email: </span><input type="email" name="wpsl_email" id="wpsl_email"
                                value="<?= $email ?>"></label>
                        <label class="form-control"><span>Website: </span><input type="url" name="wpsl_url" id="wpsl_url"
                                value="<?= $website_url ?>"></label>
                    </div>
                    <div class="button-box text-right">
                        <button type="submit" class="button-winona button-accent btn btn-sm">
                            Submit
                        </button>
                    </div>
                </form>
<?php
            } else {
                echo ' <div style="text-align: center; margin-top: 30px"> <a href="?profiletab=directory&new_entry=true" class="button-winona button-accent btn btn-sm">
                Submit Entry
    </a><div>';
            }
        } else {
            echo '<div class="um-profile-note um-profile-note-real" style="display: block !important;">
			<span>
				This user does not have directory.			</span>
		</div>';
        }
    }
    echo '</div>';
    echo '</div>';
    echo '</div>';

    if (isset($_GET['edit'])) {
    }


    return ob_get_clean();
}
add_shortcode('user_directory', 'user_directory');

function check_if_user_has_directory_entry()
{
    $posts = get_posts(array(
        'post_type'   => 'wpsl_stores',
        'numberposts' => -1,
        'author'      => um_user('ID'),
        'post_status' => array('publish', 'private', 'pending')
    ));

    if ($posts) {
        return true;
    } else {
        return false;
    }
}


function display_name()
{

    if (is_user_logged_in()) {
        $current_user = wp_get_current_user();
        $display_name = $current_user->display_name;
        return "<span>$display_name</span>";
    }
}

add_shortcode('display_name', 'display_name');

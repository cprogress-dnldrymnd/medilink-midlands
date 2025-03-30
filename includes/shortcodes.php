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
    <div class="blog-posts blog-posts-v2 flex-row simple-posts blog-posts-shortcode wow">
        <div class="row">
            <?php foreach ($posts as $post) { ?>
                <?php
                $permalink = get_the_permalink($post->ID);
                $title = $post->post_title;
                $date = get_the_date('', $post->ID);
                $image = get_the_post_thumbnail_url($post->ID, 'large');
                $category = get_the_category($post->ID);
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

                            <div class="post-details">

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
    <?php if (!is_home()) { ?>
        <div class="text-center modeltheme_button wow bounce" style="animation-name: bounce; margin-top: 40px"><a
                href="https://medilink.theprogressteam.com/latest-articles/" class="button-winona button-green btn btn-sm">VIEW
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
    <div class="member-marketplace-form" id="member-marketplace-form">
        <div class="container">

            <div class="heading-title-desc mt-0 mb-4">
                <h2>Members Marketplace Special Offers from our Patrons and Members</h2>
                <p>
                    <?php if (is_user_logged_in()) { ?>
                        <?php
                        $current_user = wp_get_current_user();
                        $display_name = $current_user->display_name;
                        ?>
                        <span>
                            <?= $display_name ?>,
                        </span>
                    <?php } ?>
                </p>
                <p>
                    If you are looking to submit an offer, please complete the submission form with all requested details
                    below.
                </p>
                <p>
                    Once submitted a member of the Membership Team will review your offer and you will receive confirmation
                    of your offer within 3 working days. To prevent any delays, please complete the form with all required
                    information.
                </p>
                <p>
                    Please note, members can have only list one offer on the Marketplace. If we receive more than one, only
                    one will be listed.
                </p>
            </div>
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
<?php
    return ob_get_clean();
}
add_shortcode('member_marketplace_form', 'member_marketplace_form');


function submit_blog_form_with_login()
{
    ob_start();
?>
    <div class="member-marketplace-form" id="member-marketplace-form">
        <div class="container">
            <h2>Submit a Blog</h2>

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
<?php
    return ob_get_clean();
}


function submit_blog_form()
{
    ob_start();
?>
    <div class="member-marketplace-form" id="member-marketplace-form">
        <div class="container">
            <h2>Submit a Blog</h2>
            <?= do_shortcode('[contact-form-7 id="83cfac2" title="Submit a Blog"]') ?>
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
        return $first_name . ' ' . $last_naclaim_offer_formme;
    } else if ($key == 'user_id') {
        return $user_id;
    } else {
        return get_user_meta($user_id, $key, true);
    }
}
add_shortcode('user_field', 'user_field');

function claim_offer_form()
{
    ob_start();
?>
    <div class="claim-offer-form">
        <div class="row row-flex">
            <div class="col-lg-6">
                <div class="post-box">
                    <div class="top">
                        <div class="image-box offer-image">
                            <img src="" alt="">
                        </div>
                        <p class="offer-author"></p>
                        <h3 class="offer-title"></h3>
                        <div class="offer-details"></div>
                    </div>

                </div>
            </div>
            <div class="col-lg-6">
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
        </div>
    </div>
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

    <div class="membership-directory">
        <div class="row">
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
                                Submit
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
                            <?php } ?>
                        </div>
                    </div>
                </div>
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


function membership_listing()
{
    ob_start();
    $wpsl_url = get_post_meta(get_the_ID(), 'wpsl_url', true);
    $wpsl_phone = get_post_meta(get_the_ID(), 'wpsl_phone', true);
    $wpsl_email = get_post_meta(get_the_ID(), 'wpsl_email', true);
    $url = addHttpsToUrl($wpsl_url);
    if (has_term(112, 'wpsl_store_category', get_the_ID())) {
        $class = 'col-lg-10';
        $is_patron = true;
    } else {
        $class = 'col-lg-12';
        $is_patron = false;
    }
?>
    <div class="col-lg-12 post-item">
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
                            <h3><?php the_title() ?></h3>
                        </div>
                        <div class="description-box">
                            <?php the_content() ?>
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
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>
<?php
    return ob_get_clean();
}

function getDomain($url)
{
    $pieces = parse_url($url);
    $domain = isset($pieces['host']) ? $pieces['host'] : '';
    if (preg_match('/(?P<domain>[a-z0-9][a-z0-9\-]{1,63}\.[a-z\.]{2,6})$/i', $domain, $regs)) {
        return $regs['domain'];
    }
    return FALSE;
}



function addHttpsToUrl($url)
{
    // Trim whitespace from the beginning and end of the URL
    $url = trim($url);

    // Check if the URL is empty or null
    if (empty($url)) {
        return ""; // Or handle it differently, like returning null or throwing an exception
    }

    // Check if the URL already starts with "https://" or "http://" (case-insensitive)
    if (stripos($url, "https://") === 0 || stripos($url, "http://") === 0) {
        return $url; // URL already has a protocol, return it as is
    }

    // Check if the URL starts with "www." (case-insensitive)
    if (stripos($url, "www.") === 0) {
        return "https://" . $url; // Add "https://"
    }

    // If none of the above conditions are met, it might be a local path or something else.
    // You can choose how to handle this:
    // 1. Return the original URL (no change):
    return $url;

    // 2. Add "http://" (less secure, but might be what you want in some cases):
    // return "http://" . $url;

    // 3. Return "https://" anyway (might lead to errors if it's not a web address):
    // return "https://" . $url;

    // 4. Return an error message or throw an exception:
    // return "Invalid URL format.";  // Or throw new Exception("Invalid URL format.");
}


function offer_category()
{
    $terms = get_terms(array(
        'taxonomy'   => 'membersmarketplace_category',
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
add_shortcode('offer_category', 'offer_category');


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
        'post_type' => 'packages',
        'numberposts' => -1,
    ));
    $packages_benefits = get_terms(array(
        'taxonomy'   => $taxonomy,
        'hide_empty' => false,
        'parent' => 113,
        'orderby' => 'term_id',
        'order' => 'ASC',
    ));
    $packages_members_only = get_terms(array(
        'taxonomy'   => $taxonomy,
        'hide_empty' => false,
        'parent' => 121,
        'orderby' => 'term_id',
        'order' => 'ASC',
    ));
    $patrons = get_terms(array(
        'taxonomy'   => $taxonomy,
        'hide_empty' => false,
        'parent' => 164,
        'orderby' => 'term_id',
        'order' => 'ASC',
    ));

    $packages_marketing = get_terms(array(
        'taxonomy'   => $taxonomy,
        'hide_empty' => false,
        'parent' => 134,
        'orderby' => 'term_id',
        'order' => 'ASC',
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
                                    <a href="/online-membership-form/" class="button-winona button-green btn btn-sm">GET STARTED</a>
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
                        Benefits to support your innovation ideas and organisation
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

                <!-- memebers only-->
                <tr>
                    <td class="title-data" colspan="<?= count($packages) + 1 ?>">
                        Enhanced Member only area access:
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
                        &nbsp;
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


                <!-- membership review-->

                <tr>
                    <td>
                        Membership Review
                    </td>
                    <?php foreach ($packages as $package) { ?>
                        <?php
                        $membership_review = cb_value($package->ID, 'membership_review');

                        ?>
                        <td class="text-center <?= $membership_review ? '' : 'tick' ?>">
                            <span><?= $membership_review ?></span>
                        </td>
                    <?php } ?>
                </tr>
                <!-- end of membership review-->

                <!-- Discounts-->
                <tr>
                    <td class="title-data " colspan="<?= count($packages) + 1 ?>">
                        Discounts
                    </td>
                </tr>

                <tr>
                    <td>
                        MM training & networking
                    </td>
                    <?php foreach ($packages as $package) { ?>
                        <?php
                        $discount_mm_training_networking = cb_value($package->ID, 'discount_mm_training_networking');
                        ?>
                        <td class="text-center <?= $discount_mm_training_networking ? '' : 'tick' ?>">
                            <span><?= $discount_mm_training_networking ?></span>
                        </td>
                    <?php } ?>
                </tr>
                <tr>
                    <td>
                        Events and/or Marketing services
                    </td>
                    <?php foreach ($packages as $package) { ?>
                        <?php
                        $discount_events_marketing_services = cb_value($package->ID, 'discount_events_marketing_services');
                        ?>
                        <td class="text-center <?= $discount_events_marketing_services ? '' : 'tick' ?>">
                            <span><?= $discount_events_marketing_services ?></span>
                        </td>
                    <?php } ?>
                </tr>
                <tr>
                    <td>
                        Medtech Innovation Expo (MTI) exhibition space
                    </td>
                    <?php foreach ($packages as $package) { ?>
                        <?php
                        $discount_medtech_expo = cb_value($package->ID, 'discount_medtech_expo');
                        ?>
                        <td class="text-center <?= $discount_medtech_expo ? '' : 'tick' ?>">
                            <span><?= $discount_medtech_expo ?></span>
                        </td>
                    <?php } ?>
                </tr>
                <tr>
                    <td>
                        Access to International Trade Shows discounts
                    </td>
                    <?php foreach ($packages as $package) { ?>
                        <?php
                        $discount_internation_trade = cb_value($package->ID, 'discount_internation_trade');
                        ?>
                        <td class="text-center <?= $discount_internation_trade ? '' : 'tick' ?>">
                            <span><?= $discount_internation_trade ?></span>
                        </td>
                    <?php } ?>
                </tr>
                <!-- end of Discounts-->



                <!-- marketing-->

                <tr>
                    <td class="title-data">
                        <strong>Marketing</strong>
                    </td>
                    <?php foreach ($packages as $package) { ?>
                        <?php
                        $marketing_level = cb_value($package->ID, 'marketing_level');
                        ?>
                        <td class="text-center bg-orange">
                            <span><?= $marketing_level ?></span>
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
                            if (has_term($marketing->slug, $taxonomy, $package->ID)) {
                                $class = 'tick-active';
                            } else {
                                $class = '';
                            }
                            ?>
                            <td class="tick <?= $class ?>">
                                <span></span>
                            </td>
                        <?php } ?>
                    </tr>
                <?php } ?>

                <tr>
                    <td>
                        Thought leadership article
                    </td>
                    <?php foreach ($packages as $package) { ?>
                        <?php
                        $marketing_thought_leadership_article = cb_value($package->ID, 'discount_internation_trade');
                        ?>
                        <td class="text-center <?= $marketing_thought_leadership_article ? '' : 'tick' ?>">
                            <span><?= $marketing_thought_leadership_article ?></span>
                        </td>
                    <?php } ?>
                </tr>
                <tr>
                    <td>
                        Blog
                    </td>
                    <?php foreach ($packages as $package) { ?>
                        <?php
                        $marketing_blog = cb_value($package->ID, 'marketing_blog');
                        ?>
                        <td class="text-center <?= $marketing_blog ? '' : 'tick' ?>">
                            <span><?= $marketing_blog ?></span>
                        </td>
                    <?php } ?>
                </tr>
                <tr>
                    <td>
                        Promotion of events
                    </td>
                    <?php foreach ($packages as $package) { ?>
                        <?php
                        $marketing_promotion = cb_value($package->ID, 'marketing_promotion');
                        ?>
                        <td class="text-center <?= $marketing_promotion ? '' : 'tick' ?>">
                            <span><?= $marketing_promotion ?></span>
                        </td>
                    <?php } ?>
                </tr>
                <tr>
                    <td>
                        Member Market place listing
                    </td>
                    <?php foreach ($packages as $package) { ?>
                        <?php
                        $marketing_memeber_marketplace = cb_value($package->ID, 'marketing_memeber_marketplace');
                        ?>
                        <td class="text-center <?= $marketing_memeber_marketplace ? '' : 'tick' ?>">
                            <span><?= $marketing_memeber_marketplace ?></span>
                        </td>
                    <?php } ?>
                </tr>
                <!-- end of marketing-->


            </tbody>
        </table>
    </div>
<?php
    return ob_get_clean();
}
add_shortcode('join_us_v2', 'join_us_v2');

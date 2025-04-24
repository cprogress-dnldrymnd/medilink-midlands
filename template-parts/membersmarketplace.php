<?php get_header() ?>
<?php
$curent_term = get_queried_object();
$current_id = $curent_term->term_id;
$name = $curent_term->name;

if (is_tax()) {
    $title = 'MEDILINK MEMBERS MARKETPLACE - ' . $name;
} else {
    $title = 'MEDILINK MEMBERS MARKETPLACE';
}
?>
<div class="header-title-breadcrumb header-title-breadcrumb-custom relative">
    <div class="header-title-breadcrumb-overlay text-center">
        <div class="container">
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12 text-left">
                    <ol class="breadcrumb text-left">
                        <li><a href="https://medilink.theprogressteam.com/">Home</a></li>
                        <li>MEMBERS MARKETPLACE</li>
                    </ol>

                    <h1><?= $title ?></h1>
                    <p style="margin-bottom: 2rem">
                        Welcome to the Member Marketplace submission area.
                    </p>

                    <div class="modeltheme_button wow bounce animated" style="margin-top: 40px; visibility: visible;"><a href="#submit-offer" class="button-winona button-green btn btn-sm">Submit an offer</a></div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
$featureds = get_posts(array(
    'post_type' => 'membersmarketplace',
    'numberposts' => 10,
    'orderby' => 'rand'
));
?>
<?php if (!is_tax()) { ?>
    <section class="latest-offers">
        <div class="container">

            <h2>Latest Offers</h2>
            <div class="featured-offers">
                <div class="swiper swiper-featured-offers">
                    <div class="swiper-wrapper">
                        <?php foreach ($featureds as $featured) { ?>
                            <?php
                            $post_author = $featured->post_author;
                            $offer_image = get_the_post_thumbnail_url($featured->ID, 'large');
                            ?>
                            <div class="swiper-slide">
                                <div class="inner flex-row">
                                    <div class="row">
                                        <div class="col-lg-7">
                                            <div class="col-content">
                                                <div class="image-box">
                                                    <img src="<?= _author_logo($featured->post_author) ?>">
                                                </div>
                                                <div class="post-title">
                                                    <h3><?= do_shortcode("[user_field key='organisation' author_id=$post_author]") ?></h3>
                                                </div>
                                                <div class="desc">
                                                    <p>
                                                        <?= $featured->post_title ?>
                                                    </p>
                                                </div>
                                                <?php if ($featured->post_content) { ?>
                                                    <div class="offer-details">
                                                        <?= wpautop($featured->post_content) ?>
                                                    </div>
                                                <?php } ?>
                                                <div class="modeltheme_button">
                                                    <?= _claim_offer_button($featured->ID) ?>
                                                    <a class="button-winona button-green btn btn-sm wow-modal-id-1 claim-offer-button" offer_owner_company="<?= _author_company($post_author) ?>" offer_owner_email="<?= _author_email($post_author) ?>" offer_details="<?= wpautop($featured->post_content) ?>" offer_image="<?= $offer_image ?>" offer_owner="<?= _author_name($post_author) ?>" offer_title="<?= $featured->post_title ?>">Claim Offer</a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-5">
                                            <div class="featured-image">
                                                <?= get_the_post_thumbnail($featured->ID, 'large') ?>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="swiper-pagination"></div>

                </div>
            </div>
        </div>
    </section>
<?php } ?>
<section class="current-offers">
    <div class="container">
        <h2>All Current Offers</h2>
        <div class="filter">
            Filter by:
            <?php
            $terms = get_terms(array(
                'taxonomy' => 'membersmarketplace_category',
            ));
            ?>
            <div class="filter-holder">
                <a class="active" href="/membersmarketplace/">ALL</a>
                <?php foreach ($terms as $term) { ?>
                    <?php if ($term->slug != 'featured') { ?>
                        <a href="<?= get_term_link($term->term_id) ?>"><?= $term->name ?></a>
                    <?php } ?>
                <?php } ?>
            </div>
        </div>
        <?= memberplace_marketplace() ?>
        <div class="modeltheme_button text-center view-all">
            <a href="#" class="button-winona button-green btn btn-sm">View All</a>
        </div>
    </div>
</section>
<section class="cta">
    <div class="container">
        <div class="inner flex-row">
            <div class="row">
                <div class="col-lg-6">
                    <div class="image-box">
                        <?= wp_get_attachment_image(49612, 'large') ?>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="cta-content">
                        <div class="heading">
                            <h2>Looking to submit your offer?</h2>
                        </div>
                        <div class="modeltheme_button">
                            <a href="#submit-offer" class="button-winona button-green btn btn-sm">SUBMIT HERE</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<div id="submit-offer" class="submit-form-holder">
    <?= do_shortcode('[member_marketplace_form]') ?>
</div>
<?= do_shortcode('[Modal-Window id="1"]') ?>

<?php if (is_user_logged_in()) { ?>
    <div id="form-clicked" class="d-none">
        <?= do_shortcode('[contact-form-7 id="cffc1b6" title="Offer Clicked Form"]') ?>
    </div>
<?php } ?>
<script>
    jQuery(document).ready(function() {
        jQuery('.claim-offer-button').click(function(e) {
            $offer_title = jQuery(this).attr('offer_title');
            $offer_desc = jQuery(this).attr('offer_desc');
            $offer_owner = jQuery(this).attr('offer_owner');
            $offer_owner_email = jQuery(this).attr('offer_owner_email');
            $offer_owner_company = jQuery(this).attr('offer_owner_company');
            $offer_owner_company = jQuery(this).attr('offer_owner_company');
            $offer_image = jQuery(this).attr('offer_image');
            $offer_details = jQuery(this).attr('offer_details');

            jQuery('input[name="offer_title"]').val($offer_title);
            jQuery('input[name="offer_desc"]').val($offer_desc);
            jQuery('input[name="offer_owner"]').val($offer_owner);
            jQuery('input[name="offer_owner_email"]').val($offer_owner_email);
            jQuery('input[name="offer_owner_company"]').val($offer_owner_company);

            jQuery('.claim-offer-form .offer-title').text($offer_title);
            jQuery('.claim-offer-form .offer-author').text($offer_owner_company);
            jQuery('.claim-offer-form .offer-details').html($offer_details);
            jQuery('.claim-offer-form .offer-image img').attr('src', $offer_image);

            jQuery('#form-clicked .wpcf7-submit').click();
            e.preventDefault();
        });
    });
    var swiper = new Swiper(".swiper-featured-offers", {
        autoheight: true,
        pagination: {
            el: ".swiper-pagination",
        },
    });
</script>

<?php get_footer() ?>
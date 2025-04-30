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
                        <li><a href="<?= get_site_url() ?>">Home</a></li>
                        <li>MEMBERS MARKETPLACE</li>
                    </ol>

                    <h1><?= $title ?></h1>
                    <div style="margin-bottom: 2rem; margin-top: 1rem">
                        <?= wpautop(carbon_get_theme_option('member_marketplace_description')) ?>

                    </div>

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
<?php } else { ?>
    <input type="hidden" name="membersmarketplace_category" value="<?= get_queried_object_id() ?>">
<?php } ?>
<section class="current-offers ajax-result">
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
                <a class="<?= is_post_type_archive('membersmarketplace') ? 'active' : '' ?>" href="<?= get_post_type_archive_link('membersmarketplace') ?>">ALL</a>
                <?php foreach ($terms as $term) { ?>
                    <?php if ($term->slug != 'featured') { ?>
                        <a class="<?= $term->term_id == get_queried_object_id() ? 'active' : '' ?>" href="<?= get_term_link($term->term_id) ?>"><?= $term->name ?></a>
                    <?php } ?>
                <?php } ?>
            </div>
        </div>
        <?= member_marketplace() ?>
        <div class="loader"><span class="wpcf7-spinner"></span></div>
        <div class="modeltheme_button text-center view-all">
            <a href="#" class="button-winona button-green btn btn-sm load-more-marketplace">Load more</a>
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


<script>
    var swiper = new Swiper(".swiper-featured-offers", {
        autoheight: true,
        pagination: {
            el: ".swiper-pagination",
        },
    });
</script>

<?php get_footer() ?>
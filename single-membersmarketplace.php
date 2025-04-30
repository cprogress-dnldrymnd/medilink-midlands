<?php get_header() ?>
<div class="header-title-breadcrumb header-title-breadcrumb-custom relative">
    <div class="header-title-breadcrumb-overlay text-center">
        <div class="container">
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12 text-left">
                    <h1>MEDILINK MEMBERS MARKETPLACE</span></h1>
                    <ol class="breadcrumb text-left">
                        <li><a href="<?= get_site_url() ?>">Home</a></li>
                        <li>MEMBERS MARKETPLACE</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
global $post;
$post_author = $post->post_author;
$offer_image = get_the_post_thumbnail_url($post->ID, 'large');
?>
<section class="latest-offers">
    <div class="container">
        <div class="featured-offers">
            <div class="inner flex-row">
                <div class="row">
                    <div class="col-lg-7">
                        <div class="col-content">
                            <div class="image-box">
                                <img src="<?= _author_logo($post->post_author) ?>">
                            </div>
                            <div class="post-title">
                                <h3><?= do_shortcode("[user_field key='organisation' author_id=$post_author]") ?></h3>
                            </div>
                            <div class="desc">
                                <p>
                                    <?= $post->post_title ?>
                                </p>
                            </div>
                            <?php if ($post->post_content) { ?>
                                <div class="offer-details">
                                    <?= wpautop($post->post_content) ?>
                                </div>
                            <?php } ?>
                            <div class="modeltheme_button">
                                <?= _claim_offer_button($post->ID) ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-5">
                        <div class="featured-image">
                            <?= get_the_post_thumbnail($post->ID, 'large') ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="claim-offer-single" style="margin-top: 50px">
    <div class="container">
        <h2 class="text-center">Claim Offer</h2>
        <?= do_shortcode('[contact-form-7 id="6c2d6fd" title="Claim Offer Form"]') ?>
    </div>
</section>
<?php get_footer() ?>
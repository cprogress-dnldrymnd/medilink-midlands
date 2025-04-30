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
<section class="latest-offers">
    <div class="container">
        <div class="featured-offers">
            <div class="inner flex-row">
                <div class="row">
                    <div class="col-lg-7">
                        <div class="col-content">
                            <div class="image-box">
                                <?= get_the_post_thumbnail(get_the_ID(), 'medium') ?>
                            </div>
                            <div class="post-title">
                                <h3><?= get_the_title() ?></h3>
                            </div>
                            <div class="desc">
                                <?= wpautop(get_the_content()) ?>
                            </div>
                            <div class="modeltheme_button d-none">
                                <?= _claim_offer_button(get_the_ID(), ) ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-5">
                        <div class="featured-image">
                            <?= wp_get_attachment_image(49568, 'large') ?>
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
<?php get_header() ?>
<div class="header-title-breadcrumb header-title-breadcrumb-custom relative">
    <div class="header-title-breadcrumb-overlay text-center">
        <div class="container">
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12 text-left">
                    <h1>MEDILINK MEMBERS MARKETPLACE</span></h1>
                    <ol class="breadcrumb text-left">
                        <li><a href="<?=  get_site_url() ?>">Home</a></li>
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
                            <div class="modeltheme_button">
                                <a href="<?= get_the_permalink() ?>" class="button-winona button-green btn btn-sm">CLICK HERE</a>
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
<?= do_shortcode('[claim_offer_form is_single=1]') ?>
<?php get_footer() ?>
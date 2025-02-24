<?php get_header() ?>
<div class="header-title-breadcrumb header-title-breadcrumb-custom relative">
    <div class="header-title-breadcrumb-overlay text-center">
        <div class="container">
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12 text-left">
                    <h1>Events and Training Materials</span></h1>
                    <ol class="breadcrumb text-left">
                        <li><a href="https://medilink.theprogressteam.com/">Home</a></li>
                        <li>Events and Training Materials</li>
                    </ol>

                </div>
            </div>
        </div>
    </div>
</div>
<section class="events-and-training">
    <div class="container">
        <?= do_shortcode('[template template_id=50388]'); ?>
    </div>
</section>

<section class="current-offers">
    <div class="container">
        <h2>Training Materials</h2>

        <div class="post-box-holder flex-row">
            <div class="row">
                <?php while (have_posts()) {
                    the_post() ?>
                    <div class="col-lg-4">
                        <div class="post-box">
                            <div class="top">
                              
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
                                    <a href="<?php the_permalink() ?>" class="button-winona button-green btn btn-sm wow-modal-id-1 claim-offer-button">READ MORE</a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
        <div class="modeltheme_button text-center view-all">
            <a href="#" class="button-winona button-green btn btn-sm">View All</a>
        </div>
    </div>
</section>



<?php get_footer() ?>
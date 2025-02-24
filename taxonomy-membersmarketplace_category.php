<?php get_header() ?>
<?php
$curent_term = get_queried_object();
$current_id = $curent_term->term_id;
$name = $curent_term->name;
?>
<div class="header-title-breadcrumb header-title-breadcrumb-custom relative">
    <div class="header-title-breadcrumb-overlay text-center">
        <div class="container">
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12 text-left">
                    <h1>MEDILINK MEMBERS MARKETPLACE - <?= $name ?></span></h1>
                    <ol class="breadcrumb text-left">
                        <li><a href="https://medilink.theprogressteam.com/">Home</a></li>
                        <li><a href="/membersmarketplace/">MEMBERS MARKETPLACE</a></li>
                        <li><?= $name ?></li>
                    </ol>
                    <div class="heading-title-desc">
                        <h3>Members Marketplace Special Offers From Our Patrons And Members</h3>
                        <p>
                            Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et<br> accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


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
                <a href="/membersmarketplace/">ALL</a>
                <?php foreach ($terms as $term) { ?>
                    <?php if ($term->slug != 'featured') { ?>
                        <a class="<?= $current_id == $term->term_id ? 'active' : '' ?>"  href="<?= get_term_link($term->term_id) ?>"><?= $term->name ?></a>
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
                            <a href="#" class="button-winona button-green btn btn-sm">SUBMIT HERE</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script>
    var swiper = new Swiper(".swiper-featured-offers", {
        autoheight: true,
        pagination: {
            el: ".swiper-pagination",
        },
    });
</script>

<?php get_footer() ?>
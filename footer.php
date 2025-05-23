<?php

/**
 * The template for displaying the footer.
 *
 */

?>

<?php if (get_post_type() == 'mt_listing') { ?>
    <div class="resources-footer">
        <div class="container">
            <?= do_shortcode('[template template_id=49489]') ?>
        </div>
    </div>
<?php } ?>
<?php if (class_exists('ReduxFrameworkPlugin')) { ?>
    <?php if (wikb('mt_backtotop_status') == true) { ?>
        <!-- BACK TO TOP BUTTON -->
        <a class="back-to-top modeltheme-is-visible modeltheme-fade-out" href="<?php echo esc_url('#0'); ?>">
            <i class="fa fa-long-arrow-up" aria-hidden="true"></i>
        </a>
    <?php } ?>
<?php } ?>

<!-- FOOTER -->
<?php $theme_init = new wikb_init_class; ?>
<footer class="flex-row <?php echo esc_attr($theme_init->wikb_get_footer_variant()); ?>">
    <!-- FOOTER BOTTOM -->
    <div class="footer-top-div text-center">
        <div class="container">
            <div class="footer-widgets">
                <?php dynamic_sidebar('footer_top'); ?>
            </div>
        </div>
    </div>

    <?php if (class_exists('ReduxFrameworkPlugin')) { ?>
        <!-- FOOTER TOP -->
        <div class="footer-middle-div">
            <div class="container footer-top">
                <?php
                //FOOTER ROW #1
                echo wp_kses_post(wikb_footer_row1());
                ?>
            </div>
        </div>
    <?php } ?>

    <!-- FOOTER BOTTOM -->
    <div class="footer-bottom-div">
        <div class="container">
            <div class="inner">
                <div class="row">
                    <div class="col-lg-6">
                        <?php dynamic_sidebar('footer_bottom_left'); ?>
                    </div>
                    <div class="col-lg-6 text-right">
                        <div class="column-holder">
                            <?php dynamic_sidebar('footer_bottom_right'); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</footer>
</div>



<?php wp_footer(); ?>
</body>

</html>
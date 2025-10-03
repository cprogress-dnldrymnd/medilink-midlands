<?php

/**
 * The template for displaying archive pages.
 *
 */

get_header();

$class_row = "col-md-8";
if (wikb('mt_blog_layout') == 'mt_blog_fullwidth') {
    $class_row = "col-md-12";
} elseif (wikb('mt_blog_layout') == 'mt_blog_right_sidebar' or wikb('mt_blog_layout') == 'mt_blog_left_sidebar') {
    $class_row = "col-md-8";
}
$sidebar = wikb('mt_blog_layout_sidebar');

// theme_ini
$theme_init = new wikb_init_class;
?>

<div class="header-title-breadcrumb header-title-breadcrumb-custom relative">
    <div class="header-title-breadcrumb-overlay text-center">
        <div class="container">
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12 text-left">
                    <h1>Opportunities</span></h1>
                    <ol class="breadcrumb text-left">
                        <li><a href="<?= get_site_url() ?>">Home</a></li>
                        <li>OPPORTUNITIES</li>
                    </ol>

                </div>
            </div>
        </div>
    </div>
</div>

<!-- Page content -->
<div class="high-padding">
    <!-- Blog content -->
    <div class="container blog-posts">
        <div class="row">

            <?php if (class_exists('ReduxFrameworkPlugin')) { ?>
                <?php if (wikb('mt_blog_layout') != '' && wikb('mt_blog_layout') == 'mt_blog_left_sidebar') { ?>
                    <?php if (is_active_sidebar($sidebar)) { ?>
                        <div class="col-md-4 sidebar-content"><?php dynamic_sidebar($sidebar); ?></div>
                    <?php } ?>
                <?php } ?>
            <?php } else { ?>
                <div class="col-md-4 sidebar-content">
                    <?php get_sidebar(); ?>
                </div>
            <?php } ?>

            <div class="<?php echo esc_attr($class_row); ?> main-content">
                <?php if (have_posts()) : ?>
                    <div class="row">

                        <?php /* Start the Loop */ ?>
                        <?php while (have_posts()) : the_post(); ?>
                            <?php /* Loop - Variant 1 */ ?>
                            <?php get_template_part('content', 'blogloop-v5'); ?>
                        <?php endwhile; ?>

                    </div>
                <?php else : ?>
                    <?php get_template_part('content', 'none'); ?>
                <?php endif; ?>
            </div>

            <div class="clearfix"></div>

            <div class="modeltheme-pagination-holder col-md-12">
                <div class="modeltheme-pagination pagination">
                    <?php the_posts_pagination(); ?>
                </div>
            </div>


            <?php if (wikb('mt_blog_layout') != '' && wikb('mt_blog_layout') == 'mt_blog_right_sidebar') { ?>
                <?php if (is_active_sidebar($sidebar)) { ?>
                    <div class="col-md-4 sidebar-content">
                        <?php dynamic_sidebar($sidebar); ?>
                    </div>
                <?php } ?>
            <?php } ?>
        </div>
    </div>
</div>
<?php get_footer(); ?>
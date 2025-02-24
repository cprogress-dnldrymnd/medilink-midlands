<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 */

    get_header(); 

    if ( wikb('mt_blog_layout') == 'mt_blog_fullwidth' ) {
        $class_row = "col-md-12";
    }elseif ( wikb('mt_blog_layout') == 'mt_blog_right_sidebar' or wikb('mt_blog_layout') == 'mt_blog_left_sidebar') {
        $class_row = "col-md-8";
    }
    $sidebar = wikb('mt_blog_layout_sidebar');

    if ( !class_exists( 'ReduxFrameworkPlugin' ) ) {
      $sidebar = 'sidebar-1';
    } 
    if ( !is_active_sidebar ( $sidebar ) ) { 
      $class = "row";
    }
    ?>

    <!-- HEADER TITLE BREADCRUBS SECTION 
	<?php if (is_home()) { ?>
    <?= wikb_header_title_breadcrumbs_v2('MEDILINK LATEST ARTICLES' ,"Dive into our latest posts for expert insights, tips, and trends brought to you by the Medilink team. Whether you're here to learn, explore, or stay updated, you'll find valuable content to inspire and inform. Happy reading!"); ?>
    <div class="featured-articles">
        <div class="container">
            <?= do_shortcode('[featured_articles]') ?>
        </div>
    </div>
<?php }else {?>
<?= wikb_header_title_breadcrumbs(); ?>
<?php } ?>
    <!-- Blog content -->
    <div class="upper-overlay">
        <div class="container blog-posts">
            <div class="row">
                <div class="row main-content">
                    <div class="row">
                        <?php if ( have_posts() ) : ?>
                            <?php /* Start the Loop */ ?>
                            <?php while ( have_posts() ) : the_post(); ?>
                                <?php
                                    get_template_part( 'content', 'blogloop-v5' );
                                ?>
                            <?php endwhile; ?>
                        <?php else : ?>
                            <?php get_template_part( 'content', 'none' ); ?>
                        <?php endif; ?>
                    </div>
                    
                    <?php if ( wikb('mt_blog_layout') != '' && wikb('mt_blog_layout') == 'mt_blog_right_sidebar') { ?>
                        <?php if (is_active_sidebar($sidebar)) { ?>
                            <div class="col-md-4 sidebar-content">
                                <?php dynamic_sidebar( $sidebar ); ?>
                            </div>
                        <?php } ?>
                    <?php } ?>
                </div>

                <div class="clearfix"></div>

                <div class="modeltheme-pagination-holder col-md-12">             
                    <div class="modeltheme-pagination pagination">             
                        <?php the_posts_pagination(); ?>
                    </div>
                </div>
                
            </div>
        </div>
    </div>

<?php if(is_home())  {?>
<div id="submit-blog" class="submit-form-holder">
    <?= do_shortcode('[submit_blog_form]') ?>
</div>
<?php } ?>
<div class="clearfix"></div>
<?php get_footer(); ?>
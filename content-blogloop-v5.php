<?php 
// BLOGLOOP-V2

$master_class = 'col-md-6';
$thumbnail_class = 'col-md-4';
$post_details_class = 'col-md-8';
$type_class = 'list-view';
$image_size = 'wikb_700x600';
$custom_no_padding = '';

if ( wikb('blog-display-type') == 'list' ) {
    $thumbnail_class = 'col-md-4';
    $post_details_class = 'col-md-8';
    $type_class = 'list-view';
    $image_size = 'wikb_700x600';
} else {
    $type_class = 'grid-view';
    if ( wikb('blog-grid-columns') == 1 ) {
        $master_class = 'col-md-12';
        $type_class .= ' grid-one-column';
        $image_size = 'wikb_1000x580';
    }elseif ( wikb('blog-grid-columns') == 2 ) {
        $master_class = 'col-md-6';
        $type_class .= ' grid-two-columns';
        $image_size = 'wikb_1000x580';
    }elseif ( wikb('blog-grid-columns') == 3 ) {
        $master_class = 'col-md-4';
        $type_class .= ' grid-three-columns';
        $image_size = 'wikb_700x500';
    }elseif ( wikb('blog-grid-columns') == 4 ) {
        $master_class = 'col-md-3';
        $type_class .= ' grid-four-columns';
        $image_size = 'wikb_700x600';
    }

    $thumbnail_class = 'full-width-part';
    $post_details_class = 'full-width-part';
}
// THUMBNAIL
$post_img = '';
$thumbnail_src = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'wikb_about_230x300' );
if ($thumbnail_src) {
    $post_img = '<img class="blog_post_image" src="'. esc_url($thumbnail_src[0]) . '" alt="'.the_title_attribute('echo=0').'" />';
    $post_col = 'col-md-7';
}else{
    $post_col = 'col-md-12 no-featured-image';
}

$content_post   = get_post(get_the_ID());
$content = $content_post->post_content;
$content = apply_filters('the_content', $content);
$content = str_replace(']]>', ']]&gt;', $content);
$content = strip_tags($content);
?>

<?php if ( ! class_exists( 'ReduxFrameworkPlugin' ) ) { ?>
<article id="post-<?php the_ID(); ?>" <?php post_class('single-post col-md-12 list-view blogloop-v2 col-md-6 grid-two-columns blogloop-no-flex'); ?>>

    <!-- POST DETAILS -->
    <div class="blog_custom">
        <!-- POST THUMBNAIL -->
        <?php if ($post_img) { ?>
            <div class="post-thumbnail col-md-5">
                <a href="<?php echo esc_url(get_the_permalink()); ?>" class="relative">
                     <?php echo wp_kses_post($post_img); ?>
                </a>
            </div>
        <?php } ?>

        <!-- POST DETAILS -->
        <div class="<?php echo esc_attr($post_col)." ".esc_attr($custom_no_padding); ?> post-details">
            <h3 class="post-name row">
                <?php if(is_sticky(get_the_ID())){ ?>
                    <!-- STICKY POST LABEL -->
                    <span class="post-sticky-label">
                        <i class="fa fa-bookmark"></i>
                    </span>
                <?php } ?>
                <a href="<?php echo esc_url(get_the_permalink()); ?>" rel="bookmark"><?php echo esc_url(the_title()); ?></a>
            </h3>

            <div class="post-excerpt row">
                <?php 
                if (get_the_excerpt() || get_the_excerpt() != '') {
                    echo wp_kses_post(wikb_excerpt_limit(get_the_excerpt(), 20)) ;
                }
                ?>
                <div class="text-element content-element">
                    <p><a class="more-link-knowledge" href="<?php echo esc_url(get_the_permalink()); ?>"><?php echo esc_html__('read more','wikb');?></a></p>
                </div>
           </div>
        </div>                       
    </div>
</article>

<?php }else{ ?>

<article id="post-<?php the_ID(); ?>" <?php post_class('single-post list-view blogloop-v2 blogloop-no-flex '.esc_attr($master_class).' '.esc_attr($type_class)); ?> >
    <div class="blog_custom">
        <?php /*POST THUMBNAIL*/ ?>
        <?php if ($post_img) { ?>
            <div class="post-thumbnail col-md-5">
                <a href="<?php echo esc_url(get_the_permalink()); ?>" class="relative">
                    <?php echo wp_kses_post($post_img); ?>
                </a>
            </div>
        <?php } ?>

        <!-- POST DETAILS -->
        <div class="<?php echo esc_attr($post_col)." ".esc_attr($custom_no_padding); ?> post-details">
             <h3 class="post-name row">
                <?php if(is_sticky(get_the_ID())){ ?>
                    <!-- STICKY POST LABEL -->
                    <span class="post-sticky-label">
                        <i class="fa fa-bookmark"></i>
                    </span>
                <?php } ?>
                <a href="<?php echo esc_url(get_the_permalink()); ?>" rel="bookmark"><?php echo esc_url(the_title()); ?></a>
            </h3>

            <div class="post-excerpt row">
                <?php 
                if (get_the_excerpt() || get_the_excerpt() != '') {
                    echo wp_kses_post(wikb_excerpt_limit(get_the_excerpt(), 20)) . '[...]';
                }
                ?>
                <div class="text-element content-element">
                    <p><a class="more-link-knowledge" href="<?php echo esc_url(get_the_permalink()); ?>"><?php echo esc_html__('read more','wikb');?></a></p>
                </div>
            </div>
         </div>                       
    </div>
</article>

<?php } ?>
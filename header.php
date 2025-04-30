<!DOCTYPE html>
<html <?php language_attributes(); ?> id="medilink-html">

<head>
    <meta charset="<?php esc_attr(bloginfo( 'charset' )); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <?php if ( ! function_exists( 'has_site_icon' ) || ! has_site_icon() ) { ?>
        <link rel="shortcut icon" href="<?php echo esc_url(wikb('mt_favicon', 'url')); ?>">
    <?php } ?>
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php if ( function_exists( 'wp_body_open' ) ) {
wp_body_open();
} ?>
    <?php /* PAGE PRELOADER */ ?>
    <?php
        if (wikb('mt_preloader_status')) {
            echo '<div class="wikb_preloader_holder '.wp_kses_post(wikb('mt_preloader_animation')).'">'.wp_kses_post(wikb_loader_animation()).'</div>';
        } 
    ?>
	
    <?php 
    $below_slider_headers = array('header5', 'header6', 'header7', 'header8');
    $normal_headers = array('header1', 'header2', 'header3', 'header4');
    $custom_header_options_status = get_post_meta( get_the_ID(), 'smartowl_custom_header_options_status', true );
    $header_custom_variant = get_post_meta( get_the_ID(), 'smartowl_header_custom_variant', true );
    $header_layout = wikb('mt_header_layout');
    if (isset($custom_header_options_status) && $custom_header_options_status == 'yes') {
        $header_layout = $header_custom_variant;
    }
    ?>

    <?php 
    $below_slider_headers = array('header5', 'header6', 'header7', 'header8');
    $normal_headers = array('header1', 'header2', 'header3', 'header4');
    $custom_header_options_status = get_post_meta( get_the_ID(), 'smartowl_custom_header_options_status', true );
    $header_custom_variant = get_post_meta( get_the_ID(), 'smartowl_header_custom_variant', true );
    $header_layout = wikb('mt_header_layout');
    if (isset($custom_header_options_status) && $custom_header_options_status == 'yes') {
        $header_layout = $header_custom_variant;
    }
    ?>
    <?php
    if (!in_array('login-register-page', get_body_class())) { ?>
        <div class="modeltheme-modal" id="modal-log-in">
            <div class="modeltheme-content" id="login-modal-content">
                <h3 class="relative">
                    <?php echo esc_html__('Login to Your Account','wikb'); ?>
                </h3>
                <div class="modal-content row">
                    <div class="col-md-12">
                        
                        <form name="loginform" id="loginform" action="<?php echo wp_login_url(); ?>" method="post">
            
                            <p class="login-username">
                                <label for="user_login"><?php echo esc_html__('Username or Email Address','wikb'); ?></label>
                                <i class="fa fa-user-o" aria-hidden="true"></i><input type="text" name="log" id="user_login" class="input" value="" size="20" placeholder="<?php echo esc_attr__('Username','wikb'); ?>">
                            </p>
                            <p class="login-password">
                                <label for="user_pass"><?php echo esc_html__('Password','wikb'); ?></label>
                                <i class="fa fa-pencil-square-o" aria-hidden="true"></i><input type="password" name="pwd" id="user_pass" class="input" value="" size="20" placeholder="<?php echo esc_attr__('Password','wikb'); ?>">
                            </p>
                            
                            <p class="login-remember">
                                <label>
                                    <input name="rememberme" type="checkbox" id="rememberme" value="forever">
                                    <?php echo esc_html__('Remember Me','wikb'); ?>
                                </label>
                            </p>
                            <div class="row-buttons">
                                <p class="login-submit">
                                    <input type="submit" name="wp-submit" id="wp-submit" class="button button-primary" value="<?php echo esc_attr__('Log In','wikb'); ?>">
                                    <input type="hidden" name="redirect_to" value="<?php echo get_site_url(); ?>">
                                </p>
                                <?php if (  get_option('users_can_register')) { ?>
                                    <p class="btn-register-p">
                                        <a class="btn btn-register" href="<?= get_the_permalink(49499) ?>"><?php echo esc_html__('Register','wikb'); ?></a>
                                    </p>
                                <?php } else { ?>
                                    <p class="um-notice err text-center"><?php echo esc_html__('Registration is currently disabled','wikb'); ?></p>
                                <?php } ?>
                                <p class="woocommerce-LostPassword lost_password">
                                    <a href="<?= get_the_permalink(50003) ?>"><?php echo esc_html__('Lost your password?','wikb'); ?></a>
                                </p>
                            </div>
                            
                        </form>
                        
                                                    
                        <?php if (function_exists('yith_ywsl_constructor')) { ?>
                            <div class="separator-modal"><?php echo esc_html__('OR','wikb'); ?></div>
                            <?php echo do_shortcode("[yith_wc_social_login]"); ?>
                        <?php } ?>
                        
                    </div>
                </div>
            </div>
        
        </div>
    <?php } ?>
    <div class="modeltheme-overlay"></div>

    <?php /* SEARCH BLOCK */ ?>
    <?php if(wikb('mt_header_is_search') == true){ ?>
        <!-- Fixed Search Form -->
        <div class="fixed-search-overlay">
            <!-- Close Sidebar Menu + Close Overlay -->
            <i class="icon-close icons"></i>
            <!-- INSIDE SEARCH OVERLAY -->
            <div class="fixed-search-inside">
                <div class="modeltheme-search">
                    <form method="GET" action="<?php echo esc_url(home_url('/')); ?>">
                        <input class="search-input" placeholder="<?php echo esc_attr__('Enter search term...', 'wikb'); ?>" type="search" value="" name="s" id="search" />
                        <i class="fa fa-search"></i>
                        <input type="hidden" name="post_type" value="post" />
                    </form>
                </div>
            </div>
        </div>
    <?php } ?>


    <!-- PAGE #page -->
    <div id="page" class="hfeed site">
        <?php
            $page_slider = get_post_meta( get_the_ID(), 'select_revslider_shortcode', true );
            if (in_array($header_layout, $below_slider_headers)){
                // Revolution slider
                if (!empty($page_slider)) {
                    echo '<div class="theme_header_slider">';
                    echo do_shortcode('[rev_slider '.esc_attr($page_slider).']');
                    echo '</div>';
                }

                // Header template variant
                echo wp_kses_post(wikb_current_header_template());
            }elseif (in_array($header_layout, $normal_headers)){
                // Header template variant
                echo wp_kses_post(wikb_current_header_template());
                // Revolution slider
                if (!empty($page_slider)) {
                    echo '<div class="theme_header_slider">';
                    echo do_shortcode('[rev_slider '.esc_attr($page_slider).']');
                    echo '</div>';
                }
            }else{
                echo wp_kses_post(wikb_current_header_template());
            }
        ?>
		
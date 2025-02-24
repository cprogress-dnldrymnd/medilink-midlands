<!DOCTYPE html>
<html <?php language_attributes(); ?>>

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
	<div class="top-bar">
		<div class="container-fluid p-0">
			<?php if(is_user_logged_in())  { ?>
				<?php
					$current_user = wp_get_current_user();
					$display_name = $current_user->display_name;
				?>
				<span>
					Welcome <?= $display_name ?>
				</span>
			<?php } else {?>
				<a href="#">
					Sign Up Today & Become Part of The Community
				</a>
			<?php } ?>
		</div>
	</div>
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
                                        <a class="btn btn-register" id="register-modal"><?php echo esc_html__('Register','wikb'); ?></a>
                                    </p>
                                <?php } else { ?>
                                    <p class="um-notice err text-center"><?php echo esc_html__('Registration is currently disabled','wikb'); ?></p>
                                <?php } ?>
                                <p class="woocommerce-LostPassword lost_password">
                                    <a href="<?php echo esc_url(wp_lostpassword_url()); ?>"><?php echo esc_html__('Lost your password?','wikb'); ?></a>
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
            <div class="modeltheme-content" id="signup-modal-content">
                <h3 class="relative">
                    <?php echo esc_html__('Personal Details','wikb'); ?>
                </h3>
                <div class="modal-content row">
                    <div class="col-md-12">
                        <?php if ( class_exists( 'WooCommerce' ) ) { ?>
                            <?php if ( get_option( 'woocommerce_enable_myaccount_registration' ) === 'yes' ) { ?>
                                <div class="u-column2 col-2">
                                    <form method="post" class="woocommerce-form woocommerce-form-register register">
                                        <?php do_action( 'woocommerce_register_form_start' ); ?>
                                        <?php if ( 'no' === get_option( 'woocommerce_registration_generate_username' ) ) : ?>
                                            <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                                                <input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="username" id="reg_username" autocomplete="username" value="<?php echo ( ! empty( $_POST['username'] ) ) ? esc_attr( wp_unslash( $_POST['username'] ) ) : ''; ?>" placeholder="<?php esc_attr_e( 'Username', 'wikb' ); ?>" />
                                            </p>
                                        <?php endif; ?>
                                        <p class="form-row form-row-first">
                                            <input type="text" class="input-text" name="billing_first_name" id="billing_first_name" value="<?php if (!empty($_POST['billing_first_name'])) esc_attr_e($_POST['billing_first_name'], 'wikb'); ?>" placeholder="<?php esc_attr_e( 'First name', 'wikb' ); ?>" />
                                        </p>
                                        <p class="form-row form-row-last">
                                            <input type="text" class="input-text" name="billing_last_name" id="billing_last_name" value="<?php if (!empty($_POST['billing_last_name'])) esc_attr_e($_POST['billing_last_name'], 'wikb'); ?>" placeholder="<?php esc_attr_e( 'Last name', 'wikb' ); ?>" />
                                        </p>
                                        <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                                            <input type="email" class="woocommerce-Input woocommerce-Input--text input-text" name="email" id="reg_email" autocomplete="email" value="<?php echo ( ! empty( $_POST['email'] ) ) ? esc_attr( wp_unslash( $_POST['email'] ) ) : ''; ?>" placeholder="<?php esc_attr_e( 'Email address', 'wikb' ); ?>" />
                                        </p>
                                        <?php if ( 'no' === get_option( 'woocommerce_registration_generate_password' ) ) : ?>
                                            <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                                                <input type="password" class="woocommerce-Input woocommerce-Input--text input-text" name="password" id="reg_password" autocomplete="new-password" placeholder="Password" />
                                            </p>
                                        <?php endif; ?>
                                        <?php do_action( 'woocommerce_register_form' ); ?>
                                        <p class="woocommerce-FormRow form-row">
                                            <?php wp_nonce_field( 'woocommerce-register', 'woocommerce-register-nonce' ); ?>
                                            <button type="submit" class="woocommerce-Button button" name="register" value="<?php esc_attr_e( 'Register', 'wikb' ); ?>"><?php esc_html_e( 'Register', 'wikb' ); ?></button>
                                        </p>
                                        <?php do_action( 'woocommerce_register_form_end' ); ?>
                                    </form>
                                    <div class="separator-modal"><?php echo esc_html__('OR','wikb'); ?></div>
                                    <?php if (function_exists('yith_ywsl_constructor')) { ?>
                                        <?php echo do_shortcode("[yith_wc_social_login]"); ?>
                                    <?php } ?>
                                </div>
                            <?php } ?>
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
		
<?php
if (is_user_logged_in() && get_current_user_id() != 164) {
  $button = 'Upgrade';
} else {
  $button = 'Join Us';
}
?>
<header class="header2">
  <div class="top-bar">
    <div class="container-fluid p-0">
      <?php if (is_user_logged_in() && get_current_user_id() != 164) { ?>
        <?php
        $current_user = wp_get_current_user();
        $display_name = $current_user->display_name;
        ?>
        <span>
          Welcome <?= $display_name ?>
        </span>
      <?php } else { ?>
        <a href="#">
          Sign Up Today & Become Part of The Community
        </a>
      <?php } ?>
    </div>
  </div>
  <!-- BOTTOM BAR -->
  <nav class="navbar navbar-default logo-infos" id="modeltheme-main-head">
    <div class="container">
      <div class="row">

        <!-- LOGO -->
        <div class="navbar-header col-md-3">
          <!-- NAVIGATION BURGER MENU -->
          <div class="mobile-only">
            <?php if (is_user_logged_in() && get_current_user_id() != 164) { ?>
              <div class="mobile-buttons">
                <div id="join-us-button" class="join-us-button"><a href="/join-us/"><?= $button ?></a> </div>
                <a href="<?php echo do_shortcode('[um_author_profile_link raw=1 user_id=' . get_current_user_id() . ']') ?>" class="profile">
                  <i class="fa fa-user" aria-hidden="true"></i>
                </a>
              </div>
            <?php } ?>
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
              <span class="sr-only"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>


          </div>



          <?php if (class_exists('ReduxFrameworkPlugin')) {
            $custom_header_activated = get_post_meta(get_the_ID(), 'smartowl_custom_header_options_status', true);
            $header_v = get_post_meta(get_the_ID(), 'smartowl_header_custom_variant', true);
            $custom_logo_url = get_post_meta(get_the_ID(), 'smartowl_header_custom_logo', true);

            if ($custom_header_activated == 'yes' && isset($custom_logo_url) && !empty($custom_logo_url)) { ?>

              <h1 class="logo">
                <a href="<?php echo esc_url(get_site_url()); ?>">
                  <img src="<?php echo esc_url($custom_logo_url); ?>" alt="<?php echo esc_attr(get_bloginfo()); ?>" />
                </a>
              </h1>

              <?php } else {

              if (wikb('mt_logo', 'url')) { ?>
                <div class="logo">
                  <a href="<?php echo esc_url(get_site_url()); ?>">
                    <img src="<?php echo esc_url(wikb('mt_logo', 'url')); ?>" alt="<?php echo esc_attr(get_bloginfo()); ?>" />
                  </a>
                </div>
              <?php } else { ?>
                <div class="logo no-logo">
                  <a href="<?php echo esc_url(get_site_url()); ?>">
                    <?php echo esc_html(get_bloginfo()); ?>
                  </a>
                </div>
              <?php } ?>
            <?php } ?>

          <?php } else { ?>
            <div class="logo no-logo">
              <a href="<?php echo esc_url(get_site_url()); ?>">
                <?php echo esc_html(get_bloginfo()); ?>
              </a>
            </div>
          <?php } ?>
        </div>

        <!-- NAV MENU -->
        <div id="navbar" class="navbar-collapse collapse col-md-9">
          <ul class="menu nav navbar-nav pull-right nav-effect nav-menu">
            <?php
            if (has_nav_menu('primary')) {
              $defaults = array(
                'menu'            => '',
                'container'       => false,
                'container_class' => '',
                'container_id'    => '',
                'menu_class'      => 'menu',
                'menu_id'         => '',
                'echo'            => true,
                'fallback_cb'     => false,
                'before'          => '',
                'after'           => '',
                'link_before'     => '',
                'link_after'      => '',
                'items_wrap'      => '%3$s',
                'depth'           => 0,
                'walker'          => ''
              );

              $defaults['theme_location'] = 'primary';

              wp_nav_menu($defaults);
              /* my account */
              if (function_exists('run_simple_support_system') && class_exists('ReduxFrameworkPlugin')) { ?>

                <?php $switch = wikb('mt_header_is_account');
                if ($switch == 1) { ?>

                  <?php if (is_user_logged_in() && get_current_user_id() != 164) { ?> <!-- logged in -->

                    <li class="menu-item mt-header-account">

                      <div id="dropdown-user-profile" class="ddmenu">
                        <a class="profile">
                          <i class="fa fa-user" aria-hidden="true"></i>
                        </a>
                        <ul>
                          <?php $mt_purchases_link_page = wikb('mt_purchases_link_page'); ?>
                          <?php $mt_tickets_link_page = wikb('mt_tickets_link_page'); ?>
                          <?php if (!empty($mt_purchases_link_page)) { ?>
                            <li><a href="<?php echo esc_url($mt_purchases_link_page); ?>">
                                <i class="icon-bag icons"></i> <?php echo esc_html__('My Purchases', 'wikb'); ?></a>
                            </li>
                          <?php } ?>
                          <?php if (!empty($mt_tickets_link_page)) { ?>
                            <li><a href="<?php echo esc_url($mt_tickets_link_page); ?>">
                                <i class="icon-layers icons"></i> <?php echo esc_html__('Create ticket', 'wikb'); ?></a>
                            </li>
                          <?php } ?>
                          <li><a href="<?php echo do_shortcode('[um_author_profile_link raw=1 user_id=' . get_current_user_id() . ']') ?>">
                              <i class="icon-user icons"></i> <?php echo esc_html__('Profile', 'wikb'); ?></a>
                          </li>
                          <div class="dropdown-divider"></div>
                          <li><a href="<?php echo esc_url(wp_logout_url(home_url())); ?>">
                              <i class="icon-logout icons"></i> <?php echo esc_html__('Log Out', 'wikb'); ?></a>
                          </li>
                        </ul>
                      </div>
                    </li>

                  <?php } else { ?> <!-- logged out -->
                    <li id="nav-menu-login" class="nav-menu-account meraki-logoin">
                      <?php if (is_404()) { ?>
                        <a href="/login" class="modeltheme-trigger"><?php esc_html_e('Sign In', 'wikb'); ?></a>
                      <?php } else { ?>
                        <a href="<?php echo esc_url('#'); ?>" data-modal="modal-log-in" class="modeltheme-trigger"><?php esc_html_e('Sign In', 'wikb'); ?></a>
                      <?php } ?>
                      <?php $mt_login_link_page = wikb('mt_login_link_page'); ?>
                    </li>
                  <?php } ?>

                  <li id="join-us-button" class="join-us-button"><a href="/join-us/"><?= $button ?></a> </li>
                <?php } ?> <!--  switch  -->
            <?php } /* function exist */
            } else {
              echo '<p class="no-menu text-left">';
              echo esc_html__('Primary navigation menu is missing. ', 'wikb');
              echo '</p>';
            }
            ?>
          </ul>
        </div>
      </div>
    </div>
  </nav>
</header>
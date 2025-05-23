<?php /* Template: Profile 2 */
if (!defined('ABSPATH')) {
    exit;
}
$description_key = UM()->profile()->get_show_bio_key($args);
?>

<div
    class="um <?php echo esc_attr($this->get_class($mode)); ?> um-<?php echo esc_attr($form_id); ?> um-role-<?php echo esc_attr(um_user('role')); ?> ">

    <div class="um-form" data-mode="<?php echo esc_attr($mode) ?>">

        <?php
        /**
         * UM hook
         *
         * @type action
         * @title um_profile_before_header
         * @description Some actions before profile form header
         * @input_vars
         * [{"var":"$args","type":"array","desc":"Profile form shortcode arguments"}]
         * @change_log
         * ["Since: 2.0"]
         * @usage add_action( 'um_profile_before_header', 'function_name', 10, 1 );
         * @example
         * <?php
         * add_action( 'um_profile_before_header', 'my_profile_before_header', 10, 1 );
         * function my_profile_before_header( $args ) {
         *     // your code here
         * }
         * ?>
         */
        do_action('um_profile_before_header', $args);

        if (um_is_on_edit_profile()) { ?>
            <form method="post" action="" data-description_key="<?php echo esc_attr($description_key); ?>">
            <?php }

        /**
         * UM hook
         *
         * @type action
         * @title um_profile_header_cover_area
         * @description Profile header cover area
         * @input_vars
         * [{"var":"$args","type":"array","desc":"Profile form shortcode arguments"}]
         * @change_log
         * ["Since: 2.0"]
         * @usage add_action( 'um_profile_header_cover_area', 'function_name', 10, 1 );
         * @example
         * <?php
         * add_action( 'um_profile_header_cover_area', 'my_profile_header_cover_area', 10, 1 );
         * function my_profile_header_cover_area( $args ) {
         *     // your code here
         * }
         * ?>
         */
        do_action('um_profile_header_cover_area', $args);

        /**
         * UM hook
         *
         * @type action
         * @title um_profile_header
         * @description Profile header area
         * @input_vars
         * [{"var":"$args","type":"array","desc":"Profile form shortcode arguments"}]
         * @change_log
         * ["Since: 2.0"]
         * @usage add_action( 'um_profile_header', 'function_name', 10, 1 );
         * @example
         * <?php
         * add_action( 'um_profile_header', 'my_profile_header', 10, 1 );
         * function my_profile_header( $args ) {
         *     // your code here
         * }
         * ?>
         */
        do_action('um_profile_header', $args);

        /**
         * UM hook
         *
         * @type filter
         * @title um_profile_navbar_classes
         * @description Additional classes for profile navbar
         * @input_vars
         * [{"var":"$classes","type":"string","desc":"UM Posts Tab query"}]
         * @change_log
         * ["Since: 2.0"]
         * @usage
         * <?php add_filter( 'um_profile_navbar_classes', 'function_name', 10, 1 ); ?>
         * @example
         * <?php
         * add_filter( 'um_profile_navbar_classes', 'my_profile_navbar_classes', 10, 1 );
         * function my_profile_navbar_classes( $classes ) {
         *     // your code here
         *     return $classes;
         * }
         * ?>
         */
        $classes = apply_filters('um_profile_navbar_classes', ''); ?>



            <div class="um-profile-navbar <?php echo esc_attr($classes); ?>">
                <?php
                /**
                 * UM hook
                 *
                 * @type action
                 * @title um_profile_navbar
                 * @description Profile navigation bar
                 * @input_vars
                 * [{"var":"$args","type":"array","desc":"Profile form shortcode arguments"}]
                 * @change_log
                 * ["Since: 2.0"]
                 * @usage add_action( 'um_profile_navbar', 'function_name', 10, 1 );
                 * @example
                 * <?php
                 * add_action( 'um_profile_navbar', 'my_profile_navbar', 10, 1 );
                 * function my_profile_navbar( $args ) {
                 *     // your code here
                 * }
                 * ?>
                 */
                do_action('um_profile_navbar', $args); ?>
                <div class="um-clear"></div>
            </div>

            <?php
            /**
             * UM hook
             *
             * @type action
             * @title um_profile_menu
             * @description Profile menu
             * @input_vars
             * [{"var":"$args","type":"array","desc":"Profile form shortcode arguments"}]
             * @change_log
             * ["Since: 2.0"]
             * @usage add_action( 'um_profile_menu', 'function_name', 10, 1 );
             * @example
             * <?php
             * add_action( 'um_profile_menu', 'my_profile_navbar', 10, 1 );
             * function my_profile_navbar( $args ) {
             *     // your code here
             * }
             * ?>
             */
            do_action('um_profile_menu', $args);



            if (um_is_on_edit_profile() || UM()->user()->preview) {

                $nav = 'main';
                $subnav = UM()->profile()->active_subnav();
                $subnav = !empty($subnav) ? $subnav : 'default'; ?>

                <div class="um-profile-body <?php echo esc_attr($nav . ' ' . $nav . '-' . $subnav); ?>">

                    <?php
                    /**
                     * UM hook
                     *
                     * @type action
                     * @title um_profile_content_{$nav}
                     * @description Custom hook to display tabbed content
                     * @input_vars
                     * [{"var":"$args","type":"array","desc":"Profile form shortcode arguments"}]
                     * @change_log
                     * ["Since: 2.0"]
                     * @usage add_action( 'um_profile_content_{$nav}', 'function_name', 10, 1 );
                     * @example
                     * <?php
                     * add_action( 'um_profile_content_{$nav}', 'my_profile_content', 10, 1 );
                     * function my_profile_content( $args ) {
                     *     // your code here
                     * }
                     * ?>
                     */
                    do_action("um_profile_content_{$nav}", $args);

                    /**
                     * UM hook
                     *
                     * @type action
                     * @title um_profile_content_{$nav}_{$subnav}
                     * @description Custom hook to display tabbed content
                     * @input_vars
                     * [{"var":"$args","type":"array","desc":"Profile form shortcode arguments"}]
                     * @change_log
                     * ["Since: 2.0"]
                     * @usage add_action( 'um_profile_content_{$nav}_{$subnav}', 'function_name', 10, 1 );
                     * @example
                     * <?php
                     * add_action( 'um_profile_content_{$nav}_{$subnav}', 'my_profile_content', 10, 1 );
                     * function my_profile_content( $args ) {
                     *     // your code here
                     * }
                     * ?>
                     */
                    do_action("um_profile_content_{$nav}_{$subnav}", $args); ?>

                    <div class="clear"></div>
                </div>

                <?php if (!UM()->user()->preview) { ?>

            </form>

        <?php }
            } else {


                $menu_enabled = UM()->options()->get('profile_menu');
                $tabs = UM()->profile()->tabs_active();

                $nav = UM()->profile()->active_tab();
                $subnav = UM()->profile()->active_subnav();
                $subnav = !empty($subnav) ? $subnav : 'default';

                if ($menu_enabled || !empty($tabs[$nav]['hidden'])) {
                    $job_role = get_user_meta(um_user('ID'), 'job_role', true);
                    $organisation = get_user_meta(um_user('ID'), 'organisation', true);
                    $phone_number = get_user_meta(um_user('ID'), 'phone_number', true);
                    $website_url = get_user_meta(um_user('ID'), 'website_url', true);
                    $address = get_user_meta(um_user('ID'), 'address', true);
                    $title = get_user_meta(um_user('ID'), 'ttle', true);
                    $organisation_description = get_user_meta(um_user('ID'), 'organisation_description', true);

        ?>

            <div class="um-profile-body <?php echo esc_attr($nav . ' ' . $nav . '-' . $subnav); ?>">
                <div class="um-main-meta um-main-meta-v2">

                    <?php if ($args['show_name']) { ?>
                        <div class="um-title">
                            <?= $title ?>
                        </div>
                        <div class="um-name">

                            <a href="<?php echo esc_url(um_user_profile_url()); ?>"
                                title="<?php echo esc_attr(um_user('display_name')); ?>"><?php echo um_user('display_name', 'html'); ?></a>

                            <?php
                            /**
                             * UM hook
                             *
                             * @type action
                             * @title um_after_profile_name_inline
                             * @description Insert after profile name some content
                             * @input_vars
                             * [{"var":"$args","type":"array","desc":"Form Arguments"}]
                             * @change_log
                             * ["Since: 2.0"]
                             * @usage add_action( 'um_after_profile_name_inline', 'function_name', 10, 1 );
                             * @example
                             * <?php
                             * add_action( 'um_after_profile_name_inline', 'my_after_profile_name_inline', 10, 1 );
                             * function my_after_profile_name_inline( $args ) {
                             *     // your code here
                             * }
                             * ?>
                             */
                            do_action('um_after_profile_name_inline', $args, um_user('ID'));
                            ?>
                        </div>
                    <?php } ?>

                    <div class="profile-meta-list-holder">

                        <ul class="profile-meta-list">
                            <?php if ($job_role) { ?>
                                <li><?= $job_role ?></li>
                            <?php } ?>
                            <?php if ($organisation) { ?>
                                <li><?= $organisation ?></li>
                            <?php } ?>
                            <?php if ($website_url) { ?>
                                <li><a href="<?= $website_url ?>" target="_blank">Visit Website</a></li>
                            <?php } ?>


                        </ul>
                        <ul class="profile-meta-list">
                            <?php if ($phone_number) { ?>
                                <li><?= $phone_number ?></li>
                            <?php } ?>
                            <?php if ($address) { ?>
                                <li><?= $address ?></li>
                            <?php } ?>
                        </ul>
                        <?php if ($organisation_description) { ?>
                            <div class="org-description">
                                <?= wpautop($organisation_description) ?>
                            </div>
                        <?php } ?>
                    </div>

                    <?php if (!isset($_GET['profiletab']) || (isset($_GET['profiletab']) && $_GET['profiletab'] == 'main')) { ?>
                        <?php if (is_user_logged_in() && get_current_user_id() == um_user('ID')) { ?>
                            <div class="edit-profile-holder">
                                <a href="<?= esc_url(um_edit_profile_url()) ?>">
                                    Edit profile
                                </a>
                            </div>
                        <?php } ?>
                    <?php } else if (isset($_GET['profiletab']) && $_GET['profiletab'] == 'posts') { ?>
                        <?= do_shortcode('[user_posts]') ?>
                    <?php } else if (isset($_GET['profiletab']) && $_GET['profiletab'] == 'marketplace') {  ?>
                        <?= do_shortcode('[user_marketplace]') ?>
                    <?php } else if (isset($_GET['profiletab']) && $_GET['profiletab'] == 'directory') {  ?>
                        <?= do_shortcode('[user_directory]') ?>
                    <?php } ?>

                </div>

                <?php
                    // Custom hook to display tabbed content
                    /**
                     * UM hook
                     *
                     * @type action
                     * @title um_profile_content_{$nav}
                     * @description Custom hook to display tabbed content
                     * @input_vars
                     * [{"var":"$args","type":"array","desc":"Profile form shortcode arguments"}]
                     * @change_log
                     * ["Since: 2.0"]
                     * @usage add_action( 'um_profile_content_{$nav}', 'function_name', 10, 1 );
                     * @example
                     * <?php
                     * add_action( 'um_profile_content_{$nav}', 'my_profile_content', 10, 1 );
                     * function my_profile_content( $args ) {
                     *     // your code here
                     * }
                     * ?>
                     */
                    do_action("um_profile_content_{$nav}", $args);

                    /**
                     * UM hook
                     *
                     * @type action
                     * @title um_profile_content_{$nav}_{$subnav}
                     * @description Custom hook to display tabbed content
                     * @input_vars
                     * [{"var":"$args","type":"array","desc":"Profile form shortcode arguments"}]
                     * @change_log
                     * ["Since: 2.0"]
                     * @usage add_action( 'um_profile_content_{$nav}_{$subnav}', 'function_name', 10, 1 );
                     * @example
                     * <?php
                     * add_action( 'um_profile_content_{$nav}_{$subnav}', 'my_profile_content', 10, 1 );
                     * function my_profile_content( $args ) {
                     *     // your code here
                     * }
                     * ?>
                     */
                    do_action("um_profile_content_{$nav}_{$subnav}", $args); ?>

                <div class="clear">
                </div>
            </div>

    <?php }
            }

            do_action('um_profile_footer', $args); ?>
    </div>
</div>

<?= do_shortcode('[Modal-Window id="1"]') ?>
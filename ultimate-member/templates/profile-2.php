<?php /* Template: Profile 2 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$description_key = UM()->profile()->get_show_bio_key( $args );
?>

<div class="um <?php echo esc_attr( $this->get_class( $mode ) ); ?> um-<?php echo esc_attr( $form_id ); ?> um-role-<?php echo esc_attr( um_user( 'role' ) ); ?> ">

	<div class="um-form" data-mode="<?php echo esc_attr( $mode ) ?>">

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
		do_action( 'um_profile_before_header', $args );

		if ( um_is_on_edit_profile() ) { ?>
			<form method="post" action="" data-description_key="<?php echo esc_attr( $description_key ); ?>">
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
		do_action( 'um_profile_header_cover_area', $args );

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
		do_action( 'um_profile_header', $args );

		
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
		do_action( 'um_profile_menu', $args );

		if ( um_is_on_edit_profile() || UM()->user()->preview ) {

			$nav = 'main';
			$subnav = UM()->profile()->active_subnav();
			$subnav = ! empty( $subnav ) ? $subnav : 'default'; ?>

			<div class="um-profile-body <?php echo esc_attr( $nav . ' ' . $nav . '-' . $subnav ); ?>">

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
				do_action( "um_profile_content_{$nav}_{$subnav}", $args ); ?>

				<div class="clear"></div>
			</div>

			<?php if ( ! UM()->user()->preview ) { ?>

			</form>

			<?php }
		} 

		do_action( 'um_profile_footer', $args ); ?>
	</div>
</div>

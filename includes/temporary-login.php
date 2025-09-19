<?php
/**
 * Plugin Name:       Temporary Login Generator
 * Description:       Create single-use or limited-use login keys that grant temporary access to a specified user account.
 * Version:           1.0.0
 * Author:            Gemini
 * Author URI:        https://gemini.google.com
 */

// Prevent direct access to the file.
if (!defined('ABSPATH')) {
    exit;
}

class Temporary_Login_Plugin
{
    /**
     * Constructor to hook everything up.
     */
    public function __construct()
    {
        // Register the custom post type for temporary logins.
        add_action('init', [$this, 'register_cpt_temporary_login']);

        // Add custom meta boxes to the post type editor screen.
        add_action('add_meta_boxes', [$this, 'add_login_meta_boxes']);

        // Save the custom meta data when a post is saved.
        add_action('save_post_temp_login', [$this, 'save_login_meta_data']);
        
        // Register the shortcode for the login form.
        add_shortcode('temporary_login_form', [$this, 'render_login_form']);

        // Handle the login form submission before the page loads.
        add_action('template_redirect', [$this, 'handle_login_submission']);
    }

    /**
     * Registers the 'temp_login' Custom Post Type.
     */
    public function register_cpt_temporary_login()
    {
        $labels = [
            'name'                  => _x('Temporary Logins', 'Post Type General Name', 'text_domain'),
            'singular_name'         => _x('Temporary Login', 'Post Type Singular Name', 'text_domain'),
            'menu_name'             => __('Temporary Logins', 'text_domain'),
            'name_admin_bar'        => __('Temporary Login', 'text_domain'),
            'archives'              => __('Login Archives', 'text_domain'),
            'attributes'            => __('Login Attributes', 'text_domain'),
            'parent_item_colon'     => __('Parent Login:', 'text_domain'),
            'all_items'             => __('All Logins', 'text_domain'),
            'add_new_item'          => __('Add New Temporary Login', 'text_domain'),
            'add_new'               => __('Add New', 'text_domain'),
            'new_item'              => __('New Login', 'text_domain'),
            'edit_item'             => __('Edit Login', 'text_domain'),
            'update_item'           => __('Update Login', 'text_domain'),
            'view_item'             => __('View Login', 'text_domain'),
            'view_items'            => __('View Logins', 'text_domain'),
            'search_items'          => __('Search Login', 'text_domain'),
        ];
        $args = [
            'label'                 => __('Temporary Login', 'text_domain'),
            'description'           => __('Create and manage temporary access keys.', 'text_domain'),
            'labels'                => $labels,
            'supports'              => ['title'],
            'hierarchical'          => false,
            'public'                => false,
            'show_ui'               => true,
            'show_in_menu'          => true,
            'menu_position'         => 20,
            'menu_icon'             => 'dashicons-lock-duplicate',
            'show_in_admin_bar'     => true,
            'show_in_nav_menus'     => false,
            'can_export'            => true,
            'has_archive'           => false,
            'exclude_from_search'   => true,
            'publicly_queryable'    => false,
            'capability_type'       => 'post',
            'rewrite'               => false,
        ];
        register_post_type('temp_login', $args);
    }

    /**
     * Adds the meta box container.
     */
    public function add_login_meta_boxes()
    {
        add_meta_box(
            'temp_login_details_metabox',
            __('Temporary Login Settings', 'text_domain'),
            [$this, 'render_login_meta_box_content'],
            'temp_login', // The CPT slug
            'normal',
            'high'
        );
    }

    /**
     * Renders the content of the meta box.
     */
    public function render_login_meta_box_content($post)
    {
        // Add a nonce field for security.
        wp_nonce_field('temp_login_save_meta_data', 'temp_login_meta_nonce');

        // Get existing values.
        $user_id = get_post_meta($post->ID, '_temp_login_user_id', true);
        $login_limit = get_post_meta($post->ID, '_temp_login_limit', true);
        $login_count = get_post_meta($post->ID, '_temp_login_count', true);
        $login_key = get_post_meta($post->ID, '_temp_login_key', true);

        // Auto-generate a key if one doesn't exist.
        if (empty($login_key)) {
            $login_key = wp_generate_password(20, false);
        }

        // Set defaults for new posts.
        $login_limit = !empty($login_limit) ? absint($login_limit) : 1;
        $login_count = !empty($login_count) ? absint($login_count) : 0;

        ?>
        <style>
            .temp-login-table { width: 100%; }
            .temp-login-table td { padding: 8px 5px; }
            .temp-login-table tr td:first-child { font-weight: bold; width: 200px; }
            .temp-login-key-wrapper { position: relative; }
            .temp-login-key-wrapper input { width: 100%; padding-right: 80px; background-color: #f0f0f0; }
            .copy-btn { position: absolute; right: 5px; top: 50%; transform: translateY(-50%); cursor: pointer; }
        </style>
        <table class="form-table temp-login-table">
            <tbody>
                <!-- User to log in as -->
                <tr>
                    <td><label for="temp_login_user_id"><?php _e('User to Log In As:', 'text_domain'); ?></label></td>
                    <td>
                        <?php
                        wp_dropdown_users([
                            'name' => 'temp_login_user_id',
                            'id' => 'temp_login_user_id',
                            'selected' => $user_id,
                            'show_option_none' => __('&mdash; Select a User &mdash;'),
                            'class' => 'widefat',
                        ]);
                        ?>
                        <p class="description"><?php _e('This temporary key will log the person into this user account.', 'text_domain'); ?></p>
                    </td>
                </tr>

                <!-- Login Limit -->
                <tr>
                    <td><label for="temp_login_limit"><?php _e('Maximum Logins:', 'text_domain'); ?></label></td>
                    <td>
                        <input type="number" id="temp_login_limit" name="temp_login_limit" value="<?php echo esc_attr($login_limit); ?>" min="1" step="1" />
                        <p class="description"><?php _e('How many times can this key be used to log in?', 'text_domain'); ?></p>
                    </td>
                </tr>
                
                <!-- Login Key -->
                 <tr>
                    <td><label for="temp_login_key"><?php _e('Login Key:', 'text_domain'); ?></label></td>
                    <td>
                        <div class="temp-login-key-wrapper">
                            <input type="text" id="temp_login_key" name="temp_login_key" value="<?php echo esc_attr($login_key); ?>" readonly />
                            <button type="button" class="button button-secondary copy-btn" onclick="copyKey()">Copy</button>
                        </div>
                        <p class="description"><?php _e('Share this key and the login page URL with the user.', 'text_domain'); ?></p>
                    </td>
                </tr>

                <!-- Login Count -->
                <tr>
                    <td><?php _e('Times Used:', 'text_domain'); ?></td>
                    <td>
                        <strong><?php echo esc_html($login_count); ?></strong>
                         <p class="description"><?php _e('The current number of times this key has been used.', 'text_domain'); ?></p>
                    </td>
                </tr>
            </tbody>
        </table>
        <script>
            function copyKey() {
                const keyField = document.getElementById('temp_login_key');
                keyField.select();
                document.execCommand('copy');
                alert('Login key copied to clipboard!');
            }
        </script>
        <?php
    }

    /**
     * Saves the custom meta data.
     */
    public function save_login_meta_data($post_id)
    {
        // Check nonce.
        if (!isset($_POST['temp_login_meta_nonce']) || !wp_verify_nonce($_POST['temp_login_meta_nonce'], 'temp_login_save_meta_data')) {
            return;
        }

        // Check if the current user has permission.
        if (!current_user_can('edit_post', $post_id)) {
            return;
        }

        // Save User ID.
        if (isset($_POST['temp_login_user_id'])) {
            $user_id = absint($_POST['temp_login_user_id']);
            update_post_meta($post_id, '_temp_login_user_id', $user_id);
        }

        // Save Login Limit.
        if (isset($_POST['temp_login_limit'])) {
            $limit = absint($_POST['temp_login_limit']);
            update_post_meta($post_id, '_temp_login_limit', $limit);
        }
        
        // Save Login Key.
        if (isset($_POST['temp_login_key'])) {
            $key = sanitize_text_field($_POST['temp_login_key']);
            update_post_meta($post_id, '_temp_login_key', $key);
        }
    }
    
    /**
     * Handles the form submission for logging in.
     */
    public function handle_login_submission() {
        if (!isset($_POST['temp_login_nonce']) || !wp_verify_nonce($_POST['temp_login_nonce'], 'temp_login_action')) {
            return;
        }

        if (empty($_POST['temp_login_key'])) {
            // Redirect back with an error code for "empty".
            wp_redirect(add_query_arg('login_error', 'empty', wp_get_referer()));
            exit;
        }
        
        $key = sanitize_text_field($_POST['temp_login_key']);

        $args = [
            'post_type' => 'temp_login',
            'post_status' => 'publish',
            'posts_per_page' => 1,
            'meta_query' => [
                [
                    'key' => '_temp_login_key',
                    'value' => $key,
                    'compare' => '=',
                ],
            ],
        ];

        $login_posts = new WP_Query($args);

        if (!$login_posts->have_posts()) {
            wp_redirect(add_query_arg('login_error', 'invalid', wp_get_referer()));
            exit;
        }

        $post_id = $login_posts->posts[0]->ID;
        $user_id = get_post_meta($post_id, '_temp_login_user_id', true);
        $limit = (int) get_post_meta($post_id, '_temp_login_limit', true);
        $count = (int) get_post_meta($post_id, '_temp_login_count', true);
        
        if ($count >= $limit) {
            wp_redirect(add_query_arg('login_error', 'expired', wp_get_referer()));
            exit;
        }
        
        $user = get_user_by('id', $user_id);
        if (!$user) {
            wp_redirect(add_query_arg('login_error', 'nouser', wp_get_referer()));
            exit;
        }
        
        // Success! Let's log them in.
        $new_count = $count + 1;
        update_post_meta($post_id, '_temp_login_count', $new_count);

        wp_set_current_user($user_id, $user->user_login);
        wp_set_auth_cookie($user_id);
        do_action('wp_login', $user->user_login, $user);

        wp_redirect(admin_url());
        exit;
    }
    
    /**
     * Renders the HTML for the login form shortcode.
     */
    public function render_login_form()
    {
        if (is_user_logged_in()) {
            return '<div class="temp-login-container"><p>You are already logged in.</p> <a href="' . wp_logout_url(home_url()) . '">Log Out</a></div>';
        }

        ob_start();
        ?>
        <style>
            .temp-login-container { max-width: 400px; margin: 40px auto; padding: 30px; border: 1px solid #ddd; border-radius: 8px; background: #f9f9f9; box-shadow: 0 2px 5px rgba(0,0,0,0.1);}
            .temp-login-container h3 { text-align: center; margin-bottom: 25px; color: #333; }
            .temp-login-container .form-row { margin-bottom: 15px; }
            .temp-login-container label { display: block; margin-bottom: 5px; font-weight: bold; color: #555;}
            .temp-login-container input[type="text"] { width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box; }
            .temp-login-container .submit-button { width: 100%; padding: 12px; border: none; border-radius: 4px; background-color: #34BFA3; color: white; font-size: 16px; cursor: pointer; transition: background-color 0.2s; }
            .temp-login-container .submit-button:hover { background-color: #005f8a; }
            .temp-login-error { padding: 15px; margin-bottom: 20px; border: 1px solid transparent; border-radius: 4px; color: #a94442; background-color: #f2dede; border-color: #ebccd1; text-align: center; }
        </style>

        <div class="temp-login-container">
            <h3>Temporary Access Login</h3>
            
            <?php
            // Display error messages
            if (isset($_GET['login_error'])) {
                $error_code = sanitize_key($_GET['login_error']);
                $message = '';
                switch ($error_code) {
                    case 'empty':
                        $message = 'Please enter your login key.';
                        break;
                    case 'invalid':
                        $message = 'The login key you entered is not valid.';
                        break;
                    case 'expired':
                        $message = 'This login key has reached its maximum number of uses.';
                        break;
                    case 'nouser':
                         $message = 'The user associated with this key no longer exists.';
                        break;
                }
                if ($message) {
                    echo '<div class="temp-login-error">' . esc_html($message) . '</div>';
                }
            }
            ?>

            <form method="POST" action="">
                <?php wp_nonce_field('temp_login_action', 'temp_login_nonce'); ?>
                <div class="form-row">
                    <label for="temp_login_key">Enter Your Login Key</label>
                    <input type="text" id="temp_login_key" name="temp_login_key" required>
                </div>
                <div class="form-row">
                    <button type="submit" class="submit-button">Log In</button>
                </div>
            </form>
        </div>
        <?php
        return ob_get_clean();
    }
}

// Instantiate the plugin class.
new Temporary_Login_Plugin();

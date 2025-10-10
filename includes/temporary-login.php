<?php

/**
 * Plugin Name:      Temporary Login Generator
 * Description:      Create limited-use login keys that grant temporary access to an account with a 24-hour session timer.
 * Version:          1.6.0
 * Author:           Gemini
 * Author URI:       https://gemini.google.com
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
        // UPDATED: Start a PHP session early.
        add_action('init', [$this, 'start_php_session'], 1);

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

        // Check for session expiry on every page load for logged-in users.
        add_action('init', [$this, 'check_session_expiry']);

        // Clear session data on manual logout.
        add_action('wp_logout', [$this, 'clear_user_session_on_logout'], 10, 1);
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
            .temp-login-table {
                width: 100%;
            }

            .temp-login-table td {
                padding: 8px 5px;
            }

            .temp-login-table tr td:first-child {
                font-weight: bold;
                width: 200px;
            }

            .temp-login-key-wrapper {
                position: relative;
            }

            .temp-login-key-wrapper input {
                width: 100%;
                padding-right: 80px;
                background-color: #f0f0f0;
            }

            .copy-btn {
                position: absolute;
                right: 5px;
                top: 50%;
                transform: translateY(-50%);
                cursor: pointer;
            }
        </style>
        <table class="form-table temp-login-table">
            <tbody>

                <tr>
                    <td><label for="temp_login_limit"><?php _e('Maximum Unique Logins:', 'text_domain'); ?></label></td>
                    <td>
                        <input type="number" id="temp_login_limit" name="temp_login_limit" value="<?php echo esc_attr($login_limit); ?>" min="1" step="1" />
                        <p class="description"><?php _e('How many different IP addresses can use this key to start a session?', 'text_domain'); ?></p>
                    </td>
                </tr>

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

                <tr>
                    <td><?php _e('Unique IPs Used:', 'text_domain'); ?></td>
                    <td>
                        <strong><?php echo esc_html($login_count); ?></strong>
                        <p class="description"><?php _e('The number of unique IP addresses that have used this key.', 'text_domain'); ?></p>
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
        $session_history = get_post_meta($post->ID, '_temp_login_session_history', true);
        ?>
        <hr>
        <h3>Unique Login History</h3>
        <p class="description">A record of the first time each unique IP address used this key to start a session.</p>
        <?php
        if (!empty($session_history) && is_array($session_history)) :
            // Reverse the array to show the most recent login first
            $session_history = array_reverse($session_history);
        ?>
            <table class="wp-list-table widefat striped fixed" style="margin-top: 20px;">
                <thead>
                    <tr>
                        <th scope="col" style="width: 25%;"><strong>IP Address</strong></th>
                        <th scope="col" style="width: 40%;"><strong>Login Time</strong></th>
                        <th scope="col" style="width: 35%;"><strong>Session Expires</strong></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($session_history as $session) : ?>
                        <tr>
                            <td><?php echo esc_html($session['ip_address']); ?></td>
                            <td><?php echo esc_html(date_i18n(
                                    get_option('date_format') . ' ' . get_option('time_format'),
                                    $session['login_time']
                                )); ?></td>
                            <td>
                                <?php
                                $expiry_time = $session['expiry_time'];
                                // Check if the session is still active
                                if (time() < $expiry_time) {
                                    echo '<strong>' . esc_html(date_i18n(
                                        get_option('date_format') . ' ' . get_option('time_format'),
                                        $expiry_time
                                    )) . '</strong>';
                                } else {
                                    echo esc_html(date_i18n(
                                        get_option('date_format') . ' ' . get_option('time_format'),
                                        $expiry_time
                                    )) . ' (Expired)';
                                }
                                ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else : ?>
            <p>This login key has not been used yet.</p>
        <?php endif;
    }


    /**
     * Saves the custom meta data.
     */
    public function save_login_meta_data($post_id)
    {
        $temp_login_user_id = 164;
        // Check nonce.
        if (!isset($_POST['temp_login_meta_nonce']) || !wp_verify_nonce($_POST['temp_login_meta_nonce'], 'temp_login_save_meta_data')) {
            return;
        }

        // Check if the current user has permission.
        if (!current_user_can('edit_post', $post_id)) {
            return;
        }

        // Save User ID.
        $user_id = absint($temp_login_user_id);
        update_post_meta($post_id, '_temp_login_user_id', $user_id);

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
    public function handle_login_submission()
    {
        if (!isset($_POST['temp_login_nonce']) || !wp_verify_nonce($_POST['temp_login_nonce'], 'temp_login_action')) {
            return;
        }

        if (empty($_POST['temp_login_key'])) {
            wp_redirect(add_query_arg('login_error', 'empty', wp_get_referer()));
            exit;
        }

        $key = sanitize_text_field($_POST['temp_login_key']);

        $args = [
            'post_type' => 'temp_login',
            'post_status' => 'publish',
            'posts_per_page' => 1,
            'meta_query' => [['key' => '_temp_login_key', 'value' => $key, 'compare' => '=',]],
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
        $user = get_user_by('id', $user_id);

        if (!$user) {
            wp_redirect(add_query_arg('login_error', 'nouser', wp_get_referer()));
            exit;
        }

        // --- IP-BASED SESSION LOGIC ---
        $ip_address = $this->get_user_ip_address();
        $sessions = get_user_meta($user_id, '_temp_login_active_sessions', true);
        $is_session_active = false;

        if (is_array($sessions) && isset($sessions[$ip_address])) {
            $login_timestamp = $sessions[$ip_address];
            //DAY_IN_SECONDS
            if (time() <= ($login_timestamp + 60)) {
                $is_session_active = true;
            }
        }

        if ($is_session_active) {
            wp_set_current_user($user_id, $user->user_login);
            wp_set_auth_cookie($user_id);
            do_action('wp_login', $user->user_login, $user);
            wp_redirect(admin_url());
            exit;
        }

        // --- UPDATED: NEW IP ADDRESS LOGIC ---
        $session_history = get_post_meta($post_id, '_temp_login_session_history', true);
        if (!is_array($session_history)) {
            $session_history = [];
        }

        $used_ips = !empty($session_history) ? array_unique(wp_list_pluck($session_history, 'ip_address')) : [];
        $is_new_ip = !in_array($ip_address, $used_ips);

        if ($is_new_ip) {
            if ($count >= $limit) {
                wp_redirect(add_query_arg('login_error', 'expired', wp_get_referer()));
                exit;
            }

            $new_count = $count + 1;
            update_post_meta($post_id, '_temp_login_count', $new_count);

            // **MODIFIED:** Only record the session in history if it's a new IP.
            $current_time = time();
            $session_history[] = [
                'ip_address' => $ip_address,
                'login_time' => $current_time,
                'expiry_time' => $current_time + 60, 
            ];
            update_post_meta($post_id, '_temp_login_session_history', $session_history);
        }

        // A 24-hour timer should start for EVERY successful login, regardless of IP.
        $this->start_user_session_timer($user_id);

        // Log the user in.
        wp_set_current_user($user_id, $user->user_login);
        wp_set_auth_cookie($user_id);
        do_action('wp_login', $user->user_login, $user);

        // UPDATED: Store the temp_login post ID in the session.
        $_SESSION['temp_login_post_id'] = $post_id;

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
            .temp-login-container {
                max-width: 400px;
                margin: 40px auto;
                padding: 30px;
                border: 1px solid #ddd;
                border-radius: 8px;
                background: #f9f9f9;
                box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            }

            .temp-login-container h3 {
                text-align: center;
                margin-bottom: 25px;
                color: #333;
            }

            .temp-login-container .form-row {
                margin-bottom: 15px;
            }

            .temp-login-container label {
                display: block;
                margin-bottom: 5px;
                font-weight: bold;
                color: #555;
            }

            .temp-login-container input[type="text"] {
                width: 100%;
                padding: 10px;
                border: 1px solid #ccc;
                border-radius: 4px;
                box-sizing: border-box;
            }

            .temp-login-container .submit-button {
                width: 100%;
                padding: 12px;
                border: none;
                border-radius: 4px;
                background-color: #34BFA3;
                color: white;
                font-size: 16px;
                cursor: pointer;
                transition: background-color 0.2s;
            }

            .temp-login-container .submit-button:hover {
                background-color: #FF8335;
            }

            .temp-login-error {
                padding: 15px;
                margin-bottom: 20px;
                border: 1px solid transparent;
                border-radius: 4px;
                color: #a94442;
                background-color: #f2dede;
                border-color: #ebccd1;
                text-align: center;
            }
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
                        $message = 'This login key has reached its maximum number of unique IP uses.';
                        break;
                    case 'nouser':
                        $message = 'The user associated with this key no longer exists.';
                        break;
                    case 'session_expired':
                        $message = 'Your 24-hour session has expired. Please log in again.';
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

    // -------------------------------------------------------------------------
    // TIMER AND SESSION FUNCTIONS
    // -------------------------------------------------------------------------

    /**
     * UPDATED: Starts a PHP session if one is not already active.
     * Hooks into 'init'.
     */
    public function start_php_session()
    {
        if (!session_id()) {
            session_start();
        }
    }


    /**
     * Checks if the current user's session has expired and logs them out if it has.
     * Hooks into 'init'.
     */
    public function check_session_expiry()
    {
        // Only run this check for logged-in users.
        if (!is_user_logged_in()) {
            return;
        }

        $user_id = get_current_user_id();
        $ip_address = $this->get_user_ip_address();
        $temp_login_post_id =  $_SESSION['temp_login_post_id'];

        $session_history = get_post_meta($temp_login_post_id, '_temp_login_session_history', true);

        if (!empty($session_history) && is_array($session_history)) {
            // Find the specific session record for the current IP address.
            foreach ($session_history as $session) {
                if (isset($session['ip_address']) && $session['ip_address'] === $ip_address) {
                    // We found the session record. Now check if it's expired.
                    if (isset($session['expiry_time']) && time() > $session['expiry_time']) {
                        // The session has expired. Log the user out.
                        $this->clear_user_session_on_logout($user_id); // Clean up the user meta.
                        wp_logout();

                        // Find the login page URL to redirect to.
                        $login_page_url = $this->find_shortcode_page('temporary_login_form');
                        if (!$login_page_url) {
                            $login_page_url = home_url(); // Fallback to homepage.
                        }

                        wp_redirect(add_query_arg('login_error', 'session_expired', $login_page_url));
                        exit;
                    }
                    // If we found the session and it's not expired, we can stop checking.
                    wp_reset_postdata();
                    return;
                }
            }
        }
    }


    /**
     * Starts the 24-hour session timer for a user upon successful login.
     * @param int $user_id The ID of the user logging in.
     */
    private function start_user_session_timer($user_id)
    {
        $ip_address = $this->get_user_ip_address();

        $sessions = get_user_meta($user_id, '_temp_login_active_sessions', true);
        if (!is_array($sessions)) {
            $sessions = [];
        }

        $sessions[$ip_address] = time();

        update_user_meta($user_id, '_temp_login_active_sessions', $sessions);
    }

    /**
     * Removes session data when a user logs out manually.
     * Hooks into 'wp_logout'.
     * @param int $user_id The ID of the user logging out.
     */
    public function clear_user_session_on_logout($user_id)
    {
        $ip_address = $this->get_user_ip_address();

        $sessions = get_user_meta($user_id, '_temp_login_active_sessions', true);

        if (is_array($sessions) && isset($sessions[$ip_address])) {
            unset($sessions[$ip_address]);
            update_user_meta($user_id, '_temp_login_active_sessions', $sessions);
        }

        // UPDATED: Clear the post ID from the session as well.
        if (isset($_SESSION['temp_login_post_id'])) {
            unset($_SESSION['temp_login_post_id']);
        }
    }

    /**
     * Helper function to get the user's IP address, considering proxies.
     * @return string The user's IP address.
     */
    private function get_user_ip_address()
    {
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        return apply_filters('tlg_get_ip', $ip);
    }

    /**
     * Helper function to find the URL of the page containing our shortcode.
     * @param string $shortcode The shortcode string to search for.
     * @return string|null The page permalink or null if not found.
     */
    private function find_shortcode_page($shortcode)
    {
        $query = new WP_Query([
            'post_type'      => 'page',
            'post_status'    => 'publish',
            'posts_per_page' => -1,
            's'              => '[' . $shortcode . ']',
        ]);

        if ($query->have_posts()) {
            $query->the_post();
            return get_permalink(get_the_ID());
        }

        return null;
    }
}

// Instantiate the plugin class.
new Temporary_Login_Plugin();

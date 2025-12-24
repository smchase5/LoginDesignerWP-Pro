<?php
/**
 * Plugin Name: Login Designer WP Pro
 * Plugin URI: https://logindesignerwp.com
 * Description: Pro addon for Login Designer WP with advanced features including Glassmorphism, AI styling, Social Login, and more.
 * Version: 1.0.0
 * Author: Sterling Chase
 * Author URI: https://logindesignerwp.com
 * License: GPL-2.0+
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: logindesignerwp-pro
 * Domain Path: /languages
 * Requires at least: 5.8
 * Requires PHP: 7.4
 */

// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}

// Define constants
define('LOGINDESIGNERWP_PRO_VERSION', '1.0.0');
define('LOGINDESIGNERWP_PRO_PATH', plugin_dir_path(__FILE__));
define('LOGINDESIGNERWP_PRO_URL', plugin_dir_url(__FILE__));
define('LOGINDESIGNERWP_PRO_FILE', __FILE__);

/**
 * Check if Free version is active
 */
function logindesignerwp_pro_check_dependencies() {
    if (!function_exists('logindesignerwp_is_pro_active')) {
        add_action('admin_notices', function() {
            echo '<div class="notice notice-error"><p>';
            echo '<strong>Login Designer WP Pro</strong> requires <strong>Login Designer WP</strong> (free version) to be installed and activated.';
            echo '</p></div>';
        });
        return false;
    }
    return true;
}

/**
 * Initialize Pro plugin
 */
function logindesignerwp_pro_init() {
    if (!logindesignerwp_pro_check_dependencies()) {
        return;
    }

    // Load Pro features (non-namespaced classes)
    require_once LOGINDESIGNERWP_PRO_PATH . 'inc/class-pro-features.php';
    require_once LOGINDESIGNERWP_PRO_PATH . 'inc/class-presets.php';
    
    // Load namespaced classes
    require_once LOGINDESIGNERWP_PRO_PATH . 'inc/class-license-handler.php';
    require_once LOGINDESIGNERWP_PRO_PATH . 'inc/class-updater.php';
    require_once LOGINDESIGNERWP_PRO_PATH . 'inc/class-pro-manager.php';

    // Initialize non-namespaced classes
    new LoginDesignerWP_Pro_Features();
    new LoginDesignerWP_Pro_Presets();
    
    // Initialize namespaced classes
    new \LoginDesignerWP\Pro\Pro_Manager();
}
add_action('plugins_loaded', 'logindesignerwp_pro_init', 20);

/**
 * Activation hook
 */
register_activation_hook(__FILE__, function() {
    if (!get_option('logindesignerwp_pro_activated')) {
        update_option('logindesignerwp_pro_activated', time());
    }
});

/**
 * Deactivation hook
 */
register_deactivation_hook(__FILE__, function() {
    // Cleanup if needed
});

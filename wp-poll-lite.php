<?php
/**
 * Plugin Name:       WP Poll Lite
 * Plugin URI:        https://sofiquldev.github.io/wp-poll-lite
 * Description:       Create amazing polls and engage your audience effortlessly.
 * Version:           1.0.0
 * Author:            Sofiqul Islam
 * Author URI:        https://github.com/sofiquldev
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       wp-poll-lite
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
    die;
}

/**
 * Autoload all classes using Composer's autoloader.
 */
require_once plugin_dir_path( __FILE__ ) . 'vendor/autoload.php';

/**
 * Define plugin constants.
 */
define( 'WP_POLL_LITE_VERSION', '1.0.0' );
define( 'WP_POLL_LITE_NAME', 'wp-poll-lite' );
define( 'WP_POLL_LITE_BASENAME', plugin_basename( __FILE__ ) );
define( 'WP_POLL_LITE_DIR', plugin_dir_path( __FILE__ ) );
define( 'WP_POLL_LITE_BASE_URL', plugin_dir_url( __FILE__ ) );
define( 'WP_POLL_LITE_ADMIN_URL', plugin_dir_url( __FILE__ ) . 'admin' );
define( 'WP_POLL_LITE_PUBLIC_URL', plugin_dir_url( __FILE__ ) . 'public' );
/**
 * Plugin activation and deactivation hooks
 */
function activate_wp_poll_lite() {
    WP_Poll_Lite\Activator::activate();
}

function deactivate_wp_poll_lite() {
    WP_Poll_Lite\Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_wp_poll_lite' );
register_deactivation_hook( __FILE__, 'deactivate_wp_poll_lite' );

/**
 * Initialize the plugin after all plugins are loaded
 */
function run_wp_poll_lite() {
    new WP_Poll_Lite\Plugin();
}

add_action( 'plugins_loaded', 'run_wp_poll_lite' );

<?php

namespace WP_Poll_Lite;

use WP_Poll_Lite\Admin\Admin;

class Plugin {

    /**
     * Constructor.
     */
    public function __construct() {
        // Run the initialization process
        $this->initialize_plugin();
        
        // You can also add more initialization logic here
    }

    /**
     * Initialize the plugin.
     */
    public function initialize_plugin() {
        add_action( 'admin_notices', [ $this, 'admin_notice' ] );

        // Other initialization code...
        new Admin();
    }

    /**
     * Admin notice for the plugin (optional).
     */
    public function admin_notice() {
        echo '<div class="notice notice-success is-dismissible"><p>' . __( 'WP Poll Lite plugin activated!', 'wp-poll-lite' ) . '</p></div>';
    }
}

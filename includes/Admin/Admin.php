<?php

namespace WP_Poll_Lite\Admin;

use WP_Poll_Lite\Admin\Pages\AllPolls;
use WP_Poll_Lite\Enqueue;
use WP_Poll_Lite\Admin\Pages\Polls;
use WP_Poll_Lite\Admin\Pages\CreatePoll;
use WP_Poll_Lite\Admin\Pages\Dashboard;
use WP_Poll_Lite\Admin\Pages\Settings;

class Admin {
    /**
     * Constructor.
     */
    public function __construct() {
        add_action( 'admin_menu',   [$this, 'wp_poll_lite_add_admin_menu'] );
        new Enqueue();
    }
    

    /**
     * Add the plugin menu and submenus to the WordPress admin.
     */
    public function wp_poll_lite_add_admin_menu() {
        add_menu_page(
            __( 'WP Poll Lite', 'wp-poll-lite' ),
            __( 'WP Poll Lite', 'wp-poll-lite' ),
            'manage_options',
            'wp-poll-lite',
            [$this, 'render_dashboard'],
            'dashicons-chart-pie',
            6
        );
        
        // Add submenus
        add_submenu_page(
            'wp-poll-lite',
            __( 'All Polls', 'wp-poll-lite' ),
            __( 'All Polls', 'wp-poll-lite' ),
            'manage_options',
            'wp-poll-lite-all-polls',
            [$this, 'render_all_polls']
        );

        add_submenu_page(
            'wp-poll-lite',
            __( 'Create Poll', 'wp-poll-lite' ),
            __( 'Create Poll', 'wp-poll-lite' ),
            'manage_options',
            'wp-poll-lite-create-poll',
            [$this, 'render_create_poll']
        );

        add_submenu_page(
            'wp-poll-lite',
            __( 'Settings', 'wp-poll-lite' ),
            __( 'Settings', 'wp-poll-lite' ),
            'manage_options',
            'wp-poll-lite-settings',
            [$this, 'render_settings']
        );
    }

    public function render_dashboard() {
        new Dashboard();
    }

    public function render_all_polls() {
        new AllPolls();
    }

    public function render_create_poll() {
        new CreatePoll();
    }
    public function render_settings() {
        new Settings();

        function wp_poll_lite_register_settings() {
            register_setting( 'wp_poll_lite_settings_group', 'wp_poll_lite_display_style' );
            register_setting( 'wp_poll_lite_settings_group', 'wp_poll_lite_enable_sharing' );
        }
        
        add_action( 'admin_init', 'wp_poll_lite_register_settings' );        
    }
}

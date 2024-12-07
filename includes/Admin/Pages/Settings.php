<?php

namespace WP_Poll_Lite\Admin\Pages;

use WP_Poll_Lite\Templates\Footer;
use WP_Poll_Lite\Templates\Header;

class Settings {

    /**
     * Constructor to register the settings.
     */
    public function __construct() {
        add_action( 'admin_init', [ $this, 'register_settings' ] );
        $this->render();
    }

    /**
     * Register plugin settings.
     */
    public function register_settings() {
        // Register individual settings
        register_setting( 'wp_poll_lite_settings_group', 'wp_poll_lite_display_style' );
        register_setting( 'wp_poll_lite_settings_group', 'wp_poll_lite_enable_sharing' );
    }

    /**
     * Render the Settings page using a template.
     */
    public function render() {
        // Data you want to pass to the template
        $data = [
            'title'       => __( 'Settings', 'wp-poll-lite' ),
            'message'     => __( 'Configure your poll settings below.', 'wp-poll-lite' ),
        ];

        // Include the header template
        new Header($data);
        ?>
        <div class="wp-poll-lite-settings-content">
            <!-- Settings Form -->
            <form method="POST" action="options.php">
                <?php
                // WordPress function to handle settings form submission
                settings_fields( 'wp_poll_lite_settings_group' );
                do_settings_sections( 'wp_poll_lite_settings_group' );
                ?>

                <table class="form-table">
                    <tr valign="top">
                        <th scope="row"><?php echo esc_html__( 'Poll Display Style', 'wp-poll-lite' ); ?></th>
                        <td>
                            <select name="wp_poll_lite_display_style" id="wp_poll_lite_display_style">
                                <option value="grid" <?php selected( get_option( 'wp_poll_lite_display_style' ), 'grid' ); ?>><?php echo esc_html__( 'Grid', 'wp-poll-lite' ); ?></option>
                                <option value="list" <?php selected( get_option( 'wp_poll_lite_display_style' ), 'list' ); ?>><?php echo esc_html__( 'List', 'wp-poll-lite' ); ?></option>
                            </select>
                            <p class="description"><?php echo esc_html__( 'Choose how polls are displayed on the front end.', 'wp-poll-lite' ); ?></p>
                        </td>
                    </tr>

                    <tr valign="top">
                        <th scope="row"><?php echo esc_html__( 'Enable Poll Sharing', 'wp-poll-lite' ); ?></th>
                        <td>
                            <input type="checkbox" name="wp_poll_lite_enable_sharing" value="1" <?php checked( get_option( 'wp_poll_lite_enable_sharing' ), 1 ); ?> />
                            <p class="description"><?php echo esc_html__( 'Enable sharing options for polls.', 'wp-poll-lite' ); ?></p>
                        </td>
                    </tr>
                </table>

                <?php submit_button( __( 'Save Settings', 'wp-poll-lite' ) ); ?>
            </form>
        </div>
        <?php

        // Include the footer template
        new Footer();
    }
}

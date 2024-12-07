<?php

namespace WP_Poll_Lite\Templates;

class Header {

    /**
     * Constructor to initialize and render the header.
     *
     * @param array $data Data passed to the header (e.g., title and message).
     */
    public function __construct( $data = [] ) {
        $this->render( $data );
    }

    /**
     * Render the header template with dynamic data.
     *
     * @param array $data Data passed to the header (e.g., title and message).
     */
    public function render( $data = [] ) {
        $title = isset( $data['title'] ) ? $data['title'] : '';
        $message = isset( $data['message'] ) ? $data['message'] : '';

        ?>
        <div class="wp-poll-main-wrapper">
            <!-- Header Section -->
            <div class="wp-poll-lite-header">
                <h2 style="margin-bottom: 0;"><?php echo esc_html( $title ); ?></h2>
                <?php if ( ! empty( $message ) ) : ?>
                    <p style="margin-top: 4px;"><?php echo esc_html( $message ); ?></p>
                <?php endif; ?>
                <hr>
            </div>

            <!-- Navigation Section (hidden by default) -->
            <div class="wp-poll-lite-nav" style="display: none;">
                <nav>
                    <ul>
                        <li><a href="<?php echo esc_url( admin_url( 'admin.php?page=wp-poll-lite' ) ); ?>"><?php esc_html_e( 'Dashboard', 'wp-poll-lite' ); ?></a></li>
                        <li><a href="<?php echo esc_url( admin_url( 'admin.php?page=wp-poll-lite-all-polls' ) ); ?>"><?php esc_html_e( 'Polls', 'wp-poll-lite' ); ?></a></li>
                        <li><a href="<?php echo esc_url( admin_url( 'admin.php?page=wp-poll-lite-settings' ) ); ?>"><?php esc_html_e( 'Settings', 'wp-poll-lite' ); ?></a></li>
                    </ul>
                </nav>
            </div>
        <?php
    }
}

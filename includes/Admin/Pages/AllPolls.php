<?php

namespace WP_Poll_Lite\Admin\Pages;

use WP_Poll_Lite\Templates\Footer;
use WP_Poll_Lite\Templates\Header;
use WP_Poll_Lite\Templates\PollsTable;

class AllPolls {

    /**
     * Constructor to register the settings and render the table.
     */
    public function __construct() {
        $this->render();
        add_action( 'admin_post_delete_poll', [$this, 'delete_poll'] );
    }

    /**
     * Render the Settings page with the list of polls.
     */
    public function render() {
        // Data you want to pass to the template
        $data = [
            'title'       => __( 'All Polls', 'wp-poll-lite' ),
            'message'     => __( 'Here you can see all the polls that have been created.', 'wp-poll-lite' ),
        ];

        // Include the header template
        new Header($data);
        
        // Initialize the Polls List Table
        $polls_list_table = new PollsTable();
        $polls_list_table->prepare_items();

        ?>
        <div class="wp-poll-lite-dashboard-content">
            <!-- List Table -->
            <form method="POST">
                <?php
                    $polls_list_table->display();
                ?>
            </form>
        </div>

        <?php

        // Include the footer template
        new Footer();
    }

    function delete_poll() {
        if ( isset( $_GET['id'] ) && isset( $_GET['_wpnonce'] ) && wp_verify_nonce( $_GET['_wpnonce'], 'delete_poll_' . $_GET['id'] ) ) {
            global $wpdb;
    
            $poll_id = absint( $_GET['id'] );
    
            // Delete the poll from the database
            $wpdb->delete( $wpdb->prefix . 'poll_lite_polls', [ 'id' => $poll_id ] );
            $wpdb->delete( $wpdb->prefix . 'poll_lite_poll_options', [ 'poll_id' => $poll_id ] );
    
            // Redirect back to the polls page
            wp_redirect( admin_url( 'admin.php?page=wp-poll-lite-all-polls' ) );
            exit;
        }
    }
    
}

<?php

namespace WP_Poll_Lite\Templates;

if ( ! class_exists( 'WP_List_Table' ) ) {
    require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}

class PollsTable extends \WP_List_Table {

    /**
     * Prepare items for the table.
     */
    public function prepare_items() {
        global $wpdb;

        // Define columns
        $columns = [
            'cb'        => '<input type="checkbox" />',
            'poll_title'=> __( 'Poll Question', 'wp-poll-lite' ),
            'poll_date' => __( 'Date Created', 'wp-poll-lite' ),
            'actions'   => __( 'Actions', 'wp-poll-lite' ),
        ];

        // Set columns and sortable columns
        $this->_column_headers = [ $columns, [], [] ];

        // Fetch polls from the database
        $sql = "SELECT * FROM {$wpdb->prefix}poll_lite_polls";
        $polls = $wpdb->get_results( $sql );

        // Set items (data rows)
        $this->items = $polls;
    }

    /**
     * Column display for the 'cb' column (checkboxes)
     */
    public function column_cb( $item ) {
        return sprintf(
            '<input type="checkbox" name="poll_ids[]" value="%s" />',
            $item->id
        );
    }

    /**
     * Column display for the 'poll_title' column (Poll Question)
     */
    public function column_poll_title( $item ) {
        $title = esc_html( $item->title );

        // Return the link to the edit page for each poll
        return sprintf(
            '<a href="%s">%s</a>',
            admin_url( 'admin.php?page=wp-poll-lite-edit-poll&id=' . $item->id ),
            $title
        );
    }

    /**
     * Column display for the 'poll_date' column (Date Created)
     */
    public function column_poll_date( $item ) {
        return date( 'Y-m-d H:i:s', strtotime( $item->publish_date ) );
    }

    /**
     * Column display for the 'actions' column (Actions like Edit/Delete)
     */
    public function column_actions( $item ) {
        $edit_url = admin_url( 'admin.php?page=wp-poll-lite-edit-poll&id=' . $item->id );
        $delete_url = wp_nonce_url(
            admin_url( 'admin-post.php?action=delete_poll&id=' . $item->id ),
            'delete_poll_' . $item->id
        );

        // Provide Edit and Delete actions for each poll
        return sprintf(
            '<a href="%s">Edit</a> | <a href="%s">Delete</a>',
            $edit_url,
            $delete_url
        );
    }
}

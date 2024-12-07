<?php

namespace WP_Poll_Lite;

class Activator {

    /**
     * Run the necessary database check and setup when the plugin is activated.
     */
    public static function activate() {
        global $wpdb;

        // Table names (including WordPress prefix)
        $polls_table = $wpdb->prefix . 'poll_lite_polls';
        $options_table = $wpdb->prefix . 'poll_lite_poll_options';
        $categories_table = $wpdb->prefix . 'poll_lite_poll_categories';

        // SQL to create wp_poll_lite_polls table
        $polls_table_sql = "CREATE TABLE $polls_table (
            id BIGINT(20) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            title VARCHAR(255) NOT NULL,
            media_id BIGINT(20) UNSIGNED DEFAULT NULL,
            publish_date DATETIME DEFAULT CURRENT_TIMESTAMP,
            expired_date DATETIME DEFAULT NULL,
            share_count INT(11) DEFAULT 0,
            category_id BIGINT(20) UNSIGNED DEFAULT NULL,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            INDEX (category_id)
        ) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;";

        // SQL to create wp_poll_lite_poll_options table
        $options_table_sql = "CREATE TABLE $options_table (
            id BIGINT(20) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            poll_id BIGINT(20) UNSIGNED NOT NULL,
            title VARCHAR(255) NOT NULL,
            vote_count INT(11) DEFAULT 0,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            FOREIGN KEY (poll_id) REFERENCES $polls_table(id) ON DELETE CASCADE
        ) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;";

        // SQL to create wp_poll_lite_poll_categories table
        $categories_table_sql = "CREATE TABLE $categories_table (
            id BIGINT(20) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(255) NOT NULL,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        ) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;";

        // Include dbDelta() function to create the tables
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

        // Create polls table
        dbDelta($polls_table_sql);

        // Create poll options table
        dbDelta($options_table_sql);

        // Create poll categories table
        dbDelta($categories_table_sql);
    }
}

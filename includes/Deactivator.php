<?php

namespace WP_Poll_Lite;

class Deactivator {

    /**
     * Code that runs when the plugin is deactivated.
     */
    public static function deactivate() {
        global $wpdb;
        $polls_table      = $wpdb->prefix . 'poll_lite_polls';
        $options_table    = $wpdb->prefix . 'poll_lite_poll_options';
        $categories_table = $wpdb->prefix . 'poll_lite_poll_categories';

        $wpdb->query( "DROP TABLE IF EXISTS $polls_table, $options_table, $categories_table;" );
    }
}

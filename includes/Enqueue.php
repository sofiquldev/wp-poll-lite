<?php

namespace WP_Poll_Lite;

class Enqueue
{
    /**
     * Constructor.
     */
    public function __construct()
    {
        add_action('admin_enqueue_scripts', [$this, 'wp_poll_lite_enqueue_styles']);
    }

    function wp_poll_lite_enqueue_styles()
    {
        wp_enqueue_media();

        wp_enqueue_style('wp-poll-lite-style', WP_POLL_LITE_BASE_URL . 'assets/css/wp-poll-lite-style.css', array(), null, 'all');
        wp_enqueue_script('wp-poll-lite-script', WP_POLL_LITE_BASE_URL . 'assets/js/wp-poll-lite-script.js', array('jquery', 'dropzone-js'), null, 'all');
        
        // Pass admin-ajax URL to the script
        wp_localize_script('wp-poll-lite-script', 'wpPollLite', array(
            'ajaxUrl' => admin_url('admin-ajax.php')
        ));
    }
}

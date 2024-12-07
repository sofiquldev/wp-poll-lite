<?php

namespace WP_Poll_Lite\Admin\Pages;

use WP_Poll_Lite\Templates\Footer;
use WP_Poll_Lite\Templates\Header;

class Dashboard {

    /**
     * Constructor to register the settings.
     */
    public function __construct() {
        $this->render();
    }

    /**
     * Render the Settings page using a template.
     */
    public function render() {
        // Data you want to pass to the template
        $data = [
            'title'       => __( 'Dashboard', 'wp-poll-lite' ),
            'message'     => __( 'Configure your poll settings below.', 'wp-poll-lite' ),
        ];

        // Include the header template
        new Header($data);

        ?>
        <div class="wp-poll-lite-dashbaord-content">
            <h2>Dashboard Content</h2>
        </div>
        <?php

        // Include the footer template
        new Footer();
    }
}

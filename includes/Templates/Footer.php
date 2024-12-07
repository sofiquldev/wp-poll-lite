<?php

namespace WP_Poll_Lite\Templates;

class Footer {

    /**
     * Constructor to render the footer
     */
    public function __construct() {
        $this->render();
    }

    /**
     * Render the footer template
     */
    public function render() {
        ?>
        <div class="wp-poll-lite-footer">
            <p>&copy; <?php echo esc_html( date('Y') ); ?> <?php esc_html_e( 'WP Poll Lite', 'wp-poll-lite' ); ?></p>
        </div>
        </div>
        <?php
    }
}

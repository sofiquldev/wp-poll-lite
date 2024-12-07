<?php

namespace WP_Poll_Lite\Admin\Pages;

class PollCategories {

    public function render() {
        echo '<div class="wrap"><h1>' . __( 'Poll Categories', 'wp-poll-lite' ) . '</h1>';
        echo '<p>' . __( 'Manage your poll categories here.', 'wp-poll-lite' ) . '</p>';
        // Display form or list for categories
        echo '</div>';
    }
}

<?php
if ( ! defined( 'WPINC' ) ) {
	die;
}

class WP_Poll_Lite_Shortcodes {

	public function __construct() {
		// Register the shortcodes
		add_shortcode( 'all', array( $this, 'display_all_polls' ) );
		add_shortcode( 'poll', array( $this, 'display_single_poll' ) );
	}

	/**
	 * Shortcode to display all polls.
	 */
	public function display_all_polls( $atts ) {
		global $wpdb;

		$atts = shortcode_atts( array(
			'category' => '', // Default: no category
		), $atts, 'all' );

		$category = sanitize_text_field( $atts['category'] );

		// Get all polls
		$query = "SELECT * FROM {$wpdb->prefix}wppl_polls";
		if ( ! empty( $category ) ) {
			$query .= $wpdb->prepare( " WHERE categories LIKE %s", '%' . $wpdb->esc_like( $category ) . '%' );
		}

		$polls = $wpdb->get_results( $query );

		// If no polls are found
		if ( empty( $polls ) ) {
			return '<p>' . __( 'No polls found.', 'wp-poll-lite' ) . '</p>';
		}

		ob_start(); // Start buffering output

		foreach ( $polls as $poll ) {
			echo '<div class="wppl-poll">';
			echo '<h3>' . esc_html( $poll->title ) . '</h3>';
			// Add more HTML and options display here
			echo '</div>';
		}

		return ob_get_clean(); // Return the buffered HTML
	}

	/**
	 * Shortcode to display a single poll.
	 */
	public function display_single_poll( $atts ) {
		global $wpdb;

		$atts = shortcode_atts( array(
			'id' => '', // Poll ID
			'latest' => 'false', // Latest poll
		), $atts, 'poll' );

		if ( ! empty( $atts['id'] ) ) {
			$poll = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM {$wpdb->prefix}wppl_polls WHERE id = %d", $atts['id'] ) );
		} elseif ( 'true' === $atts['latest'] ) {
			$poll = $wpdb->get_row( "SELECT * FROM {$wpdb->prefix}wppl_polls ORDER BY created_at DESC LIMIT 1" );
		}

		// If no poll is found
		if ( ! $poll ) {
			return '<p>' . __( 'Poll not found.', 'wp-poll-lite' ) . '</p>';
		}

		ob_start(); // Start buffering output

		// Display poll title and options here
		echo '<div class="wppl-poll">';
		echo '<h3>' . esc_html( $poll->title ) . '</h3>';
		// Display options or other information here
		echo '</div>';

		return ob_get_clean(); // Return the buffered HTML
	}
}

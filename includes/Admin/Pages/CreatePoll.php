<?php

namespace WP_Poll_Lite\Admin\Pages;

use WP_Poll_Lite\Templates\Footer;
use WP_Poll_Lite\Templates\Header;

class CreatePoll
{
    /**
     * Constructor
     */
    public function __construct()
    {
        add_action('admin_post_wp_poll_lite_create_poll', [$this, 'save_poll'], 10, 0);
        $this->render();
    }

    /**
     * Render the Create Poll form
     */
    public function render()
    {
        // Data you want to pass to the template
        $data = [
            'title'   => __('Create Poll', 'wp-poll-lite'),
            'message' => __('Create your poll.', 'wp-poll-lite'),
        ];

        // Include the header template
        new Header($data);
        
?>

        <div class="wp-poll-lite-form-left">
            <!-- Poll Creation Form -->
            <form id="create-poll-form" class="form-wrapper" method="POST" action="<?php echo esc_url(admin_url('admin-post.php')); ?>" enctype="multipart/form-data">
                <?php wp_nonce_field('wp_poll_lite_create_poll', 'wp_poll_lite_create_poll_nonce'); ?>

                <input type="hidden" name="action" value="wp_poll_lite_create_poll" />

                <div class="poll-editor">
                    <!-- Poll Question Input -->
                    <input type="text" id="pollQuestion" name="poll_question" placeholder="Enter poll question" required />

                    <!-- Poll Options -->
                    <div id="pollOptions">
                        <input type="text" class="optionInput" name="poll_options[]" placeholder="Option 1" required />
                        <input type="text" class="optionInput" name="poll_options[]" placeholder="Option 2" required />
                    </div>

                    <button type="button" id="addOptionButton" class="btn"><?php echo __('Add Option', 'wp-poll-lite') ?></button>
                    <button type="submit" id="createPollButton" class="btn"><?php echo __('Create Poll', 'wp-poll-lite') ?></button>
                </div>

                <div class="preview">
                    <!-- Image preview area -->
                    <div id="imagePreview">
                        <img id="imagePreviewImg" src="null" alt="Image" style="max-width: 100%; height: auto;" />
                        <span class="placeholder"><?php echo __('Click to Upload Image') ?></span>
                    </div>

                    <!-- Hidden input field to store image URL -->
                    <input type="hidden" id="pollImageUrl" name="poll_image_url" />
                </div>
            </form>

        </div>

        <script type="text/javascript">
            jQuery(document).ready(function($) {
                // Open the WordPress Media Uploader when the button is clicked
                $('#imagePreview').click(function(e) {
                    e.preventDefault();

                    // Create a media uploader
                    var mediaUploader = wp.media({
                            title: '<?php echo esc_js(__('Select Image', 'wp-poll-lite')); ?>',
                            button: {
                                text: '<?php echo esc_js(__('Use this image', 'wp-poll-lite')); ?>'
                            },
                            multiple: false // Allow only one file to be selected
                        })
                        .on('select', function() {
                            // Get the selected image details
                            var attachment = mediaUploader.state().get('selection').first().toJSON();

                            // Set the image URL to the hidden input
                            $('#pollImageUrl').val(attachment.url);

                            // Show the image preview section and set the image source
                            $('#imagePreview').show();
                            $('#imagePreviewImg').attr('src', attachment.url);
                        })
                        .open();
                });
            });
        </script>

<?php
        // Include footer template
        new Footer();
    }

    /**
     * Save Poll to the database
     */
    /**
     * Save Poll to the database
     */
    public function save_poll()
    {
        var_dump('WP_POLL_LITE_BASE_URL');
        // Verify nonce for security
        if (! isset($_POST['wp_poll_lite_create_poll_nonce']) || ! wp_verify_nonce($_POST['wp_poll_lite_create_poll_nonce'], 'wp_poll_lite_create_poll')) {
            wp_die(__('Permission denied.', 'wp-poll-lite'));
        }
        error_log(print_r($_POST, true));

        // Sanitize form data
        $poll_question    = isset($_POST['poll_question']) ? sanitize_text_field($_POST['poll_question']) : '';
        $poll_options     = isset($_POST['poll_options']) ? array_map('sanitize_text_field', $_POST['poll_options']) : [];
        $poll_start_date  = isset($_POST['poll_start_date']) ? sanitize_text_field($_POST['poll_start_date']) : '';
        $poll_expiry_date = isset($_POST['poll_expiry_date']) ? sanitize_text_field($_POST['poll_expiry_date']) : '';

        // Check for empty poll question and options
        if (empty($poll_question) || empty($poll_options) || count($poll_options) < 2) {
            wp_die(__('Poll question and at least two options are required.', 'wp-poll-lite'));
        }

        // Handle image upload (optional)
        $media_id = null;
        if (isset($_POST['poll_image_url']) && ! empty($_POST['poll_image_url'])) {
            $media_id = $this->get_media_id_from_url($_POST['poll_image_url']);
            if (! $media_id) {
                wp_die(__('Invalid image URL.', 'wp-poll-lite'));
            }
        }

        // Insert the poll into the database
        global $wpdb;
        $poll_data = [
            'title'        => $poll_question,
            'media_id'     => $media_id,
            'publish_date' => $poll_start_date,
            'expired_date' => $poll_expiry_date,
            'share_count'  => 0,
            'category_id'  => null,
        ];

        // Insert poll into database and get poll ID
        $wpdb->insert($wpdb->prefix . 'poll_lite_polls', $poll_data);
        $poll_id = $wpdb->insert_id;

        // If poll insertion failed, return an error
        if (! $poll_id) {
            wp_die(__('Failed to create poll. Please try again.', 'wp-poll-lite'));
        }

        // Insert options for the poll
        foreach ($poll_options as $option_title) {
            $wpdb->insert(
                $wpdb->prefix . 'poll_lite_poll_options',
                [
                    'poll_id'   => $poll_id,
                    'title'     => $option_title,
                    'vote_count' => 0,
                ]
            );
        }

        // Redirect to the polls page with a success message
        wp_redirect(add_query_arg('message', 'poll_created', admin_url('admin.php?page=wp-poll-lite-all-polls')));
        exit;
    }


    /**
     * Get Media ID from URL
     */
    private function get_media_id_from_url($url)
    {
        // Get the media ID from the URL
        $attachment_id = attachment_url_to_postid($url);

        // Check if the URL points to an existing media item
        if ($attachment_id) {
            return $attachment_id;
        }

        return null;
    }
}

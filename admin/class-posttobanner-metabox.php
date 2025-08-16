<?php

class ptbMetaBox
{

    /**
     * Hook into the appropriate actions when the class is constructed.
     */
    public function __construct()
    {
        add_action('admin_enqueue_scripts',   array($this, 'enqueue_scripts'));
        add_action('add_meta_boxes',       array($this, 'add_meta_box'));
        add_action('save_post',            array($this, 'save'));
    }

    public function enqueue_scripts()
    {
        wp_enqueue_style('ptb-meta-box-fonts', 'https://fonts.googleapis.com/css2?family=Montserrat&display=swap');
        wp_enqueue_script('ptb-meta-box-script', plugin_dir_url(__FILE__) . 'js/posttobanner-metabox.js', array('jquery'), null, true);
        wp_localize_script('ptb-meta-box-script', 'ptb_ajax', array
            (
                'ajax_url' => admin_url('admin-ajax.php'),
                'post_id' => get_the_ID(),
                'background_src' => get_the_post_thumbnail_url(get_the_ID(), 'full'),
                'logo_src' => wp_get_original_image_url(get_option('ptb_image_id')),
                'title' => get_the_title(get_the_ID()),
                'excerpt' => get_the_excerpt(get_the_ID()),
                'category' => get_the_category(get_the_ID())[0]->name,
                'footer_title' => get_option('ptb_footer_title'),
                'blog_url' => get_option('ptb_blog_url'),
                'reference' => get_permalink(get_option('page_for_posts'))
            )
        );
    }

    /**
     * Adds the meta box container.
     */
    public function add_meta_box($post_type)
    {
        $post_types = array('post');

        if (in_array($post_type, $post_types))
        {
            add_meta_box(
                'ptb-meta-box',
                __('Post to Banner', 'textdomain'),
                array($this, 'render_meta_box_content'),
                $post_type,
                'side',
                'high'
            );
        }
    }

    /**
     * Save the meta when the post is saved.
     *
     * @param int $post_id The ID of the post being saved.
     */
    public function save($post_id)
    {
        /*
		 * We need to verify this came from the our screen and with proper authorization,
		 * because save_post can be triggered at other times.
		 */

        // Check if our nonce is set.
        if (! isset($_POST['myplugin_inner_custom_box_nonce']))
        {
            return $post_id;
        }

        $nonce = $_POST['myplugin_inner_custom_box_nonce'];

        // Verify that the nonce is valid.
        if (! wp_verify_nonce($nonce, 'myplugin_inner_custom_box'))
        {
            return $post_id;
        }

        /*
		 * If this is an autosave, our form has not been submitted,
		 * so we don't want to do anything.
		 */
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
        {
            return $post_id;
        }

        // Check the user's permissions.
        if ('page' == $_POST['post_type'])
        {
            if (! current_user_can('edit_page', $post_id))
            {
                return $post_id;
            }
        }
        else
        {
            if (! current_user_can('edit_post', $post_id))
            {
                return $post_id;
            }
        }
    }

    /**
     * Render Meta Box content.
     *
     * @param WP_Post $post The post object.
     */
    public function render_meta_box_content($post)
    {
        if (!has_post_thumbnail($post->ID)) return false;
        ?>

        <div id="ptb-container-feed" class="ptb-metabox-container">
            <span class="ptb-metabox-title">Feed</span>
            <canvas id="ptb-canvas-feed" width="1200px" height="1200px">
                Your browser does not support the HTML canvas tag.
            </canvas>
            <button class="ptb-download button" data-type="feed">Download</button>
        </div>

        <div id="ptb-container-story" class="ptb-metabox-container">
            <span class="ptb-metabox-title">Story</span>
            <canvas id="ptb-canvas-story" width="1080px" height="1920px">
                Your browser does not support the HTML canvas tag.
            </canvas>
            <button class="ptb-download button" data-type="story">Download</button>
        </div>

        <?php
    }
}

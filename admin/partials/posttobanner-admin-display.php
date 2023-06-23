<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://oswaldocavalcante.com
 * @since      1.0.0
 *
 * @package    Posttobanner
 * @subpackage Posttobanner/admin/partials
 */
?>

<div class="wrap">
    <h1>Post to Banner Settings</h1>

    <form method="post" action="options.php">
        <?php
            settings_fields( 'ptb_settings' );
            do_settings_sections( 'ptb_settings' );
        ?>

        <div>
            <h2 class="title">Website settings</h2>
            <table class="form-table">
                <tbody>
                    <tr class="ptb-settings-field">
                        <th>
                            <label>Blog URL</label>
                        </th>
                        <td>
                            <input type="text" class="regular-text ltr" name="ptb_blog_url" value="<?php echo get_option( 'ptb_blog_url' ) ?>" placeholder="site.com/blog">
                        </td>
                    </tr>
                    <tr class="ptb-settings-field">
                        <th>
                            <label>Site logo</label>
                        </th>
                        <td>
                        <?php 
                            $image_id = get_option( 'ptb_image_id' );

                        if( $image_url = wp_get_attachment_image_url( $image_id, 'medium' ) ) : ?>
                            <a href="#" class="rudr-upload">
                                <img src="<?php echo esc_url( $image_url ) ?>" />
                            </a>
                            <a href="#" class="rudr-remove">Remover imagem</a>
                            <input type="hidden" class="regular-text ltr" name="ptb_image_id" value="<?php echo get_option( 'ptb_image_id' ) ?>"/>
                        <?php else : ?>
                            <a href="#" class="button rudr-upload">Enviar imagem</a>
                            <a href="#" class="rudr-remove" style="display:none">Remover imagem</a>
                            <input type="hidden" class="regular-text ltr" name="ptb_image_id" value="<?php echo get_option( 'ptb_image_id' ) ?>"/>
                        <?php endif; ?>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div>
            <h2 class="title">Banner settings</h2>
            <table class="form-table">
                <tbody>
                    <tr class="ptb-settings-field">
                        <th>
                            <label>Category</label>
                        </th>
                        <td>
                            <input type="text" class="regular-text ltr" name="ptb_category" value="<?php echo get_option( 'ptb_category' ) ?>" placeholder="Articles">
                        </td>
                    </tr>
                    <tr class="ptb-settings-field">
                        <th>
                            <label>Footer title</label>
                        </th>
                        <td>
                            <input type="text" class="regular-text ltr" name="ptb_footer_title" value="<?php echo get_option( 'ptb_footer_title' ) ?>" placeholder="Read now">
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <button type="submit" name="submitForm" class="button button-primary">Save settings</button>

    </form>
</div>
         
<?php
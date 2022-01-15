<div id="shipper-details" class="one-half first">
    <h1><?php echo apply_filters('wpc_shipper_details_label',esc_html__('Shipper Details', 'wpcargo' ) ); ?></h1>
    <?php do_action('wpc_before_shipper_details_table', $post->ID); ?>
    <table class="wpcargo form-table">
        <?php do_action('wpc_before_shipper_details_metabox', $post->ID); ?>
        <tr>
            <th><label><?php esc_html_e('Shipper Name', 'wpcargo'); ?></label></th>
            <td><input type="text" id="wpcargo_shipper_name" name="wpcargo_shipper_name" value="<?php echo get_post_meta($post->ID, 'wpcargo_shipper_name', true); ?>" size="25" /></td>
        </tr>
        <tr>
            <th><label><?php esc_html_e('Phone Number','wpcargo'); ?></label></th>
            <td><input type="text" id="wpcargo_shipper_phone" name="wpcargo_shipper_phone" value="<?php echo get_post_meta($post->ID, 'wpcargo_shipper_phone', true); ?>" size="25" /></td>
        </tr>
        <tr>
            <th><label><?php esc_html_e('Address', 'wpcargo'); ?></label></th>
            <td><input type="text" id="wpcargo_shipper_address" name="wpcargo_shipper_address" value="<?php echo get_post_meta($post->ID, 'wpcargo_shipper_address', true); ?>" size="25" /></td>
        </tr>
        <tr>
            <th><label><?php esc_html_e('Email','wpcargo'); ?></label></th>
            <td><input type="email" id="wpcargo_shipper_email" name="wpcargo_shipper_email" value="<?php echo get_post_meta($post->ID, 'wpcargo_shipper_email', true); ?>" size="25" /></td>
        </tr>
        <?php do_action('wpc_after_shipper_details_metabox', $post->ID); ?>
    </table>
    <?php do_action('wpc_after_shipper_details_table', $post->ID); ?>
</div> <!-- shipper-details -->
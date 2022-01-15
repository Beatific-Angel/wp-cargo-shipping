<div id="receiver-details" class="one-half">
  <h1><?php echo apply_filters('wpc_receiver_details_label',esc_html__('Receiver Details', 'wpcargo' ) ); ?></h1>
  <?php do_action('wpc_before_receiver_details_table', $post->ID); ?>
  <table class="wpcargo form-table" >
    <?php do_action('wpc_before_receiver_details_metabox', $post->ID); ?>
    <tr>
      <th><label>
          <?php esc_html_e('Receiver Name', 'wpcargo'); ?>
        </label></th>
      <td><input type="text" id="wpcargo_receiver_name" name="wpcargo_receiver_name" value="<?php echo get_post_meta($post->ID, 'wpcargo_receiver_name', true); ?>"size="25" /></td>
    </tr>
    <tr>
      <th><label>
          <?php esc_html_e('Phone Number', 'wpcargo' ); ?>
        </label></th>
      <td><input type="text" id="wpcargo_receiver_phone" name="wpcargo_receiver_phone" value="<?php echo get_post_meta($post->ID, 'wpcargo_receiver_phone', true); ?>"size="25" /></td>
    </tr>
    <tr>
      <th><label>
          <?php esc_html_e('Address','wpcargo'); ?>
        </label></th>
      <td><input type="text" id="wpcargo_receiver_address" name="wpcargo_receiver_address" value="<?php echo get_post_meta($post->ID, 'wpcargo_receiver_address', true); ?>"size="25" /></td>
    </tr>
    <tr>
      <th><label>
          <?php esc_html_e('Email', 'wpcargo'); ?>
        </label></th>
      <td><input type="email" id="wpcargo_receiver_email" name="wpcargo_receiver_email" value="<?php echo get_post_meta($post->ID, 'wpcargo_receiver_email', true); ?>"size="25" />
    </tr>
    <?php do_action('wpc_after_receiver_details_metabox', $post->ID); ?>
  </table>
  <?php do_action('wpc_after_receiver_details_table', $post->ID); ?>
</div>
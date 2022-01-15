<h1><?php echo wpcargo_client_account_settings_label(); ?></h1>
<form method="POST" action="options.php" enctype="multipart/form-data">
    <?php settings_fields( 'wpcargo-ca-settings-group' ); ?>
    <?php do_settings_sections( 'wpcargo-ca-settings-group' ); ?>
    <table class="form-table">
        <tbody>
        	<tr valign="top">
                <th scope="row" colspan="2" class="titledesc">
                    <input type="checkbox" name="wpc_disable_registered_shipper_search" value="1" <?php checked( get_option('wpc_disable_registered_shipper_search'), 1 ); ?> /> <?php esc_html_e('Disable Search Client Shipper?', 'wpcargo' ); ?>
                </th>
            </tr>
            <tr valign="top">
                <th scope="row" colspan="2" class="titledesc">
                    <input type="checkbox" name="wpc_disable_registered_receiver_search" value="1" <?php checked( get_option('wpc_disable_registered_receiver_search'), 1 ); ?> /> <?php esc_html_e('Disable Search Client Receiver?', 'wpcargo' ); ?>
                </th>
            </tr>
        </tbody>
    </table>
    <input class="primary button-primary" type="submit" name="submit" value="<?php esc_html_e('Save Settings', 'wpcargo' ); ?>" />
</form>
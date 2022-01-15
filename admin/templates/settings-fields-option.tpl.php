<tr>
    <th scope="row"><?php esc_html_e( 'Add Type of Shipment', 'wpcargo' ) ; ?></th>
    <td>
        <textarea placeholder="<?php esc_html_e( 'Ex. Shipment 1, Shipment 2, Shipment 3', 'wpcargo' ) ; ?>" cols="40" rows="5" name="wpcargo_option_settings[settings_shipment_type]"><?php echo esc_attr( $options['settings_shipment_type'] ); ?></textarea>
        <p style="font-size: 10px;">( <?php esc_html_e( 'Must be comma separated', 'wpcargo' ) ; ?> )</p>
    </td>
</tr>
<tr>
    <th scope="row"><?php esc_html_e( 'Add Shipment Mode', 'wpcargo' ) ; ?></th>
    <td>
        <textarea placeholder="<?php esc_html_e( 'Ex. Shipment Mode 1, Shipment Mode 2, Shipment Mode 3', 'wpcargo' ) ; ?>" cols="40" rows="5" name="wpcargo_option_settings[settings_shipment_wpcargo_mode]"><?php echo esc_attr( $options['settings_shipment_wpcargo_mode'] ); ?></textarea>
        <p style="font-size: 10px;">( <?php esc_html_e( 'Must be comma separated', 'wpcargo' ) ; ?> )</p>
    </td>
</tr>
<tr>
    <th scope="row"><?php esc_html_e( 'Add Shipment Location', 'wpcargo' ) ; ?></th>
    <td>
        <textarea placeholder="<?php esc_html_e( 'Ex. Afghanistan, Albania, Algeria', 'wpcargo' ) ; ?>" cols="40" rows="5" name="wpcargo_option_settings[settings_shipment_country]"><?php echo esc_attr( $options['settings_shipment_country'] ); ?></textarea>
        <p style="font-size: 10px;">( <?php esc_html_e( 'Must be comma separated', 'wpcargo' ) ; ?> )</p>
        <p style="font-size: 10px;"><strong><i>( <?php esc_html_e( 'Note: If you have WPCargo Custom Field Add-on installed, go to Manage form Fields to update list of locations.', 'wpcargo' ) ; ?> )</i></strong></p>
    </td>
</tr>
<tr>
    <th scope="row"><?php esc_html_e( 'Add Shipment Carrier', 'wpcargo' ) ; ?></th>
    <td>
        <textarea placeholder="<?php esc_html_e( 'Ex. Shipment Carrier 1, Shipment Carrier 2, Shipment Carrier 3', 'wpcargo' ) ; ?>" cols="40" rows="5" name="wpcargo_option_settings[settings_shipment_wpcargo_carrier]"><?php echo esc_attr( $options['settings_shipment_wpcargo_carrier'] ); ?></textarea>
        <p style="font-size: 10px;">( <?php esc_html_e( 'Must be comma separated', 'wpcargo' ) ; ?> )</p>
    </td>
</tr>
<tr>
    <th scope="row"><?php esc_html_e( 'Add Shipment Payment Mode', 'wpcargo' ) ; ?></th>
    <td>
        <textarea placeholder="<?php esc_html_e( 'Ex. Payment Mode 1, Payment Mode 2, Payment Mode 3', 'wpcargo' ) ; ?>" cols="40" rows="5" name="wpcargo_option_settings[settings_shipment_wpcargo_payment_mode]"><?php echo esc_attr( $options['settings_shipment_wpcargo_payment_mode'] ); ?></textarea>
        <p style="font-size: 10px;">( <?php esc_html_e( 'Must be comma separated', 'wpcargo' ) ; ?> )</p>
    </td>
</tr>
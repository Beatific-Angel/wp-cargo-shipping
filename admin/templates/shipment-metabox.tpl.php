<div id="shipment-details">
	<h1><?php echo apply_filters('wpc_shipment_details_label', esc_html__('Shipment Details', 'wpcargo' ) ); ?></h1>
	<?php do_action('wpc_before_shipment_details_table', $post->ID); ?>
	<table class="wpcargo form-table">
		<?php do_action('wpc_before_shipment_details_metabox', $post->ID); ?>
		<tr>
			<th><label><?php esc_html_e('Type of Shipment', 'wpcargo' ); ?></label></th>
			<td>
				<?php if( !empty( $shipment_type_list ) ){ ?>
					<select name="wpcargo_type_of_shipment">
						<option value=""><?php esc_html_e('-- Select One --', 'wpcargo' ); ?></option>
						<?php foreach ( $shipment_type_list as $val) { ?>
							<option value="<?php echo trim($val); ?>" <?php echo ( trim($val) == get_post_meta($post->ID, 'wpcargo_type_of_shipment', true)) ? 'selected' : '' ; ?>><?php echo trim($val); ?></option>
						<?php } ?>
					</select>
				<?php } ?>
				<?php if( empty( $shipment_type ) ): ?>
					<span class="meta-box error">
						<strong>
							<?php esc_html__('No Selection setup, Please add selection', 'wpcargo'); ?>
							<a href="<?php echo admin_url().'/admin.php?page=wpcargo-settings"'; ?> ><?php esc_html__('here.', 'wpcargo'); ?></a>
						</strong>
					</span>
				<?php endif; ?>
			</td>
		</tr>
		<tr>
			<th><label><?php esc_html_e('Weight','wpcargo'); ?></label></th>
			<td><input type="text" id="wpcargo_weight" name="wpcargo_weight" value="<?php echo get_post_meta($post->ID, 'wpcargo_weight', true); ?>"size="25" /></td>
		</tr>
		<tr>
			<th><label><?php esc_html_e('Courier','wpcargo'); ?></label></th>
			<td><input type="text" id="wpcargo_courier" name="wpcargo_courier" value="<?php echo get_post_meta($post->ID, 'wpcargo_courier', true); ?>"size="25" /></td>
		</tr>
		<tr>
			<th><label><?php esc_html_e('Packages','wpcargo'); ?></label></th>
			<td><input type="text" id="pack" name="wpcargo_packages" value="<?php echo get_post_meta($post->ID, 'wpcargo_packages', true); ?>"size="25" /></td>
		</tr>
		<tr>
			<th><label><?php esc_html_e('Mode','wpcargo'); ?></label></th>
			<td>
				<?php if( !empty($shipment_mode_list) ){ ?>
					<select name="wpcargo_mode_field">
						<option value=""><?php esc_html_e('-- Select One --', 'wpcargo' ); ?></option>
						<?php foreach ( $shipment_mode_list as $val) { ?>
							<option value="<?php echo trim($val); ?>" <?php echo ( trim($val) == get_post_meta($post->ID, 'wpcargo_mode_field', true)) ? 'selected' : '' ; ?>><?php echo trim($val); ?></option>
						<?php } ?>
					</select>
				<?php } ?>
				<?php if( empty( $shipment_mode ) ): ?>
					<span class="meta-box error">
						<strong>
							<?php esc_html__('No Selection setup, Please add selection', 'wpcargo'); ?>
							<a href="<?php echo admin_url().'/admin.php?page=wpcargo-settings"'; ?> ><?php esc_html__('here.', 'wpcargo'); ?></a>
						</strong>
					</span>
				<?php endif; ?>
			</td>
		</tr>
		<tr>
			<th><label><?php esc_html_e('Product','wpcargo'); ?></label></th>
			<td><input type="text" id="prod" name="wpcargo_product" value="<?php echo get_post_meta($post->ID, 'wpcargo_product', true); ?>"size="25" /></td>
		</tr>
		<tr>
			<th><label><?php esc_html_e('Quantity', 'wpcargo'); ?></label></th>
			<td><input type="text" id="wpcargo_qty" name="wpcargo_qty" value="<?php echo get_post_meta($post->ID, 'wpcargo_qty', true); ?>"size="25" /></td>
		</tr>
		<tr>
			<th><label><?php esc_html_e('Payment Mode','wpcargo' ); ?></label></th>
			<td>
				<?php if( !empty($payment_mode_list) ) { ?>
					<select name="payment_wpcargo_mode_field">
						<option value=""><?php esc_html_e('-- Select One --', 'wpcargo' ); ?></option>
						<?php foreach ( $payment_mode_list as $val) { ?>
							<option value="<?php echo trim($val); ?>" <?php echo ( trim($val) == get_post_meta($post->ID, 'payment_wpcargo_mode_field', true)) ? 'selected' : '' ; ?>> <?php echo trim($val); ?> </option>
						<?php } ?>
					</select>
				<?php } ?>
				<?php if( empty( $payment_mode ) ): ?>
					<span class="meta-box error">
						<strong>
							<?php esc_html__('No Selection setup, Please add selection', 'wpcargo'); ?>
							<a href="<?php echo admin_url().'/admin.php?page=wpcargo-settings"'; ?> ><?php esc_html__('here.', 'wpcargo'); ?></a>
						</strong>
					</span>
				<?php endif; ?>
			</td>
		<tr>
			<th><label><?php esc_html_e('Total Freight','wpcargo'); ?></label></th>
			<td><input type="text" id="wpcargo_total_freight" name="wpcargo_total_freight" value="<?php echo get_post_meta($post->ID, 'wpcargo_total_freight', true); ?>"size="25" /></td>
		</tr>
		<tr>
		<th><label><?php esc_html_e('Carrier','wpcargo'); ?></label></th>
			<td>
				<?php if( !empty( $shipment_carrier_list ) ){ ?>
					<select name="wpcargo_carrier_field">
						<option value=""><?php esc_html_e('-- Select One --', 'wpcargo' ); ?></option>
						<?php foreach ( $shipment_carrier_list as $val ) { ?>
							<option value="<?php echo trim($val); ?>" <?php echo ( trim($val) == get_post_meta($post->ID, 'wpcargo_carrier_field', true)) ? 'selected' : '' ; ?> ><?php echo trim($val); ?></option>
						<?php } ?>
					</select>
				<?php } ?>
				<?php if( empty( $shipment_carrier ) ): ?>
					<span class="meta-box error">
						<strong>
							<?php esc_html__('No Selection setup, Please add selection', 'wpcargo'); ?>
							<a href="<?php echo admin_url().'/admin.php?page=wpcargo-settings"'; ?> ><?php esc_html__('here.', 'wpcargo'); ?></a>
						</strong>
					</span>
				<?php endif; ?>
			</td>
		</tr>
		<tr>
			<th><label><?php esc_html_e('Carrier Reference No.','wpcargo'); ?></label></th>
			<td><input type="text" id="wpcargo_carrier_ref_number" name="wpcargo_carrier_ref_number" value="<?php echo get_post_meta($post->ID, 'wpcargo_carrier_ref_number', true); ?>"size="25" /></td>
		</tr>
		<tr>
			<th><label><?php esc_html_e('Departure Time','wpcargo' ); ?></label></th>
			<td>
				<label for="UpdateDate"></label>
				<input type='text' class="wpcargo-timepicker" id='datetimepicker5' name="wpcargo_departure_time_picker" autocomplete="off" value="<?php echo get_post_meta($post->ID, 'wpcargo_departure_time_picker', true); ?>"/>
			</td>
		</tr>
		<tr>
			<th><label><?php esc_html_e('Origin','wpcargo'); ?></label></th>
			<td>
				<?php if( !empty($shipment_country_org_list) ){ ?>
					<select name="wpcargo_origin_field">
						<option value=""><?php esc_html_e('-- Select One --', 'wpcargo' ); ?></option>
						<?php foreach ( $shipment_country_org_list as $val) { ?>
							<option value="<?php echo trim($val); ?>" <?php echo ( trim($val) == get_post_meta($post->ID, 'wpcargo_origin_field', true)) ? 'selected' : '' ; ?> ><?php echo trim($val); ?></option>
						<?php } ?>
					</select>
				<?php } ?>
				<?php if( empty( $shipment_country_org ) ): ?>
					<span class="meta-box error">
						<strong>
							<?php esc_html__('No Selection setup, Please add selection', 'wpcargo'); ?>
							<a href="<?php echo admin_url().'/admin.php?page=wpcargo-settings"'; ?> ><?php esc_html__('here.', 'wpcargo'); ?></a>
						</strong>
					</span>
				<?php endif; ?>
			</td>
		</tr>
		<tr>
			<th><label><?php esc_html_e('Destination','wpcargo'); ?></label></th>
			<td>
				<?php if( !empty( $shipment_country_des_list ) ){ ?>
					<select id="dest_1" name="wpcargo_destination">
						<option value=""><?php esc_html_e('-- Select One --', 'wpcargo' ); ?></option>
						<?php foreach ( $shipment_country_des_list as $val) { ?>
							<option value="<?php echo trim($val); ?>" <?php echo ( trim($val) == get_post_meta($post->ID, 'wpcargo_destination', true)) ? 'selected' : '' ; ?> ><?php echo trim($val); ?></option>
						<?php } ?>
					</select>
				<?php } ?>
				<?php if( empty( $shipment_country_des ) ): ?>
					<span class="meta-box error">
						<strong>
							<?php esc_html__('No Selection setup, Please add selection', 'wpcargo'); ?>
							<a href="<?php echo admin_url().'/admin.php?page=wpcargo-settings"'; ?> ><?php esc_html__('here.', 'wpcargo'); ?></a>
						</strong>
					</span>
				<?php endif; ?>
			</td>
		</tr>
		<tr>
			<th><label><?php esc_html_e('Pickup Date','wpcargo'); ?></label></th>
			<td><input type='text' class="wpcargo-datepicker" id='datetimepicker4' name="wpcargo_pickup_date_picker" autocomplete="off" value="<?php echo $wpcargo_pickup_date_picker; ?>"/></td>
		</tr>
		<tr>
			<th><label><?php esc_html_e('Pickup Time :','wpcargo'); ?></label></th>
			<td><input type='text' class="wpcargo-timepicker" id='datetimepicker7' name="wpcargo_pickup_time_picker" autocomplete="off" value="<?php echo get_post_meta($post->ID, 'wpcargo_pickup_time_picker', true); ?>" /></td>
		</tr>
		<tr>
			<th><label><?php esc_html_e('Expected Delivery Date', 'wpcargo'); ?></label></th>
			<td><input type='text' class="wpcargo-datepicker" id='datetimepicker3' name="wpcargo_expected_delivery_date_picker" autocomplete="off" value="<?php echo $wpcargo_expected_delivery_date_picker; ?>"/></td>
		</tr>
		<tr>
			<th><label><?php esc_html_e('Comments','wpcargo'); ?></label></th>
			<td><textarea rows="4" cols="50" id="wpcargo_comments" name="wpcargo_comments"><?php echo get_post_meta($post->ID, 'wpcargo_comments', true); ?></textarea></td>
		</tr>
		<?php do_action('wpc_after_shipment_details_metabox', $post->ID); ?>
	</table>
	<?php do_action('wpc_after_shipment_details_table', $post->ID); ?>
</div>
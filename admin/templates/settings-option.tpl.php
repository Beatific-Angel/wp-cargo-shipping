<form method="post" action="options.php">
	<?php
		settings_fields( 'wpcargo_option_settings_group' );
		do_settings_sections( 'wpcargo_option_settings_group' );
	?>
	<table class="form-table">
		<?php do_action('wpcargo_fields_option_settings_group', $options ); ?>
		<tr>
			<th scope="row"><?php esc_html_e( 'Add Shipment Status', 'wpcargo' ) ; ?></th>
			<td>
				<textarea placeholder="<?php esc_html_e( 'Ex. Shipment Status 1, Shipment Status 2, Shipment Status 3', 'wpcargo' ) ; ?>" cols="40" rows="5" name="wpcargo_option_settings[settings_shipment_status]"><?php echo esc_attr( $options['settings_shipment_status'] ); ?></textarea>
				<p style="font-size: 10px;">( <?php esc_html_e( 'Must be comma separated', 'wpcargo' ) ; ?> )</p>
			</td>
		</tr>
		<tr valign="top">
			<th scope="row"><?php esc_html_e( 'Add Shipment Logo', 'wpcargo' ) ; ?></th>
			<td>
				<input type="text" name='wpcargo_option_settings[settings_shipment_ship_logo]' id="image-chooser" value="<?php echo $options['settings_shipment_ship_logo'];?>">        <a id="choose-image" class="button" >Upload Logo</a>
				<script>
				jQuery(document).ready(function($){
					var file_frame;
					$('#choose-image').live('click', function( event ){
						event.preventDefault();
						if ( file_frame ) {
							file_frame.open();
							return;                        }
							// Create the media frame.
							file_frame = wp.media.frames.file_frame = wp.media({
								title: $( this ).data( 'uploader_title' ),
								button: {
									text: $( this ).data( 'uploader_button_text' ),
								},
								multiple: false
								// Set to true to allow multiple files to be selected
							});
							// When an image is selected, run a callback.
							file_frame.on( 'select', function() {
							// We set multiple to false so only get one image from the uploader
							attachment = file_frame.state().get('selection').first().toJSON();
							// Do something with attachment.id and/or attachment.url here
							$('#image-chooser').val( attachment.url );
						});
						// Finally, open the modal
						file_frame.open();
					});
				});
				</script>
			</td>
		</tr>
		<tr valign="top">
			<th scope="row"><?php esc_html_e( 'Display Barcode?', 'wpcargo' ) ; ?></th>
			<td>
				<input type="checkbox" name="wpcargo_option_settings[settings_barcode_checkbox]" value="1" <?php echo ( !empty( $options['settings_barcode_checkbox'] ) ) ? 'checked' : '' ; ?> >
				<p style="font-size: 10px;">( <?php esc_html_e( 'Check if you want to display barcode at the results.', 'wpcargo' ) ; ?> )</p>
			</td>
		</tr>
		<tr>
			<th scope="row"><?php esc_html_e( 'Track Page Settings', 'wpcargo' ) ; ?></th>
			<td>
				<select name='wpcargo_page_settings[wpcargo_page_settings_track_form]'>
					<?php $pages = get_pages(); ?>
					<option value="">--Select Page--</option>
					<?php foreach ($pages as $page) { ?>
						<option value="<?php  echo $page->ID; ?>" <?php selected( $page_options['wpcargo_page_settings_track_form'], $page->ID ); ?>> <?php echo $page->post_title; ?> </option>
					<?php } ?>
				</select>
				<p style="font-size:12px;"><?php esc_html_e('Select a page to insert', 'wpcargo'); ?> "[wpcargo_trackform]"</p>
		        <?php
		        	if (!empty($page_options['wpcargo_page_settings_track_form'])) { ?>
						<a target="_blank" href="post.php?post=<?php echo $page_options['wpcargo_page_settings_track_form']; ?>&amp;action=edit" class="button button-secondary pmpro_page_edit">        <?php esc_html_e('Edit Page', 'wpcargo'); ?></a>
						<a target="_blank" href="<?php echo get_page_link($page_options['wpcargo_page_settings_track_form']); ?>" class="button button-secondary pmpro_page_view"> <?php esc_html_e('View Page', 'wpcargo'); ?> </a>
					<?php }
                    if (!empty($page_options['wpcargo_page_settings_track_form'])) {
                    		$wpbd_insert_shortcode = array(
                    			'ID' => $page_options['wpcargo_page_settings_track_form'],
                    			'post_content' => '[wpcargo_trackform]'
                    		);
                    	wp_update_post($wpbd_insert_shortcode);
                    } ?>
            </td>
        </tr>
        <tr>
        	<th scope="row"><?php esc_html_e( 'Enable Autogenerate Shipment Number?', 'wpcargo' ) ; ?></th>
        	<td>
        		<input type="checkbox" name="wpcargo_option_settings[wpcargo_title_prefix_action]" <?php  echo ( !empty( $options['wpcargo_title_prefix_action'] ) && $options['wpcargo_title_prefix_action'] != NULL  ) ? 'checked' : '' ; ?> />
        	</td>
        </tr>
        <tr>
        	<th scope="row"><?php esc_html_e( 'Shipment Number Prefix', 'wpcargo' ) ; ?></th>
        	<td>
        		<p><input type="text" name="wpcargo_option_settings[wpcargo_title_prefix]" value="<?php echo $options['wpcargo_title_prefix']; ?>" placeholder="WPC"/></p>
        	</td>
		</tr>
		<tr>
        	<th scope="row"><?php esc_html_e( 'Shipment Number Suffix', 'wpcargo' ) ; ?></th>
        	<td>
        		<p><input type="text" name="wpcargo_title_suffix" value="<?php echo $wpcargo_title_suffix; ?>" placeholder="XYZ"/></p>
        	</td>
		</tr>
		<tr>
        	<th scope="row">
				<?php esc_html_e( 'Shipment Number of Digits', 'wpcargo' ) ; ?>
			</th>
        	<td>
        		<p><input type="number" name="wpcargo_title_numdigit" value="<?php echo $wpcargo_title_numdigit; ?>" placeholder="##########"/ min="4"></p>
				<p class="description"><?php esc_html_e('This will be the number of digits that autocreate shipment title. Note: The default number of digits is 12 and minumum of 4 digits', 'wpcargo'); ?></p>
        	</td>
        </tr>
        <tr>
        	<th scope="row"><?php esc_html_e( 'Base color', 'wpcargo' ) ; ?></th>
        	<td>
        		<p><input type="text" class="color-field" name="wpcargo_option_settings[wpcargo_base_color]" value="<?php echo ( $options['wpcargo_base_color'] ) ? : '#00A924' ; ?>" placeholder="#000"/></p>
        	</td>
        </tr>
        <tr>
        	<th scope="row"><?php esc_html_e( 'TAX(%)', 'wpcargo' ) ; ?></th>
        	<td>
        		<p><input type="text" name="wpcargo_option_settings[wpcargo_tax]" value="<?php echo $tax; ?>"/></p>
        		<p class="description"><?php esc_html_e('Note: This setting is optional, some of the WPCargo add on plugins use this data.', 'wpcargo'); ?></p>
        	</td>
        </tr>
        <tr>
        	<th colspan="2"><h2><?php esc_html_e( 'Shipment History Settings', 'wpcargo' ) ; ?></h2></th>
        </tr>
        <tr>
        	<th><?php esc_html_e( 'Display Shipment History in Invoice', 'wpcargo' ) ; ?></th>
        	<td>
        		<input type="checkbox" name="wpcargo_option_settings[wpcargo_invoice_display_history]" <?php  echo ( !empty( $options['wpcargo_invoice_display_history'] ) && $options['wpcargo_invoice_display_history'] != NULL  ) ? 'checked' : '' ; ?> />
        	</td>
        </tr>
        <tr>
        	<th scope="row"><?php esc_html_e( 'Enable User Timezone', 'wpcargo' ) ; ?></th>
        	<td>
        		<input type="checkbox" name="wpcargo_user_timezone" <?php  checked( get_option('wpcargo_user_timezone'), 1 ); ?> value="1" />
        	</td>
        </tr>
        <tr>
        	<th><?php esc_html_e( 'Allow Roles to update shipment history', 'wpcargo' ) ; ?></th>
        	<td>
        		<ul id="wpcargo_edit_history_role">
                    <?php
                    $edit_history_role = array();
                    if( !empty( $options ) ){
                        $edit_history_role = ( array_key_exists( 'wpcargo_edit_history_role', $options ) ) ? $options['wpcargo_edit_history_role'] : array();
                    }
	        		$roles = get_editable_roles();
	        		foreach ($roles as $role_key => $role_value) {
	        			?><li><input type="checkbox" name="wpcargo_option_settings[wpcargo_edit_history_role][]" value="<?php echo $role_key ?>" <?php echo in_array( $role_key, $edit_history_role ) ? 'checked' : '' ; ?> /> <?php echo $role_value['name']; ?></li><?php
	        		}
	        		?>
	        	</ul>
        	</td>
        </tr>
        <tr>
        	<th colspan="2"><h2><?php esc_html_e( 'Assign Shipment Email Settings', 'wpcargo' ) ; ?></h2></th>
        </tr>
        <tr>
        	<th><?php esc_html_e( 'Disable Email for Employee?', 'wpcargo' ) ; ?></th>
        	<td>
        		<input type="checkbox" name="wpcargo_option_settings[wpcargo_email_employee]" <?php  echo ( !empty( $options['wpcargo_email_employee'] ) && $options['wpcargo_email_employee'] != NULL  ) ? 'checked' : '' ; ?> />
        	</td>
        </tr>
        <tr>
        	<th scope="row"><?php esc_html_e( 'Disable Email for Agent?', 'wpcargo' ) ; ?></th>
        	<td>
        		<input type="checkbox" name="wpcargo_option_settings[wpcargo_email_agent]" <?php  echo ( !empty( $options['wpcargo_email_agent'] ) && $options['wpcargo_email_agent'] != NULL  ) ? 'checked' : '' ; ?> />
        	</td>
        </tr>
        <tr>
        	<th><?php esc_html_e( 'Disable Email for Client?', 'wpcargo' ) ; ?></th>
        	<td>
        		<input type="checkbox" name="wpcargo_option_settings[wpcargo_email_client]" <?php  echo ( !empty( $options['wpcargo_email_client'] ) && $options['wpcargo_email_client'] != NULL  ) ? 'checked' : '' ; ?> />
        	</td>
        </tr>
		<?php do_action( 'wpcargo_after_assign_email', $options ); ?>
	</table>
	<?php submit_button(); ?>
</form>
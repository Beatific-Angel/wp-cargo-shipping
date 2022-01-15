<form method="post" action="options.php">
	<?php
	settings_fields( 'wpc_shmap_option_group' );
	do_settings_sections( 'wpc_shmap_option_group' ); ?>
	<table class="form-table">
		<tr>
			<th><?php esc_html_e('Enable Shipment History Map', 'wpcargo' ); ?></th>
			<td>
				<input type="checkbox" name="shmap_active" value="1" <?php checked( $shmap_active, 1 ); ?>>
			</td>
		</tr>
		<tr>
			<th><?php esc_html_e('Display Map in result page?', 'wpcargo' ); ?></th>
			<td>
				<input type="checkbox" name="shmap_result" value="1" <?php checked( $shmap_result, 1 ); ?>>
				<p class="description"><?php esc_html_e( 'Note: This option will take effect only in the result page when "Shipment History Map" option is enabled.', 'wpcargo' ); ?></p>
			</td>
		</tr>
		<tr>
			<th><?php esc_html_e('Map Type', 'wpcargo' ); ?></th>
			<td>
				<select id="maptype" name="shmap_type" required="required">
					<option value=""><?php esc_html_e( '--Select Map Type--', 'wpcargo' ); ?></option>
					<option value="terrain" <?php selected( $shmap_type, 'terrain' ); ?>>Terrain</option>
					<option value="satellite" <?php selected( $shmap_type, 'satellite' ); ?>>Satellite</option>
					<option value="roadmap" <?php selected( $shmap_type, 'roadmap' ); ?>>Roadmap</option>
					<option value="hybrid" <?php selected( $shmap_type, 'hybrid' ); ?>>Hybrid</option>
				</select>
				<p class="description"><?php esc_html_e('note: Default is Terrain.', 'wpcargo'); ?></p>
			</td>
		</tr>
		<tr>
			<th><?php esc_html_e('Zoom Level', 'wpcargo' ); ?></th>
			<td>
				<select id="maptype" name="shmap_zoom" required="required">
					<option value=""><?php esc_html_e( '--Select Zoom Level--', 'wpcargo' ); ?></option>
					<option value="1" <?php selected( $shmap_zoom, 1 ); ?>>World</option>
					<option value="5" <?php selected( $shmap_zoom, 5 ); ?>>Landmass/continent</option>
					<option value="10" <?php selected( $shmap_zoom, 10 ); ?>>City</option>
					<option value="15" <?php selected( $shmap_zoom, 15 ); ?>>Streets</option>
					<option value="20" <?php selected( $shmap_zoom, 20 ); ?>>Buildings</option>
				</select>
				<p class="description"><?php esc_html_e('note: Default is Streets.', 'wpcargo'); ?></p>
			</td>
		</tr>
		<tr>
			<th><?php esc_html_e('Google Map API Key', 'wpcargo' ); ?></th>
			<td>
				<input style="width: 380px;" type="text" name="shmap_api" value="<?php echo $shmap_api; ?>">
				<p class="description"><?php esc_html_e('Please click here to get Google Map API Key', 'wpcargo' ); ?> <a class="button button-primary button-small" href="https://developers.google.com/maps/documentation/embed/get-api-key" target="_blank"><?php esc_html_e('Get API Key','wpcargo' ); ?></a></p>
			</td>
		</tr>
		<tr>
			<th><?php esc_html_e('Longitude', 'wpcargo' ); ?></th>
			<td>
				<input type="text" name="shmap_longitude" value="<?php echo $shmap_longitude; ?>">
			</td>
		</tr>
		<tr>
			<th><?php esc_html_e('Latitude', 'wpcargo' ); ?></th>
			<td>
				<input type="text" name="shmap_latitude" value="<?php echo $shmap_latitude; ?>">
			</td>
		</tr>
		<tr>
			<th><?php esc_html_e('Country Restriction', 'wpcargo' ); ?></th>
			<td>
				<input type="text" name="shmap_country_restrict" value="<?php echo $shmap_country_restrict; ?>">
				<p><i><b><?php esc_html_e( 'Please enter ISO 3166-1 Alpha-2 compatible country code. This is to limit the results for you chosen country only.', 'wpcargo' ); ?></b></i></p>
			</td>
		</tr>
		<tr>
			<th><?php esc_html_e('Google Map Label Color', 'wpcargo' ); ?></th>
			<td>
				<p><input type="text" class="color-field" name="shmap_label_color" value="<?php echo $shmap_label_color; ?>" placeholder="#000"/></p>
			</td>
		</tr>
		<tr>
			<th><?php esc_html_e('Google Map Label Size', 'wpcargo' ); ?></th>
			<td>
				<p><input type="text" name="shmap_label_size" value="<?php echo $shmap_label_size; ?>" placeholder=""/>px</p>
			</td>
		</tr>
		<th scope="row"><?php esc_html_e( 'Google Map Marker', 'wpcargo' ) ; ?></th>
			<td>
				<input type="text" name='shmap_marker' id="image-chooser" value="<?php echo $shmap_marker;?>"><a id="choose-image" class="button" ><?php esc_html_e( 'Upload Logo', 'wpcargo' ) ; ?></a>
				<script>
				jQuery(document).ready(function($){
				 // Uploading files
					var file_frame;
					$('#choose-image').live('click', function( event ){
						event.preventDefault();
						// If the media frame already exists, reopen it.
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
				<p class="description"><?php esc_html_e( 'Note: Marker must be 55px X 55px dimension for best output.', 'wpcargo'); ?></p>
			</td>
	</table>
	<input class="button button-primary button-large" type="submit" name="submit" value="<?php esc_html_e('Save Map Settings', 'wpcargo' ); ?>">
</form>
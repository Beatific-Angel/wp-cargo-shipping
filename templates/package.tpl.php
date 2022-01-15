<div id="wpc-multiple-package" class="print-section wpcargo-table-responsive table-responsive">
	<p class="header-title"><strong><?php apply_filters( 'wpc_multiple_package_header', esc_html_e( 'Packages', 'wpcargo' ) ); ?></strong></p>
	<table class="table wpcargo-table" style="width:100%;">
		<thead>
			<tr>
				<?php foreach ( wpcargo_package_fields() as $key => $value): ?>
					<?php 
					if( in_array( $key, wpcargo_package_dim_meta() ) && !wpcargo_package_settings()->dim_unit_enable ){
						continue;
					}
					?>
					<th><?php echo $value['label']; ?></th>
				<?php endforeach; ?>
			</tr>
		</thead>
		<tbody>
			<?php if(!empty(wpcargo_get_package_data( $shipment->ID ))): ?>
				<?php foreach ( wpcargo_get_package_data( $shipment->ID ) as $data_key => $data_value): ?>
				<tr class="package-row">
					<?php foreach ( wpcargo_package_fields() as $field_key => $field_value): ?>
						<?php 
						if( in_array( $field_key, wpcargo_package_dim_meta() ) && !wpcargo_package_settings()->dim_unit_enable ){
							continue;
						}
						?>
						<td class="package-data <?php echo wpcargo_to_slug($field_key); ?>">
							<?php 
								$package_data = array_key_exists( $field_key, $data_value ) ? $data_value[$field_key] : '' ;
								echo is_array( $package_data ) ? implode(',', $package_data ) : $package_data; 
							?>

						</td>
					<?php endforeach; ?>
				</tr>
				
				<?php endforeach; ?>
				
				<?php do_action( 'wpcargo_after_package_row' ); ?>
			<?php else: ?>
				<tr>
					<td class="empty-data" colspan="<?php echo !wpcargo_package_settings()->dim_unit_enable ? count( wpcargo_package_fields() ) - count( wpcargo_package_dim_meta() ) : count( wpcargo_package_fields() ) ; ?>">
						<i>Data empty.</i>
					</td>
				</tr>
			<?php endif; ?>
		</tbody>
	</table>
	<?php do_action('wpcargo_after_package_details', $shipment ); ?>
</div>
<div class="wpc-mp-wrap">
	<table id="wpcargo-package-table" class="wpc-multiple-package wpc-repeater">
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
				<th>&nbsp;</th>
			</tr>
		</thead>
		<tbody data-repeater-list="<?php echo WPCARGO_PACKAGE_POSTMETA; ?>">
			<?php if(!empty(wpcargo_get_package_data( $shipment->ID ))): ?>
				<?php foreach ( wpcargo_get_package_data( $shipment->ID ) as $data_key => $data_value): ?>
				<tr data-repeater-item class="wpc-mp-tr">
					<?php foreach ( wpcargo_package_fields() as $field_key => $field_value): ?>
						<?php 
						if( in_array( $field_key, wpcargo_package_dim_meta() ) && !wpcargo_package_settings()->dim_unit_enable ){
							continue;
						}
						?>
						<td>
							<?php
							$package_data = array_key_exists( $field_key, $data_value ) ? $data_value[$field_key] : '' ;
							$package_data = is_array( $package_data ) ? implode(',', $package_data ) : $package_data;
							echo wpcargo_field_generator( $field_value, $field_key, $package_data ); 
							?>
						</td>
					<?php endforeach; ?>
					<td><input data-repeater-delete type="button" class="wpc-delete" value="<?php esc_html_e('Delete','wpcargo'); ?>"/></td>
				</tr>
				<?php endforeach; ?>
			<?php else: ?>
				<tr data-repeater-item class="wpc-mp-tr">
					<?php foreach ( wpcargo_package_fields() as $field_key => $field_value): ?>
						<?php 
						if( in_array( $field_key, wpcargo_package_dim_meta() ) && !wpcargo_package_settings()->dim_unit_enable ){
							continue;
						}
						?>
					<td>
						<?php echo wpcargo_field_generator( $field_value, $field_key ); ?>
					</td>
					<?php endforeach; ?>
					<td><input data-repeater-delete type="button" class="wpc-delete" value="<?php esc_html_e('Delete','wpcargo'); ?>"/></td>
				</tr>
			<?php endif; ?>
		</tbody>
		<tfoot>
			<?php do_action('wpcargo_after_package_table_row', $shipment); ?>
			<tr class="wpc-computation">
				<td colspan="6"><input data-repeater-create type="button" class="wpc-add" value="<?php esc_html_e('Add Package','wpcargo'); ?>"/></td>
			</tr>
		</tfoot>
	</table>
	<?php do_action('wpcargo_after_package_totals', $shipment ); ?>
</div>
<script>
jQuery(document).ready(function ($) {
	'use strict';
	$('#wpcargo-package-table').repeater({
		show: function () {
			$(this).slideDown();
		},
		hide: function (deleteElement) {
			if( confirm('<?php esc_html_e( 'Are you sure you want to delete this element?', 'wpcargo' ); ?>') ) {
				$(this).slideUp(deleteElement);
			}
		}
	});
});
</script>
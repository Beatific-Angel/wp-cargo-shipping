<div  class="wpc-sh-wrap">
	<table id="shipment-history" class="wpc-shipment-history" style="width:100%">
		<thead>
			<tr>
				<?php foreach( wpcargo_history_fields() as $history_name => $history_fields ): ?>
					<th class="tbl-sh-<?php echo $history_name; ?>"><?php echo $history_fields['label']; ?></th>
				<?php endforeach; ?>
				<?php do_action('wpcargo_shipment_history_header'); ?>
				<th class="tbl-sh-action">&nbsp;</th>
			</tr>
		</thead>
		<tbody data-repeater-list="wpcargo_shipments_update">
		<?php
			if( !empty( $shipments ) ):
				foreach ( $shipments as $shipment ) :
					?>
					<tr data-repeater-item class="history-data">
						<?php foreach( wpcargo_history_fields() as $history_name => $history_value ): ?>
							<?php 
								$value = !empty( $shipment[$history_name] ) ? $shipment[$history_name] : '';
								$picker_class = '';
								if( $history_name == 'date' ){
									$picker_class = 'wpcargo-datepicker';
								}elseif( $history_name == 'time' ){
									$picker_class = 'wpcargo-timepicker';
								}
							?>
							<td class="tbl-sh-<?php echo $history_name; ?>">
								<?php echo wpcargo_field_generator( $history_value, $history_name, $value, $picker_class.' status_'.$history_name ); ?>
							</td>
						<?php endforeach; ?>
						<?php do_action('wpcargo_shipment_history_data_editable', $shipment ); ?>
						<td class="tbl-sh-action">
							<input data-repeater-delete type="button" class="wpc-delete" value="<?php esc_html_e('Delete', 'wpcargo')?>"/>
						</td>
					</tr>
					<?php
				endforeach;
			else :
				?>
				<tr data-repeater-item class="history-data">
					<?php foreach( wpcargo_history_fields() as $history_name => $history_value ): ?>
						<?php 
							$picker_class = '';
							if( $history_name == 'date' ){
								$picker_class = 'wpcargo-datepicker';
							}elseif( $history_name == 'time' ){
								$picker_class = 'wpcargo-timepicker';
							}
						?>
						<td class="tbl-sh-<?php echo $history_name; ?>">
							<?php echo wpcargo_field_generator( $history_value, $history_name, '', $picker_class.' status_'.$history_name ); ?>
						</td>
					<?php endforeach; ?>
					<?php do_action('wpcargo_shipment_history_data_editable', $shipment = array() ); ?>
					<td class="tbl-sh-action">
						<input data-repeater-delete type="button" class="wpc-delete" value="<?php esc_html_e('Delete', 'wpcargo')?>"/>
					</td>
				</tr>
			<?php endif; ?>
		</tbody>
	</table>
</div>
<?php do_action('before_wpcargo_shipment_history', $post->ID); ?>
<script>
jQuery(document).ready(function ($) {
	'use strict';
	$('#shipment-history').repeater({
		defaultValues: {
			'date': '<?php echo $wpcargo->user_date(get_current_user_id()); ?>',
			'time': '<?php echo $wpcargo->user_time(get_current_user_id()); ?>',
			'location': '',
			'remarks': '',
			'updated-name': '<?php echo $current_user->user_firstname.' '.$current_user->user_lastname; ?>',
			'updated-by': '<?php echo $current_user->ID; ?>'
		},
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
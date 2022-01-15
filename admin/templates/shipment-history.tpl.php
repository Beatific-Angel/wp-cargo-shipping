<div  class="wpc-sh-wrap">
	<table id="shipment-history" class="wpc-shipment-history" style="width:100%">
		<thead>
			<tr>
				<?php foreach( wpcargo_history_fields() as $history_name => $history_fields ): ?>
					<th class="tbl-sh-<?php echo $history_name; ?>"><?php echo $history_fields['label']; ?></th>
				<?php endforeach; ?>
				<?php do_action('wpcargo_shipment_history_header'); ?>
			</tr>
		</thead>
		<tbody data-repeater-list="wpcargo_shipments_update">
		<?php
			if( !empty( $shipments ) ):
				foreach ( $shipments as $shipment ) :
					?>
					<tr data-repeater-item class="history-data">
						<?php foreach( wpcargo_history_fields() as $history_name => $history_value ): ?>
							<td class="tbl-sh-<?php echo $history_name; ?>">
								<?php 
									if( !empty( $shipment[$history_name] ) ){
										echo $shipment[$history_name];
									}
								?>
							</td>
						<?php endforeach; ?>
						<?php do_action('wpcargo_shipment_history_data', $shipment ); ?>
					</tr>
					<?php
				endforeach;
			else :
				?>
				<tr data-repeater-item class="history-data">
					<td colspan="6"><?php esc_html_e('No Shipment History Found.', 'wpcargo'); ?></td>
				</tr>
			<?php endif; ?>
		</tbody>
	</table>
</div>
<?php do_action('before_wpcargo_shipment_history', $post->ID); ?>
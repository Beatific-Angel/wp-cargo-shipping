<div id="wpcargo-history-section" class="wpcargo-history-details print-section">
	<p class="header-title"><strong><?php echo apply_filters( 'wpc_shipment_history_header', esc_html__( 'Shipment History' , 'wpcargo') ); ?></strong></p>
	<?php do_action('before_wpcargo_shipment_history', $shipment->ID) ?>
	<table id="shipment-history" class="table wpcargo-table" style="width: 100%;">
        <thead>
			<tr>
			<?php foreach( wpcargo_history_fields() as $history_name => $history_fields ): ?>
				<th><?php echo $history_fields['label']; ?></th>
			<?php endforeach; ?>
			<?php do_action('wpcargo_shipment_history_header'); ?>
		</tr>
		</thead>
        <tbody>
        <?php
            $shipment_history = maybe_unserialize( get_post_meta( $shipment->ID, 'wpcargo_shipments_update', true ) );
            if(!empty($shipment_history)){
                foreach(array_reverse($shipment_history) as $shipments){
                    ?>
                    <tr class="history-row">
						<?php foreach( wpcargo_history_fields() as $history_name => $history_fields ): ?>
							<?php
								$value = array_key_exists( $history_name, $shipments ) ? $shipments[$history_name] : '' ;
							?>
							<td class="history-data <?php echo wpcargo_to_slug($history_name); ?> <?php echo wpcargo_to_slug($value); ?>"><?php echo $value; ?></td>
						<?php endforeach; ?>
                        <?php do_action('wpcargo_shipment_history_data', $shipments ); ?>
                    </tr>
                    <?php
                }
            }
        ?>
        </tbody>
    </table>
    <?php do_action('after_wpcargo_shipment_history', $shipment->ID) ?>
</div>
<?php
	$shipment_id 		= $shipment_detail->ID;
	$shipper_name		= wpcargo_get_postmeta($shipment_id, 'wpcargo_shipper_name' );
	$shipper_address	= wpcargo_get_postmeta($shipment_id, 'wpcargo_shipper_address' );
	$shipper_phone		= wpcargo_get_postmeta($shipment_id, 'wpcargo_shipper_phone' );
	$shipper_email		= wpcargo_get_postmeta($shipment_id, 'wpcargo_shipper_email' );
	$receiver_name		= wpcargo_get_postmeta($shipment_id, 'wpcargo_receiver_name' );
	$receiver_address	= wpcargo_get_postmeta($shipment_id, 'wpcargo_receiver_address' );
	$receiver_phone		= wpcargo_get_postmeta($shipment_id, 'wpcargo_receiver_phone' );
	$receiver_email		= wpcargo_get_postmeta($shipment_id, 'wpcargo_receiver_email' );
?>
<div id="print-shipper-info" class="wpcargo-row print-section">
	<div class="one-half first">
		<p id="print-shipper-header" class="header-title"><strong><?php echo apply_filters('result_shipper_address', esc_html__('Shipper Address', 'wpcargo')); ?></strong></p>
		<p class="shipper details"><?php echo $shipper_name; ?><br />
			<?php echo $shipper_address; ?><br />
			<?php echo $shipper_phone; ?><br />
			<?php echo $shipper_email; ?><br />
		</p>
	</div>
	<div class="one-half">
		<p id="print-receiver-header" class="header-title"><strong><?php echo apply_filters('result_receiver_address', esc_html__('Receiver Address', 'wpcargo')); ?></strong></p>
		<p class="receiver details"><?php echo $receiver_name; ?><br />
			<?php echo $receiver_address; ?><br />
			<?php echo $receiver_phone; ?><br />
			<?php echo $receiver_email; ?><br />
		</p>
	</div>
</div>
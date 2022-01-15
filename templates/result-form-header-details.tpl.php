<div id="wpcargo-track-header" class="wpcargo-col-md-12 text-center detail-section">
    <div class="comp_logo">
        <?php $options = get_option('wpcargo_option_settings');  ?>
        <img src="<?php echo !empty($options['settings_shipment_ship_logo']) ? $options['settings_shipment_ship_logo'] : ''; ?>">
    </div><!-- comp_logo -->
	<?php
		$options = get_option('wpcargo_option_settings');
		$barcode_settings = !empty($options['settings_barcode_checkbox']) ? $options['settings_barcode_checkbox'] : '';
		if(!empty($barcode_settings)) {
			?>
		    <div class="b_code">
		        <img src="<?php echo $url_barcode; ?>" alt="<?php echo $tracknumber; ?>" />
		    </div><!-- b_code -->
			<?php
		}
	?>
	<div class="shipment-number">
        <h2 class="wpcargo-title"><?php echo apply_filters('wpcargo_track_result_shipment_number', $tracknumber ); ?></h2>
    </div><!-- Track_Num -->
</div>
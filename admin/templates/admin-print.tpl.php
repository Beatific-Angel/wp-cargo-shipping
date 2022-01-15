<?php
if (!defined('ABSPATH')){
	exit; // Exit if accessed directly
}
$get_post_id = isset($_GET['id']) ? $_GET['id']: '';
if(isset($get_post_id)) {
	$sql = "SELECT * FROM " . $wpdb->prefix . "posts WHERE ID = '$get_post_id' AND post_status = 'publish' AND post_type='wpcargo_shipment'";
	$results = $wpdb->get_results($sql);
	if(!empty($results)){
		foreach ($results as $shipment_detail) :
			do_action( 'wpcargo_before_search_result' );
			do_action( 'wpcargo_print_btn' ); ?>
            <div id="wpcargo-result-print">
				<?php
					do_action( 'admin_before_print', $shipment_detail );
					do_action( 'admin_print_header', $shipment_detail );
					do_action( 'admin_print_shipper', $shipment_detail );
					do_action( 'admin_print_shipment', $shipment_detail );
					do_action( 'wpcargo_after_track_details', $shipment_detail );
					do_action('wpcargo_after_package_details', $shipment_detail );	
					if( wpcargo_package_settings()->frontend_enable ){
						do_action('wpcargo_after_package_totals', $shipment_detail );
					}
				?>
			</div><!-- wpcargo-result-print -->
		<?php
		endforeach;
	}
}
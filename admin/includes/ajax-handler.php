<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
function view_shipment_details_callback(){
	$shipment_id 	= $_POST['shipmentID'];
	$shipment 		= new stdClass;
	$shipment->ID 	= $shipment_id;
	$shipment->post_title = get_the_title( $shipment_id );
	ob_start();
	?>
	<div id="wpcargo-result">
		<div id="wpcargo-result-wrapper" class="wpcargo-wrap-details container">
			<?php
			do_action('wpcargo_before_track_details', $shipment );
			do_action('wpcargo_track_header_details', $shipment );
			do_action('wpcargo_track_shipper_details', $shipment );
			do_action('wpcargo_before_shipment_details', $shipment );
			do_action('wpcargo_track_shipment_details', $shipment );
			do_action('wpcargo_after_track_details', $shipment );			
			do_action('wpcargo_after_package_details', $shipment );			
			if( wpcargo_package_settings()->frontend_enable ){
				do_action('wpcargo_after_package_totals', $shipment );
			}
			?>
		</div>
	</div>
	<?php
	$output = ob_get_clean();
	echo $output;
	wp_die();
}
add_action('wp_ajax_view_shipment_details', 'view_shipment_details_callback' );
add_action('wp_ajax_nopriv_view_shipment_details', 'view_shipment_details_callback' );
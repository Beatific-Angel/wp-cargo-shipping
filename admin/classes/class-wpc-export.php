<?php
if ( ! defined( 'ABSPATH' ) ) { die; }
class WPC_Export{
	function form_fields(){
		$wpcargo_meta_data = array(
			array(
				'meta_key' 	=> 'wpcargo_shipper_name',
				'label' 	=> esc_html__( 'Shipper Name', 'wpcargo' ),
				'fields' 	=> array()
			),
			array(
				'meta_key' 	=> 'wpcargo_shipper_phone',
				'label' 	=> esc_html__( 'Phone Number', 'wpcargo' ),
				'fields' 	=> array()
			),
			array(
				'meta_key' 	=> 'wpcargo_shipper_address',
				'label' 	=> esc_html__( 'Shipper Address', 'wpcargo' ),
				'fields' 	=> array()
			),
			array(
				'meta_key' 	=> 'wpcargo_shipper_email',
				'label' 	=> esc_html__( 'Shipper Email', 'wpcargo' ),
				'fields' 	=> array()
			),
			array(
				'meta_key' 	=> 'wpcargo_receiver_name',
				'label' 	=> esc_html__( 'Receiver Name', 'wpcargo' ),
				'fields' 	=> array()
			),
			array(
				'meta_key' 	=> 'wpcargo_receiver_phone',
				'label' 	=> esc_html__( 'Phone Number', 'wpcargo' ),
				'fields' 	=> array()
			),
			array(
				'meta_key' 	=> 'wpcargo_receiver_address',
				'label' 	=> esc_html__( 'Receiver Address', 'wpcargo' ),
				'fields' 	=> array()
			),
			array(
				'meta_key' 	=> 'wpcargo_receiver_phone',
				'label' 	=> esc_html__( 'Phone Number', 'wpcargo' ),
				'fields' 	=> array()
			),
			array(
				'meta_key' 	=> 'wpcargo_receiver_email',
				'label' 	=> esc_html__( 'Receiver Email', 'wpcargo' ),
				'fields' 	=> array()
			),
			array(
				'meta_key' 	=> 'agent_fields',
				'label' 	=> esc_html__( 'Agent Name', 'wpcargo' ),
				'fields' 	=> array()
			),
			array(
				'meta_key' 	=> 'wpcargo_type_of_shipment',
				'label' 	=> esc_html__( 'Type of Shipment', 'wpcargo' ),
				'fields' 	=> array()
			),
			array(
				'meta_key' 	=> 'wpcargo_courier',
				'label' 	=> esc_html__( 'Courier', 'wpcargo' ),
				'fields' 	=> array()
			),
			array(
				'meta_key' 	=> 'wpcargo_mode_field',
				'label' 	=> esc_html__( 'Mode', 'wpcargo' ),
				'fields' 	=> array()
			),
			array(
				'meta_key' 	=> 'wpcargo_qty',
				'label' 	=> esc_html__( 'Quantity', 'wpcargo' ),
				'fields' 	=> array()
			),
			array(
				'meta_key' 	=> 'wpcargo_total_freight',
				'label' 	=> esc_html__( 'Total Freight', 'wpcargo' ),
				'fields' 	=> array()
			),
			array(
				'meta_key' 	=> 'wpcargo_carrier_ref_number',
				'label' 	=> esc_html__( 'Carrier Reference No.', 'wpcargo' ),
				'fields' 	=> array()
			),
			array(
				'meta_key' 	=> 'wpcargo_origin_field',
				'label' 	=> esc_html__( 'Origin', 'wpcargo' ),
				'fields' 	=> array()
			),
			array(
				'meta_key' 	=> 'wpcargo_pickup_date_picker',
				'label' 	=> esc_html__( 'Pickup Date', 'wpcargo' ),
				'fields' 	=> array()
			),
			array(
				'meta_key' 	=> 'wpcargo_status',
				'label' 	=> esc_html__( 'Shipment Status', 'wpcargo' ),
				'fields' 	=> array()
			),
			array(
				'meta_key' 	=> 'wpcargo_comments',
				'label' 	=> esc_html__( 'Comments', 'wpcargo' ),
				'fields' 	=> array()
			),
			array(
				'meta_key' 	=> 'wpcargo_weight',
				'label' 	=> esc_html__( 'Weight', 'wpcargo' ),
				'fields' 	=> array()
			),
			array(
				'meta_key' 	=> 'wpcargo_packages',
				'label' 	=> esc_html__( 'Packages', 'wpcargo' ),
				'fields' 	=> array()
			),
			array(
				'meta_key' 	=> 'wpcargo_product',
				'label' 	=> esc_html__( 'Product', 'wpcargo' ),
				'fields' 	=> array()
			),
			array(
				'meta_key' 	=> 'payment_wpcargo_mode_field',
				'label' 	=> esc_html__( 'Payment Mode', 'wpcargo' ),
				'fields' 	=> array()
			),
			array(
				'meta_key' 	=> 'wpcargo_carrier_field',
				'label' 	=> esc_html__( 'Carrier', 'wpcargo' ),
				'fields' 	=> array()
			),
			array(
				'meta_key' 	=> 'wpcargo_departure_time_picker',
				'label' 	=> esc_html__( 'Departure Time', 'wpcargo' ),
				'fields' 	=> array()
			),
			array(
				'meta_key' 	=> 'wpcargo_destination',
				'label' 	=> esc_html__( 'Destination', 'wpcargo' ),
				'fields' 	=> array()
			),
			array(
				'meta_key' 	=> 'wpcargo_pickup_time_picker',
				'label' 	=> esc_html__( 'Pickup Time', 'wpcargo' ),
				'fields' 	=> array()
			),
			array(
				'meta_key' 	=> 'wpcargo_expected_delivery_date_picker',
				'label' 	=> esc_html__( 'Expected Delivery Date', 'wpcargo' ),
				'fields' 	=> array()
			),
			array(
				'meta_key' 	=> 'wpcargo_shipments_update',
				'label' 	=> esc_html__( 'History', 'wpcargo' ),
				'fields' 	=> array()
			),
		);
		$form_fields = apply_filters( 'ie_registered_fields', $wpcargo_meta_data );
		return  $form_fields;
	}
	function wpc_export_request( ){
		if ( isset( $_REQUEST['wpc_ie_nonce'] ) && wp_verify_nonce( $_REQUEST['wpc_ie_nonce'], 'wpc_import_ie_results_callback' ) ) {
			?>
			<script type="text/javascript">
				jQuery(document).ready(function($) {
					$('body').append('<div class="wpcargo-loading">Loading...</div>');
				});
			</script>
			<?php
			$date_from 				= $_REQUEST['date-from'];
			$date_to 				= strtotime( $_REQUEST['date-to'] );
			$meta_fields			= array();
			$meta_fields_default	= array('ShipmentID', 'Shipment Title', 'Shipment Category');
			$meta_fields_label		= array();
			$meta_fields_key		= array();
			$shipper_meta_query		= array();
			$status_meta_query		= array();
			$registered_shipper_query = array();
			$form_fields			= $this->form_fields();
			//** Checked if meta field is not empty and add to defualt meta field
			if( isset( $_REQUEST['meta-fields'] ) && !empty( $_REQUEST['meta-fields']) ){
				$meta_fields_key = $_REQUEST['meta-fields'];
				//** Change metakey into meta Label in the CSV header
				foreach ( $_REQUEST['meta-fields'] as $fields ) {
					$meta_fields_label[] = $form_fields[$fields];
				}
			}
			//** Checked if meta field is not empty and add to defualt meta field
			if( isset( $_REQUEST['search-shipper'] ) && !empty( $_REQUEST['search-shipper']) ){
				$shipper_meta_query = array(
					'key'			=> apply_filters( 'wpc_report_search_shipper_name_metakey', 'wpcargo_shipper_name' ),
					'value' 		=> $_REQUEST['search-shipper'],
					'compare'		=> '=',
				);
			}
			//** Checked if meta field is not empty and add to defualt meta field
			if( isset( $_REQUEST['wpcargo_status'] ) && !empty( $_REQUEST['wpcargo_status']) ){
				$status_meta_query = array(
					'key'			=> 'wpcargo_status',
					'value' 		=> $_REQUEST['wpcargo_status'],
					'compare'		=> '=',
				);
			}
			if( isset( $_REQUEST['registered_shipper'] ) && !empty( $_REQUEST['registered_shipper']) ){
				$registered_shipper_query = array(
					'key'			=> 'registered_shipper',
					'value' 		=> $_REQUEST['registered_shipper'],
					'compare'		=> '=',
				);
			}
			//** Merge Header Details for excel import
			$meta_label = array_merge($meta_fields_default, $meta_fields_label);
			if( isset( $_REQUEST['tax_input']['wpcargo_shipment_cat'] ) && !empty( $_REQUEST['tax_input']['wpcargo_shipment_cat'] ) ) {
				$wpc_ie_args = array(
					'post_type' 		=> $this->post_type,
					'post_status' 		=> 'publish',
					'posts_per_page' 	=> -1,
					'meta_query' 		=> array( $shipper_meta_query, $status_meta_query, $registered_shipper_query ),
					'tax_query'			=> array(
						array(
							'taxonomy' 			=> $this->post_taxonomy,
							'field' 			=> 'id',
							'terms' 			=> $_REQUEST['tax_input']['wpcargo_shipment_cat'],
							'operator' 			=> 'IN'
						)
					),
					'date_query' => array(
						array(
							'after'     => $date_from,
							'before'    => array(
								'year'  => date('Y', $date_to ),
								'month' => date('n', $date_to ),
								'day'   => date('j', $date_to ),
							),
						'inclusive' => true,
						),
					),
				);
			}else {
				$wpc_ie_args = array(
					'post_type' 		=> $this->post_type,
					'post_status' 		=> 'publish',
					'posts_per_page' 	=> -1,
					'meta_query' 		=> array( $shipper_meta_query, $status_meta_query, $registered_shipper_query ),
					'date_query' => array(
						array(
							'after'     => $date_from,
							'before'    => array(
								'year'  => date('Y', $date_to ),
								'month' => date('n', $date_to ),
								'day'   => date('j', $date_to ),
							),
						'inclusive' => true,
						),
					),
				);
			}
			$filename_unique = "shipment-export-".time().".csv";
			$csv_file = fopen($filename_unique, "w");
			$wpc_ie_query = new WP_Query( $wpc_ie_args );
			if ( $wpc_ie_query->have_posts() ) :
			$wpc_hook_merge_header = apply_filters( 'wpc_hook_merge_export_header', array());
			fputcsv( $csv_file, array_merge($meta_label, !empty($wpc_hook_merge_header) ? $wpc_hook_merge_header : array())  );
				while ( $wpc_ie_query->have_posts() ) : $wpc_ie_query->the_post();
					$excel_data 			= array();
					$wpc_hook_merge_fields 	= array();
					$field_id				= array();
					$shipment_category = '';
					$post_terms = wp_get_post_terms( get_the_ID(), $this->post_taxonomy );
					$post_term_container = array();
					if( !empty( $post_terms ) ) {
						foreach( $post_terms as $post_term ){
							$post_term_container[] = $post_term->name;
						}
						$shipment_category = implode(', ', $post_term_container);
					}
					$excel_data[] = get_the_ID();
					$field_id[]   = get_the_ID();
					$excel_data[] = get_the_title();
					$excel_data[] = $shipment_category;
					foreach( $meta_fields_key as $meta_field ) {
						$wpcargo_post_meta = get_post_meta( get_the_ID(), $meta_field, TRUE);
						if(is_array($wpcargo_post_meta)) {
							foreach($wpcargo_post_meta as $meta_val) {
								$excel_data[] = join(' | ', $meta_val);
							}
						}else{
							$get_meta_fields = get_post_meta( get_the_ID(), $meta_field, TRUE);
							if( is_serialized($get_meta_fields) && $meta_field == 'wpcargo_shipments_update' ) {
								$unserialize_meta_fields = unserialize($get_meta_fields);
								$get_field_data = array();
								foreach($unserialize_meta_fields as $field_data) {
									$get_fields[] = $field_data;
									if(!empty($field_data['date'])) {
										$get_field_data[] = $field_data['date']. ', ' .$field_data['time']. ', ' .$field_data['location']. ', ' .$field_data['status']. ', ' .$field_data['remarks'];
									}
								}
								$excel_data[] = join(" | ", $get_field_data);
							}elseif( is_serialized($get_meta_fields) && $meta_field != 'wpcargo_shipments_update' ) {
								$unser_meta_fields = unserialize($get_meta_fields);
								$get_data_fields = array();
								foreach($unser_meta_fields as $data_fields){
									$get_data_fields[] = $data_fields;
								}
								if(count($get_data_fields) > 1){
									$excel_data[] = join(" | ", $unser_meta_fields);
								}else{
									$excel_data[] = $unser_meta_fields[0].' | ';
								}
							}else{
								$excel_data[] = get_post_meta( get_the_ID(), $meta_field, TRUE);
							}
						}
					}
					$wpc_hook_merge_fields = apply_filters( 'wpc_hook_merge_export_fields', array(), get_the_ID() );
					fputcsv( $csv_file, array_merge($excel_data, !empty($wpc_hook_merge_fields) ? $wpc_hook_merge_fields : array()) );
				endwhile;
				fclose($csv_file);
				?>
                <script>
					jQuery(document).ready(function($) {
						setTimeout(function(){
							$('body .wpcargo-loading').remove();
							window.location='<?php echo $filename_unique; ?>';
						}, 3000);
					});
				</script>
			<?
			else:
			ob_start();
			?>
				<div class="notice notice-error">
                    <p><?php esc_html_e( 'No Result Found!', 'wpcargo' ); ?></p>
				</div>
				<script>
					jQuery(document).ready(function($) {
						$('body .wpcargo-loading').remove();
					});
				</script>
			<?php
			echo ob_get_clean();
			endif;
			wp_reset_postdata();
		}
	}
}
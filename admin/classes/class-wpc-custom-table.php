<?php
if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}
add_filter('manage_wpcargo_shipment_posts_columns' , 'set_default_wpcargo_columns');
function set_default_wpcargo_columns($columns) {
    $get_the_wpcargo_tbl = array(
		'cb' 					=> '<input type="checkbox" />',
		'title' 				=> __( apply_filters( 'wpc_admin_tbl_list_tracking_number', 'Tracking Number' ), 'wpcargo'),
		'wpcargo_category' 		=> __( apply_filters( 'wpc_admin_tbl_list_category', 'Category' ), 'wpcargo'),
		'registered_shipper' 	=> __( apply_filters( 'wpc_admin_tbl_registered_shipper', 'Shipment Owner' ), 'wpcargo'),
		'agent_fields' 			=> __( apply_filters( 'wpc_admin_tbl_list_agent', 'Agent' ), 'wpcargo'),
		wpcargo_shipper_meta_filter() 	=> wpcargo_shipper_label_filter(),
		wpcargo_receiver_meta_filter() => wpcargo_receiver_label_filter(),
		'wpcargo_date' 			=> __( apply_filters( 'wpc_admin_tbl_list_date', 'Date' ), 'wpcargo'),
		'wpcargo_status' 		=> __( apply_filters( 'wpc_admin_tbl_list_status', 'Status' ), 'wpcargo'),
		'wpcargo_actions' 		=> __( apply_filters( 'wpc_admin_tbl_list_action', 'Actions' ), 'wpcargo'),
    );
    $get_the_wpcargo_tbl 		= apply_filters('default_wpcargo_columns', $get_the_wpcargo_tbl );
	return $get_the_wpcargo_tbl;
}
add_action( 'manage_wpcargo_shipment_posts_custom_column', 'manage_default_wpcargo_columns', 10, 2 );
function manage_default_wpcargo_columns( $column, $post_id ) {
	global $post, $wpcargo;
	switch( $column ) {
		case 'agent_fields' :
			$agent_fields = get_post_meta( $post_id, 'agent_fields', true);
			if( is_numeric( $agent_fields ) ){
				$last_name = get_the_author_meta( 'last_name', $agent_fields );
				$first_name = get_the_author_meta( 'first_name', $agent_fields );
				if( !empty( $last_name ) && !empty( $first_name ) ){
					echo $first_name.' '.$last_name;
				}else{
					echo get_the_author_meta( 'display_name', $agent_fields );
				}
			}else{
				echo $agent_fields;
			}
			break;
		case 'wpcargo_category' :
			$post_term = wp_get_post_terms( $post_id, 'wpcargo_shipment_cat', array( 'fields' => 'names' ) );
			echo implode(',', $post_term );
			break;
		case 'registered_shipper' :
			$registered_shipper = get_post_meta( $post_id, 'registered_shipper', true);
			echo ( $registered_shipper ) ? $wpcargo->user_fullname( $registered_shipper ) : '';
			break;
		case wpcargo_shipper_meta_filter() :
			$shipper_name 	= wpcargo_shipper_meta_filter();
			$wpcargo_shipper_name = get_post_meta( $post_id, $shipper_name, true);
			echo $wpcargo_shipper_name;
			break;
		case wpcargo_receiver_meta_filter() :
			$receiver_name 	= wpcargo_receiver_meta_filter();
			$wpcargo_receiver_name = get_post_meta($post_id, $receiver_name, true);
			echo $wpcargo_receiver_name;
			break;
		case 'wpcargo_date':
			$wpcargo_date_publish = get_the_date( $wpcargo->date_format, $post_id );
			echo $wpcargo_date_publish;
			break;
		case 'wpcargo_status' :
			$wpcargo_status = get_post_meta( $post_id, 'wpcargo_status', true );
			echo $wpcargo_status;
			break;
		case 'wpcargo_shipment_cat' :
			$terms = get_the_terms( $post_id, 'wpcargo_shipment_cat' );
			if ( !empty( $terms ) ) {
				$out = array();
				foreach ( $terms as $term ) {
					$out[] = sprintf( '<a href="%s">%s</a>',
						esc_url( add_query_arg( array( 'post_type' => 'wpcargo_shipment', 'wpcargo_shipment_cat' => $term->slug ), 'edit.php' ) ),
						esc_html( sanitize_term_field( 'name', $term->name, $term->term_id, 'wpcargo_shipment', 'display' ) )
					);
				}
				echo join( ', ', $out );
			}
			else {
				esc_html_e( 'No Category', 'wpcargo' );
			}
			break;
		case 'wpcargo_actions' :
			echo '<a href="edit.php?post_type=wpcargo_shipment&page=wpcargo-print-layout&id='.get_the_ID().'" class="button button-secondary"><span class="dashicons dashicons-media-document"></span> Invoice</a><br/>';
			echo '<a href="edit.php?post_type=wpcargo_shipment&page=wpcargo-print-label&id='.get_the_ID().'" class="button button-secondary"><span class="dashicons dashicons-tag"></span> Label</a>';
		break;
		default :
			break;
	}
}
add_filter( 'manage_edit-wpcargo_shipment_sortable_columns', 'set_custom_wpcargo_sortable_columns' );
function set_custom_wpcargo_sortable_columns( $columns ) {
	$columns['wpcargo_date'] 			= 'wpcargo_date';
	$columns['agent_fields'] 			= 'agent_fields';
	$columns['registered_shipper'] 		= 'registered_shipper';
	$columns[wpcargo_shipper_meta_filter()] 	= wpcargo_shipper_meta_filter();
	$columns[wpcargo_receiver_meta_filter()] 	= wpcargo_receiver_meta_filter();
	return $columns;
}
add_action( 'pre_get_posts', 'wpcargo_custom_orderby' );
function wpcargo_custom_orderby( $query ) {
	if ( ! is_admin() )
	return;
	if(isset($_GET['post_type']) && $_GET['post_type'] == 'wpcargo_shipment') {
		$orderby = $query->get( 'orderby');
		if(!isset($_GET['orderby'])){
			$query->set( 'orderby', 'wpcargo_date' );
			$query->set( 'order', 'DESC' );
		}
		if ( 'agent_fields' == $orderby ) {
			$query->set( 'meta_key', 'agent_fields' );
			$query->set( 'orderby', 'meta_value' );
		}
		if ( wpcargo_shipper_meta_filter() == $orderby ) {
			$query->set( 'meta_key', wpcargo_shipper_meta_filter() );
			$query->set( 'orderby', 'meta_value' );
		}
		if ( wpcargo_receiver_meta_filter() == $orderby ) {
			$query->set( 'meta_key', wpcargo_receiver_meta_filter() );
			$query->set( 'orderby', 'meta_value' );
		}
	}
}
/*
** Bulk and Quick Edit function
*/
add_action( 'quick_edit_custom_box', 'wpcargo_bulk_update_status', 10, 2 );
add_action( 'bulk_edit_custom_box', 'wpcargo_bulk_update_status', 10, 2 );
function wpcargo_bulk_update_status( $column_name,  $screen_post_type ){
	global $wpcargo;
	$shmap_active 	= get_option('shmap_active');
 	if( $screen_post_type == 'wpcargo_shipment'  ){
	    wp_nonce_field( 'wpcargo_bulk_update_action', 'wpcargo_bulk_update_nonce' );
	    if( $column_name == 'wpcargo_status' ){
	 		?>
		 	<fieldset id="shipment-bulk-update" class="inline-edit-col-left" style="border: 1px solid #ddd; margin-top: 6px; padding:8px;">
		 		<div class="inline-edit-col wpc-status-section">
					<div class="inline-edit-group wp-clearfix">
						<legend class="inline-edit-legend"><?php esc_html_e( 'Update Shipment Status', 'wpcargo' ) ?></legend>
						<p><input style="width:100%;" class="bulkdate" type="date" name="status_date" placeholder="<?php echo $wpcargo->date_format; ?>" autocomplete="off" /></p>
						<p><input style="width:100%;" class="bulktime" type="time" name="status_time" autocomplete="off" /></p>
						<p><input style="width:100%;" class="status_location" type="text" name="status_location" placeholder="<?php esc_html_e( 'Current City', 'wpcargo' ); ?>"  autocomplete="off" /></p>
						<?php if( !empty( $wpcargo->status ) ): ?>
					        <select style="width:100%;" class="wpcargo_status" name="wpcargo_status" >
					            <option value=""><?php esc_html_e( '--Select Status--', 'wpcargo' ) ?></option>
					            <?php
					                foreach( $wpcargo->status as $value ){
					                    ?><option value="<?php echo $value; ?>"><?php echo $value; ?></option><?php
					                }
					            ?>
					        </select>
					    <?php else: ?>
					        <p class="description"><?php esc_html_e( 'No Shipment Status Found.', 'wpcargo' ) ?> <a href="<?php echo admin_url('admin.php?page=wpcargo-settings'); ?>"><?php esc_html_e( 'Add Shipment Status', 'wpcargo' ) ?></a></p>
					    <?php endif; ?>
					    <p> <textarea style="width:100%;" class="remarks" name="status_remarks" placeholder="<?php esc_html_e( 'Remarks', 'wpcargo' ); ?>" ></textarea>
					</div>
				</div>
			</fieldset>
			<fieldset class="inline-edit-col-right">
		 		<div class="inline-edit-col">
					<div class="inline-edit-group wp-clearfix">
						<label class="inline-edit-status alignleft">
							<span class="title"><?php esc_html_e( 'Select Agent', 'wpcargo' ); ?></span>
							<select name="wpcargo_agent">
								<option value=""><?php esc_html_e( '— No Change —', 'wpcargo' ); ?></option>
								<?php
								if( !empty( $wpcargo->agents ) ){
							 		foreach ( $wpcargo->agents as $agentid => $agent_name ) {
							 			?><option value="<?php echo $agentid; ?>"><?php echo $agent_name; ?></option><?php
							 		}
							 	}
								?>
							</select>
						</label>
					</div>
				</div>
			</fieldset>
		 	<?php
		}
 	}
}
/*
** Bulk and Quick Save function
*/
add_action( 'save_post', 'wpcargo_shipment_bulk_save' );
function wpcargo_shipment_bulk_save( $post_id ) {
	global $wpcargo;
    if ( !current_user_can( 'edit_post', $post_id ) ) {
        return;
    }
    if( !isset( $_REQUEST["wpcargo_bulk_update_nonce"] ) ){
    	return;
    }
    if ( !wp_verify_nonce( $_REQUEST["wpcargo_bulk_update_nonce"], 'wpcargo_bulk_update_action' ) ){
        return;
    }
    $current_user = wp_get_current_user();
	if ( isset( $_REQUEST['wpcargo_status'] ) && $_REQUEST['wpcargo_status'] != '' ) {
	    $wpcargo_status 	= trim( sanitize_text_field( $_REQUEST['wpcargo_status'] ) );
		$status_location 	= trim( sanitize_text_field( $_REQUEST['status_location'] ) );
		$status_time 		= sanitize_text_field( $_REQUEST['status_time'] );
		$status_remarks 	= trim( sanitize_text_field( $_REQUEST['status_remarks'] ) );
		$status_date 		= trim( sanitize_text_field( $_REQUEST['status_date'] ) );
		$apply_to_shipment 	= ( isset($_REQUEST['apply_status']) ) ? true : false ;
		$wpcargo_shipments_update = maybe_unserialize( get_post_meta( $post_id, 'wpcargo_shipments_update', true ) );
		// Make sure that it is set.
		$new_history = array(
			'date' => $status_date,
			'time' => $status_time,
			'location' => $status_location,
			'updated-name' => $current_user->display_name,
			'updated-by' => $current_user->ID,
			'remarks'	=> $status_remarks,
			'status'    => $wpcargo_status
		);
		if( $wpcargo_status ){
			update_post_meta($post_id, 'wpcargo_status', $wpcargo_status );
		}
		if( !empty( $wpcargo_shipments_update ) ){
			if( $wpcargo_status ){
				array_push($wpcargo_shipments_update, $new_history);
			}
			update_post_meta($post_id, 'wpcargo_shipments_update', maybe_serialize( $wpcargo_shipments_update ) );
		}else{
			if( !wp_is_post_revision( $post_id ) ){
				if( $wpcargo_status ){
					update_post_meta($post_id, 'wpcargo_shipments_update', maybe_serialize( array( $new_history ) ) );
				}
			}
		}
		do_action( 'wpc_add_sms_shipment_history', $post_id );
		//require_once( WPCARGO_PLUGIN_PATH.'admin/templates/email-notification.tpl.php' );
	}
	if ( isset( $_REQUEST['wpcargo_agent'] ) && $_REQUEST['wpcargo_agent'] != '' ) {
	    $wpcargo_agent  = $_REQUEST['wpcargo_agent'];
		update_post_meta( $post_id, 'agent_fields', $wpcargo_agent );
	}
}
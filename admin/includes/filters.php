<?php
if (!defined('ABSPATH')){
	exit; // Exit if accessed directly
}
add_action('restrict_manage_posts', 'wpcargo_filter_status');
function wpcargo_filter_status() {
	global $typenow, $wpcargo;
	$shipmentCat = 'wpcargo_shipment_cat';
	$args = array(
		'taxonomy' => $shipmentCat,
	);
	$shipment_category	= get_terms( $args );
	$post_type 			= 'wpcargo_shipment'; // change to your post type
	$status  			= 'wpcargo_status'; // change to your taxonomy
	$wpcargo_users      = $wpcargo->users;
	if ($typenow == $post_type) {
		$shipment_status = array_filter( $wpcargo->status );
		if( !empty( $shipment_status ) ){
			echo '<select name="wpcargo_status">';
				echo '<option value="">'.esc_html__('-- Select All Status --', 'wpcargo').'</option>';
					foreach( $shipment_status as $val ){
						$selected_val = isset($_REQUEST[$status]) && $_REQUEST[$status] == trim($val) ? 'selected' : '';
						echo '<option value="'.trim($val).'" '.$selected_val.'>'.trim($val).'</option>';
					}
			echo '</select>';
		}
		//Agents
		$args_agent = array(
			'role'         => 'cargo_agent',
			'meta_key' => 'first_name',
			'orderby'  => 'meta_value',
		 );
		$get_wpcargo_agent = get_users( $args_agent );
		if( !empty( $shipment_category ) ){
			echo '<select name="wpcargo_shipment_cat">';
				echo '<option value="">'.esc_html__('-- Select All Category --', 'wpcargo').'</option>';
					foreach( $shipment_category as $objShipmentCat ){
						$selectedCategory = isset($_REQUEST[$shipmentCat]) && $_REQUEST[$shipmentCat] == $objShipmentCat->slug ? 'selected' : '';
						echo '<option value="'.$objShipmentCat->slug.'" '.$selectedCategory.'>'.$objShipmentCat->name.' ('.$objShipmentCat->count.')</option>';
					}
			echo '</select>';
		}
		if(!empty($get_wpcargo_agent) && is_array($get_wpcargo_agent)) {
			echo '<select name="cargo_agent">';
				echo '<option value="">'.esc_html__('-- All Agents --', 'wpcargo').'</option>';
			foreach($get_wpcargo_agent as $agent_details){
				$user_fullname = $wpcargo->user_fullname( $agent_details->ID );
				$selected_val = isset($_REQUEST['cargo_agent']) && $_REQUEST['cargo_agent'] == $agent_details->ID ? 'selected' : '';
				echo '<option value="'.trim($agent_details->ID).'" '.$selected_val.'>'.$user_fullname.'</option>';
			}
			echo '</select>';
		}
		// Registered Shipper
		if(!empty( wpcargo_has_registered_shipper() ) ) {
			echo '<select name="registered_shipper">';
				echo '<option value="">'.apply_filters( 'wpcargo_filter_registered_shipper_label', esc_html__('-- All Owners --', 'wpcargo') ).'</option>';
				foreach( wpcargo_has_registered_shipper() as $shipper_id ){
					$user_fullname = apply_filters( 'wpcargo_filter_registered_shipper_option_label', $wpcargo->user_fullname(  $shipper_id ), $shipper_id );
					$selected_val = isset($_REQUEST['registered_shipper']) && $_REQUEST['registered_shipper'] ==  $shipper_id ? 'selected' : '';
					echo '<option value="'.trim( $shipper_id).'" '.$selected_val.'>'.$user_fullname.'</option>';
				}
			echo '</select>';
		}
		//Shipper Name
		$get_shippers = wpc_get_meta_values( wpcargo_shipper_meta_filter() );
		if(!empty($get_shippers) && is_array($get_shippers)) {
			$get_wpcargo_shipper = array_unique(array_filter($get_shippers));
			sort($get_wpcargo_shipper);
			echo '<select name="'.wpcargo_shipper_meta_filter().'">';
				echo '<option value="">'.esc_html__('-- All Shipper --', 'wpcargo').'</option>';
			foreach($get_wpcargo_shipper as $shipper_details){
				$selected_val = isset($_REQUEST[wpcargo_shipper_meta_filter()]) && $_REQUEST[wpcargo_shipper_meta_filter()] == $shipper_details ? 'selected' : '';
				echo '<option value="'.trim($shipper_details).'" '.$selected_val.'>'.trim($shipper_details).'</option>';
			}
			echo '</select>';
		}
		//Receiver Name
		$get_receiver = wpc_get_meta_values(wpcargo_receiver_meta_filter());
		if(!empty($get_receiver) && is_array($get_receiver)) {
			$get_wpcargo_receiver = array_unique(array_filter($get_receiver));
			sort($get_wpcargo_receiver);
			echo '<select name="'.wpcargo_receiver_meta_filter().'">';
				echo '<option value="">'.esc_html__('-- All Receiver --', 'wpcargo').'</option>';
			foreach($get_wpcargo_receiver as $receiver_details){
				$selected_val = isset($_REQUEST[wpcargo_receiver_meta_filter()]) && $_REQUEST[wpcargo_receiver_meta_filter()] == $receiver_details ? 'selected' : '';
				echo '<option value="'.trim($receiver_details).'" '.$selected_val.'>'.trim($receiver_details).'</option>';
			}
			echo '</select>';
		}
	};
}
add_filter('parse_query', 'wpc_status_query');
function wpc_status_query($query) {
	global $pagenow;
	$post_type = 'wpcargo_shipment';
	$q_vars    = &$query->query_vars;
	$get_wpc_query = array();
	$meta_query 	= array();
	if ( $pagenow == 'edit.php' && isset($q_vars['post_type']) && $q_vars['post_type'] == $post_type && isset($_GET['wpcargo_status']) && $_GET['wpcargo_status'] != '' ) {
		$get_wpc_query[] = array(
			'key'     => 'wpcargo_status',
			'value'   => $_GET['wpcargo_status'],
			'compare' => '=',
		);
	}
	if ( $pagenow == 'edit.php' && isset($q_vars['post_type']) && $q_vars['post_type'] == $post_type && isset($_GET['cargo_agent']) && $_GET['cargo_agent'] != '') {
		 $get_wpc_query[] = array(
			'key'     => 'agent_fields',
			'value'   => $_GET['cargo_agent'],
			'compare' => '=',
		  );
	}
	if ( $pagenow == 'edit.php' && isset($q_vars['post_type']) && $q_vars['post_type'] == $post_type && isset($_GET['registered_shipper']) && $_GET['registered_shipper'] != '') {
		 $get_wpc_query[] = array(
			'key'     => 'registered_shipper',
			'value'   => $_GET['registered_shipper'],
			'compare' => '=',
		  );
	}
	if ( $pagenow == 'edit.php' && isset($q_vars['post_type']) && $q_vars['post_type'] == $post_type && isset($_GET[wpcargo_shipper_meta_filter()]) && $_GET[wpcargo_shipper_meta_filter()] != '') {
		 $get_wpc_query[] = array(
			'key'     => wpcargo_shipper_meta_filter(),
			'value'   => $_GET[wpcargo_shipper_meta_filter()],
			'compare' => '=',
		  );
	}
	if ( $pagenow == 'edit.php' && isset($q_vars['post_type']) && $q_vars['post_type'] == $post_type && isset($_GET[wpcargo_receiver_meta_filter()]) && $_GET[wpcargo_receiver_meta_filter()] != '') {
		 $get_wpc_query[] = array(
			'key'     => wpcargo_receiver_meta_filter(),
			'value'   => $_GET[wpcargo_receiver_meta_filter()],
			'compare' => '=',
		  );
	}
	if ( $pagenow == 'edit.php' && isset($q_vars['post_type']) && $q_vars['post_type'] == $post_type && isset($_GET['wpcargo_shipment_cat']) && $_GET['wpcargo_shipment_cat'] != '') {
		$meta_query['tax_query'] =  array(
			'taxonomy' => 'wpcargo_shipment_cat',
			'field' => 'slug',
			'terms' => array( $_GET['wpcargo_shipment_cat'] ),
			'_children' => true,
			'operator' => 'IN'
		 );
   }
	//** Export custom query for WPCargo Shipment table
	$filter_metakey 	= apply_filters( 'wpcargo_shipment_query_filter', array( ) );
	if( !empty( $filter_metakey ) ){
		foreach ( $filter_metakey as $metakey ) {
			if ( $pagenow == 'edit.php' && isset($q_vars['post_type']) && $q_vars['post_type'] == $post_type && isset($_GET[$metakey]) && $_GET[$metakey] != '' ) {
				$compare = '=';
				if( is_array( $_GET[$metakey] ) ){
					$compare = 'IN';
				}
				$get_wpc_query[] = array(
					'key'     => $metakey,
					'value'   => $_GET[$metakey],
					'compare' => '=',
				);
			}
		}
	}
	$meta_query[] = array(
		$get_wpc_query
	);
	if(!isset($_GET['page']) && is_admin()) {
		$query->set( 'meta_query', $meta_query);
	}
}
add_filter('posts_join', 'wpc_search_join_admin_tbl_lists' );
function wpc_search_join_admin_tbl_lists ($join){
    global $pagenow, $wpdb;
    if ( isset($_GET['s']) && is_admin() && $pagenow=='edit.php' && $_GET['post_type']=='wpcargo_shipment' && $_GET['s'] != '') {
        $join .='LEFT JOIN '.$wpdb->postmeta. ' ON '. $wpdb->posts . '.ID = ' . $wpdb->postmeta . '.post_id ';
    }
    return $join;
}
add_filter( 'posts_where', 'wpc_search_query_admin_tbl_lists' );
function wpc_search_query_admin_tbl_lists( $where ){
    global $pagenow, $wpdb;
    if ( !isset($_GET['page']) && isset($_GET['s']) && is_admin() && $pagenow=='edit.php' && $_GET['post_type']=='wpcargo_shipment' && $_GET['s'] != '') {
        $where = preg_replace(
       "/\(\s*".$wpdb->posts.".post_title\s+LIKE\s*(\'[^\']+\')\s*\)/",
       "(".$wpdb->posts.".post_title LIKE $1) OR (".$wpdb->postmeta.".meta_value LIKE $1)", $where );
    }
    return $where;
}
function wpc_get_meta_values( $key = '', $type = 'wpcargo_shipment', $status = 'publish' ) {
    global $wpdb;
    if( empty( $key ) )
        return;
    $r = $wpdb->get_col( $wpdb->prepare( "
        SELECT pm.meta_value FROM {$wpdb->postmeta} pm
        LEFT JOIN {$wpdb->posts} p ON p.ID = pm.post_id
        WHERE pm.meta_key = '%s'
        AND p.post_status = '%s'
        AND p.post_type = '%s'
    ", $key, $status, $type ) );
    return $r;
}
/*
 * My Account filter Query
 */
add_filter('wpcargo_account_query', function( $args, $sort ){
	$user_id 	= get_current_user_id();
	$user_info	= get_userdata( $user_id );
	$user_roles = $user_info->roles;
	if( in_array( 'administrator', $user_roles ) ){
		unset( $args['meta_query'] );
	}else{
		if(  $sort == 'owned' ){
			$args['meta_query'] = array(
				array(
					'key' => 'registered_shipper',
					'value' => $user_id
				)
			);
		}elseif( $sort == 'receivable' ){
			$args['meta_query'] = array(
				array(
					'key' => 'registered_receiver',
					'value' => $user_id
				)
			);
		}
	}
	return $args;
}, 10, 2 );
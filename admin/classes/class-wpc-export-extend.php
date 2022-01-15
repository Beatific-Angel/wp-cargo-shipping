<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }
require_once( WPCARGO_PLUGIN_PATH.'admin/classes/class-wpc-export.php');
class WPC_Export_Admin extends WPC_Export{
	protected $post_type 		= 'wpcargo_shipment';
	protected $post_taxonomy 	= 'wpcargo_shipment_cat';
	function __construct(){
		add_action('admin_menu', array($this,'wpc_import_export_submenu_page') );
		add_action( 'wp_ajax_update_import_option_ajax_request',  array($this,'update_import_option_ajax_request') );
		add_action( 'wp_ajax_search_shipper',  array($this,'wpc_import_export_search_shipper') );
	}
	function wpc_import_export_submenu_page() {
		//** Import Submenu
		add_submenu_page(
			'edit.php?post_type=wpcargo_shipment',
			wpcargo_report_settings_label(),
			wpcargo_report_settings_label(),
			'manage_options',
			'wpc-report-export',
			array($this,'wpc_import_export_submenu_page_callback') );
		//** Exmport Submenu
		add_submenu_page(
			NULL,
			wpcargo_report_settings_label(),
			wpcargo_report_settings_label(),
			'manage_options',
			'wpc-ie-import',
			array($this,'wpc_import_export_submenu_page_callback') );
	}
	function wpc_import_export_submenu_page_callback() {
		global $wpdb;
		$table_name = $wpdb->prefix.'wpcargo_custom_fields';
		$field_selection = $this->form_fields();
		$page = $_GET['page'];
		$tax_args       = array(
			'orderby' => 'name',
			'order' => 'ASC',
			'taxonomy' => $this->post_taxonomy,
			'hide_empty' => 0
		);
		$cat_taxonomy = get_categories($tax_args);
		ob_start();
		?>
		<div class="wrap"><div id="icon-tools" class="icon32"></div>
            <?php $this->wpc_ie_header_tab();  ?>
            <div style="clear: both;"></div>
            <div id="form-block">
            	<?php
					if( $page == 'wpc-report-export' ){
						$this->wpc_export_form( $field_selection, $cat_taxonomy, $page);
					}
				?>
            </div>
            <div id="ads">
		    	<a href="http://www.wpcargo.com/product/wpcargo-importexport-add-ons/" target="_blank" class="wpc-documentation">
				    <div class="wpc-img"> <img src="<?php echo WPCARGO_PLUGIN_URL; ?>/admin/assets/images/documentation.png"> </div>
				    <div class="wpc-desc">
				      <h3><?php esc_html_e('Purchase', 'wpcargo'); ?> WPCargo Import Export Add-ons</h3>
				      <p><?php esc_html_e('If you want a more comprehensive and customizable report, purchase', 'wpcargo'); ?> WPCargo Import Export Add-ons.</p>
				    </div>
				</a>
		    </div>
		</div>
        <?php
		echo ob_get_clean();
	}
	function update_import_option_ajax_request() {
		// The $_REQUEST contains all the data sent via ajax
		if ( isset($_REQUEST) ) {
			update_option('multiselect_settings', $_REQUEST['multiselect_settings'], true);
		}
		// Always die in functions echoing ajax content
	   die();
	}
	function wpc_export_form( $fields = array(), $taxonomy = array(), $page ='') {
		add_action( 'wp_ajax_update_import_option_ajax_request',  'update_import_option_ajax_request' );
		global $wpcargo;
		$options 					= get_option( 'multiselect_settings' );
		if( !empty( $options ) ){
			if( array_key_exists( 0, $options ) ){
				$options = array();
			}
		}
		$user_args = array(
						'meta_key' => 'first_name',
						'orderby'  => 'meta_value',
						'role__in' => array( 'wpcargo_client' ),
					);
		$users = get_users( $user_args );
		$registered_shipper = isset( $_REQUEST['shipment_author'] ) ? (int)$_REQUEST['shipment_author'] : '';
		?>
        <form id="wpc-ie-form" method="POST" action="<?php echo admin_url(); ?>edit.php?post_type=wpcargo_shipment&page=wpc-report-export" >
			<?php wp_nonce_field( 'wpc_import_ie_results_callback', 'wpc_ie_nonce' ); ?>
            <p><strong class="left-lbl"><?php esc_html_e('Shipper Name:','wpcargo'); ?></strong> <input id="search-shipper" type="text" name="search-shipper" value="<?php echo isset($_REQUEST['search-shipper']) ? $_REQUEST['search-shipper'] : '';  ?>" /></p>
            <?php if( !empty($users) && !wpcie_is_client() ): ?>
				<p>
					<strong class="left-lbl"><?php esc_html_e( 'Registered Shipper:', 'wpcargo' ); ?></strong>
					<select name="registered_shipper" class="form-control browser-default custom-select" id="registered_shipper">
						<option value=""><?php esc_html_e('-- Registered Shipper --', 'wpcargo' ); ?></option>
						<?php foreach( $users as $user ): ?>
							<option value="<?php  echo $user->ID; ?>" <?php selected( $registered_shipper, $user->ID ); ?> ><?php echo $wpcargo->user_fullname( $user->ID ); ?></option>
						<?php endforeach; ?>      
					</select>
				</p>
            <?php endif; ?>
			<p id="import-datepicker"><strong class="left-lbl"><?php esc_html_e('Date Range','wpcargo'); ?> : </strong></p>
			<p id="daterange-section" style="padding-left: 20px;">
				<label for="date-from" ><strong><?php esc_html_e('From : ','wpcargo'); ?></strong></label>
				<input class="wpcargo-datepicker" type="text" id="wpcargo-import-form" name="date-from" value="<?php echo isset($_REQUEST['date-from']) ? $_REQUEST['date-from'] : ''; ?>" required />
				<label for="date-to"><strong><?php esc_html_e('To : ','wpcargo'); ?></strong></label>
				<input class="wpcargo-datepicker" type="text" id="wpcargo-import-to" name="date-to" value="<?php echo isset($_REQUEST['date-to']) ? $_REQUEST['date-to'] : ''; ?>" required />
			</p>
			<p>
			<strong class="left-lbl"><?php esc_html_e('Status','wpcargo'); ?>: </strong>
			<select name="wpcargo_status" class="wpc-status">
				<?php
				if(!empty($wpcargo->status)) {
					echo '<option value="">-- '.esc_html__('Choose Status', 'wpcargo').' --</option>';
					foreach( $wpcargo->status as $status ){
						$get_selected_value = isset($_REQUEST['wpcargo_status']) && $_REQUEST['wpcargo_status'] == $status ? 'selected' : '';
						echo '<option value="'.$status.'" '.$get_selected_value.'>'.$status.'</option>';
					}
				}
				?>
			</select>
			</p>
            <div id="multi-select-export">
                <p><strong><?php esc_html_e('Select Option','wpcargo'); ?></strong></p>
                <div class="row">
                    <div class="col-xs-5">
                        <select name="from[]" id="multiselect" class="form-control" size="8" multiple="multiple">
                            <?php
                            if($fields) {
                            	asort($fields);
                                foreach( $fields as $key => $value ){
                                    ?><option value="<?php echo $value['meta_key']; ?>"><?php echo $value['label']; ?></option><?php
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-xs-2">
                        <button type="button" id="multiselect_rightAll" class="btn btn-block"><span class="dashicons dashicons-controls-skipforward"></span></button>
                        <button type="button" id="multiselect_rightSelected" class="btn btn-block"><span class="dashicons dashicons-controls-forward"></span></button>
                        <button type="button" id="multiselect_leftSelected" class="btn btn-block"><span class="dashicons dashicons-controls-back"></span></button>
                        <button type="button" id="multiselect_leftAll" class="btn btn-block"><span class="dashicons dashicons-controls-skipback"></span></button>
                    </div>
                    <div class="col-xs-5">
                        <select name="meta-fields[]" id="multiselect_to" class="form-control" size="8" multiple="multiple">
                            <?php
                                if(!empty( $options ) ) {
                                    foreach ($options as $optkey => $optvalue ) {
                                    	echo "<option value='".$optkey."'>".$optvalue."</option>";
                                    }
                                }
                            ?>
                        </select>
                    </div>
                </div>
            </div>
			<div style="clear:both;"></div>
            <input type="hidden" name="post_type" value="wpcargo_shipment" />
            <input type="hidden" name="page" value="<?php echo $page; ?>" />
            <p><input style="margin-top: 24px;" class="button button-primary button-large" type="submit" name="submit" value="<?php esc_html_e('Generate Report','wpcargo'); ?>" /></p>
            <p class="description"><?php esc_html_e('Note: This will take a couple of seconds to generate reports, wait for a pop up message to save your report.', 'wpcargo' ); ?></p>
        </form>
	    <div style="clear: both;"></div>
		<script type="text/javascript">
		jQuery(document).ready(function($) {
			$('#multi-select-export button.btn.btn-block').on('click', function(e){
				e.preventDefault();
				$("#multiselect_to, #multiselect").trigger('change');
			});
			$('#multiselect').multiselect({
				sort: false,
				autoSort: false,
				autoSortAvailable: false,
			});
			$("#multiselect_to, #multiselect").on('change',function() {
				setTimeout(function(){
					var selectoptions= {};
					$.each($("#multiselect_to option"), function( ) {
						var metaKey = $(this).attr("value");
						var metaValue = $(this).text();
						selectoptions[metaKey] = metaValue;
					});
					jQuery.ajax({
						url : 'admin-ajax.php',
						type : 'post',
						data : {
							action : 'update_import_option_ajax_request',
							multiselect_settings: selectoptions
						},
						success : function( response ) {
							//alert(response)
						}
					});
				}, 1000);
			});
		});
		</script>
	    <?php
	}
	function wpc_import_export_search_shipper(){
		global $wpdb, $post;
		// Handle request then generate response using WP_Ajax_Response
		$term = $_GET['term'];
		$shipper_name_metakey = apply_filters( 'wpc_report_search_shipper_name_metakey', 'wpcargo_shipper_name' );
		$wpc_get_fields = $wpdb->get_results("SELECT tbl2.meta_value AS meta_value FROM `$wpdb->posts` AS tbl1 INNER JOIN `$wpdb->postmeta` AS tbl2 ON tbl1.ID = tbl2.post_id WHERE tbl1.post_type LIKE 'wpcargo_shipment' AND tbl2.meta_key LIKE '".$shipper_name_metakey."' AND tbl2.meta_value LIKE '%".$term."%' GROup BY meta_value");
		if( !empty($wpc_get_fields) ){
			foreach( $wpc_get_fields as $shipper ){
				$suggestions[] = array(
					'label'	=> $shipper->meta_value,
				);
			}
		}
		$response = wp_send_json( $suggestions );
		echo $response;
		die();
	}
	function wpc_ie_header_tab(){
		$view = $_GET['page'];
		?>
		<div class="wpc-ie-tab">
			<h2 class="nav-tab-wrapper">
            <a href="<?php echo admin_url( 'edit.php?post_type=wpcargo_shipment&page=wpc-report-export' );?>" class="nav-tab<?php if($view == 'wpc-report-export') { ?> nav-tab-active<?php } ?>"><?php esc_html_e("Shipment Reports", 'wpcargo'); ?> </a>
			</h2>
		</div>
		<?php
		if( $view == 'wpc-report-export' ){
			$this->wpc_export_request( );
		}
	}
}
$wpc_export_admin = new WPC_Export_Admin();
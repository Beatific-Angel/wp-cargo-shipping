<?php
$wpcargo_tracking_number = ( isset( $_REQUEST['wpcargo_tracking_number'] ) ) ? $_REQUEST['wpcargo_tracking_number'] : '' ;
$result_page_id = $atts['id'];
if(!empty($result_page_id)){
	$get_action = 'action="'.get_page_link($result_page_id).'"';
}else{
	$get_action = 'action';
}
?>
<style type="text/css">
	@media
		only screen 
		and (max-width: 760px), (min-device-width: 768px) 
		and (max-device-width: 1024px)  {
			/* Force table to not be like tables anymore */
			table#wpcargo-track-table tr td input[type="text"], 
			table#wpcargo-track-table tr td input[type="submit"],
			table#wpcargo-track-table tr td select, 
			table#wpcargo-track-table tr td textarea,
			form table#wpcargo-track-table{
				width:100% !important;
				min-width: 100%;
			}
			table#wpcargo-track-table, 
			#wpcargo-track-table thead, 
			#wpcargo-track-table tbody, 
			#wpcargo-track-table th, 
			#wpcargo-track-table td,
			#wpcargo-track-table tr {
				display: block;
			}
			/* Hide table headers (but not display: none;, for accessibility) */
			#wpcargo-track-tablethead tr {
				position: absolute;
				top: -9999px;
				left: -9999px;
			}
			#wpcargo-track-table tr {
				margin: 0 0 1rem 0;
			}
			#wpcargo-track-table tr:nth-child(odd) {
				background: #ccc;
			}
			#wpcargo-track-table td {
				/* Behave  like a "row" */
				border: none;
				border-bottom: 1px solid #eee;
				position: relative;
				padding: 0;
			}
			#wpcargo-track-table td:before {
				position: absolute;
				top: 0;
				left: 6px;
				width: 45%;
				padding-right: 10px;
				white-space: nowrap;
			}
			#wpcargo-track-table .submit-track {
				padding:16px 0;
			}
	}
</style>
<div class="wpcargo-track wpcargo">
	<form method="post" name="wpcargo-track-form" <?php echo $get_action; ?>>
		<?php wp_nonce_field( 'wpcargo_track_shipment_action', 'track_shipment_nonce' ); ?>
		<table id="wpcargo-track-table" class="track_form_table">
			<tr class="track_form_tr">
				<th class="track_form_th" colspan="2"><h4><?php echo apply_filters('wpcargo_tn_form_title', esc_html__('Enter the Consignment No.', 'wpcargo') ); ?></h4></th>
			</tr>
			<tr class="track_form_tr">
				<?php do_action('wpcargo_add_form_fields'); ?>
				<td class="track_form_td"><input class="input_track_num" type="text" name="wpcargo_tracking_number" value="<?php echo $wpcargo_tracking_number; ?>" autocomplete="off" placeholder="<?php echo apply_filters('wpcargo_tn_placeholder', esc_html__('Enter Tracking Number', 'wpcargo' ) ); ?>" required></td>
				<td class="track_form_td submit-track"><input id="submit_wpcargo" class="wpcargo-btn wpcargo-btn-primary" name="wpcargo-submit" type="submit" value="<?php echo apply_filters('wpcargo_tn_submit_val', esc_html__( 'TRACK RESULT', 'wpcargo' ) ); ?>"></td>
			</tr>
			<?php echo apply_filters('wpcargo_example_text', ' <tr class="track_form_tr"><td class="track_form_td" colspan="2"><h4>'.esc_html__('Ex: 12345', 'wpcargo').'</h4></td></tr>'); ?>
		</table>
	</form>
</div>
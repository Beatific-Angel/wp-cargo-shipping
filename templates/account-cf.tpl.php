<?php
if (!defined('ABSPATH')){
    exit; // Exit if accessed directly
}
global $wpdb;
$cf_fields = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix."wpcargo_custom_fields WHERE display_flags LIKE '%account_page%' ORDER BY ABS(weight)");
?>
<style type="text/css">
	@media only screen and (max-width:767px) {
		#list-container .wpc-ca-list-table,  
		#list-container .wpc-ca-list-thead,  
		#list-container .wpc-ca-list-body,  
		#list-container .wpc-ca-list-th,  
		#list-container .wpc-ca-list-td,  
		#list-container .wpc-ca-list-tr {	display: block;}
		#list-container .wpc-ca-list-thead .wpc-ca-list-tr {	position: absolute;	top: -9999px;	left: -9999px;}
		#list-container .wpc-ca-list-td {	border: none;	border: 1px solid #ddd;	position: relative;	padding-left: 50% !important;	min-height: 30px;}
		#list-container .wpc-ca-list-td:before {	position: absolute;	top: 6px;	left: 6px;	width: 45%;	padding-right: 10px;	white-space: nowrap;}
		.wpc-ca-list-td:nth-of-type(1):before {	content: "Tracking #";}
		<?php
			if( !empty($cf_fields) ){
				$counter_thead = 2;
				foreach($cf_fields as $result){
					?>.wpc-ca-list-td:nth-of-type(<?php echo $counter_thead; ?>):before {	content: "<?php echo $result->label; ?>";}<?php
					$counter_thead++;
				}
			}
		?>
		.wpc-ca-list-td:nth-of-type(5):before {	content: "<?php echo esc_html__('View More', 'wpcargo'); ?>"}
	}
</style>
<h3><?php echo esc_html__('Welcome', 'wpcargo' ).' '.$user_full_name; ?></h3>
<div id="wpcargo-account">
	<h4><?php esc_html_e('Shipment List', 'wpcargo' ); ?></h4>
    <div id="shipment-list">
    	<table class="table wpcargo-table-responsive-md wpcargo-table">
            <thead>
                <tr>
                    <th><?php esc_html_e('Tracking #', 'wpcargo'); ?></th>
					<?php
						if(!empty($cf_fields)){
							foreach($cf_fields as $result){
								echo '<th>'.$result->label.'</th>';
							}
						}
					?>
				    <th><?php esc_html_e('View More', 'wpcargo'); ?></th>
				</tr>
			</thead>
			<tbody>
				<?php
					if ( $shipment_query->have_posts() ) :
						while ( $shipment_query->have_posts() ) : $shipment_query->the_post();
						?>
						 <tr>
						 	<td ><?php echo get_the_title(); ?></td>
								<?php	
								if( !empty( $cf_fields ) ){						
									foreach( $cf_fields as $field ) {
										$value = wpcargo_get_postmeta( get_the_ID(), $field->field_key, $field->field_type );
										?>
											<td ><?php echo $value; ?></td>		
										<?php
									}
								}							
								?>							
							<td><a class="view-shipment" href="#" data-id="<?php echo get_the_ID(); ?>"><?php esc_html_e('View Details', 'wpcargo'); ?></a></td>	
						 </tr>
						<?php
						endwhile;
					else:
						?><tr><td colspan="<?php echo count( $cf_fields ) + 2; ?>"><?php esc_html_e('No Shipment found!', 'wpcargo'); ?></td></tr><?php
					endif;				
				?>
			</tbody>		
		</table>
		<?php echo wpcargo_pagination( array( 'custom_query' => $shipment_query ) ); ?>	
	</div>	
</div>		
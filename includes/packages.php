<?php
if (!defined('ABSPATH')){
	exit; // Exit if accessed directly
}
define( 'WPCARGO_PACKAGE_POSTMETA', apply_filters( 'wpcargo_package_postmeta', 'wpc-multiple-package' ) );
add_action('wpcargo_after_package_details', 'wpcargo_multiple_package_after_track_details', 5, 1 );
function wpcargo_multiple_package_after_track_details( $shipment ){
	if( multiple_package_status() ) {
		wpcargo_include_template( 'package.tpl', $shipment );
	}
}
add_action('wpcargo_after_package_totals', 'wpcargo_after_package_details_callback', 10, 1 );
function wpcargo_after_package_details_callback( $shipment ){
    $class = is_admin() ? 'one-third' : 'wpcargo-col-md-4' ;
    $style = is_admin() ? 'style="display:block;overflow:hidden;margin-bottom:36px"' : '' ;
	$shipment_id = (!empty ( $shipment ) ) ? $shipment->ID : '';
	$package_volumetric = (!empty ( $shipment ) ) ? wpcargo_package_volumetric( $shipment->ID ) : '0.00';
	$package_actual_weight = (!empty ( $shipment ) ) ? wpcargo_package_actual_weight( $shipment->ID ) : '0.00';
	?>
	<div id="package-weight-info" class="wpcargo-container" <?php echo $style; ?>>
		<div class="wpcargo-row">
			<section class="<?php echo $class; ?> first" style="text-align: center; font-weight: bold;">
				<?php echo apply_filters( 'wpcargo_package_volumetric_label', esc_html__('Total Volume Weight :', 'wpcargo') ); ?> <span id="package_volumetric"><?php echo $package_volumetric.'</span>'.wpcargo_package_settings()->weight_unit; ?>.
			</section>
			<section class="<?php echo $class; ?>" style="text-align: center; font-weight: bold;">
				<?php echo apply_filters( 'wpcargo_package_actual_weight_label', esc_html__('Total Actual Weight :', 'wpcargo') ); ?> <span id="package_actual_weight"><?php echo $package_actual_weight.'</span>'.wpcargo_package_settings()->weight_unit; ?>.
			</section>
			<?php do_action('wpcargo_after_package_totals_section', $shipment_id); ?>
		</div>
	</div>
	<?php
	do_action('wpcargo_after_package_details_script', $shipment);
}
add_action('wpcargo_after_package_details_script', 'wpcargo_after_package_details_script_callback', 10, 1 );
function wpcargo_after_package_details_script_callback( $shipment ){
	$dim_meta   = wpcargo_package_dim_meta();
	$qty_meta   = wpcargo_package_qty_meta();
	$weight_meta = wpcargo_package_weight_meta();
	$divisor    = wpcargo_package_settings()->divisor ? wpcargo_package_settings()->divisor : 1;
	$dim_meta   = json_encode( $dim_meta );
	?>
	<script>
		var mainContainer   = 'table tbody[data-repeater-list="<?php echo WPCARGO_PACKAGE_POSTMETA; ?>"]';
		var divisor         = <?php echo $divisor ?>;
		var dimMeta         = <?php echo $dim_meta; ?>;
		var qtyMeta         = "<?php echo $qty_meta; ?>";
		var weightMeta      = "<?php echo $weight_meta; ?>";    
		jQuery(document).ready(function($){
			if( mainContainer.length > 0 ){
				$( mainContainer ).on( 'change keyup', 'input', function(){
					var totalQTY        = 0;
					var totalWeight     = 0;
					var totalVolumetric = 0;
					var totalVolume		= 0;
				 
					$( mainContainer + ' tr' ).each(function(){
						var currentVolumetric = 1; 
						var currentQTY        = 0;
						var packageWeight     = 0;
						$(this).find('input').each(function(){
							var currentField    = $(this);
							var className       = $( currentField ).attr('name');
							// Exclude in the loop field without name attribute
							if ( typeof className === "undefined" ){
									return;
							}
							// Get the QTY
							if ( className.indexOf(qtyMeta) > -1 ){
								var pQty = $( currentField ).val() == '' ? 0 : $( currentField ).val() ;
								totalQTY += parseFloat( pQty );
								currentQTY = parseFloat( pQty );
							}
							// Get the weight
							if ( className.indexOf(weightMeta) > -1 ){
								var pWeight = $( currentField ).val() == '' ? 0 : $( currentField ).val() ;
								packageWeight += parseFloat( pWeight );
							}
							
							// Calculate the volumetric                       
							$.each( dimMeta, function( index, value ){   
												  
								if ( className.indexOf(value) == -1 ){
									return;
								}
								currentVolumetric *= $( currentField ).val();
							} );
						});
						totalVolumetric += currentQTY * ( currentVolumetric / divisor );
						totalWeight     += currentQTY * packageWeight;
						totalVolume		+= currentQTY * currentVolumetric;
					});
					$('#package-weight-info #total_volume_metric_output').text( totalVolume.toFixed(2) );
					$('#package-weight-info #package_volumetric').text( totalVolumetric.toFixed(2) );
					$('#package-weight-info #package_actual_weight').text( totalWeight.toFixed(2) );
				});
			}
		});
	</script>
    <?php
}
function wpcargo_package_settings(){
    $options                        = get_option( 'wpc_mp_settings' );
    $wpc_mp_dimension_unit          = !empty($options) && array_key_exists( 'wpc_mp_dimension_unit', $options ) ? $options['wpc_mp_dimension_unit'] : 'cm';
    $wpc_mp_peice_type              = !empty($options) && array_key_exists( 'wpc_mp_piece_type', $options ) ? array_filter( array_map('trim', explode(",", $options['wpc_mp_piece_type']) ) ) : array();
    $wpc_mp_weight_unit             = !empty($options) && array_key_exists( 'wpc_mp_weight_unit', $options ) ? $options['wpc_mp_weight_unit'] : 'lbs';
    $wpc_mp_enable_dimension_unit   = !empty($options) && array_key_exists( 'wpc_mp_enable_dimension_unit', $options ) ? $options['wpc_mp_enable_dimension_unit'] : false;
    $wpc_mp_enable_admin  			= !empty($options) && array_key_exists( 'wpc_mp_enable_admin', $options ) ? $options['wpc_mp_enable_admin'] : false;
    $wpc_mp_enable_frontend  		= !empty($options) && array_key_exists( 'wpc_mp_enable_frontend', $options ) ? $options['wpc_mp_enable_frontend'] : false;
    $package_settings                    = new stdClass();
    $package_settings->dim_unit          = $wpc_mp_dimension_unit;
    $package_settings->peice_types       = $wpc_mp_peice_type;
    $package_settings->weight_unit       = $wpc_mp_weight_unit;
    $package_settings->dim_unit_enable   = $wpc_mp_enable_dimension_unit;
    $package_settings->admin_enable   	 = apply_filters( 'wpcargo_package_admin_enable', $wpc_mp_enable_admin );
    $package_settings->frontend_enable   = apply_filters( 'wpcargo_package_frontend_enable', $wpc_mp_enable_frontend );
    $package_settings->divisor           = $wpc_mp_dimension_unit == 'cm' ? apply_filters( 'wpcargo_package_divisor_cm', 5000 ) : apply_filters( 'wpcargo_package_divisor_inc', 138.4 );
    $package_settings->volume_unit       = $wpc_mp_dimension_unit == 'cm' ? apply_filters( 'wpcargo_package_cm_volume_unit', 'kg.' ) : apply_filters( 'wpcargo_package_inc_volume_unit', 'lbs.' );
    return $package_settings;
}
function wpcargo_package_dim_meta( ){
	$dim_meta = array( 'wpc-pm-length', 'wpc-pm-width', 'wpc-pm-height' );
	return apply_filters( 'wpcargo_package_dim_meta', $dim_meta );
}
function wpcargo_package_qty_meta( ){
	return apply_filters( 'wpcargo_package_qty_meta', 'wpc-pm-qty' );
}
function wpcargo_package_weight_meta( ){
	return apply_filters( 'wpcargo_package_weight_meta', 'wpc-pm-weight' );
}
function wpcargo_package_fields(){
    $package_fields = array(
        'wpc-pm-qty' => array(
            'label' => esc_html__('Qty.', 'wpcargo'),
            'field' => 'number',
            'required' => false,
            'options' => array()
        ),
        'wpc-pm-piece-type' => array(
            'label' => esc_html__('Piece Type', 'wpcargo'),
            'field' => 'select',
            'required' => false,
            'options' => wpcargo_package_settings()->peice_types
        ),
        'wpc-pm-description' => array(
            'label' => esc_html__('Description', 'wpcargo'),
            'field' => 'textarea',
            'required' => false,
            'options' => array()
        ),
        'wpc-pm-length' => array(
            'label' => esc_html__('Length', 'wpcargo').'('.wpcargo_package_settings()->dim_unit.')',
            'field' => 'number',
            'required' => false,
            'options' => array()
        ),
        'wpc-pm-width' => array(
            'label' => esc_html__('Width', 'wpcargo').'('.wpcargo_package_settings()->dim_unit.')',
            'field' => 'number',
            'required' => false,
            'options' => array()
        ),
        'wpc-pm-height' => array(
            'label' => esc_html__('Height', 'wpcargo').'('.wpcargo_package_settings()->dim_unit.')',
            'field' => 'number',
            'required' => false,
            'options' => array()
        ),
        'wpc-pm-weight' => array(
            'label' => esc_html__('Weight ', 'wpcargo').'('.wpcargo_package_settings()->weight_unit.')',
            'field' => 'number',
            'required' => false,
            'options' => array()
        ),
    );
    return apply_filters( 'wpcargo_package_fields', $package_fields );
}
function wpcargo_get_package_data( $shipment_id, $meta_key = WPCARGO_PACKAGE_POSTMETA  ){
    $packages = get_post_meta( (int)$shipment_id, $meta_key, true) ? maybe_unserialize( get_post_meta( (int)$shipment_id, $meta_key, true) ) : array();
    return apply_filters( 'wpcargo_get_package_data', $packages, $shipment_id, $meta_key );
}
function wpcargo_package_volumetric( $shipment_id ){
	$volumetric = 0;
	$divisor    = wpcargo_package_settings()->divisor;
	$unit    	= wpcargo_package_settings()->volume_unit;
	$packages 	= wpcargo_get_package_data( $shipment_id );
	
	if( !empty( $packages ) ){	
		foreach ($packages as $key => $value) {
			$multiplier = 1;
			$qty = array_key_exists( wpcargo_package_qty_meta(), $value ) ? $value[wpcargo_package_qty_meta()] : 0 ;
			foreach ( wpcargo_package_dim_meta() as $dim_meta ) {
				if( !array_key_exists( $dim_meta, $value ) ){
					continue;
				}
				$multiplier *=  floatval($value[$dim_meta]);
			}
			$volumetric += ( floatval($multiplier) / floatval($divisor) ) * floatval($qty);
		}		
	}
	return apply_filters( 'wpcargo_package_volumetric', number_format( $volumetric, 2, '.', ''), $shipment_id );
}
function wpcargo_package_actual_weight( $shipment_id ){
	$weight = 0;
	$packages = wpcargo_get_package_data( $shipment_id );
	if( !empty( $packages ) ){	
		foreach ($packages as $key => $value) {
			$qty 			= array_key_exists( wpcargo_package_qty_meta(), $value ) ? $value[wpcargo_package_qty_meta()] : 0 ;
			$weight_meta 	= array_key_exists( wpcargo_package_weight_meta(), $value ) ? $value[wpcargo_package_weight_meta()] : 0 ;
			$weight += floatval( $weight_meta ) * floatval( $qty );
		}		
	}
	return apply_filters( 'wpcargo_package_actual_weight', number_format( $weight, 2, '.', ''), $shipment_id );
}
function multiple_package_status(){
	$status = false;
	if( wpcargo_package_settings()->frontend_enable && !empty( wpcargo_package_fields() ) ) {
		$status = true;
	}
	return apply_filters( 'multiple_package_status', $status );
}

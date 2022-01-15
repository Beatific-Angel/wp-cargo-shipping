jQuery(document).ready(function ($) {
	var AJAXURL 				= wpcargoAJAXHandler.ajax_url;
	var vat_percentage 			= wpcargoAJAXHandler.vat_percentage;
	var deleteElementMessage 	= wpcargoAJAXHandler.deleteElementMessage;
	var autoFillPlaceholder 	= wpcargoAJAXHandler.autoFillPlaceholder;
	var wpcargoDateFormat 		= wpcargoAJAXHandler.date_format;
	var wpcargoTimeFormat 	 	= wpcargoAJAXHandler.time_format;
	var wpcargoDateTimeFormat 	= wpcargoAJAXHandler.datetime_format;
	
	$("#shipment-history .status_updated-name").attr('readonly', true);
	$(".wpcargo-datepicker, .wpcargo-timepicker, .wpcargo-datetimepicker").attr("autocomplete", "off");
	
	$(".wpcargo-datepicker").datetimepicker({
		timepicker:false,
		format:wpcargoDateFormat		
	});
	
	$(".wpcargo-timepicker").datetimepicker({
		datepicker:false,
		format:wpcargoTimeFormat
	});
	
	$(".wpcargo-datetimepicker").datetimepicker({
		format:wpcargoDateTimeFormat
	});
	$('.misc-pub-section.wpc-status-section, #shipment-bulk-update').on('change', 'select.wpcargo_status', function( e ){
		e.preventDefault();
		var status = $(this).val();
		if( status ){
			$('.wpc-status-section .date').prop('required',true);
			$('.wpc-status-section .time').prop('required',true);
			$('.wpc-status-section .status_location').prop('required',true);
			$('.wpc-status-section .remarks').prop('required',true);
		}else{
			$('.wpc-status-section .date').prop('required',false);
			$('.wpc-status-section .time').prop('required',false);
			$('.wpc-status-section .status_location').prop('required',false);
			$('.wpc-status-section .remarks').prop('required',false);
		}
	});
});
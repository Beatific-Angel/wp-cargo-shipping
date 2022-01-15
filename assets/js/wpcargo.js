jQuery(document).ready(function($){
	var AJAXURL = wpcargoAJAXHandler.ajax_url;
    var pageURL = wpcargoAJAXHandler.pageURL;
	var wpcargoDateTimeFormat 	= wpcargoAJAXHandler.datetime_format;
	
	$('#shipment-list').on('click','.view-shipment', function(e){
		e.preventDefault();
		var shipmentID = $(this).data('id');
		$.ajax({
            type:"POST",
            data:{
                action:'view_shipment_details',    
                shipmentID:shipmentID,
            },
            url : AJAXURL,
            beforeSend:function(){
                //** Proccessing
                $('body').append('<div class="wpcargo-loading">Loading...</div>');
            },
            success:function(data){
            	$('#view-shipment-modal .modal-body').html( data );
                $('body .wpcargo-loading').remove();                   
                $('#view-shipment-modal').addClass('wpcargo-show-modal');
            }
        });
	});
	
	$('#view-shipment-modal').on('click','.close', function(e){
		e.preventDefault();
		$('#view-shipment-modal').removeClass('wpcargo-show-modal');
	});
    $('#wpcargo-sort-shipment').on('change', '#sort', function( e ) {
        e.preventDefault();
        var sort = $(this).val();
        window.location = pageURL+ '?sort=' + sort;
    });
	
	/* TEMPORARY FOR FM AND CF */
	$(".wpccf-datetimepicker").datetimepicker({
		format:wpcargoDateTimeFormat
	});
});
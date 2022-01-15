jQuery(document).ready(function($) {
	//**
	$('#import-file').click( function(event ){
		event.preventDefault();
		var postValue = $(this).attr('data-value')
		//console.log( postValue );
		$.ajax({
			type:"POST",
			data:{
				action:'wpc_import_export_ajax_loader',	
				postValue:postValue,
			},
			url : wpc_ie_ajaxscripthandler.ajax_url,
			beforeSend:function(){
				$("#wpc-ie-loader").attr('class','loading');
			},
			success:function(data){
				$("#wpc-ie-loader").removeAttr('class','loading');
				$("#wpc-ie-loader").html( data );
				//console.log( data );
			}
		});
	});
	//** Shipment Title auto complete for the import
	$( "input#search-shipper" ).autocomplete({
		source: wpc_ie_ajaxscripthandler.ajax_url + "?action=search_shipper",
		autoFocus: true,
		dataType: 'json',
		delay: 100,
		minLength: 2,
		select: function( event, uidata ) {
		$(this).val( uidata.item.label );
			return false;
		},
		change: function (event, ui) {
			if (!ui.item) {
				$(this).val("");
			}
		}
	});
	$( "input#search-shipper" ).on('click', function(){
		$(this).val('');
	});
});
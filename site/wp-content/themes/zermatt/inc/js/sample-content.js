jQuery( document ).ready( function( $ ) {
	$( '.zermatt-sample-content-notice' ).on( 'click', '.notice-dismiss', function( e ) {
		$.ajax( {
			type: 'post',
			url: ajaxurl,
			data: {
				action: 'zermatt_dismiss_sample_content',
				nonce: zermatt_SampleContent.dismiss_nonce,
				dismissed: true
			},
			dataType: 'text',
			success: function( response ) {
				//console.log( response );
			}
		} );
	});
} );

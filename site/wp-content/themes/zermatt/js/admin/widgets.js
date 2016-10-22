jQuery( document ).ready( function( $ ) {
	"use strict";
	var $body = $( 'body' );

	//zermatt_repeating_sortable_init();

	// Widget Actions on Save
	$( document ).ajaxSuccess( function( e, xhr, options ) {
		if ( options.data.search( 'action=save-widget' ) != -1 ) {
			var widget_id;

			if ( ( widget_id = options.data.match( /widget-id=(ci-.*?-\d+)\b/ ) ) !== null ) {
				var widget = $( "input[name='widget-id'][value='" + widget_id[1] + "']" ).parent();
				//zermatt_repeating_sortable_init( widget );
				zermatt_collapsible_init( widget );
				zermatt_repeating_colorpicker_init();
			}

		}
	} );

/*
	// CI Items widget
	$body.on( 'change', '.ci-repeating-fields .posttype_dropdown', function() {

		var fieldset = $( this ).parent().parent();

		$.ajax({
			type: 'post',
			url: ThemeWidget.ajaxurl,
			data: {
				action: fieldset.data( 'ajaxaction' ),
				post_type_name: $( this ).val(),
				name_field: fieldset.find( '.posts_dropdown' ).attr( 'name' )
			},
			dataType: 'text',
			beforeSend: function() {
				fieldset.addClass( 'loading' );
				fieldset.find( '.posts_dropdown' ).prop( 'disabled', 'disabled' ).css( 'opacity', '0.5' );
			},
			success: function( response ) {
				if ( response != '' ) {
					fieldset.find( 'select.posts_dropdown' ).html( response ).children( 'option:eq(1)' ).prop( 'selected', 'selected' );
					fieldset.find( '.posts_dropdown' ).removeAttr( 'disabled' ).css( 'opacity', '1' );
				} else {
					fieldset.find( 'select.posts_dropdown' ).html( '' ).prop( 'disabled', 'disabled' ).css( 'opacity', '0.5' );
				}

				fieldset.removeClass( 'loading' );
			}
		});

	});
*/

	zermatt_collapsible_init();
	$( 'body' ).on( 'click', '.ci-collapsible legend', function() {
		var arrow = $( this ).find( 'i' );
		if ( arrow.hasClass( 'dashicons-arrow-down' ) ) {
			arrow.removeClass( 'dashicons-arrow-down' ).addClass( 'dashicons-arrow-right' );
			$( this ).siblings( '.elements' ).slideUp();
		} else {
			arrow.removeClass( 'dashicons-arrow-right' ).addClass( 'dashicons-arrow-down' );
			$( this ).siblings( '.elements' ).slideDown();
		}
	} );


	zermatt_repeating_colorpicker_init();
	$( document ).ajaxSuccess( function( e, xhr, settings ) {
		if ( settings.data.search( 'action=save-widget' ) != -1 ) {
			zermatt_repeating_colorpicker_init();
		}
	} );

});

zermatt_collapsible_init = function( selector ) {
	if ( selector === undefined ) {
		jQuery( '.ci-collapsible .elements' ).hide();
		jQuery( '.ci-collapsible legend i' ).removeClass( 'dashicons-arrow-down' ).addClass( 'dashicons-arrow-right' );
	} else {
		jQuery( '.ci-collapsible .elements', selector ).hide();
		jQuery( '.ci-collapsible legend i', selector ).removeClass( 'dashicons-arrow-down' ).addClass( 'dashicons-arrow-right' );
	}
}

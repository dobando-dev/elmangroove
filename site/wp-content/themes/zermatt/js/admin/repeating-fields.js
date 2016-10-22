var zermatt_repeating_sortable_init = function( selector ) {
	if ( typeof selector === 'undefined' ) {
		jQuery('.ci-repeating-fields .inner').sortable({ placeholder: 'ui-state-highlight' });
	} else {
		jQuery('.ci-repeating-fields .inner', selector).sortable({ placeholder: 'ui-state-highlight' });
	}
};

var zermatt_repeating_colorpicker_init = function( selector ) {
	if ( selector === undefined ) {
		var ciColorPicker = jQuery( '#widgets-right .colorpckr, #wp_inactive_widgets .colorpckr' ).filter( function() {
			return !jQuery( this ).parents( '.field-prototype' ).length;
		} );

		ciColorPicker.wpColorPicker();
	} else {
		jQuery( '.colorpckr', selector ).wpColorPicker();
	}
};

jQuery(document).ready(function($) {
	"use strict";
	var $body = $( 'body' );

	// Repeating fields
	zermatt_repeating_sortable_init();

	$body.on( 'click', '.ci-repeating-add-field', function( e ) {
		var repeatable_area = $( this ).siblings( '.inner' );
		var fields = repeatable_area.children( '.field-prototype' ).clone( true ).removeClass( 'field-prototype' ).removeAttr( 'style' ).appendTo( repeatable_area );
		zermatt_repeating_sortable_init();
		//zermatt_repeating_colorpicker_init();
		e.preventDefault();
	} );


	$body.on( 'click', '.ci-repeating-remove-field', function( e ) {
		var field = $(this).parents('.post-field');
		field.remove();
		e.preventDefault();
	});
});

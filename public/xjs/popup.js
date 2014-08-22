jQuery( document ).ready( function(){
	"use strict";

	jQuery( 'body' ).append( '<div id="yesno-popup" class="modal hide fade" tabindex="-1" role="dialog"><div class="modal-header"><button type="button" class="close" data-dismiss="modal">×</button><h3 id="modal-title">Loading...</h3></div><div class="modal-body"></div><div class="modal-footer"><a href="#" class="btn btn-primary modal-action">Ok</a><button class="btn" data-dismiss="modal">Cancel</button></div></div>' );

	// reset modal
	jQuery( '#yesno-popup' ).on( 'hide', function () {
		jQuery( '#yesno-popup #modal-title' ).html( 'Loading...' );
		jQuery( '#yesno-popup .modal-body' ).html( '');
		jQuery( '#yesno-popup a.modal-action' ).attr( 'href', '#' );
	})

	// update modal content
	jQuery( 'body' ).on( 'click', 'a[href="#yesno-popup"]', function(){
		jQuery( '#yesno-popup #modal-title' ).html( jQuery( this ).attr( 'data-title' ) );
		jQuery( '#yesno-popup .modal-body' ).html( jQuery( this ).attr( 'data-content' ) );
		jQuery( '#yesno-popup a.modal-action' ).attr( 'href', jQuery( this ).attr( 'data-action' ) );
	} );
	
} );

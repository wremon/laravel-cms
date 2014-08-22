jQuery( document ).ready( function(){
	"use strict";

	jQuery( 'body' ).on( 'click', 'form input[type="submit"]', function(){
		var return_value 	= true,
			form 			= jQuery( this ).parents( 'form' ).attr( 'id' );

		jQuery( form ).find( '.required' ).each( function(){
			if ( check_value( jQuery( this ).attr( 'id' ) ) === false ){
				jQuery( this ).addClass( 'error-field' );
				return_value = false;
			}
		} );

		return return_value;
	} );

} );



function check_value( element ){
	"use strict";
	
	var value 	= jQuery( '#' + element ).val();
	jQuery( '#' + element ).removeClass( 'error-field' );

	switch( jQuery( '#' + element ).attr( 'type' ) ){
		case 'text':
		case 'password':
			if ( value === '' ){
				return false;
			}
		break;

		case 'email':
			if ( value === '' ){
				return false;
			}else{
				var pattern = new RegExp(/^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?$/i);
				return pattern.test( value );
			}
		break;

		case 'number':
			if ( value === '' ){
				return false;
			}else{
				return value.isNumeric;
			}
		break;

		default:
			if ( jQuery( '#' + element ).is( 'textarea' ) ){
				if ( value === '' ){
					return false;
				}
			}

			if ( jQuery( '#' + element ).is( 'select' ) ){
				console.log( jQuery( '#' + element ).find( ':selected' ).val() );
				if ( jQuery( '#' + element + ' option:selected' ).val() === '' ){
					return false;
				}
			}
		break;
	}

	return true;
}
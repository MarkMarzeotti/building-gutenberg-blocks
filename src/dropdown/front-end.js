jQuery( document ).ready( function( $ ) {
	$( '.wp-block-cgb-dropdown' ).click( function() {
		$( this ).find( '.dropdown-content' ).slideToggle();
	} );
} );

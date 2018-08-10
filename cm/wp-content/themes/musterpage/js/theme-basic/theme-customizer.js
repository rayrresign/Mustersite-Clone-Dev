

/* Title Custom by RESIGN */ 
(function( $ ) {

	wp.customize( 'blogname', function( value ) {
		value.bind( function( to ) {
			$( '.site-title a' ).text( to );
		} );
	} );

	wp.customize( 'blogdescription', function( value ) {
		value.bind( function( to ) {
			$( '.site-description' ).text( to );
		} );
	} );
	
	 wp.customize( 'header_textcolor', function( value ) {
        value.bind( function( to ) {
            if ( 'blank' === to ) {
                $( '.site-title' ).css( {
                    'clip': 'rect(1px, 1px, 1px, 1px)',
                    'position': 'absolute'
                } );
            } else {
                $( '.site-title' ).css( {
                    'clip': 'auto',
                    'position': 'static'
                } );

                $( '.site-title a' ).css( {
                    'color': to
                } );
            }
        } );
    });

})( jQuery );
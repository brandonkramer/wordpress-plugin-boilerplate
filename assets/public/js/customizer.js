/**
 * File customizer.js.
 *
 * Plugin Customizer enhancements for a better user experience.
 */

( function( $ ) {

    // Site title and description.
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

    // Update footer address live
    wp.customize( 'footer_address', function( value ) {
        value.bind( function( to )  {
            $( '#js-footer-address' ).text( to );
        })
    } );

    // Update header colour live
    // Adjust the selector and styles according to your theme markup.
    wp.customize( 'header_color', function( value ) {
        value.bind( function( to )  {
            $( '.site-header' ).css( 'background', to );
        });
    } );

} )( jQuery );
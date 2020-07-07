$( window ).on( 'load', function() {
    $( '.dodajPjesmu').on( 'click', dodaj ); //link
} );

function dodaj() {
    var pjesma = $( this ).attr( 'value' );
    console.log( $( this ).attr( 'value' ) );

    $.ajax( {
        type: 'GET',
        url: 'music.php?rt=songs/add',
        data: {
            id: pjesma
        },
        success: function( data ) {
            console.log( data );
            if( data === 'dodano' ) {
                alert( 'Dodano u popis za reprodukciju!' );
            } else {
                alert( 'Već postoji u popisu za reprodukciju!')
            }
        },
        error: function( xhr, status ) {
            console.log( status );
        }
    } );

}
$( window ).on( 'load', function() {
    $( '.dodajPjesmu').on( 'click', dodaj ); //link
} );

function dodaj() {
    var pjesma = $( this ).parent().parent().parent().find('td').eq(1).text();
    var izvodjac = $( this ).parent().parent().parent().find('td').eq(2).text();
    var user = $( 'div.align-middle').eq(0).attr('id');
    //console.log( user );

    $.ajax( {
        type: 'GET',
        url: 'music.php?rt=songs/add',
        data: {
            naziv: pjesma,
            artist: izvodjac,
            korisnik: user
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
/*
Klikom na ikonu predstavljenu sa plusom (plavim ili zelenim), dodaje se određena pjesma u playlistu.
*/
$( window ).on( 'load', function() {
    $( '.dodajPjesmu').on( 'click', dodaj ); //link
} );

/*
@pjesma : id pjesme koja se želi dodati u popis za repordukciju

Funkcija šalje id pjesme koju korisnik želi dodati u svoju playlistu funkciji add u songsController-u.
Ukoliko funkcija add uistinu doda pjesmu u playlistu, tj. pjesma nije postojala u playlisti,
    korisnik se obavještava o unosu putem alerta.
Ukoliko pjesma već postoji u playlisti, ne dodajemo ju ponovo te obavještavamo korisnika da
    odabrana pjesma već postoji u njegovoj playlisti.
*/
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
/*
Ovdje rješavamo korisnikove unose u searcBar.
Ukoliko korisnik nesto unosi u polje za pretragu pjesmi, dobiva listu od maksimalno 10 pjesmi
    koje kao podstring sadrže korisnikov unos.
Klikom na gumb kraj pretrage se prikazuje unešena pjesma (ukoliko ona postoji u bazi).
*/
$( window ).on( 'load', function() {
    $( '#searchBar').on( 'input', trazi ); // označava input za searchBar

    $( '#gumbPretraga').on( 'click', prikaziPjesmu ); // gumb za pretragu pjesme u searchBar-u.
} );

/*
Funkciji prikazPjesme u songController-u šaljemo korisnikov input.
Ukoliko pjesma postoji u bazi, korisnik se preusmjerava na view za prikaz pjesme.
Ukoliko korisnik unese pjesmu koja se ne nalazi u bazi, ništa se ne događa.
*/
function prikaziPjesmu() {
    var unos = $( '#searchBar' ).val();
    if( unos !== '' ) {
        $.ajax( {
            type: 'GET',
            url: 'music.php?rt=songs/prikazPjesme',
            data: {
                unos: unos
            },
            success: function( data ) {
                console.log( data );
                if( typeof data.error === 'undefined' ) {
                    window.location.replace(window.location.origin + window.location.pathname + '?rt=songs/showSong&id=' + data);
                }
            },
            error: function( xhr, status ) {
                console.log( status );
            }
        } );
    }
}

/*
Svaka promjena u searcBar-u se evidentira.
Unos iz searcBar-a šalje se funkciji trazi u songController-u.
Ukoliko je taj unos podstring nekih naslova pjesama, ispisuje se maksimalno 10 naslova pjesmi
    u listu ispod input-a u searcBar-u, inače ta lista ostaje prazna i ne prikazuje se.
*/
function trazi() {
    var unos = $( this ).val();
    //console.log(unos);

    $.ajax( {
        type: 'GET',
        url: 'music.php?rt=songs/trazi',
        data: {
            unos: unos
        },
        success: function( data ) {
            //console.log( data );
            var lista = [];
            for( var i = 0; i < data.length; ++i ) {
                var temp = "<option value='" + data[i] + "' />\n";
                if( lista.length <= 10 ) {
                    lista.push( temp );
                } else {
                    break;
                } 
            }
            $('#datalist_pjesme').html( lista );
        },
        error: function( xhr, status ) {
            console.log( status );
        }

    } );
}
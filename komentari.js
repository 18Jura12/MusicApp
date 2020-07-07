/*
Datoteka za obradu lajkova komentara i dodavanje komentara.
Komentari se prikazuju na stranici pojedine pjesme.
*/
$( window ).on( 'load', function() {
    $( 'body').on( 'click', 'button.lajkovi', obradiLajk ); // ažurira se stanje lajkova/dislajkova ukoliko korisnik klikne na lajk/dislajk

    $( '#gumbKomentar' ).on( 'click', dodajKomentar ); // dodaje se komentar u bazu i prikazuje odmah na stranici
} );

/*
@unos : komentar kojeg je korisnik upisao u polje za dodavanje komentara
@idPjesme : id pjesme koju korisnik trenutno komentira

Funkcija  dodajKomentar šalje @unos i @idPjesme funkciji unosKomentara u messageController-u
    koja dodaje komentar u bazu. Ukoliko je ubacivanje u bazu uspješno, natrag se šalju sve informacije o komentaru.
success funkcija stvara novi div koji sadrži komentar, ime osobe koja je kreirala komentar, vrijeme nastanka komentara
    i lajkove/dislajkove (oboje nula jer je komentar tek kreiran).
*/
function dodajKomentar() {
    var unos = $( '#Komentiraj' ).val();
    var idPjesme = $( this ).val();
    //console.log( unos );
    //console.log( idPjesme );

    if( !unos.match( /^[\t\s]*$/ ) && !unos.match( /;/ ) ) { //nema naredbe i prazne poruke
        //console.log( 'uslo' );
        $.ajax( {
            type: 'GET',
            url: 'music.php?rt=messages/unosKomentara',
            data: {
                unos: unos,
                id: idPjesme
            },
            success: function( data ) {
                //console.log( data );

                var div = $( '<div>' );
                var pre1 = $( '<pre style="background-color: rgb(255, 235, 204);">');
                pre1.html( '<b><i>' + data.username + '</i></b> (' + data.date + '):<br>');
                var pre2 = $( '<pre style="display: inline-block; background-color: rgb(255, 204, 128); width: 90%;">' );
                pre2.text( unos );
                //console.log( pre2 );
                pre1.append( pre2 );
                var span = $( '<span style="position: absolute; text-align: right; padding-right: 1%; padding-bottom: 1%; width: 10%;">' );
                var button1 = $( '<button class="lajkovi "title="thumbs_up" value=' + data.id + '>');
                button1.html( '&#128077; 0');
                span.append( button1 ).append( '<br>' );
                var button2 = $( '<button class="lajkovi "title="thumbs_down" value=' + data.id + '>');
                button2.html( '&#128078; 0');
                span.append( button2 );
                pre1.append( span );
                div.append( pre1 );

                //console.log(div);

                $( '#divKomentari' ).prepend(div);

                $( '#Komentiraj').val('');
            },
            error: function( xhr, status ) {
                console.log( status );
            }
        } );

    }
}

/*
@akcija : thums_up ili thumbs_down (ovisno na što je korisnik kliknuo)
@gumb : kliknuti gumb
@idKomentara : id komentara kojeg lajkamo/dislajkamo

Funkcija šalje upravo napisane argumente funkciji 'lajkovi' u messagesController-u koja 
    ažurira stanje lajkova/dislajkova određenog komentara u bazi.
Ukoliko je sve uspješno provedeno, funkcija success povećava broj lajkova/dislajkova kliknutog komentara.
*/
function obradiLajk() {
    var akcija = $( this ).attr( 'title' );
    var gumb = $( this );
    var idKomentara = $( this ).val();

    $.ajax( {
        type: 'GET',
        url: 'music.php?rt=messages/lajkovi',
        data: {
            id: idKomentara,
            action: akcija
        },
        success: function( data ) {
            gumb.html( '&#128077; ' + data );
        },
        error: function( xhr, status ) {
            console.log( status );
        }
    } );
}
$( window ).on( 'load', function() {
    $( 'body').on( 'click', 'button.lajkovi', obradiLajk );

    $( '#gumbKomentar' ).on( 'click', dodajKomentar );
} );

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
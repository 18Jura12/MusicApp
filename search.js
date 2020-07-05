$( window ).on( 'load', function() {
    $( '#searchBar').on( 'input', trazi );

    $( '#gumbPretraga').on( 'click', prikaziPjesmu );
} );

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
                lista.push( temp );
                
            }
            $('#datalist_pjesme').html( lista );
        },
        error: function( xhr, status ) {
            console.log( status );
        }

    } );
}
$( window ).on( 'load', function() {
    $( 'input').on( 'click', forma );

} );

function forma() {

    godina = $(this).attr('id');
    console.log(godina);

    $.ajax({

        type: 'GET',
        url: 'music.php?rt=songs/year',
        data: {
            godina: godina,
        },
        success: function( data ) {
            
            //console.log(data);
            $('body').append($('<hr>'))
                     .append($('<div class="row" id="forma">').append($('<div class="col-md-1">')).append($('<div class="col-md-5" id="odabir">')));
            for(var i=1; i <= 10; i++) {

                var j = i;
                if(i == 9) j=10;
                if(i == 10) j=12;
                $('#odabir').append($('<div class="row-md-1 custom-control custom-radio">').append($('<input type="radio" class="bod" id="'+j+'" name="inlineDefaultRadiosExample"><label class="custom-control-label" for="'+j+'" style=" display: inline; vertical-align: center;">'+j+'</label>')))

            }
            $('#forma').append($('<div class="col-md-2" id="gumbi">'));
            for(var i=0; i < data.length; i++) {

                console.log(data[i]);
                 $('#gumbi').append($('<button style="width=25%; height=10%;"><div>'+data[i][0]+'</div><div>'+data[i][1]+'<br><div style="font-size:10px; color:gray;">'+data[i][2]+'</div></div>'));

             }

        },
        error: function( xhr, status ) {
            console.log( status );
        }

    });

}
$( window ).on( 'load', function() {
    let odabir = Array(0,0,0,0,0,0,0,0,0,0);
    $( 'button').on( 'click', function() {

        if($(this).attr('id') == 'submit') {

            godina = $(this).attr('label');
            username = $(this).attr('value');

            $.ajax({

                url: 'music.php?rt=points/save',
                data: {

                    data: odabir,
                    year: godina,
                    username: username

                },
                success: function() {

                    alert('Bodovi uspješno pohranjeni!');

                },
                error: function( xhr, status ) {
                    console.log( status );
                }

            });

        } else if ($('input[type="radio"]:checked').attr('class') !== undefined) {

            var points = $('input[type="radio"]:checked').attr('class');
            var song = $(this).attr('id');
    
            if(odabir[points] != 0) {

                $('#'+odabir[points].toString()).attr('disabled', false);

            }
            odabir[points] = song;
            $('#'+song.toString()).attr('disabled', true);
            var html = $('input.'+points.toString()).parent().html()
            html = html.substring(0,html.indexOf(">")+1);
            //console.log(html);
            $('input.'+points.toString()).parent().html(html+' '+$('#'+song.toString()).children(0).html());
    
        }
        if(odabir.indexOf(0) == -1) {

            $('#submit').attr('disabled', false);

        }

    });

} );
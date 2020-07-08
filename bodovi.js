
//Ovaj Javascript dokument čini prikaz forme za korisnikovo bodovanje pjesama određene godine (bodovi.php) interaktivnom.
//Konkretno služi za izradu stringa koji predstavlja dodijeljene bodove, koji se sprema u tablicu musicPoints.
$( window ).on( 'load', function() {

    //Naše novo bodovanje koje se inicijalizira na nepopunjene vrijednosti (jer ne postoji id 0 za pjesmu).
    let odabir = Array(0,0,0,0,0,0,0,0,0,0);

    //na pritisak nekog od gumba unutar kojeg je opisana pjesma, dodijeli mu bod koji je označen sa radio-gumbom
    $( 'button').on( 'click', function() {

        //pohrana bodovanja u bazu preko ajax upita na controller za tablicu musicPoints.
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

        //ako je neki radio button označen, napravi prethodno opisanu akciju 
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
            broj = parseInt(points) + 1;
            if(broj > 8) broj++;
            if(broj > 10) broj++;
            $('input.'+points.toString()).parent().html(html+' '+broj+' '+$('#'+song.toString()).children(0).html());
    
        }
        //ukoliko je odabrana pjesma za svaki broj bodova, omogući pritisak na gumb za pohranu bodova.
        if(odabir.indexOf(0) == -1) {

            $('#submit').attr('disabled', false);

        }

    });

} );
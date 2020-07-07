<?php

require_once __DIR__ . '/../model/user.class.php';
require_once __DIR__ . '/../model/message.class.php';
require_once __DIR__ . '/../model/song.class.php';

class messagesController {
    
    /*
    Funkcija koja za dani id pjesme i danu akciju (lajk/dislajk) ažurira brojevno stanje
        lajkova/dislajkova u bazi.
    Vraća novi broj lajkova/dislajkova (povećan za 1).
    */
    public function lajkovi() {

        if( !isset( $_GET[ 'id' ] ) ) {
            sendJSONandExit( ['error' => 'Ne postoji $_GET[\'id\']!' ] );
        }
        $idKomentara = $_GET['id'];

        if( !isset( $_GET[ 'action' ] ) ) {
            sendJSONandExit( ['error' => 'Ne postoji $_GET[\'action\']!' ] );
        }
        $akcija = $_GET['action'];

        $komentar = Message::find( 'id', $idKomentara );
        $komentar->$akcija +=1;
        $komentar->save();
        sendJSONandExit( $komentar->$akcija );
    }

    /*
    Funkcija koja za dani id pjesme i novoupisani komentar kreira novi komentar u bazi te
        šalje natrag podatke potrebne za prikaz upravo napravljenog komentara na trenutnoj stranici.
    */
    public function unosKomentara() {

        if( !isset( $_GET[ 'id' ] ) ) {
            sendJSONandExit( ['error' => 'Ne postoji $_GET[\'id\']!' ] );
        }
        $idPjesme = $_GET['id'];

        if( !isset( $_GET[ 'unos' ] ) ) {
            sendJSONandExit( ['error' => 'Ne postoji $_GET[\'unos\']!' ] );
        }
        $komentar = $_GET['unos'];
        $datum = date("Y-m-d h:i:s");

        $message = [];

        $novo = Message::new( array( 0, $_SESSION['korisnik'], $idPjesme, $komentar, 0, 0, $datum ) );
        

        $message['id'] = $novo->save();
        $message['username'] = $_SESSION['korisnik'];
        $message['date'] = $datum;

        sendJSONandExit( $message );
    }
}

function sendJSONandExit( $message ) {
    // Kao izlaz skripte pošalji $message u JSON formatu i
    // prekini izvođenje.
    header( 'Content-type:application/json;charset=utf-8' );
    echo json_encode( $message );
    flush();
    exit( 0 );

}

?>
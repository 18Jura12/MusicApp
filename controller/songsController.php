<?php

require_once __DIR__ . '/../model/user.class.php';
require_once __DIR__ . '/../model/song.class.php';
require_once __DIR__ . '/../model/message.class.php';

class songsController {

    public function playlist() {

        $user = User::find( 'username', $_SESSION['korisnik'] );
        $popis = User::predlozeno();

        if( !preg_match('/^[\t\s]*$/', $user->songs ) ) {
            $pjesme = explode(" ", $user->songs);
            $songs = [];
            $novo = [];

            foreach( $pjesme as $pjesma ) {
                if( !preg_match( '/^[0-9]+$/', $pjesma ) ) {
                    continue;
                }
                $song =  Song::find( 'id_song', $pjesma );
                if( isset( $_POST['ukloni'] ) && $_POST['ukloni'] === $song->id_song ) {
                    continue;
                }
                $songs[] = $song;
                $novo[] = $song->id_song;
            }

            $user->songs = implode(" ", $novo );
            $user->save();

        } else {
            $songs = [];
        }       

        require_once __DIR__ . '/../view/songList.php';
    }

    public function add() {

        $message = 'nije dodano';

        if( !isset( $_GET[ 'naziv' ] ) ) {
            sendJSONandExit( ['error' => 'Ne postoji $_GET[\'naziv\']!' ] );
        }
        $naziv = $_GET['naziv'];

        if( !isset( $_GET[ 'artist' ] ) ) {
            sendJSONandExit( ['error' => 'Ne postoji $_GET[\'artist\']!' ] );
        }
        $izvodjac = $_GET['artist'];

        $songs = Song::where( 'name', $naziv );
        $song = NULL;
        foreach( $songs as $value ) { 
            if( $value->artist === $izvodjac ) { // jedinstveno ime pjesme i izvođača, skupa
                $song = $value;
            }
        }
        if( $song == NULL ) {
            sendJSONandExit( ['error' => 'Ne postoji pjesma!' ] );
        }
        
        $id = $song->id_song;
        $user = User::find( 'username', $_SESSION['korisnik'] );
        if( preg_match('/^[\t\s]*$/', $user->songs ) ) {
            $pjesme = [];
        } else {
            $pjesme = explode(" ", $user->songs);
            
        }
        $sadrzano = false;

        foreach( $pjesme as $pjesma ) {
            if( $pjesma == $id ) {
                $sadrzano = true;
                break;
            }
        }

        if( $sadrzano == false ) {
            $pjesme[] = $id;
            $user->songs = implode(" ", $pjesme );
            $user->save();
            $message = 'dodano';
        }

        sendJSONandExit( $message );
    }

    public function trazi() {

        if( !isset( $_GET[ 'unos' ] ) ) {
            sendJSONandExit( ['error' => 'Ne postoji $_GET[\'unos\']!' ] );
        }
        $unos = $_GET['unos'];
        $message = [];

        $pjesme = Song::all();
        foreach( $pjesme as $pjesma ) {
            if( stripos( $pjesma->name, $unos ) !== false ) {
                $message[] = $pjesma->name;
            }
        }

        sendJSONandExit($message);
    }

    function prikazPjesme() {
        if( !isset( $_GET[ 'unos' ] ) ) {
            sendJSONandExit( ['error' => 'Ne postoji $_GET[\'unos\']!' ] );
        }
        $unos = $_GET['unos'];

        $song = Song::find( 'name', $unos );
        if( $song == NULL ) {
            sendJSONandExit( ['error' => 'Ne postoji pjesma!' ] );
        } else {
            $message = $song->id_song;
            sendJSONandExit( $message );
        }
    }

    function showSong() {

        $song = Song::find( 'id_song', $_GET['id'] );
        $komentari = Message::where( 'id_song', $_GET['id'] );
        $popis = User::predlozeno();
        usort($komentari, "date_sort");
        $korisnik = $_SESSION['korisnik'];

        require_once __DIR__ . '/../view/songView.php';

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

function date_sort($a, $b) {
    return (-1) *( strtotime($a->date) - strtotime($b->date));
}

?>
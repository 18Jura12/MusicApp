<?php

require_once __DIR__ . '/../model/user.class.php';
require_once __DIR__ . '/../model/song.class.php';
require_once __DIR__ . '/../model/playlist.class.php';
require_once __DIR__ . '/../model/message.class.php';

class songsController {

    public function playlist() {

        $user = User::find( 'username', $_SESSION['korisnik'] );
        $playlista = Playlist::find( 'username', $user->username );

        if( $playlista !== NULL ) {
            $pjesme = explode(" ", $playlista->songs);
            $songs = [];
            $novo = [];

            foreach( $pjesme as $pjesma ) {
                $song =  Song::find( 'id_song', $pjesma );
                if( isset( $_POST['ukloni'] ) && $_POST['ukloni'] === $song->id_song ) {
                    continue;
                }
                $songs[] = $song;
                $novo[] = $song->id_song;
            }

            $playlista->songs = implode(" ", $novo );
            //print_r($playlista);

            $playlista->save();

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

        if( !isset( $_GET[ 'korisnik' ] ) ) {
            sendJSONandExit( ['error' => 'Ne postoji $_GET[\'korisnik\']!' ] );
        }
        $korisnik = $_GET['korisnik'];

        $song = Song::find( 'name', $naziv );
        if( $song == NULL ) {
            sendJSONandExit( ['error' => 'Ne postoji pjesma!' ] );
        }
        
        $id = $song->id_song;
        $playlista = Playlist::find( 'username', $korisnik );
        if( $playlista === NULL ) {
            $playlista = Playlist::new( array( 0, $korisnik, 0, '' ) );
            sendJSONandExit( $playlista->username);
            $playlista->save();
            
        }
        $pjesme = explode(" ", $playlista->songs);
        $sadrzano = false;

        foreach( $pjesme as $pjesma ) {
            if( $pjesma == $id ) {
                $sadrzano = true;
                break;
            }
        }

        if( $sadrzano == false ) {
            $pjesme[] = $id;
            $playlista->songs = implode(" ", $pjesme );
            $playlista->save();
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

?>
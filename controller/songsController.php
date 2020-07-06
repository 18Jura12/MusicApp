<?php

require_once __DIR__ . '/../model/user.class.php';
require_once __DIR__ . '/../model/song.class.php';
require_once __DIR__ . '/../model/message.class.php';

class songsController {

    public function playlist() {

        $user = User::find( 'username', $_SESSION['korisnik'] );
        //$playlista = Playlist::find( 'username', $user->username );

        if( $user->songs !== '0' ) {
            $pjesme = explode(" ", $user->songs);
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

            $user->songs = implode(" ", $novo );
            //print_r($user);

            $user->save();

        } else {
            $songs = [];
        }      

        $godine = Song::column('year');
        $zemlje = Song::column('country'); 

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
        $user = User::find( 'username', $korisnik );
        if( $user->songs === '0' ) {

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
        usort($komentari, "date_sort");
        $korisnik = $_SESSION['korisnik'];

        $godine = Song::column('year');
        $zemlje = Song::column('country');

        require_once __DIR__ . '/../view/songView.php';

    }

    public function plasman() {

        $song = Song::find( 'id_song', $_GET['id'] );
        $pjesme = Song::where('year', $song->year);

        foreach($pjesme as $pjesma) {

            $points[] = $pjesma->semifinal_points;

        }
        array_multisort($points, SORT_DESC, $pjesme);

        $godine = Song::column('year');
        $zemlje = Song::column('country');

        require_once __DIR__ . '/../view/results.php';

    }

    public function zemlja() {

        $songs = Song::where('country', $_GET['zemlja']);

        $godine = Song::column('year');
        $zemlje = Song::column('country');

        require_once __DIR__ . '/../view/countryView.php';

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
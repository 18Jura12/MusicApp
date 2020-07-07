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

        $godine = Song::column('year');
        $zemlje = Song::column('country'); 

        require_once __DIR__ . '/../view/songList.php';
    }

    public function add() {

        $message = 'nije dodano';

        if( !isset( $_GET[ 'id' ] ) ) {
            sendJSONandExit( ['error' => 'Ne postoji $_GET[\'id\']!' ] );
        }
        $id = $_GET['id'];

        $song = Song::find( 'id_song', $id );
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

    function year() {

        if(!isset($_GET['godina'])) {

            sendJSONandExit( ['error' => 'Ne postoji $_GET[\'godina\']!' ] );

        }
        $unos = $_GET['godina'];
        $message = [];
        $pjesme = Song::where('year', $unos);

        foreach($pjesme as $key => $value) {

            $message[] = array($value->flag, $value->name, $value->artist);

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

        $popis = User::predlozeno();

        require_once __DIR__ . '/../view/results.php';

    }

    public function zemlja() {

        $songs = Song::where('country', $_GET['zemlja']);

        $godine = Song::column('year');
        $zemlje = Song::column('country');

        $popis = User::predlozeno();

        require_once __DIR__ . '/../view/countryView.php';

    }

    public function bodovi() {

        $godine = Song::where('year',$_GET['godina']);

        $godine = Song::column('year');
        $zemlje = Song::column('country');

        $popis = User::predlozeno();


        require_once __DIR__ . '/../view/bodovi.php';

    }

    public function poredak() {

        $godine = Song::column('year');
        $zemlje = Song::column('country');

        $popis = User::predlozeno();

        if( isset( $_GET['godina'] ) ) {
            $pjesme = Song::where('year',$_GET['godina']);
            $year = $_GET['godina'];
        } else {
            $pjesme = Song::where('year',$_POST['year']);
            $year = $_POST['year'];
        }

        foreach($pjesme as $pjesma) {

            $points[] = $pjesma->fan_points;

        }
        array_multisort($points, SORT_DESC, $pjesme);

        require_once __DIR__ . '/../view/fanBodovi.php';
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
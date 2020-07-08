<?php

require_once __DIR__ . '/../model/user.class.php';
require_once __DIR__ . '/../model/song.class.php';
require_once __DIR__ . '/../model/points.class.php';
require_once __DIR__ . '/../model/message.class.php';

class songsController {

    /*
    @user : trenutno ulogirani korisnik
    @popis : popis predloženih pjesama
    @songs : pjesme u playlisti korisnika
    @godine : godine u bazi ( 2018, 2019)
    @zemlje : zemlje koje sudjeluju u Euroviziji

    Ukoliko korisnik ima pjesama u playlisti, dohvaćamo id-eve tih pjesama te
        prikazujemo videe pjesama korisniku.
    Također ukoliko korisnik klikne na gumb za uklanjanje pjesme, izbacujemo ju iz playliste
        te ažuriramo bazu
    */
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

    /*
    Funkcija koja pomoću dobivenog id-a pjesme dodaje pjesmu u playlistu korisnika
        (ukoliko ona već ne postoji u playlisti) te ažurira bazu.
    */
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
        if( preg_match('/^[\t\s]*$/', $user->songs ) ) { //korisnik ima praznu playlistu
            $pjesme = [];
        } else {
            $pjesme = explode(" ", $user->songs);
            
        }
        $sadrzano = false;

        foreach( $pjesme as $pjesma ) { 
            if( $pjesma == $id ) {
                $sadrzano = true; // odabrana pjesma već postoji u playlisti
                break;
            }
        }

        if( $sadrzano == false ) { // odabrana pjesma ne postoji u playlisti
            $pjesme[] = $id;
            $user->songs = implode(" ", $pjesme );
            $user->save();
            $message = 'dodano';
        }

        sendJSONandExit( $message );
    }

    /*
    @unos : korisnikov unos u searchBar-u

    Funkcija koja vraća sva imena pjesama koja kao podstring sadrže string koji je korisnik
        unio u searchBar (neovisno o velikim i malim slovima).
    */
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

    /*
    
    Funkcija koja vraća relevantne podatke za prepoznavanje pjesme, a pjesme filtrira prema zadanoj godini.
    */
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

    /*
    @unos : korisnikov unos u searchBar-u

    Funkcija koja vraća id pjesme ukoliko naslov pjesme postoji u bazi.
    Ukoliko postoji više istih naslova pjesama, vraćamo samo jedan id.
    */
    function prikazPjesme() {
        if( !isset( $_GET[ 'unos' ] ) ) {
            sendJSONandExit( ['error' => 'Ne postoji $_GET[\'unos\']!' ] );
        }
        $unos = $_GET['unos'];

        $songs = Song::where( 'name', $unos ); 

        if( $songs == NULL ) {
            sendJSONandExit( ['error' => 'Ne postoji pjesma!' ] );
        } else {
            $message = $songs[0]->id_song; //ako postoji više pjesama istog naslova, uzimamo prvu dobivenu iz baze
            sendJSONandExit( $message );
        }
    }

    /*
    Funkcija koja prikazuje detalje pjesme preko danog id-a.
    Prikazuju se komentari za pjesmu, plasman i ostali detalji.
    */
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

    /*
    
    Funkcija dohvaća sve pjesme iz tražene godine te ih sortira silazno prema plasmanu i šalje na prikaz rezultata natjecanja zadane godine.
    */
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

    /*
    
    Funkcija dohvaća sve pjesme iz zadane zemlje i šalje rezultate na prikaz podataka o zadanoj zemlji.
    */
    public function zemlja() {

        $songs = Song::where('country', $_GET['zemlja']);

        $godine = Song::column('year');
        $zemlje = Song::column('country');

        $popis = User::predlozeno();

        require_once __DIR__ . '/../view/countryView.php';

    }

    /*
    
    Funkcija dohvaća sve pjesme iz tražene godine i šalje ih prikazu forme za bodovanje pjesama te godine od strane korisnika.
    */
    public function bodovi() {

        $pjesme = Song::where('year',$_GET['godina']);

        $godine = Song::column('year');
        $zemlje = Song::column('country');

        $temp = Points::find('username', $_SESSION['korisnik']);
        $stupac = 'godina'.$_GET['godina'];
        $temp = explode(" ", $temp->$stupac);
        $tvoji = [];
        if($temp[0] !== '0') {

            foreach($temp as $id) {

                $tvoji[] = Song::find('id_song', intval($id));
    
            }

        }

        //print_r($tvoji);

        $popis = User::predlozeno();


        require_once __DIR__ . '/../view/bodovi.php';

    }

    /*
    Funkcija koja za danu godinu pronalazi sve pjesme iz te godine te ih sortira
        silazno prema bodovima koje su dali korisnici aplikacije.
    */
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

        $temp = Points::find('username', $_SESSION['korisnik']);
        $stupac = 'godina'.$year;
        $temp = explode(" ", $temp->$stupac);
        $tvoji = [];
        if($temp[0] !== '0') {

            foreach($temp as $id) {

                $tvoji[] = Song::find('id_song', intval($id));
    
            }

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

/*
Funkcija koja sortira niz prema varijabli 'date', silazno.
Potrebna je za komentare kako bi se najnoviji komentari prikazivali na vrhu.
*/
function date_sort($a, $b) {
    return (-1) *( strtotime($a->date) - strtotime($b->date));
}

?>
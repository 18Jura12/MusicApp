<?php


require_once __DIR__ . '/../model/user.class.php';
require_once __DIR__ . '/../model/song.class.php';

class usersController {

    /*
    Funkcija koja preusmjerava korisnika na formu za login.
    */
    public function login() {
        $message = '';
        require_once __DIR__ . '/../view/login.php';
    }

    /*
    Funkcija koja preusmjerava korisnika na formu za registraciju.
    */
    public function register() {
        $message = '';
        require_once __DIR__ . '/../view/register.php';
    }

    /*
    Funkcija koja provjerava podatke koje je korisnik poslao u formi za login.
    Ukoliko korisnik upiše previše ili premalo slova za korisničko ime,
        ili se korisničko ime sastoji od nedopuštenih znakova i slično, korisniku
        se šalje poruka pa pojašnjenja popunjavanja forme, i ponovo mu se prikazuje 
        forma za login.
    Ukoliko su podaci u formi ispravni, korisniku se prikazuje njegova početna stranica.
    */
    public function verifyLogin() {
        if( !preg_match( '/^[a-zA-Z]{3,10}$/', $_POST['username'] ) ) {
            $message = 'Korisničko ime treba imati između 3 i 10 slova.';
            require_once __DIR__ . '/../view/login.php';
        }

        $user = User::find( 'username', $_POST['username'] );

        if( $user === NULL) { // ne postoji korisnik s tim imenom
            $message = 'Korisnik s tim imenom ne postoji.';
            require_once __DIR__ . '/../view/login.php';
        } else if( $user->has_registered === '0' ) {
            $message = 'Korisnik s tim imenom se nije još registrirao. Provjerite e-mail.';
            require_once __DIR__ . '/../view/login.php';
        } else if( !password_verify( $_POST['password'], $user->password_hash ) ) {
            $message = 'Lozinka nije ispravna.';
            require_once __DIR__ . '/../view/login.php';
        } else {
            $_SESSION['korisnik'] = $_POST['username'];
            $this->pocetna();
        }
    }

    /*
    @pjesme : pjesme iz zadnje godine (2019.) koje se prikazuju na početnoj stranici.
    @popis : niz od 3 predložene pjesme za korisnika
    @godine : sve godine koje postoje u bazi
    @zemlje: sve države koje sudjeluju u natjecanju
    
    Funkcija koja služi za prikaz pjesama iz određene godine.
        Ukoliko je korisnik na početnoj stranici, prikazuju se pjesme iz zadnje godine.
        Ukoliko je korisnik odabrao određenu godinu iz navigation_bar-a, 
            prikazuju se pjesme iz odabrane godine.
    */
    public function pocetna() {

        $popis = User::predlozeno();
        if(!isset($_GET['godina'])) {
            $year = 2019;
        } else {
            $year = $_GET['godina'];
        }
        $pjesme = Song::where('year', $year);
        $godine = Song::column('year');
        $zemlje = Song::column('country');

        //print_r($zemlje);
            
        require_once __DIR__ . '/../view/home.php';

    }

    /*
    Funkcija koja provjerava korisnikove inpute u formi za registraciju.
    Ukoliko je nešto krivo uneseno, obavještava se korisnik i ponovno mu se prikazuje
        forma za registraciju.
    Ukoliko je korisnik uspješno popunio formu, ubacuje se u bazu, i šalje mu se mail za
        potvrdu registracije. Također, obavještava se o uspješnosti registracije putem određenog view-a.
    */
    public function verifyRegister() {

        if( !preg_match( '/^[A-Za-z]{3,10}$/', $_POST['usernameReg'] ) ) {
            $message = 'Korisničko ime treba imati između 3 i 10 slova.';
            require_once __DIR__ . '/../view/register.php';
        } else if( !filter_var( $_POST['mail'], FILTER_VALIDATE_EMAIL ) ) {
            $message = 'E-mail adresa nije ispravna.';
            //echo $_POST['email'];
            require_once __DIR__ . '/../view/register.php';
        } else {
            $user = User::find( 'username', $_POST['usernameReg'] );

            if( $user !== NULL) { // postoji korisnik s tim imenom
                $message = 'Korisnik s tim imenom već postoji u bazi.';
                require_once __DIR__ . '/../view/register.php';
            } else {
                // Dodaj novog korisnika u bazu.
                // Prvo mu generiraj random string od 10 znakova za registracijski link.
		        $reg_seq = '';
		        for( $i = 0; $i < 20; ++$i ) {
                    $reg_seq .= chr( rand(0, 25) + ord( 'a' ) ); // Zalijepi slučajno odabrano slovo
                }

                $newUser = User::new( array( $_POST['usernameReg'], $_POST['mail'], $_POST['country'], password_hash( $_POST['passwordReg'], PASSWORD_DEFAULT ), '', $reg_seq, 0 ) );

                //print_r( $newUser );
   
                $newUser->save(); //sprema ga u bazu

                // Sad mu još pošalji mail
                $to       = $_POST['mail'];
                $subject  = 'Registracijski mail';
                $messageMail  = 'Poštovani ' . $_POST['usernameReg'] . "!\nZa dovršetak registracije kliknite na sljedeći link: ";
                $messageMail .= 'http://' . $_SERVER['SERVER_NAME'] . htmlentities( dirname( $_SERVER['PHP_SELF'] ) ) . '/music.php?rt=users/sanducic&niz=' . $reg_seq . "\n";

                //echo '<br>' . $messageMail;
                
                $headers  = 'From: rp2@studenti.math.hr' . "\r\n" .
		                'Reply-To: rp2@studenti.math.hr' . "\r\n" .
                        'X-Mailer: PHP/' . phpversion();
                $isOK = mail($to, $subject, $messageMail, $headers);
   
		        if( !$isOK ) {
                    $message = 'Ne mogu poslati mail.';
                    require_once __DIR__ . '/../view/register.php';
                } else {
                    require_once __DIR__ . '/../view/registerSuccessful.php';
                }
            }            
        }
    }

    /*
    Funkcija koja ažurira varijablu u bazi da se korisnik uspješno registrirao.
    */
    public function sanducic() {
        if( !isset( $_GET['niz'] ) || !preg_match( '/^[a-z]{20}$/', $_GET['niz'] ) ) {
            $message = 'Probajte ponovo kliknuti na link u mailu.';
            require_once __DIR__ . '/../view/login.php';
        }

        //Pretpostavljamo da postoji samo jedan takav niz
        $user = User::find( 'registration_sequence', $_GET['niz'] );

        $user->has_registered = 1;
        $user->save();

        require_once __DIR__ . '/../view/mailSuccessful.php';
    }

    /*
    Ukoliko se korisnik želi odjaviti, uništava se sesija i korisnik se preusmjerava 
        na formu za login.
    */
    public function logout() {
        session_unset();
        session_destroy();

        require_once __DIR__ . '/../music.php';
    }

}

?>
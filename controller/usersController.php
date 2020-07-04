<?php

require_once __DIR__ . '/../model/user.class.php';
require_once __DIR__ . '/../model/song.class.php';

class usersController {
    public function login() {
        $message = '';
        require_once __DIR__ . '/../view/login.php';
    }

    public function register() {
        $message = '';
        require_once __DIR__ . '/../view/register.php';
    }

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

    public function pocetna() {

        $pjesme = Song::where('year', 2019);
            
        require_once __DIR__ . '/../view/home.php';

    }

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

                $newUser = User::new( array( $_POST['usernameReg'], $_POST['mail'], $_POST['country'], password_hash( $_POST['passwordReg'], PASSWORD_DEFAULT ), $reg_seq, 0 ) );

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
                    //$message = 'Ne mogu poslati mail.' . $to . ' ' . $subject . ' ' . $messageMail;
                    //$message = error_get_last()['message'];
                    var_dump(error_get_last()['message']);
                    //require_once __DIR__ . '/../view/register.php';
                } else {
                    require_once __DIR__ . '/../view/registerSuccessful.php';
                }
            }            
        }
    }

    public function sanducic() {
        echo 'sanducic';
    }

    public function logout() {

        //echo 'tu';
        session_unset();
        session_destroy();

        require_once __DIR__ . '/../music.php';

    }

}

?>
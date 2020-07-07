<?php

require_once __DIR__ . '/model.class.php';

//Ova klasa predstavlja korisnika aplikacije: njegovo korisničko ime, zemlju iz koje dolazi, email, šifru za ulogiravanje u aplikaciju, playlistu koje je reprezentirana strikžngom koji sadrži id-eve pjesama koje se nalaze u playlisti, te podatke potrebne za registraciju.
class User extends Model{
    protected static $table = 'musicUsers';
    protected static $attributes = ['username' => 'varchar', 'email' => 'varchar', 'country' => 'varchar', 'password_hash' => 'varchar', 'songs' => 'varchar', 'registration_sequence' => 'varchar', 'has_registered' => 'int'];
}

?>
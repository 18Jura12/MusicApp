<?php

require_once __DIR__ . '/model.class.php';

//klasa predstavlja sve dodijeljene bodove od strane fanova (korisnika aplikacije), raspoređene prema korisniku(ključ username) i godini na koju se bodovi odnose(godina_).
//jedan element stupca godina_ je string sa 10 brojčanih vrijednosti odovojenih razmakom koje predstavljaju id-eve pjesama kojima su dodijeljeni bodovi od 1 do 12, prema eurovizijskom načinu bodovanja.
//ako korisnik još nije dodijelio bodove, vrijednost je '0'.
class Points extends Model{
    protected static $table = 'musicPoints';
    protected static $attributes = ['username' => 'varchar', 'godina2018' => 'varchar', 'godina2019' => 'varchar'];
}

?>
<?php

require_once __DIR__ . '/model.class.php';

//klasa predstavlja pjesmu Eurovizije: ima id, ime, izvođača, godinu u kojoj je nastupala, zemlju koju je predstavljala, link na youtube video live nastupa s natjecanja, sve relevantne bodove s natjecanja i plasmane u polufinalu/finalu te bodove dobivene od strane korisnika aplikacije.
class Song extends Model{
    protected static $table = 'musicSongs';
    protected static $attributes = ['id_song' => 'int', 'name' => 'varchar', 'artist' => 'varchar', 'country' => 'varchar', 'year' => 'int', 'genre' => 'varchar', 'thumbs_up' => 'int', 'link_video' => 'string', 'flag' => 'varchar', 'semifinal' => 'int', 'semifinal_place' => 'int', 'semifinal_points' => 'int', 'final_place' => 'int', 'final_points' => 'int', 'fan_points' => 'int'];
}

?>
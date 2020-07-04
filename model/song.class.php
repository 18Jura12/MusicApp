<?php

require_once __DIR__ . '/model.class.php';

class Song extends Model{
    protected static $table = 'musicSongs';
    protected static $attributes = ['id_song' => 'int', 'name' => 'varchar', 'artist' => 'varchar', 'country' => 'varchar', 'year' => 'int', 'genre' => 'varchar', 'thumbs_up' => 'int', 'link_video' => 'string', 'flag' => 'varchar', 'semifinal' => 'int', 'semifinal_place' => 'int', 'semifinal_points' => 'int', 'final_place' => 'int', 'final_points' => 'int', 'fan_points' => 'int'];
}

?>
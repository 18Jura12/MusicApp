<?php

require_once __DIR__ . '/model.class.php';

class Playlist extends Model{
    protected static $table = 'musicPlaylist';
    protected static $attributes = ['id' => 'int', 'username' => 'varchar', 'songs_counter' => 'int', 'songs' => 'varchar'];
}

?>
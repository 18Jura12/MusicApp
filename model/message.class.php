<?php

require_once __DIR__ . '/model.class.php';

// Ova klasa predstavlja sve objavljene komentare za svaku pjesmu u bazi. Tome se pristupa u songView-u.
// sadrži lajkove i dislajkove, te id pjesme koju predstavlja.
class Message extends Model{
    protected static $table = 'musicMessages';
    protected static $attributes = ['id' => 'int', 'username' => 'varchar', 'id_song' => 'int', 'content' => 'varchar', 'thumbs_up' => 'int', 'thumbs_down' => 'int', 'date' => 'date'];
}

?>
<?php

require_once __DIR__ . '/model.class.php';

class Message extends Model{
    protected static $table = 'musicMessages';
    protected static $attributes = ['id' => 'int', 'username' => 'varchar', 'id_song' => 'int', 'content' => 'varchar', 'thumbs_up' => 'int', 'thumbs_down' => 'int', 'date' => 'date'];
}

?>
<?php

require_once __DIR__ . '/model.class.php';

class User extends Model{
    protected static $table = 'musicUsers';
    protected static $attributes = ['username' => 'varchar', 'email' => 'varchar', 'country' => 'varchar', 'password_hash' => 'varchar', 'songs' => 'varchar', 'points' => 'varchar', 'registration_sequence' => 'varchar', 'has_registered' => 'int'];
}

?>
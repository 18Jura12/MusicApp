<?php

require_once __DIR__ . '/model.class.php';

class Points extends Model{
    protected static $table = 'musicPoints';
    protected static $attributes = ['username' => 'varchar', 'godina2018' => 'varchar', 'godina2019' => 'varchar'];
}

?>
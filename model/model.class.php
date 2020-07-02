<?php

require_once __DIR__ . '/../app/database/db.class.php';

abstract class Model {
    protected static $table = null;
    protected static $attributes = [];
    protected $columns = [];

    public function __get( $col )
    {
        // Omogućava da umjesto $this->columns['name'] pišemo $this->name.
        // (uoči: $this->columns može ostati protected!)
        if( isset( $this->columns[ $col ] ) )
            return $this->columns[ $col ];

        return null;
    }

    public function __set( $col, $value )
    {
        // Omogućava da umjesto $this->columns['name']='Mirko' pišemo $this->name='Mirko'.
        // (uoči: $this->columns može ostati protected!)
        $this->columns[$col] = $value;

        return $this;
    }

    // Funkcija vraća onaj (jedini!) objekt iz tablice $table kojem je $column jednak $value
    public static function find( $column, $value ) {
        $db = DB::getConnection();

        $klasa = get_called_class();

        try{
            $st = $db->prepare( 'SELECT * FROM ' . $klasa::$table . ' WHERE ' . $column . ' = "' . $value . '"');
            $st->execute();
        } catch(PDOException $e) {
            echo 'Greska: ' . $e->getMessage();
        }

        $row = $st->fetch( PDO::FETCH_ASSOC );

        if( $st->rowCount() !== 1 ) {
            return NULL;
        }

        $temp = new $klasa();

        $kljucevi = array_keys( $row );
        foreach( $kljucevi as $kljuc ) {
            $temp->$kljuc = $row[$kljuc];
        }

        return $temp;
    }

    public static function new ( $values ) {
        $klasa = get_called_class();

        $temp = new $klasa();

        $kljucevi = array_keys( $klasa::$attributes );

        foreach( array_combine($kljucevi, $values) as $kljuc => $value ) {
            $temp->$kljuc = $value;
        }

        /*echo '<pre>';
        print_r( $temp );
        echo '</pre>';*/

        return $temp;
        
    }
}

?>
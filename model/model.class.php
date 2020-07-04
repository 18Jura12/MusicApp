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

    // Funkcija sprema novi ili ažurira postojeći redak u tablici $table koji pripada objektu $this.
    // ($this->id je ključ u tablici $table).
    public function save() {

        $db = DB::getConnection();
        $klasa = get_called_class();

        $kljucevi = array_keys( $klasa::$attributes );

        /*echo '<pre>';
        print_r( $this);
        echo '</pre>';*/

        $column = $kljucevi[0];
        $value = $this->$column;

        $user = User::find( $column, $value );

        $vrijednosti = [];

        if( $user === NULL ) { // novi redak
            $promjena = 'INSERT INTO ' . $klasa::$table . ' ( ';

            $atributi = implode( ", ", $kljucevi );
            $promjena .= $atributi;

            foreach( $kljucevi as $kljuc ) {
                if( $klasa::$attributes[$kljuc] !== 'int' ) {
                    $temp = '"';
                    $temp .= $this->$kljuc;
                    $temp .= '"';
                } else {
                    $temp = $this->$kljuc;
                }

                $vrijednosti[] = $temp;
            }

            $vrijednosti = implode( ", ", $vrijednosti );
            $promjena .= ' ) VALUES ( ' . $vrijednosti . ' )';

            //print_r($promjena);

        } else { // update postojeceg retka
            $promjena = 'UPDATE ' . $klasa::$table . ' SET ';

            foreach( $kljucevi as $kljuc ) {
                if( $kljuc !== $column ) { // nije primarni kljuc
                    if( $klasa::$attributes[$kljuc] !== 'int') {
                        $vrijednost = '"' . $this->$kljuc . '"';
                    } else {
                        $vrijednost = $this->$kljuc;
                    }

                    $temp = $kljuc . ' = ' . $vrijednost;
                    $vrijednosti[] = $temp;
                }
            }

            $vrijednosti = implode( ", ", $vrijednosti );
            $promjena .= ' WHERE ' . $column . ' = ' . $value;
        }

        try {
            $st = $db->prepare( $promjena );
            $st->execute();
        } catch( PDOException $e ) {
            echo 'Greska: ' . $e->getMessage();
        }
    }

    // Funkcija vraća polje koje sadrži sve objekte iz tablice $table kojima u stupcu $column piše vrijednost
    public static function where( $column, $value ) {
        $db = DB::getConnection();

        $klasa = get_called_class();
        $niz = [];

        try{
            $st = $db->prepare( 'SELECT * FROM ' . $klasa::$table . ' WHERE ' . $column . ' = "' . $value . '"');   
            $st->execute();
        } catch(PDOException $e) {
            echo 'Greska: ' . $e->getMessage();
        }

        while( $row = $st->fetch( PDO::FETCH_ASSOC ) ) {
            $kljucevi = array_keys( $row );

            $temp = new $klasa();

            foreach( $kljucevi as $kljuc ) {
                $temp->$kljuc = $row[$kljuc];
            }

            $niz[] = $temp;
        }

        return $niz;
    }


}

?>
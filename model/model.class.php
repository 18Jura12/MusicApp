<?php

require_once __DIR__ . '/../app/database/db.class.php';

//apstraktna klasa koju naslijeđuju sve ostale klase koje predstavljaju elemente tablica iz baza
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

        //print_r($st);

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

    //funkcija radi novi objekt sa danim parametrima koji je tipa $this tj. tipa klase od čije strane je pozvana funkcija.
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

        $user = $klasa::find( $column, $value );

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
                    $vrijednosti[] = $temp;;

                }
            }

            

            $vrijednosti = implode( ", ", $vrijednosti );
            //print_r( $vrijednosti);
            $promjena .= $vrijednosti . ' WHERE ' . $column . ' = ' . '"'.$value.'"';
        }

        try {
            $st = $db->prepare( $promjena );
            $st->execute();
        } catch( PDOException $e ) {
            echo $promjena;
            echo 'Greska: ' . $e->getMessage();
        }

        return $db->lastInsertId();
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

    // Funkcija vraća polje koje sadrži sve objekte iz tablice $table
    public static function all() {

        $db = DB::getConnection();

        $klasa = get_called_class();

        try {
            $st = $db->prepare( 'SELECT * FROM ' . $klasa::$table . '' );
            $st->execute();
        } catch(PDOException $e) {
            echo 'Greska: ' . $e->getMessage();
        }        

        $niz = [];

        while( $row = $st->fetch( PDO::FETCH_ASSOC ) ) {
            $kljucevi = array_keys( $row );

            /*echo '<pre>';
            print_r( $kljucevi );
            echo '</pre>';*/

            $temp = new $klasa();

            foreach( $kljucevi as $kljuc ) {
                $temp->$kljuc = $row[$kljuc];
            }

            $niz[] = $temp;
        }

        return $niz;
    }

    /*
    Funkcija koja nalazi tri pjesme za predlaganje korisniku.
    Ukoliko korisnik ima pjesme u playlisti, gledamo njihove žanrove i biramo onaj žanr 
        čijih pjesmi ima najviše u playlisti te predlažemo 3 pjesme istog žanra.
    Ukoliko korisnik nema pjesmi u playlisti, prikazujemo pop pjesme.
    Isto tako, ako nemamo ukupno 3 pjesme odabranog žanra, nadopunjujemo ih sa pjesmama 
        čiji je žanr pop.
    */
    public function predlozeno() {

        $user = User::find( 'username', $_SESSION['korisnik'] );
        $popis = [];

        if( !preg_match('/^[\t\s]*$/', $user->songs ) ) { //imamo nesto u playlisti

            $popis = explode( " ", $user->songs );
            $zanrovi = [];

            foreach( $popis as $idPjesme ) {
                if( !preg_match( '/^[0-9]+$/', $idPjesme ) ) {
                    continue;
                }

                $genre = Song::find( 'id_song', $idPjesme )->genre;
                if( !array_key_exists( $genre, $zanrovi ) ) { // brojimo pjesme po žanrovima
                    $zanrovi[$genre] = 1;
                } else {
                    $zanrovi[$genre] += 1;
                }
            }

            $zanr =array_search( max( $zanrovi ), $zanrovi ); //biramo žanr čijih pjesama imamo najviše
            $popis = [];
            $popisBaza = Song::where( 'genre', $zanr );

            if( count( $popisBaza ) < 3 ) { // nemamo 3 pjesme odabranog žanra
                $br = 0;
                foreach( $popisBaza as $value ) {
                    $popis[] = $value;
                    $br += 1;
                }
                $popisBaza = Song::where( 'genre', 'pop' ); // nadopunimo preostale pjesme sa pop pjesmama
                $temp = array_rand( $popisBaza, 3-$br );
                //print_r($temp);

                if( $br === 2 ) {
                    $pjesma = $popisBaza[$temp];
                    $popis[] = $pjesma;
                } else {
                    foreach( $temp as $value ) {
                        $pjesma = $popisBaza[$value];
                        $popis[] = $pjesma;
                    }
                }            
            } else { //imamo 3 pjesme odabranog žanra
                $temp = array_rand( $popisBaza, 3 );
                foreach( $temp as $value ) {
                    $pjesma = $popisBaza[$value];
                    $popis[] = $pjesma;
                }
            }
        } else { // nemamo nista u playlisti, biramo pop pjesme
            $popisBaza = Song::where( 'genre', 'pop' );
            $temp = array_rand( $popisBaza, 3 );
            foreach( $temp as $value ) {
                $pjesma = $popisBaza[$value];
                $popis[] = $pjesma;
            }
        }      
        
        //print_r($popis);
        //print_r( $zanr );

        return $popis;
    }

    //funkcija vraća sve jedinstvana vrijednosti stupca $column
    public static function column($column) {

        $db = DB::getConnection();

        $klasa = get_called_class();

        try {
            $st = $db->prepare( 'SELECT DISTINCT '.$column.' FROM ' . $klasa::$table . '' );
            $st->execute();
        } catch(PDOException $e) {
            echo 'Greska: ' . $e->getMessage();
        }   

        $rezultat = $st->fetchAll( PDO::FETCH_ASSOC );
        $values = [];
        foreach($rezultat as $key => $value) {

            $values[] = $value["$column"];

        }
        asort($values);
        return $values;

    }

}

?>
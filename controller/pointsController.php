
<!-- 
    Ovaj Controller predstavlja upravljanje podatcima iz tablice musicPoints.
 -->
<?php

require_once __DIR__ . '/../model/points.class.php';
require_once __DIR__ . '/../model/song.class.php';

class PointsController {

    //Ova funkcija sprema dati string s bodovima u tablicu pod zadani username, za zadanu godinu.
    public function save() {

        $row = Points::find('username', $_GET['username']);
        $col = 'godina'. $_GET['year'];
        $stari = explode(" ", $row->$col);
        $row->$col = implode(" ", $_GET['data']);
        
        $row->save();

        $novi = $_GET['data'];
        
        //Ovdje uklanjamo bodove, ukoliko prepisujemo već postojeće bodovanje.
        if(intval($stari[0]) !== 0) {

            $j = 1;
            for($i=0; $i<sizeof($stari); $i++) {

                if($j > 8) $j++;
    
                $pjesma = Song::find('id_song', intval($stari[$i]));
                $pjesma->fan_points = $pjesma->fan_points - $j;
                $pjesma->save();
                
                $j++;
    
            } 

        }

        //Ovdje ažuriramo bodove korisnika za svaku pjesmu (onaj atribut fan_points, opisan u klasi pjesme(song.class.php)).
        $j = 1;
        for($i=0; $i<sizeof($novi); $i++) {

            if($j > 8) $j++;

            $pjesma = Song::find('id_song', intval($novi[$i]));
            $pjesma->fan_points = $pjesma->fan_points + $j;
            $pjesma->save();
            
            $j++;

        } 

    } 

}

?>
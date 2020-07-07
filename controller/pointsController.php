<?php

require_once __DIR__ . '/../model/points.class.php';
require_once __DIR__ . '/../model/song.class.php';

class PointsController {

    public function save() {

        $row = Points::find('username', $_GET['username']);
        $col = 'godina'. $_GET['year'];
        $stari = explode(" ", $row->$col);
        $row->$col = implode(" ", $_GET['data']);
        
        $row->save();

        $novi = $_GET['data'];
        
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

function sendJSONandExit( $message ) {
    // Kao izlaz skripte pošalji $message u JSON formatu i
    // prekini izvođenje.
    header( 'Content-type:application/json;charset=utf-8' );
    echo json_encode( $message );
    flush();
    exit( 0 );
}

?>
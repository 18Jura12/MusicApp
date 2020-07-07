<!-- Ovaj html prikazuje tri tablice koje reprezentiraju ishod natjecanja zadane godine te istiću zadanu Zemlju i njezin plasman.
     Tablice su raspoređene pomoću Bootstrap-ovog grida.
 -->
<?php

require_once __DIR__ . '/home_header.php';

?>

<!-- 
    Sve su tri tablice svaka u svojem stupcu jednog reda mreže, uz jedan dodatni stupac koji glumi padding prve tablice.
    Prva tablica predstavlja prvo polufinale, druga drugo, a treća finale. U polufinalima su sivom pozadinom retka označene one zemlje koje nisu prošle u finale.
    U tablici finala je zlatnom bojom pozadine označen pobjednik.
 -->
<div class="row d-flex justify-content-around">
    <div class="col-md-1"></div>
    <div class="col-md-3">
        <table class="table">
            <tr><th class="bg-primary" scope="col" colspan="4" style="text-align: center; vertical-align: middle;">Polufinale 1</th></tr>
            <?php
            foreach($pjesme as $value) {

                if($value->semifinal === '1') {

                    echo '<tr '. ispao($value, $song) .'><td class="align-middle" style="text-align: center; vertical-align: middle; font-size: 30px;"  scope="row">'.$value->semifinal_place.'.</td><td class="align-middle" style="text-align: center; vertical-align: middle; font-size: 30px;"  scope="row">'.$value->flag.'</td>';
                    echo '<td class="align-middle" style=" vertical-align: middle;">'.$value->name.'<br><div style="font-size: 10px; color: gray;">'.$value->artist.'</div></td>'.'<td class="align-middle" style="text-align: center; vertical-align: middle;">'.$value->semifinal_points.'</td>';

                }

            }
            ?>
        </table>
    </div>
    <div class="col-md-3 offset-md-1">
        <table class="table">
            <tr><th class="bg-primary" scope="col" colspan="4" style="text-align: center; vertical-align: middle;">Polufinale 2</th></tr>
            <?php
            foreach($pjesme as $value) {

                if($value->semifinal === '2') {

                    echo '<tr '. ispao($value, $song) .'><td class="align-middle" style="text-align: center; vertical-align: middle; font-size: 30px;"  scope="row">'.$value->semifinal_place.'.</td><td class="align-middle" style="text-align: center; vertical-align: middle; font-size: 30px;"  scope="row">'.$value->flag.'</td>';
                    echo '<td class="align-middle" style=" vertical-align: middle;">'.$value->name.'<br><div style="font-size: 10px; color: gray;">'.$value->artist.'</div></td>'.'<td class="align-middle" style="text-align: center; vertical-align: middle;">'.$value->semifinal_points.'</td>';

                }

            }
            ?>
        </table>
    </div>
    <div class="col-md-3">
        <table class="table">
            <tr><th class="bg-primary" scope="col" colspan="4" style="text-align: center; vertical-align: middle;">Finale</th></tr>
            <?php
            $points = [];
            foreach($pjesme as $pjesma) {

                $points[] = $pjesma->final_points;
    
            }
            array_multisort($points, SORT_DESC, $pjesme);
            foreach($pjesme as $value) {

                if($value->final_place !== '-1') {

                    echo '<tr '. prvi($value, $song) .'><td class="align-middle" style="text-align: center; vertical-align: middle; font-size: 30px;"  scope="row">'.$value->final_place.'.</td><td class="align-middle" style="text-align: center; vertical-align: middle; font-size: 30px;"  scope="row">'.$value->flag.'</td>';
                    echo '<td class="align-middle" style=" vertical-align: middle;">'.$value->name.'<br><div style="font-size: 10px; color: gray;">'.$value->artist.'</div></td>'.'<td class="align-middle" style="text-align: center; vertical-align: middle;">'.$value->final_points.'</td>';

                }

            }
            ?>
        </table>
    </div>
</div>

<?php

require_once __DIR__ . '/_footer.php';

//pomoćna funkcija koja provjerava je li pjesma s trenutnim id-em ispala iz polufinala i je li ona zadana zemlja koju treba istaknuti.
function ispao($pjesma, $song) {

    $naredba = '';

    if($pjesma->semifinal_place > '10') {

        $naredba .= 'background-color: lightgray; ';

    }
    if($pjesma->id_song === $song->id_song) {

        $naredba .= 'font-weight: bold; ';

    }
    return 'style="' . $naredba . '"';

}

//pomoćna funkcija koja provjerava je li pjesma s trenutnim id-em pobjedila u finalu i je li ona zadan zemlja koju treba istaknuti.
function prvi($pjesma, $song) {

    $naredba = '';

    if($pjesma->final_place === '1') {

        $naredba .= 'background-color: gold; ';

    }
    if($pjesma->id_song === $song->id_song) {

        $naredba .= 'font-weight: bold; ';

    }
    return 'style="' . $naredba . '"';

}

?>
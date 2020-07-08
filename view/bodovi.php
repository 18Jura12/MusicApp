<?php

require_once __DIR__ . '/home_header.php';

?>
<script type="text/javascript" src="bodovi.js"></script>
<?php

//prikaz prethodno dodijeljenih bodova od strane korisnika.
//ažurira se tek osvježavanjem stranice.
if(!empty($tvoji)) {

    echo '<hr><b>VAŠI PRETHODNO DODIJELJENI BODOVI:<b><br><table style="width=100vw;"><tr>';
    for($i=0; $i<sizeof($tvoji); $i++) {

        $j = $i+1;
        if($j > 8) $j++;
        if($j > 10) $j++;
        echo '<td>'.$j.' '.$tvoji[$i]->flag.'&emsp;&emsp;</td>';

    }
    echo '</tr></table><hr>';

}

//radio gumbi za novi unos bodova.
//klikom na njih, moguće je nakon toga kliknuti na neku pjesmu te na taj način njoj dodijeliti broj bodova označen pored radio gumba.
echo '<table><tr>';
for($i=0; $i<10; $i++) {

    $j = $i+1;
    if($j > 8) $j++;
    if($j > 10) $j++;
    echo '<td><input type="radio" name="bodovi" class="'.$i.'">'.$j.'&emsp;&emsp;</td>';

}
echo '</tr></table><hr>';

//gumbi koji predstavljaju pjesme.
echo '<div class="row"><div class="col">';
for($i=0; $i<sizeof($pjesme); $i++) {

    if($i % 5 === 0) {

        if($i !== 0) {
            echo '</div>';
        }
        echo '<div class="row">';


    }
    if($i % 5 === 0) echo '<div class="col-md-1"></div>';
    echo '<button type="button" class="col-md-2 btn btn-default" id="'.$pjesme[$i]->id_song.'"><div>'.$pjesme[$i]->flag.'</div><div>'.$pjesme[$i]->name.'<br><div style="font-size:10px; color:gray;">'.$pjesme[$i]->artist.'</div></div></button>';

}
echo '</div></div>';

//gumb kojim se pohranjuje novi odabir
echo '<hr style="border: 1px solid darkgray;"><div style="display:flex; justify-content: center;"><button type="button" class="btn btn-primary btn-lg" id="submit" value="'.$_SESSION['korisnik'].'" disabled=true label="'.$_GET['godina'].'">Glasaj!</button></div>';

require_once __DIR__ . '/_footer.php';

?>
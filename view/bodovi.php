<?php

require_once __DIR__ . '/home_header.php';

?>
<script type="text/javascript" src="bodovi.js"></script>
<?php
echo '<div class="row">';
echo '<div class="col-ml-6">';
$j = 1;
$k = 0;
for($i=0; $i<sizeof($pjesme); $i++) {

    if($i % 4 === 0) {

        if($i !== 0) {
            if($j<12)  {

                if($j > 8) $j++;
                echo '<div class="col-md-2 offset-md-2"><div style="padding:10%; float:right;"><input type="radio" name="bodovi" class="'.$k.'">'.$j.'</div></div>';
                $j++; $k++;

            }
            echo '</div>';
        }
        echo '<div class="row">';


    }
    echo '<button type="button" class="col-md-2 btn btn-default" id="'.$pjesme[$i]->id_song.'"><div>'.$pjesme[$i]->flag.'</div><div>'.$pjesme[$i]->name.'<br><div style="font-size:10px; color:gray;">'.$pjesme[$i]->artist.'</div></div></button>';

}
echo '</div>';
echo '<hr style="border: 1px solid darkgray;"><div style="display:flex; justify-content: center;"><button type="button" class="btn btn-primary btn-lg" id="submit" value="'.$_SESSION['korisnik'].'" disabled=true label="'.$_GET['godina'].'">Glasaj!</button></div>';

require_once __DIR__ . '/_footer.php';

?>
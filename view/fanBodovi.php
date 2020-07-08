<?php

require_once __DIR__ . '/home_header.php';

//Ova tablica prikazuje bodove koje je dodijelio korisnik
if(!empty($tvoji)) {

    echo '<hr>VAŠI BODOVI:<br><table><tr>';
    for($i=0; $i<sizeof($tvoji); $i++) {

        $j = $i+1;
        if($j > 8) $j++;
        if($j > 10) $j++;
        echo '<td>'.$j.' '.$tvoji[$i]->flag.'&emsp;&emsp;</td>';

    }
    echo '</tr></table><hr>';

}

?>
<!-- Izbor za prikaz bodova iz određene godine.
    Na klik radio button-a se prikažu bodovi iz određene godine. -->
<div class="izbor">
    <form class="forma" action="music.php?rt=songs/poredak" method="POST">
        <div style="width:50%; float:left; text-align: center;">
        <input onChange="this.form.submit();" type="radio" name="year" value=2019 />2019
        </div>

        <div style="width:50%; float: left; text-align: center;">
        <input onChange="this.form.submit();" type="radio" name="year" value=2018 />2018
        </div>
    </form>
</div>
<br>
<br>
<br>
<!-- Prikaz odabrane godine. -->
<div class="naslov">
    Godina:
    <br>
    <?php echo $year; ?>
</div>
<br>

<!-- Ispis svih pjesama iz tražene godine i prikaz njihovih bodova dobivenih od stane korisnika. -->
<div class="sadrzaj">
    <p class="ispis" style="text-align: center;" ><i>Bodovi korisnika</i></p>
    <?php
        $br = 1;
        foreach( $pjesme as $pjesma ) {
        ?>
        <div class="ispis" >
            <span>
                <?php echo $pjesma->flag; ?>
            </span>
            <p class="p-evi">
                <strong><?php echo $pjesma->name; ?></strong><br>
                <?php echo $pjesma->artist; ?>
            </p>
            <p class="points">
                <strong><?php echo $pjesma->fan_points; ?></strong>
        </p>
        </div>
        <?php
        }
    ?>

</div>

<?php

require_once __DIR__ . '/_footer.php';

?>
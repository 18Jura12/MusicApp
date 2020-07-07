<?php

require_once __DIR__ . '/home_header.php';

?>
<script type="text/javascript" src="dodaj.js"></script>
<table class="table">
<thead class="thead-dark">
    <tr>
        <th scope="col" colspan="2" style="vertical-align: middle;">Zemlja</th>
        <th scope="col" style=" vertical-align: middle;">Pjesma</th>
        <th scope="col" style=" vertical-align: middle;">Izvođač</th>
    </tr>
</thead>
<tbody>
<?php
foreach($pjesme as $value) {

    //Ako ti se da pokušati poravnati vertikalno sve td-ove, bio bih ti beskrajno zahvalan, ali stvarno je gnjavaža i sve sam probao! Jučer sam se s tim gnjavio par sati... DJELOMICNO
    echo '<tr><th class="align-middle" style="font-size: 30px;  vertical-align: middle;" scope="row">'.$value->flag.'</th>';
    echo '<td class="align-middle" style=" vertical-align: middle;">'.$value->country.'</td>'.'<td class="align-middle" style=" vertical-align: middle;">'.$value->name.'</td>'.'<td class="align-middle" style=" vertical-align: middle;">'.$value->artist.'</td>';
    ?>
    <td>
        <div id=<?php echo $_SESSION['korisnik']; ?> class="align-middle" style="font-size: 30px; ">
            <!--Ništa od funkcija na linkovima nije implementirano :D-->
            <!--Ova treba dodati pjesmu u playlistu DODANO --> 
            <a value=<?php echo $value->id_song; ?> title="Dodaj u popis za reprodukciju" class="dodajPjesmu"><span class="glyphicon glyphicon-plus" style=" vertical-align: middle;"></span></a>&emsp;
            <!--Ova treba za dati id pjesme otvoriti komentare i lajkove za tu pjesmu unutar nekog prozorčića-->
            <a title="Otvori pjesmu" href="music.php?rt=songs/showSong&id=<?php echo $value->id_song; ?>"><span class="glyphicon glyphicon-facetime-video" style=" vertical-align: middle;"></span></a>&emsp;
            <!--Ova otvara rezultate finala i polufinala te godine u kojoj je ta pjesma sudjelovala, može i podebljati tu pjesmu u tablicama :)-->
            <a title="Pogledaj plasman"href="music.php?rt=songs/plasman&id=<?php echo $value->id_song; ?>"><span class="glyphicon glyphicon-list" style=" vertical-align: middle;"></span></a>
        </div>
    </td>
    <?php
    echo '</tr>';

}
echo('</tbody></table>');

require_once __DIR__ . '/_footer.php';

?>
<?php

require_once __DIR__ . '/home_header.php';

?>
<!-- Početna stranica pri ulogiravanju (ili klikom na ikonu MusicApp).
    Prikazuju se sve pjesme iz zadnje godine (u ovom slučaju 2019.), tj.
    ime pjesme, izvođač, zemlja, i dodatne akcije na pjesmu (dodaj, prikaži, plasman).
-->
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
    echo '<tr><th class="align-middle" style="font-size: 30px;  vertical-align: middle;" scope="row">'.$value->flag.'</th>';
    echo '<td class="align-middle" style=" vertical-align: middle;">'.$value->country.'</td>'.'<td class="align-middle" style=" vertical-align: middle;">'.$value->name.'</td>'.'<td class="align-middle" style=" vertical-align: middle;">'.$value->artist.'</td>';
    ?>
    <td>
        <div id=<?php echo $_SESSION['korisnik']; ?> class="align-middle" style="font-size: 30px; ">
            <!--Link koji dodaje pjesmu u playlistu. --> 
            <a value=<?php echo $value->id_song; ?> title="Dodaj u popis za reprodukciju" class="dodajPjesmu"><span class="glyphicon glyphicon-plus" style=" vertical-align: middle;"></span></a>&emsp;
            <!--Link koji za dani id pjesme otvara komentare i lajkove za tu pjesmu. -->
            <a title="Otvori pjesmu" href="music.php?rt=songs/showSong&id=<?php echo $value->id_song; ?>"><span class="glyphicon glyphicon-facetime-video" style=" vertical-align: middle;"></span></a>&emsp;
            <!--Ova otvara rezultate finala i polufinala te godine u kojoj je ta pjesma sudjelovala, te podebljava kliknutu pjesmu u dobivenim tablicama. -->
            <a title="Pogledaj plasman"href="music.php?rt=songs/plasman&id=<?php echo $value->id_song; ?>"><span class="glyphicon glyphicon-list" style=" vertical-align: middle;"></span></a>
        </div>
    </td>
    <?php
    echo '</tr>';

}
echo('</tbody></table>');

require_once __DIR__ . '/_footer.php';

?>
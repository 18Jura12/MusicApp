<!-- 
    Ovaj html prikazuje tablicu sa svim pjesmama koje su se natjecale za zadanu zemlju.
-->
<?php

require_once __DIR__ . '/home_header.php';

?>

<style>
    .themed-container {
        padding: 15px;
        margin-bottom: 30px;
        background-color: rgba(0, 123, 255, .15);
        border: 1px solid rgba(0, 123, 255, .2);
    }
</style>

<!-- Bootstrap-ov element koji smo koristili za naslov prikaza. U njemu se nalazi zastava i ime zadane zemlje. -->
<section class="jumbotron text-center">
    <div class="container">
      <h1><?php echo $songs[0]->flag; ?></h1>
      <p class="lead text-muted"><?php echo $songs[0]->country; ?></p>
    </div>
</section>

<script type="text/javascript" src="dodaj.js"></script>

<!-- Bootstrap-ova tablica koja prikazuje popis gore opisanih pjesama. Također sadrži i dodatne gumbe specifične za svaku pjesmu, za daljnje navigiranje po stranici -->
<table class="table">
<thead class="thead-dark">
    <tr>
        <th scope="col" style="vertical-align: middle;">Godina</th>
        <th scope="col" style=" vertical-align: middle;">Pjesma</th>
        <th scope="col" style=" vertical-align: middle;">Izvođač</th>
    </tr>
</thead>
<tbody>
<?php
foreach($songs as $value) {

    echo '<td class="align-middle" style=" vertical-align: middle;">'.$value->year.'</td>'.'<td class="align-middle" style=" vertical-align: middle;">'.$value->name.'</td>'.'<td class="align-middle" style=" vertical-align: middle;">'.$value->artist.'</td>';
    ?>
    <td>
        <div id=<?php echo $_SESSION['korisnik']; ?> class="align-middle" style="font-size: 30px; ">
            <a title="Dodaj u popis za reprodukciju" class="dodajPjesmu"><span class="glyphicon glyphicon-plus" style=" vertical-align: middle;"></span>&emsp;</a>
            <a title="Otvori pjesmu" href="music.php?rt=songs/showSong&id=<?php echo $value->id_song; ?>"><span class="glyphicon glyphicon-facetime-video" style=" vertical-align: middle;"></span>&emsp;</a>
            <a title="Pogledaj plasman"href="music.php?rt=songs/plasman&id=<?php echo $value->id_song; ?>"><span class="glyphicon glyphicon-list" style=" vertical-align: middle;"></span></a>
        </div>
    </td>
    <?php
    echo '</tr>';

}
echo('</tbody></table>');

require_once __DIR__ . '/_footer.php';

?>
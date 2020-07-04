<?php

require_once __DIR__ . '/home_header.php';


?>
<table class="table">
<thead class="thead-dark">
    <tr>
        <th scope="col" colspan="2">Zemlja</th>
        <th scope="col"></th>
        <th scope="col">Pjesma</th>
        <th scope="col">Izvođač</th>
    </tr>
</thead>
<tbody>
<?php
foreach($pjesme as $value) {

    //Ako ti se da pokušati poravnati vertikalno sve td-ove, bio bih ti beskrajno zahvalan, ali stvarno je gnjavaža i sve sam probao! Jučer sam se s tim gnjavio par sati...
    echo '<tr><th class="align-middle" style="font-size: 30px;" scope="row">'.$value->flag.'</th>';
    echo '<td class="align-middle">'.$value->country.'</td>'.'<td class="align-middle"><iframe height=180 width=320 src="'.$value->link_video.'"></iframe></td>'.'<td class="align-middle">'.$value->name.'</td>'.'<td class="align-middle">'.$value->artist.'</td>';
    ?>
    <td>
        <div style="font-size: 30px; " class="align-middle">
            <!--Ništa od funkcija na linkovima nije implementirano :D-->
            <!--Ova treba dodati pjesmu u playlistu-->
            <a href="music.php?rt=songs/add"><span class="glyphicon glyphicon-plus"></span></a><br>
            <!--Ova treba za dati id pjesme otvoriti komentare i lajkove za tu pjesmu unutar nekog prozorčića-->
            <a href="music.php?rt=messages/pop-up&id=<?php echo $value->id; ?>"><span class="glyphicon glyphicon-comment"></span></a><br>
            <!--Ova otvara rezultate finala i polufinala te godine u kojoj je ta pjesma sudjelovala, može i podebljati tu pjesmu u tablicama :)-->
            <a href="music.php?rt=songs/plasman&id=<?php echo $value->id; ?>"><span class="glyphicon glyphicon-list"></span></a>
        </div>
    </td>
    <?php
    echo '</tr>';

}
echo('</tbody></table>');

require_once __DIR__ . '/home_footer.php';

?>
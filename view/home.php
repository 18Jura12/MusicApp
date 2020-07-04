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

    // print('tu');
    // print_r($value);
    echo '<tr style="display: flex; justify-content: center; align-items: left;"><th style="font-size: 30px;" scope="row">'.$value->flag.'</th>';
    echo '<td>'.$value->country.'</td>'.'<td><iframe height=180 width=320 src="'.$value->link_video.'"></iframe></td>'.'<td>'.$value->name.'</td>'.'<td>'.$value->artist.'</td>';
    ?>
    <td>
        <div>
            <a href="music.php?rt=songs/add"><span class="glyphicon glyphicon-plus"></span></a>
            <a href="#"><span class="glyphicon glyphicon-comment"></span></a>
            <a href="#"><span class="glyphicon glyphicon-list"></span></a>
        </div>
    </td>
    <?php
    echo '</tr>';

}
echo('</tbody></table>');

require_once __DIR__ . '/home_footer.php';

?>
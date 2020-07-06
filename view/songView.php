<?php

require_once __DIR__ . '/home_header.php';

?>
 <script type="text/javascript" src="komentari.js"></script>
<style>
.themed-grid-col {
  padding-top: 15px;
  padding-bottom: 15px;
  background-color: rgba(86, 61, 124, .15);
  border: 1px solid rgba(86, 61, 124, .2);
}

.themed-container {
  padding: 15px;
  margin-bottom: 30px;
  background-color: rgba(0, 123, 255, .15);
  border: 1px solid rgba(0, 123, 255, .2);
}
</style>

<section class="jumbotron text-center">
    <div class="container">
      <h1><?php echo $song->name; ?></h1>
      <p class="lead text-muted"><?php echo $song->artist; ?></p>
      <br>
      <h2><?php echo $song->flag . ' ' . $song->country; ?></h2>
    </div>
</section>

<div style="text-align: center;">
    <iframe width="80%" height="425" src=<?php echo $song->link_video ?>>
    </iframe>
    <br>
    <br>
    <table width="80%" style="text-align: center; margin-left: 10%;">
        <tr >
            <th style="text-align: center; background-color: rgb(255, 163, 26); width: 20%;">Polufinale - mjesto</th>
            <th style="text-align: center; background-color: rgb(204, 122, 0); width: 20%;">Polufinale - bodovi</th>
            <th style="text-align: center; background-color: rgb(255, 163, 26); width: 20%;">Finale - mjesto</th>
            <th style="text-align: center; background-color: rgb(204, 122, 0); width: 20%;">Finale - bodovi</th>
        </tr>
        <tr>
            <td width="20%" style="text-align: center;"><?php if($song->semifinal === '-1') echo '-'; else echo $song->semifinal_place; ?></td>
            <td width="20%" style="text-align: center;"><?php if($song->semifinal === '-1') echo '-'; else echo $song->semifinal_points; ?></td>
            <td width="20%" style="text-align: center;"><?php if($song->final_place === '-1') echo '-'; else echo $song->final_place; ?></td>
            <td width="20%" style="text-align: center;"><?php if($song->final_place === '-1') echo '-'; else echo $song->final_points; ?></td>
        </tr>
    </table>
    <br>

    <div width="100%" style="text-align: center;">
        <h2>Komentari</h2>
        <div class="input-group" style="padding: 10px 15px; max-width: 100%;">
                <input id="Komentiraj" type="text" class="form-control" placeholder="Komentiraj...">
                <div class="input-group-btn">
                <button id="gumbKomentar" value=<?php echo $song->id_song; ?> class="btn btn-default" type="submit">
                    Dodaj!
                </button>
                </div>
            </div>
    </div>
    <br>


    <div id="divKomentari" style="text-align: left; margin-left: 2%; margin-right: 2%;">
        <?php 
            foreach( $komentari as $komentar ) {
        ?>
            <div><?php echo '<pre style="background-color: rgb(255, 235, 204);"><b><i>' . $komentar->username . '</i></b> (' . $komentar->date . '):<br><pre style="display: inline-block; background-color: rgb(255, 204, 128); width: 90%;">' . $komentar->content . '</pre>';
                echo '<span style="position: absolute; text-align: right; padding-right: 1%; padding-bottom: 1%; width: 10%;">';
                echo '<button class="lajkovi" title="thumbs_up" value=' . $komentar->id . '>&#128077; ' . $komentar->thumbs_up . '</button><br>';
                echo '<button class="lajkovi" title="thumbs_down" value=' . $komentar->id . '>&#128078; ' . $komentar->thumbs_down . '</button>';
                echo '</span></pre>';?></div>
            <?php
        }
        ?>
    </div>
</div>

<?php

require_once __DIR__ . '/home_footer.php';

?>
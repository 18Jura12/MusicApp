<?php

require_once __DIR__ . '/home_header.php';

?> 
<main role="main">

  <section class="jumbotron text-center">
    <div class="container">
      <h2>Popis za reprodukciju</h2>
      <p class="lead text-muted">Moj popis pjesama za slušanje</p>
    </div>
  </section>

    
    <div style="margin: auto; width: 80%; padding: 15px; display: flex;
        justify-content: center;
        align-items: center;">
        <input id="searchBar" class="form-control " type="text" placeholder="Upiši naziv pjesme" aria-label="Search" style="width: 80%;">
        <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Traži pjesmu!</button>
    </div>
    
    <br>

  <div class="album py-5 bg-light">
    <div class="container">

    <form action="music.php?rt=songs/playlist" method="POST">
    <div id="popis" class="row">
    <?php
    foreach( $songs as $song ) {
        $opis = $song->artist . ' - ' . $song->name;
        $value = '"' . $song->id_song . '"';
        ?>
        <div class="col-md-4">
            <iframe width="100%" height="225" src=<?php echo $song->link_video ?>>
            </iframe>
            <div class="card-body">
              <span class="card-text"><?php echo $opis; ?></span>
              <div class="btn-group" style="float: right;">
                  <button name="ukloni" type="submit" class="btn btn-sm btn-outline-secondary" value=<?php echo $value; ?> >Ukloni</button>
              </div>
            </div>
        </div>
        <?php
    }
    ?>
    </form>

  </div>

</main>

<?php

require_once __DIR__ . '/_footer.php';

?>
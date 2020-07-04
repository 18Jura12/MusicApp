<?php

require_once __DIR__ . '/home_header.php';

?> 
    <link rel="canonical" href="https://getbootstrap.com/docs/4.5/examples/album/">

    <!-- Bootstrap core CSS -->
<link href="../assets/dist/css/bootstrap.css" rel="stylesheet">

    <style>
      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
      }

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }
    </style>
    <!-- Custom styles for this template -->
    <link href="album.css" rel="stylesheet">
  </head>
  <body>

<main role="main">

  <section class="jumbotron text-center">
    <div class="container">
      <h2>Popis za reprodukciju</h2>
      <p class="lead text-muted">Moj popis pjesama za slušanje</p>
    </div>
  </section>

  <div class="album py-5 bg-light">
    <div class="container">

    <div class="row">
    <?php
    foreach( $songs as $song ) {
        $opis = $song->artist . ' - ' . $song->name;
        ?>
        <div class="col-md-4">
            <iframe width="100%" height="225" src=<?php echo $song->link_video ?>>
            </iframe>
            <div class="card-body">
              <span class="card-text"><?php echo $opis; ?></span>
              <div class="btn-group" style="float: right;">
                  <button type="button" class="btn btn-sm btn-outline-secondary">Ukloni</button>
              </div>
            </div>
        </div>
        <br>
        <br>
        <?php
    }
    ?>

  </div>

</main>

<?php

require_once __DIR__ . '/home_footer.php';

?>
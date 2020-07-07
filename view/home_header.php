<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <link rel="canonical" href="https://getbootstrap.com/docs/4.5/examples/album/">
    <link rel="canonical" href="https://getbootstrap.com/docs/4.5/examples/carousel/">
    <link rel="canonical" href="https://getbootstrap.com/docs/4.5/examples/grid/">
    <link rel="canonical" href="https://getbootstrap.com/docs/4.5/examples/radio/">
    <script type="text/javascript" src="search.js"></script>
    <link href="css/footer.css" rel="stylesheet">
    <link href="css/poredak.css" rel="stylesheet">

    <title>🎶 MusicApp</title>

    <nav class="navbar navbar-inverse">
        <div class="container-fluid">
            <div class="navbar-header">
                <a class="navbar-brand" href="music.php?rt=users/pocetna">🎶 MusicApp</a>
            </div>
            <ul class="nav navbar-nav">
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">Godina
                    <span class="caret"></span></a>
                    <ul class="dropdown-menu navbar-inverse">
                    <!--Ovdje bih trebao dohvatiti godine, to možeš u funkciji početna dohvatiti pa ovdje ispisati u opcije.
                    Link ide na stranicu sa pjesmama iz te godine, trebao bi na toj stranici biti gumb za poredak i gumb za 
                    ukupne bodove fanova, što je onaj komplicirani dio koji sam oslovio kasnije.-->
                        <?php
                        foreach($godine as $godina) {

                            echo '<li><a href="music.php?rt=users/pocetna&godina='.$godina.'">'.$godina.'</a></li>';

                        }
                        ?>
                    </ul>
                </li>
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">Zemlja
                    <span class="caret"></span></a>
                    <ul class="dropdown-menu navbar-inverse">
                    <!--Ovdje bih trebao dohvatiti zemlje, to možeš u funkciji početna dohvatiti pa ovdje ispisati u opcije, idealno sa zastavama-->
                        <?php
                        foreach($zemlje as $zemlja) {

                            echo '<li><a href="music.php?rt=songs/zemlja&zemlja='.$zemlja.'">'.$zemlja.'</a></li>';

                        }
                        ?>
                    </ul>
                </li>
                <li><a href="music.php?rt=songs/playlist">Moje pjesme</a></li>
                <!--Ako stignemo, jer sada kada sam malo razmislio o tome, dosta je komplicirano, ali imamo cijelu tablicu actions samo za to :)
                Treba tu napraviti dodjelu bodova tako da se pravilno dodijele i onda spremiti to sve u MusicActions i onda kada čitaš u fan bodovima
                poredak, to sve pozbrojiti... puno posla i puno prtljanja po stringovima baze, ali da se.-->
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">Moji bodovi
                    <span class="caret"></span></a>
                    <ul class="dropdown-menu navbar-inverse">
                    <!--Ovdje bih trebao dohvatiti godine, to možeš u funkciji početna dohvatiti pa ovdje ispisati u opcije.
                    Link ide na stranicu sa pjesmama iz te godine, trebao bi na toj stranici biti gumb za poredak i gumb za 
                    ukupne bodove fanova, što je onaj komplicirani dio koji sam oslovio kasnije.-->
                        <?php
                        foreach($godine as $godina) {

                            echo '<li><a href="music.php?rt=songs/bodovi&godina='.$godina.'">'.$godina.'</a></li>';

                        }
                        ?>
                        <li><a href="music.php?rt=songs/poredak&godina=2019">Poredak</a></li>
                    </ul>
                </li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li><a href="music.php?rt=users/logout"><span class="glyphicon glyphicon-log-out"></span> Odjava</a></li>
            </ul>

            <div class="input-group nav navbar-nav navbar-right" style="padding: 15px 15px; margin-right: -15px; margin-left: -15px; max-width: 120px;">
                <div style="color: white; margin-right: 15px; margin-left: 15px; width: 150%;"><strong><?php echo 'Bok, ' . $_SESSION['korisnik'] . '!'; ?>
                    </strong></div>
            </div>

            <!--Ovdje se možeš igrati sa tim pretragama po izvođačima i pjesmama. Fja nije implementirana SAMO PO PJESMAMA-->
            
            <div class="input-group nav navbar-nav navbar-right" style="padding: 10px 15px; margin-right: -15px; margin-left: -15px; max-width: 320px;">
                <input list="datalist_pjesme" id="searchBar" type="text" class="form-control" placeholder="Pretraga">
                <datalist id="datalist_pjesme"></datalist>
                <div class="input-group-btn">
                <button id="gumbPretraga" class="btn btn-default" type="submit">
                    <i class="glyphicon glyphicon-search"></i>
                </button>
                </div>
            </div>
            
        </div>
    </nav>
    <style>
        td {

            font-size: 20px;

        }
    </style>
</head>
<body>

<div class="zaglavlje">
    <table style="width: 100%;">
        <tr>
            <td style="width: 25%; padding: 1% 2%;">Predložene pjesme: </td>
            <?php 
            //print_r($popis);
            foreach( $popis as $value ) { 
                //print_r($value);
                $link = $value->name . '<br>' . $value->flag . '<br>' . $value->artist;
                echo '<td class="tdPredlozeni"><a href="music.php?rt=songs/showSong&id=' . $value->id_song . '">' . $link . '</a></td>';
            }
            ?>
        </tr>
    </table>
</div>
<br>
<br>
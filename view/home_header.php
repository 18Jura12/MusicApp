<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

    <title>🎶 MusicApp</title>

    <nav class="navbar navbar-inverse">
        <div class="container-fluid">
            <div class="navbar-header">
                <a class="navbar-brand" href="#">🎶 MusicApp</a>
            </div>
            <ul class="nav navbar-nav">
                <li class="active"><a href="#" id="home"><span class="glyphicon glyphicon-home"></span></a></li>
                <li><a href="#">Page 1</a></li>
                <li><a href="#">Page 2</a></li>
                <li><a href="music.php?rt=songs/playlist">Moj pjesme</a></li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li><a href="music.php?rt=users/logout"><span class="glyphicon glyphicon-log-out"></span> Odjava</a></li>
            </ul>
        </div>
    </nav>

    <style>
        td {

            font-size: 20px;

        }
    </style>
</head>
<body>
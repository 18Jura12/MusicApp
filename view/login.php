<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="css/login.css" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

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

</head>
<body>
    <form class="form-signin" action="music.php?rt=users/verifyLogin" method="POST">
        <div class="text-center mb-4">
            <h1 class="h3 mb-3 font-weight-normal">Glazbena aplikacija!</h1>
        </div>

        <div class="form-label-group">
            <input type="text" id="inputUsername" name="username" class="form-control" placeholder="Korisničko ime" required autofocus>
            <label for="inputUsername">Korisničko ime</label>
        </div>

        <div class="form-label-group">
            <input type="password" id="inputPassword" name="password"class="form-control" placeholder="Password" required>
            <label for="inputPassword">Lozinka</label>
        </div>

        <button id="gumbLogin" class="btn btn-lg btn-primary btn-block" type="submit" name="buttonLogin">Ulogiraj se!</button>
        <br>

        <p>
        <?php echo $message; ?>
        </p>

    </form>


    <form action="music.php?rt=users/register" method="POST">
    
        <div class="registracija">
            <p style="text-align:center;"> Nemaš još račun? Izradi ga! </p>
            <button id="gumbRegister" class="btn btn-lg btn-primary btn-block" type="submit" name="buttonRegister">Registriraj se!</button>
        </div>

    </form>
    
</body>
</html>
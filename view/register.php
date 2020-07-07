<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registracija</title>
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
      <!-- Forma za registraciju. 
          Korisnik popunjava formu, i pri uspješnom popunjavanju dobiva mail za potvrdu registracije.
      -->
    <form class="form-signin" action="music.php?rt=users/verifyRegister" method="POST">
        <div class="text-center mb-4">
            <h1 class="h3 mb-3 font-weight-normal">Registriraj se!</h1>
        </div>

        <div class="form-label-group">
            <input type="text" id="inputUsername" name="usernameReg" class="form-control" placeholder="Username" required autofocus>
            <label for="inputUsername">Odaberi korisničko ime</label>
        </div>

        <div class="form-label-group">
            <input type="password" id="inputPassword" name="passwordReg"class="form-control" placeholder="Password" required>
            <label for="inputPassword">Odaberi svoju lozinku</label>
        </div>

        <div class="form-label-group">
            <input type="email" id="inputEmail" name="mail" class="form-control" placeholder="Email address" required>
            <label for="inputEmail">E-mail adresa</label>
        </div>

        <div class="form-label-group">
            <input type="text" id="inputCountry" name="country" class="form-control" placeholder="Country" required>
            <label for="inputCountry">Država</label>
        </div>

        <button id="gumbStvoriRacun" class="btn btn-lg btn-primary btn-block" type="submit" name="buttonCreate">Stvori korisnički račun!</button>
        <br>

        <p>
          <?php echo $message; ?>
        </p>
    </form>
    
</body>
</html>
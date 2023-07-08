<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>CURL</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN"
    crossorigin="anonymous"></script>
</head>

<body class="bg-dark text-light">
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark border-bottom mb-5">
    <a class="navbar-brand ms-5" href="#">Zadanie 2</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
      aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav">
        <li class="nav-item active">
          <a class="nav-link" href="index.php">Jedálny lístok <span class="sr-only"></span></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="describeAPI.php">Popis API</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="useAPI.php">Overenie API</a>
        </li>
      </ul>
    </div>
  </nav>
  <div class="container">
    <h2>GET</h2>
    <h3>---------------</h3>
    <h3>Bez parametrov</h3>
    <h3>---------------</h3>
    <h5>Vráti JSON s jedlami, cenami, názvami reštauráciami a dňom</h5>
    <h3>---------------</h3>
    <br>
    <br>
    <h2>GET</h2>
    <h3>---------------</h3>
    <h3>Parametre: day - deň kedy sú konkrétne jedlá ponúkane</h3>
    <h3>---------------</h3>
    <h5>Vráti JSON s informácie o ponuke jedál pre konkrétny deň</h5>
    <h3>---------------</h3>
    <br>
    <br>
    <h2>PUT</h2>
    <h3>---------------</h3>
    <h3>Parametre: id - id jedla price - nová cena pre jedlo s id</h3>
    <h3>---------------</h3>
    <h5>Upraví cenu jedla s id</h5>
    <h3>---------------</h3>
    <br>
    <br>
    <h2>POST</h2>
    <h3>---------------</h3>
    <h3>Parametre: food - názov jedla price - cena jedla restaurant - kto dané jedlo ponúka</h3>
    <h3>---------------</h3>
    <h5>Pridá nové jedlo</h5>
    <h3>---------------</h3>
    <br>
    <br>
    <h2>DELETE</h2>
    <h3>---------------</h3>
    <h3>Parametre: restaurant - koho jedlo má byť vymazané</h3>
    <h3>---------------</h3>
    <h5>Vymaže všetky jedlá reštaurácie</h5>
    <h3>---------------</h3>
  </div>
</body>

</html>
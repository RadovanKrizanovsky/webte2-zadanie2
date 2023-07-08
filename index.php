<?php


require_once('config.php');

$db = new PDO("mysql:host=$hostname;dbname=$dbname", $username, $password);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);



function getPageContent($db, $url, $name)
{

  $ch = curl_init();

  curl_setopt($ch, CURLOPT_URL, $url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

  $output = curl_exec($ch);

  curl_close($ch);

  $sql = "INSERT INTO sites (name, html) VALUES (:name, :html)";
  $stmt = $db->prepare($sql);

  $stmt->bindParam(":name", $name, PDO::PARAM_STR);
  $stmt->bindParam(":html", $output, PDO::PARAM_STR);

  if ($stmt->execute()) {
  } else {
    echo "Ups. Nieco sa pokazilo";
  }
  unset($stmt);
}

function getMenuFromDB($db, $name)
{
  $page_content = "";
  $sql = "SELECT html FROM sites WHERE name = :name ORDER BY time_saved DESC LIMIT 1";

  $stmt = $db->prepare($sql);

  $stmt->bindParam(":name", $name, PDO::PARAM_STR);
  $stmt->execute();

  if ($stmt->rowCount() == 1) {
    $row = $stmt->fetch();
    $page_content = $row["html"];
  } else {
    echo "Nenachadza sa v tabulke alebo je duplicitne.";
  }

  return $page_content;
}

?>
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
  <div class="container d-flex justify-content-center">
    <form method="post">
      <button class="btn btn-secondary mx-5" onclick="getData()">GET</button>
      <button class="btn btn-secondary mx-5" id="buttonWeek">Týžďeň</button>
      <button class="btn btn-secondary mx-5" id="buttonMonday">Pondelok</button>
      <button class="btn btn-secondary mx-5" id="buttonTuesday">Utorok</button>
      <button class="btn btn-secondary mx-5" id="buttonWednesday">Streda</button>
      <button class="btn btn-secondary mx-5" id="buttonThursday">Štvrtok</button>
      <button class="btn btn-secondary mx-5" id="buttonFriday">Piatok</button>
    </form>
  </div>
  <div class="container">
    <div id="dataaaa"></div>
    <div id="whole">

    </div>
    <div class="row">
      <div class="col-sm border text-center">
        <h2>Venza</h2>
        <div id="venza" class="col-sm border text-center"></div>
        <?php
        ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// ROW 1
        
        ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// ROW 1
        ?>
      </div>
      <div class="col-sm border text-center">
        <h2>Druzba</h2>
        <div id="druzba" class="col-sm border text-center"></div>
        <?php
        ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// ROW 2
        
        ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// ROW 2
        ?>
      </div>
      <div class="col-sm border text-center">
        <h2>FreeFood</h2>
        <div id="freeFood" class="col-sm border text-center"></div>
        <?php
        ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// ROW 3
        
        ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// ROW 3
        ?>
      </div>
    </div>
  </div>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/1.3.4/axios.min.js"></script>
  <script>


    //WholeMenu();

    document.getElementById('buttonWeek').onclick = WholeMenu();
    document.getElementById('buttonMonday').onclick = monday();
    document.getElementById('buttonTuesday').onclick = WholeMenu();
    document.getElementById('buttonWednesday').onclick = WholeMenu();
    document.getElementById('buttonThursday').onclick = WholeMenu();
    document.getElementById('buttonFriday').onclick = WholeMenu();

    async function WholeMenu() {
      const mon = await axios.get('https://site139.webte.fei.stuba.sk/curlAndAPI/api.php?day=pondelok');
      const tue = await axios.get('https://site139.webte.fei.stuba.sk/curlAndAPI/api.php?day=utorok');
      const wed = await axios.get('https://site139.webte.fei.stuba.sk/curlAndAPI/api.php?day=streda');
      const thu = await axios.get('https://site139.webte.fei.stuba.sk/curlAndAPI/api.php?day=stvrtok');
      const fri = await axios.get('https://site139.webte.fei.stuba.sk/curlAndAPI/api.php?day=piatok');
      //console.log(mon.data)
      //const venza = document.getElementById('whole');

      const allDays = [mon, tue, wed, thu, fri];
      const dayNames = ["Pondelok", "Utorok", "Streda", "Štvrtok", "Piatok"];
      var dayIndex = 0;

      let Venzastring = '';
      let FreeFoodstring = '';
      let Druzbastring = '';

      allDays.forEach((day) => {
        Druzbastring += '<br>' + '<p>' + dayNames[dayIndex] + '</p>' + '<br>';
        Venzastring += '<br>' + '<p>' + dayNames[dayIndex] + '</p>' + '<br>';
        FreeFoodstring += '<br>' + '<p>' + dayNames[dayIndex] + '</p>' + '<br>';
        day.data.forEach((item) => {
          if (item.restaurant === "Cantina") {

            Druzbastring += '<p>' + item.food + " " + item.price + '</p>';

          } else if (item.restaurant === "Venza") {

            Venzastring += '<p>' + item.food + " " + item.price + '</p>';

          } else if (item.restaurant === "FREEFOOD") {

            FreeFoodstring += '<p>' + item.food + " " + item.price + '</p>';

          }

        });
        console.log(Druzbastring);
        dayIndex++;
      });
      document.getElementById('venza').innerHTML = Venzastring;
      document.getElementById('druzba').innerHTML = Druzbastring;
      document.getElementById('freeFood').innerHTML = FreeFoodstring;

      /*
      for (const day in allDays) {
        console.log("here");
        for (const item in day.data) {
            console.log(item);
            

        }
        */
      /*
        //console.log(items[item]);
        string += '<p>'  + items[item].food + '</p>';
        }
        //console.log(items[item]);
        string += '<p>'  + items[item].food + '</p>';
        */

    }

    async function monday() {
      const monTwo = await axios.get('https://site139.webte.fei.stuba.sk/curlAndAPI/api.php?day=pondelok');
      //console.log(mon.data)
      //const venza = document.getElementById('whole');

      const allDaysTwo = [monTwo];
      const dayNamesTwo = ["Pondelok", "Utorok", "Streda", "Štvrtok", "Piatok"];
      var dayIndexTwo = 0;

      let VenzastringTwo = '';
      let FreeFoodstringTwo = '';
      let DruzbastringTwo = '';

      allDaysTwo.forEach((dayTwo) => {
        DruzbastringTwo += '<br>' + '<p>' + dayNamesTwo[dayIndexTwo] + '</p>' + '<br>';
        VenzastringTwo += '<br>' + '<p>' + dayNamesTwo[dayIndexTwo] + '</p>' + '<br>';
        FreeFoodstringTwo += '<br>' + '<p>' + dayNamesTwo[dayIndexTwo] + '</p>' + '<br>';
        dayTwo.data.forEach((itemTwo) => {
          if (itemTwo.restaurant === "Cantina") {

            DruzbastringTwo += '<p>' + itemTwo.food + " " + itemTwo.price + '</p>';

          } else if (itemTwo.restaurant === "Venza") {

            VenzastringTwo += '<p>' + itemTwo.food + " " + itemTwo.price + '</p>';

          } else if (itemTwo.restaurant === "FREEFOOD") {

            FreeFoodstringTwo += '<p>' + itemTwo.food + " " + itemTwo.price + '</p>';

          }

        });
        console.log(DruzbastringTwo);
        dayIndexTwo++;
      });
      document.getElementById('venza').innerHTML = VenzastringTwo;
      document.getElementById('druzba').innerHTML = DruzbastringTwo;
      document.getElementById('freeFood').innerHTML = FreeFoodstringTwo;

      /*
      for (const day in allDays) {
        console.log("here");
        for (const item in day.data) {
            console.log(item);
            

        }
        */
      /*
        //console.log(items[item]);
        string += '<p>'  + items[item].food + '</p>';
        }
        //console.log(items[item]);
        string += '<p>'  + items[item].food + '</p>';
        */

    }
  </script>
</body>

</html>
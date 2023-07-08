<?php



ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once('config.php');
$db = new PDO("mysql:host=$hostname;dbname=$dbname", $username, $password);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
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
            <input type="submit" name="buttonDownload" value="Stiahni" class="btn btn-secondary mx-5" />
            <input type="submit" name="buttonParse" value="Rozparsuj" class="btn btn-secondary mx-5" />
            <input type="submit" name="buttonDelete" value="Vymaž" class="btn btn-secondary mx-5" />
        </form>
    </div>
    <div class="d-flex justify-content-center">
        <form class="m-5">

            <label for="mealInsert">Food:</label>
            <input type="text" id="mealInsert"><br>

            <label for="cash">Price:</label>
            <input type="text" id="cash"><br>

            <label for="place">Restaurant:</label>
            <input type="text" id="place"><br>


            <button type="button" onclick="makeFood()">Create Data</button>
        </form>
        <br>
        <form class="m-5">
            <label for="mealID">Food ID:</label>
            <input type="text" id="mealID"><br>

            <label for="cash">New Price:</label>
            <input type="text" id="newcash"><br>

            <button type="button" onclick="uptDt()">Update Data</button>
        </form>

        <form class="m-5">
            <label for="restaurantToDelete">Delete:</label>
            <input type="text" id="restaurantToDelete"><br>

            <button type="button" onclick="delRest()">Delete Data</button>
        </form>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/1.3.4/axios.min.js"></script>
    <script>
        async function makeFood() {

            const food = document.getElementById('mealInsert').value;
            const price = document.getElementById('cash').value;
            const restaurant = document.getElementById('place').value;

            var dayz = ["pondelok", "utorok", "streda", "štvrtok", "piatok"];
            var res = await axios.post(`api.php?food=${food}&price=${price}&restaurant=${restaurant}`);
            console.log(res.data);
            alert("done");
        }


        async function uptDt() {
            const foodId = document.getElementById('mealID').value;
            const price = document.getElementById('newcash').value;
            const res = await axios.put(`api.php?id=${foodId}&price=${price}`);
            alert("done");
        }

        async function delRest() {
            const restaurant = document.getElementById('restaurantToDelete').value;
            const res = await axios.delete(`api.php?restaurant=${restaurant}`);
            alert("done")
        }

    </script>
</body>

</html>

<?php

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

//////////////////////////////////////////BUTTONS



if (array_key_exists('buttonDownload', $_POST)) {
    getPageContent($db, "http://www.freefood.sk/menu/#fayn-food", "free-food");
    getPageContent($db, "https://www.druzbacatering.sk/jedalny-listok/", "druzba");
    getPageContent($db, "https://www.novavenza.sk/tyzdenne-menu", "venza");
} else if (array_key_exists('buttonParse', $_POST)) {
    buttonParse($db);
} else if (array_key_exists('buttonDelete', $_POST)) {
    buttonDelete($db);
}
function buttonDelete($db)
{
    $sql = "DELETE FROM sites";
    $stmt = $db->prepare($sql);
    if ($stmt->execute()) {

    } else {
        echo "bad";
    }
    unset($stmt);

    $sql = "DELETE FROM parsed";
    $stmt = $db->prepare($sql);

    if ($stmt->execute()) {

    } else {
        echo "bad";
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
        echo "Not in table";
    }

    return $page_content;

}

function buttonParse($db)
{


    $sql = "DELETE FROM parsed";
    $stmt = $db->prepare($sql);

    if ($stmt->execute()) {

    } else {
        echo "bad";
    }
    unset($stmt);


    $freeFoodHTML = getMenuFromDB($db, "free-food");
    $druzbaHTML = getMenuFromDB($db, "druzba");
    $venzaFoodHTML = getMenuFromDB($db, "venza");

    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// FREE-FOOD

    // Parsovanie pomocou DOMXPath
    $dom = new DOMDocument();
    @$dom->loadHTML($freeFoodHTML);
    $xpath = new DOMXPath($dom);


    $menu_lists = $xpath->query('//ul[contains(@class, "daily-offer")]');
    echo "menu list";
    echo $menu_lists[1]->textContent;

    $fayn_food = $menu_lists[1];

    foreach ($fayn_food->childNodes as $day) {

        if ($day->nodeType === XML_ELEMENT_NODE) {

            $datum = explode(',', $day->firstElementChild->textContent);
            echo $day->firstElementChild->textContent;

            foreach ($day->lastElementChild->childNodes as $ponuka) {

                $typ = $ponuka->firstElementChild;
                $cena = $ponuka->lastElementChild;

                $ponuka->removeChild($typ); // Vymazanie por. cisla
                $ponuka->removeChild($cena); // Vymazanie ceny



                $sql = "INSERT INTO parsed (food, price, restaurant, day, image) VALUES (:food, :price, :restaurant, :day, :image)";
                $stmt = $db->prepare($sql);

                $food = $ponuka->textContent;
                $price = $cena->textContent;
                $restaurant = "FREEFOOD";
                $day = $datum[0];
                $image = null;

                $stmt->bindParam(":food", $food, PDO::PARAM_STR);
                $stmt->bindParam(":price", $price, PDO::PARAM_STR);
                $stmt->bindParam(":restaurant", $restaurant, PDO::PARAM_STR);
                $stmt->bindParam(":day", $day, PDO::PARAM_STR);
                $stmt->bindParam(":image", $image, PDO::PARAM_STR);

                if ($stmt->execute()) {
                } else {
                    echo "Ups. Nieco sa pokazilo";
                }
                unset($stmt);

            }


        }

    }

    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// FREE-FOOD




    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// VENZA
    @$dom->loadHTML($venzaFoodHTML);


    $h5ss = $dom->getElementsByTagName('h5');

    $remove = ["Menu 1", "Menu 2", "Jedlo týždňa", "Polievka", "Vege", "Menu 3", "Menu 4", "Múčne", "Šalát"];

    $foods = array();
    $prices = array();

    foreach ($h5ss as $h5tagss) {
        if (in_array($h5tagss->nodeValue, $remove)) {
            $h5tagss->parentNode->removeChild($h5tagss);
        }
    }
    $counter = 0;
    foreach ($h5ss as $h5tagss) {
        if ($counter % 2 == 0) {
            $foods[] = $h5tagss->nodeValue;
        } else {
            $prices[] = $h5tagss->nodeValue;
        }
        $counter++;
    }
    $dayz = ["pondelok", "utorok", "streda", "štvrtok", "piatok"];
    $cntr1 = 1;
    $cntr2 = 0;
    for ($i = 0; $i < count($foods); $i++) {
        $name = "Venza";
        $day = $dayz[$cntr2];
        if ($cntr1 == 10) {
            $cntr1 = 0;
            $cntr2++;
        }

        $image = null;
        $sql = "INSERT INTO parsed (food, price, restaurant, day, image) VALUES (:food, :price, :restaurant, :day, :image)";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(":food", $foods[$i]);
        $stmt->bindParam(":price", $prices[$i]);
        $stmt->bindParam(":restaurant", $name);
        $stmt->bindParam(":day", $day);
        $stmt->bindParam(":image", $image);
        $stmt->execute();






        $cntr1++;
    }


    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// VENZA

    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// DRUZBA
    @$dom->loadHTML($druzbaHTML);

    $emAllTags = $dom->getElementsByTagName('em');

    $remove = ["III. ", "ll ", "I", "III", "III ", "0,33l ", "0,33l ", "I ", "II"];

    $foods = array();
    $prices = array();

    foreach ($emAllTags as $emMainTag) {
        if (in_array($emMainTag->nodeValue, $remove)) {
            $emMainTag->parentNode->removeChild($emMainTag);
        }
    }
    $remove2 = ["0,33l ", "I", " "];
    foreach ($emAllTags as $emMainTag) {
        if (in_array($emMainTag->nodeValue, $remove2)) {
            $emMainTag->parentNode->removeChild($emMainTag);
        }
    }
    $remove3 = ["ll"];
    foreach ($emAllTags as $emMainTag) {
        if (in_array($emMainTag->nodeValue, $remove3)) {
            $emMainTag->parentNode->removeChild($emMainTag);
        }
    }

    $counter = 0;
    foreach ($emAllTags as $emMainTag) {
        echo $emMainTag->nodeValue . "<br>";
        $foods[] = $emMainTag->nodeValue;
    }

    $dayz = ["pondelok", "utorok", "streda", "štvrtok", "piatok"];
    $cntr1 = 1;
    $cntr2 = 0;
    for ($i = 0; $i < count($foods); $i++) {
        $name = "Cantina";
        $day = $dayz[$cntr2];
        $price = "4,20€/5.70€";
        if ($i % 4 == 0) {
            $price = "v cene menu";
        }
        if ($cntr1 == 4) {
            $cntr1 = 0;
            $cntr2++;
        }
        $image = null;
        $sql = "INSERT INTO parsed (food, price, restaurant, day, image) VALUES (:food, :price, :restaurant, :day, :image)";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(":food", $foods[$i]);
        $stmt->bindParam(":price", $price);
        $stmt->bindParam(":restaurant", $name);
        $stmt->bindParam(":day", $day);
        $stmt->bindParam(":image", $image);
        $stmt->execute();
        $cntr1++;
    }

}

?>
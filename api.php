<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

require_once('config.php');
$db = new PDO("mysql:host=$hostname;dbname=$dbname", $username, $password);

switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        $day = $_GET;

        if (empty($day['day'])) {
            read_food($db);
        } else {
            //echo "here";
            read_food_by_day($db, $day);
        }
        break;
    case 'POST':
        create_food_entry($db, $_GET);
        break;
    case 'PUT':
        update_food_price($db, $_GET, $_PUT);
        break;
    case 'DELETE':
        $restaurant = $_GET['restaurant'];
        delete_parsed($db, $restaurant);
        break;
}

function read_food($db)
{
    $stmt = $db->query('SELECT * from parsed;');
    $foods = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($foods);
}

function read_food_by_day($db, $day)
{
    $stmt = $db->query('SELECT * from parsed WHERE day = "' . $day['day'] . '";');
    $foods = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($foods);
}


function create_food_entry($db, $data)
{
    $days = array("pondelok", "utorok", "streda", "štvrtok", "piatok", "sobota", "nedeľa");
    for ($i = 0; $i < 7; $i++) {
        $image = null;
        $sql = "INSERT INTO parsed (food, price, restaurant, day, image) VALUES (:food, :price, :restaurant, :day, :image)";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(":food", $data['food']);
        $stmt->bindParam(":price", $data['price']);
        $stmt->bindParam(":restaurant", $data['restaurant']);
        $stmt->bindParam(":day", $days[$i]);
        $stmt->bindParam(":image", $image);
        $stmt->execute();
        echo json_encode(array('success' => 'Data created successfully'));
    }
}

function update_food_price($db)
{
    $stmt = $db->prepare('UPDATE parsed SET price = :price WHERE id = :id;');
    $stmt->bindParam(':id', $_GET['id']);
    $stmt->bindParam(':price', $_GET['price']);
    $stmt->execute();
    echo json_encode(array('success' => 'Data update'));
}

function delete_parsed($db, $restaurant)
{
    if (!isEmpty($restaurant)) {
        echo json_encode(array('error' => 'Delete error'));
        http_response_code(400);
        return;
    } else {
        $stmt = $db->prepare('DELETE FROM parsed WHERE restaurant = :restaurant');
        $stmt->bindParam(':restaurant', $restaurant);
        $stmt->execute();
        echo json_encode(array('success' => 'Data delete!'));
    }
}

function isEmpty($variable)
{

    if (empty($variable)) {
        $ok = false;
    } else {
        $ok = true;
    }

    return $ok;
}
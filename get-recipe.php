<?php
$mysqli = new mysqli("sql103.infinityfree.com", "if0_38809133", "W3gliX0QZba7", "if0_38809133_recipe_site");
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

$type = $_GET['type'] ?? 'day';

$result = $mysqli->query("SELECT COUNT(*) AS total FROM recipes");
$row = $result->fetch_assoc();
$total = $row['total'];

if ($total === 0) {
    echo json_encode(["error" => "No recipes found"]);
    exit;
}

if ($type === 'day') {
    $dateNumber = date("Ymd"); // stay the same for whole day
    $id = (int)($dateNumber) % $total;
} else {
    //  random type
    $id = rand(0, $total - 1);
}

$recipe = $mysqli->query("SELECT * FROM recipes LIMIT $id, 1")->fetch_assoc();

header('Content-Type: application/json');
echo json_encode($recipe);
?>
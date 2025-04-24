<?php
$mysqli = new mysqli("sql103.infinityfree.com", "if0_38809133", "W3gliX0QZba7", "if0_38809133_recipe_site");
if ($mysqli->connect_error) {
    die("Database connection failed: " . $mysqli->connect_error);
}

$type = $_GET['type'] ?? 'day';

$result = $mysqli->query("SELECT COUNT(*) AS total FROM recipes");
if (!$result) {
    die("Error: Failed to fetch recipe count. " . $mysqli->error);
}

$row = $result->fetch_assoc();
$total = $row['total'] ?? 0;

if ($total === 0) {
    die(json_encode(["error" => "No recipes found"]));
}

if ($type === 'day') {
    $dateNumber = date("Ymd");
    $id = (int)($dateNumber) % $total;
} else {
    $id = rand(0, $total - 1);
}

$recipe = $mysqli->query("SELECT * FROM recipes LIMIT $id, 1");
if (!$recipe) {
    die("Error: Failed to fetch the recipe. " . $mysqli->error);
}

$recipeData = $recipe->fetch_assoc();
if (!$recipeData) {
    die(json_encode(["error" => "Recipe not found"]));
}

header('Content-Type: application/json');
echo json_encode($recipeData);

$mysqli->close();
?>
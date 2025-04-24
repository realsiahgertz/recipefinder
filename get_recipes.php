<?php
$mysqli = new mysqli("sql103.infinityfree.com", "if0_38809133", "W3gliX0QZba7", "if0_38809133_recipe_site");
if ($mysqli->connect_error) {
    die("Database connection failed: " . $mysqli->connect_error);
}

$result = $mysqli->query("SELECT * FROM recipes");
if (!$result) {
    die("Error: Failed to fetch recipes. " . $mysqli->error);
}

$recipes = [];
while ($row = $result->fetch_assoc()) {
    $recipes[] = $row;
}

header('Content-Type: application/json');
echo json_encode($recipes);

$mysqli->close();
?>
<?php
$mysqli = new mysqli("sql103.infinityfree.com", "if0_38809133", "W3gliX0QZba7", "if0_38809133_recipe_site");
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

$title = $_POST['title'];
$description = $_POST['description'];
$image = $_POST['image'];
$tags = $_POST['tags'];
$page = $_POST['page'];

// insert new line into the recipe table
$stmt = $mysqli->prepare("INSERT INTO recipes (title, description, image, tags, page) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("sssss", $title, $description, $image, $tags, $page);
$stmt->execute();

$stmt->close();
$mysqli->close();

header("Location: catalog.php");
exit();
?>
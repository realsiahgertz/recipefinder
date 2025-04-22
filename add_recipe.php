<?php
$mysqli = new mysqli("localhost", "root", "", "recipe_site");
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

$title = $_POST['title'];
$description = $_POST['description'];
$image = $_POST['image'];
$tags = $_POST['tags'];
$page = $_POST['page'];

$stmt = $mysqli->prepare("INSERT INTO recipes (title, description, image, tags, page) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("sssss", $title, $description, $image, $tags, $page);
$stmt->execute();

$stmt->close();
$mysqli->close();

header("Location: catalog.php");
exit();
?>
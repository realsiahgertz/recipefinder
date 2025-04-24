<?php
$mysqli = new mysqli("sql103.infinityfree.com", "if0_38809133", "W3gliX0QZba7", "if0_38809133_recipe_site");
if ($mysqli->connect_error) {
    die("Database connection failed: " . $mysqli->connect_error);
}

$title = $_POST['title'] ?? '';
$description = $_POST['description'] ?? '';
$image = $_POST['image'] ?? '';
$tags = $_POST['tags'] ?? '';
$page = $_POST['page'] ?? '';

if (empty($title) || empty($description) || empty($page)) {
    die("Error: Missing required fields. Please fill out all required fields.");
}

// Insert new line into the recipe table
$stmt = $mysqli->prepare("INSERT INTO recipes (title, description, image, tags, page) VALUES (?, ?, ?, ?, ?)");
if (!$stmt) {
    die("Error: Failed to prepare the database query. " . $mysqli->error);
}
$stmt->bind_param("sssss", $title, $description, $image, $tags, $page);
if (!$stmt->execute()) {
    die("Error: Failed to execute the database query. " . $stmt->error);
}

$stmt->close();
$mysqli->close();

header("Location: catalog.php");
exit();
?>
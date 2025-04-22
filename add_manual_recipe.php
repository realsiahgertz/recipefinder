<?php
$mysqli = new mysqli("localhost", "root", "", "recipe_site");
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $image = $_POST['image'];
    $tags = $_POST['tags'];
    $ingredients = $_POST['ingredients'];
    $directions = $_POST['directions'];

    // Save the manual recipe as a new page
    $page = "recipes/" . strtolower(str_replace(' ', '-', $title)) . ".html";
    $recipePageContent = "
<!doctype html>
<html>
<head>
    <title>$title</title>
    <link rel='stylesheet' href='../styles/styles.css'>
    <link rel='stylesheet' href='../styles/backgrounds.css'>
</head>
<body>
    <h1>$title</h1>
    <h2>Ingredients</h2>
    <ul>
        " . implode("\n", array_map(fn($item) => "<li>$item</li>", explode("\n", $ingredients))) . "
    </ul>
    <h2>Directions</h2>
    <ol>
        " . implode("\n", array_map(fn($step) => "<li>$step</li>", explode("\n", $directions))) . "
    </ol>
</body>
</html>
";
    file_put_contents($page, $recipePageContent);

    // Insert into database
    $stmt = $mysqli->prepare("INSERT INTO recipes (title, description, image, tags, page) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $title, $description, $image, $tags, $page);
    $stmt->execute();

    $stmt->close();
    $mysqli->close();

    echo "Manual recipe added successfully: $title";

    header("Location: catalog.php");
    exit();
} else {
    echo "Invalid request method.";
}
?>
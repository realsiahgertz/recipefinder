<?php
$mysqli = new mysqli("sql103.infinityfree.com", "if0_38809133", "W3gliX0QZba7", "if0_38809133_recipe_site");
// $mysqli = new mysqli("localhost", "root", "", "recipe_site");
if ($mysqli->connect_error) {
    die("Database connection failed: " . $mysqli->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'] ?? '';
    $description = $_POST['description'] ?? '';
    $image_source = $_POST['image_source'] ?? 'url';
    $image = $_POST['image'] ?? '';
    $tags = $_POST['tags'] ?? '';
    $ingredients = $_POST['ingredients'] ?? '';
    $directions = $_POST['directions'] ?? '';

    if (empty($title) || empty($description) || empty($ingredients) || empty($directions)) {
        die("Error: Missing required fields. Please fill out all required fields.");
    }

    // If no image provided, use a default
    if (empty($image)) {
        $image = "images/default-food.jpg";
    }

    // Save the manual recipe as a new page
    $page = "recipes/" . strtolower(str_replace(' ', '-', $title)) . ".html";
    $recipePageContent = "
<!doctype html>
<html>
<head>
    <title>$title</title>
    <link rel='stylesheet' href='../styles/styles.css'>
    <link rel='stylesheet' href='../styles/backgrounds.css'>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
</head>
<body>
    <nav class='navbar'>
        <ul class='nav navbar-nav'>
            <li><a href='../index.html'>Home</a></li>
            <li><a href='../about.html'>About</a></li>
            <li><a href='../catalog.php'>Catalog</a></li>
            <li><a href='../add-recipe.html'>Add Recipe</a></li>
        </ul>
        <h2>Recipe Finder</h2>
        <img src='../images/favicon.ico' alt='Recipe Finder logo' class='logo'>
    </nav>

    <header id='" . strtolower(str_replace(' ', '-', $title)) . "' style='background-image: url(\"$image\"); background-size: cover; background-position: center; height: 200px;'>
    </header>

    <div class='center_text'>
        <h1>$title</h1>
        <h2>Description</h2>
        <p>$description</p>
        <h2>Ingredients</h2>
        <ul>
            " . implode("\n", array_map(fn($item) => "<li>$item</li>", explode("\n", $ingredients))) . "
        </ul>
        <h2>Directions</h2>
        <ol>
            " . implode("\n", array_map(fn($step) => "<li>$step</li>", explode("\n", $directions))) . "
        </ol>
    </div>

    <footer>
        <p>&copy; 2025 Justin Gumbis & Siah Gertz. All rights reserved.</p>
    </footer>
</body>
</html>
";
    if (!file_put_contents($page, $recipePageContent)) {
        die("Error: Failed to save the recipe page.");
    }

    // Insert into database
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
} else {
    die("Invalid request method.");
}
?>
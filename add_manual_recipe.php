<?php
// $mysqli = new mysqli("localhost", "root", "", "recipe_site"); local XAMPP use only
$mysqli = new mysqli("sql103.infinityfree.com", "if0_38809133", "W3gliX0QZba7", "if0_38809133_recipe_site");
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
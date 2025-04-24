<?php // database connection lines
$host = "sql103.infinityfree.com";
$username = "if0_38809133";
$password = "W3gliX0QZba7";
$dbname = "if0_38809133_recipe_site";

// $host = "localhost";
// $username = "root";
// $password = "";
// $dbname = "recipe_site";

$conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$stmt = $conn->query("SELECT * FROM recipes");
$recipes = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!doctype html>
<html>

<head>
    <link rel="icon" href="images/favicon.ico" type="image/x-icon" />
    <title>Catalog</title>
    <link rel="stylesheet" href="styles/styles.css">
    <link rel="stylesheet" href="styles/backgrounds.css">
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>

<body>
    <nav class="navbar">
        <ul class="nav navbar-nav">
            <li><a href="index.html">Home</a></li>
            <li><a href="about.html">About</a></li>
            <li class="active"><a href="#">Catalog</a></li>
            <li><a href="add-recipe.html">Add Recipe</a></li>
        </ul>
        <h2>Recipe Finder</h2>
        <img src="images/favicon.ico" alt="Recipe Finder logo" class="logo">
    </nav>

    <header id="food-array">
    </header>

    <div class="center_text">
        <h1>Catalog</h1>
        <input type="text" id="searchInput" placeholder="Search recipes..." onkeyup="filter(event)"
            style="width: 100%; padding: 10px; margin-bottom: 20px; border: 1px solid var(--line-divider); border-radius: 4px;" />
        <h2>Filter by tag</h2>
        <div id="tag-filter">
            <button onclick="filterByTag('breakfast')" class="btn">Breakfast</button>
            <button onclick="filterByTag('lunch')" class="btn">Lunch</button>
            <button onclick="filterByTag('dinner')" class="btn">Dinner</button>
            <button onclick="filterByTag('dessert')" class="btn">Dessert</button>
            <button onclick="filterByTag('all')" class="btn">Show All</button>
        </div>

        <div id="recipe-container" class="center_text">
            <?php foreach ($recipes as $recipe): ?> <!--This is where we create the recipe cards using php instead of hard coding them -->
                <a href="<?= $recipe['page'] ?>" class="recipe-card-link <?= $recipe['tags'] ?>">
                    <section class="recipe-card">
                        <img src="<?= $recipe['image'] ?>" />
                        <div>
                            <h3><?= htmlspecialchars($recipe['title']) ?></h3>
                            <p class="description"><?= htmlspecialchars($recipe['description']) ?></p>
                        </div>
                    </section>
                </a>
            <?php endforeach; ?>
        </div>
    </div>

    <footer>
        <p>
        <p>&copy; 2025 Justin Gumbis & Siah Gertz. All rights reserved.</p>
        </p>
    </footer>
    <script src="script.js">
    </script>
</body>

</html>
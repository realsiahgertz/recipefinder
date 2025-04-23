"# recipefinder"

Our main changes we wanted to make were ones that made everything more dynamic and less hardcoded. So before we had hardcoded recipes
and now we have fully dynamic recipe cards being created.

About.html is a simple about page for the developers.

Catalog.php is our big change, we now get the recipes from our database and display them the same way, except instead of our own
recipie page and instructions, we now use a link to an external site for the recipe. This way, people can use our site to gather
all their favorite recipes from around the internet into one place--RecipeFinder.

Add-recipe.html is a simple form page where people can submit data for a new recipe. Links for images must me correct in order
for the images to show correctly on the catalog page.

How we did it:
Found a website to host a subdomain for free (InfinityFree), after that I was able to create a MySQL table inside their services and 
see it using phpMyAdmin just like from XAMPP. After that we uploaded our project files into their online htdocs folder and then used
the link they gave us to see the website deployed.

First changed Catalog.html and had to turn it into a php file so we could use the database and generate dynamic recipe cards.

Add_recipe.php allowed us to INSERT new entries into our database table. We also implemented some basic error handling in case
the connection was bad.

get_recipes.php (not get-recipe.php) was made to for catalog page to retrieve all the recipes in the table at once when the page loads.
This page again uses basic error handling in case there is a bad connection.

get-recipe.php was made so that index.html can retrieve a recipe of the day and a random recipe whenerver the button was clicked.
More besic error handling.

add_manual_recipe.php was created so the user could choose between adding a recipe from another site or a recipe where they input all
the ingredients and instructions themselves. 

If we had more time, it would be a good idea to use user authentication so not everyone visiting the site could just add recipes to it.
So lets just say that anyone could see and interact with our site even if they are not logged in, but if they wanted to add a recipe 
they would have to log in first. 
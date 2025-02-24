function updateTotalRecipes() {
  fetch('catalog.html')
      .then(response => response.text())
      .then(text => {
          const parser = new DOMParser();
          const doc = parser.parseFromString(text, 'text/html');
          const recipeCards = doc.querySelectorAll('.recipe-card');
          const totalRecipes = recipeCards.length;
          localStorage.setItem('totalRecipes', totalRecipes);
          return totalRecipes;
      })
      .catch(error => {
          console.error('Error loading recipe count:', error);
          return 5; // fallback default
      });
}

function getTotalRecipes() {
  return parseInt(localStorage.getItem('totalRecipes')) || 4;
}

function getRandomRecipe() {
    const recipeOfDayId = generateRecipeOfDayId();
    let randomId = recipeOfDayId;
    do {
        randomId = Math.floor(Math.random() * getTotalRecipes());
    }
    while (randomId == recipeOfDayId);

  fetch('catalog.html')
      .then(response => response.text())
      .then(text => {
          let parser = new DOMParser();
          let doc = parser.parseFromString(text, 'text/html');
          let element = doc.getElementById(randomId.toString());
         
          if (element) {
              document.getElementById("random-recipe").innerHTML = element.outerHTML;
          } else {
              document.getElementById("random-recipe").innerHTML = "Recipe not found";
          }
      })
      .catch(error => {
          document.getElementById("random-recipe").innerHTML = "Error loading recipe";
          console.error("Error:", error);
      });
}

function recipeOfDay() {
    const id = generateRecipeOfDayId();
    // console.log("dateNumber: ", dateNumber);
    console.log("maxId: ", getTotalRecipes());
    console.log("ID: ", id);
    fetch('catalog.html')
        .then(response => response.text())
        .then(text => {
            let parser = new DOMParser();
            let doc = parser.parseFromString(text, 'text/html');
            let element = doc.getElementById(id.toString());
            
            if (element) {
                document.getElementById("demo").innerHTML = element.outerHTML;
            } else {
                document.getElementById("demo").innerHTML = "Recipe not found";
            }
        })
        .catch(error => {
            document.getElementById("demo").innerHTML = "Error loading recipe";
            console.error("Error:", error);
        });
}

function generateRecipeOfDayId() {
    const date = new Date();
    const dateNumber = date.getDate()+date.getMonth()+date.getFullYear();
    const id = dateNumber % getTotalRecipes();
    return id;
}

function filter(event) {
  const searchTerm = event.target.value.toLowerCase();
  
  const recipeCards = document.querySelectorAll('.recipe-card');

  console.log("Search term: " + searchTerm);
    console.log("Recipe cards: " + recipeCards);
  
  recipeCards.forEach(card => {
      const cardWrapper = card.parentElement;
      
      const title = card.querySelector('h3').textContent.toLowerCase();
      
      if (title.includes(searchTerm)) {
          cardWrapper.style.display = '';
      } else {
          cardWrapper.style.display = 'none';
      }
  });
}

function filterByTag(category) {
    document.querySelectorAll('.recipe-card').forEach(card => {
        const cardWrapper = card.parentElement;
        cardWrapper.style.display = 'none';
    });
    
    console.log("Category: " + category);
    
    if (category === 'all') {
        document.querySelectorAll('.recipe-card').forEach(card => {
            const cardWrapper = card.parentElement;
            cardWrapper.style.display = '';
        });
    } else {
        const matchingRecipes = document.querySelectorAll('.' + category);
        matchingRecipes.forEach(card => {
            card.style.display = '';
        });
    }
}

function test() {
    console.log("Test");
}

document.addEventListener('DOMContentLoaded', () => {
  updateTotalRecipes();
  recipeOfDay();
});
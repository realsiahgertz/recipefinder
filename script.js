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
  const randomId = Math.floor(Math.random() * getTotalRecipes());
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
  const date = new Date();
  const dateNumber = date.getDate()+date.getMonth()+date.getFullYear();
  const id = dateNumber % getTotalRecipes();
  console.log("dateNumber: ", dateNumber);
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

function filter(event) {
  const searchTerm = event.target.value.toLowerCase();
  
  const recipeCards = document.querySelectorAll('.recipe-card');
  
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

document.addEventListener('DOMContentLoaded', () => {
  updateTotalRecipes();
  recipeOfDay();
});
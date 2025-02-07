function recipeOfDay(maxId) {
    const date = new Date();
    const dateNumber = date.getDate();
    const id = date.getDate()*date.getMonth()*date.getFullYear() % maxId + 1;
    console.log("Id: ", id);

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
function recipeOfDay(maxId) {
    const date = new Date();
    const dateNumber = date.getDate();
    const id = (date.getDate()+date.getMonth()+date.getFullYear()) % maxId + 1;
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

function trackVisit(recipeId) {
  const now = Date.now();
  const visits = JSON.parse(localStorage.getItem('recipeVisits') || '{}');
  
  for (let id in visits) {
      visits[id] = visits[id].filter(timestamp => 
          now - timestamp < 3600000
      );
  }
  
  if (!visits[recipeId]) {
      visits[recipeId] = [];
  }
  visits[recipeId].push(now);
  
  localStorage.setItem('recipeVisits', JSON.stringify(visits));
}

function getTrendingRecipe() {
  const visits = JSON.parse(localStorage.getItem('recipeVisits') || '{}');
  let maxVisits = 0;
  let trendingId = null;
  
  for (let id in visits) {
      const recentVisits = visits[id].length;
      if (recentVisits > maxVisits) {
          maxVisits = recentVisits;
          trendingId = id;
      }
  }
  
  return trendingId;
}

function displayTrendingRecipe() {
  const trendingId = getTrendingRecipe() || '1';
  
  fetch('catalog.html')
      .then(response => response.text())
      .then(text => {
          const parser = new DOMParser();
          const doc = parser.parseFromString(text, 'text/html');
          const element = doc.getElementById(trendingId);
          
          if (element) {
              const trendingDiv = document.getElementById('trending');
              if (trendingDiv) {
                  const clonedElement = element.cloneNode(true);
                  trendingDiv.innerHTML = '';
                  trendingDiv.appendChild(clonedElement);
              }
          }
      })
      .catch(error => {
          console.error('Error loading trending recipe:', error);
      });
}

function initVisitTracking() {
  const match = window.location.pathname.match(/recipes\/(.+?)\.html/);
  if (match) {
      const recipeId = match[1];
      trackVisit(recipeId);
  }
}

setInterval(displayTrendingRecipe, 60000);

document.addEventListener('DOMContentLoaded', () => {
  initVisitTracking();
  displayTrendingRecipe();
});
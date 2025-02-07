function recipeOfDay(maxId) {
  const randomId = Math.floor(Math.random() * maxId) + 1;

  const date = new Date();
  console.log("Date: ", date);

  fetch('catalog.html')
      .then(response => response.text())
      .then(text => {
          let parser = new DOMParser();
          let doc = parser.parseFromString(text, 'text/html');
          let element = doc.getElementById(randomId.toString());
          
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
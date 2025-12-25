document.addEventListener("DOMContentLoaded", () => {

  console.log("JS loaded");

  fetch("getCars.php")
    .then(res => res.json())
    .then(cars => {
      const container = document.querySelector(".container");

      if (!container) {
        console.error("Container not found!");
        return;
      }

      container.innerHTML = "";

      cars.forEach(car => {
        container.innerHTML += `
          <div class="card">
            <img src="${car.image}" alt="${car.name}">
            <h2>${car.name}</h2>

            <div class="info">
              <p><strong>Year:</strong> ${car.year}</p>
              <p><strong>Color:</strong> ${car.color}</p>
              <p><strong>Engine:</strong> ${car.engine}</p>
            </div>

            <div class="price">$${Number(car.price).toLocaleString()}</div>
<button class="reserve-btn" onclick="window.location.href='Reservations.html'">
    Reserve Now
</button>


          </div>
        `;
      });
    })
    .catch(err => console.error("Fetch error:", err));

});

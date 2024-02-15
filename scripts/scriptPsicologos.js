let menu = document.querySelector('.fa-bars');
let navbar = document.querySelector('.navbar');

menu.addEventListener('click', function () {
  menu.classList.toggle('fa-times');
  navbar.classList.toggle('nav-toggle');
});

window.addEventListener('scroll', () => {
  menu.classList.remove('fa-times');
  navbar.classList.remove('nav-toggle');
});

function mostrarInformacion(button) {
  const psychologistId = button.dataset.id;
  window.location.href = `../presentacion/presentacionProfesional.php?id=${psychologistId}`;
}


/*
document.addEventListener("DOMContentLoaded", function () {
  // Obtén los elementos del DOM que necesitarás
  const especialidadFilter = document.getElementById("especialidadFilter");
  const disponibilidadFilter = document.getElementById("disponibilidadFilter");
  const cardContainer = document.getElementById("cardContainer");
  const buscarBtn = document.getElementById("buscarBtn");

  // Asigna un evento al botón de búsqueda
  buscarBtn.addEventListener("click", function () {
    // Filtra las tarjetas según las opciones seleccionadas
    const especialidadSeleccionada = especialidadFilter.value;
    const disponibilidadSeleccionada = disponibilidadFilter.value;

    // Itera sobre las tarjetas y muestra/oculta según las opciones seleccionadas
    const tarjetas = cardContainer.querySelectorAll(".card");
    tarjetas.forEach((tarjeta) => {
      const tarjetaEspecialidad = tarjeta.querySelector(".card-text").textContent;
      const tarjetaDisponibilidad = tarjeta.querySelector(".card-text-diponibilidad").textContent;

      const cumpleEspecialidad = especialidadSeleccionada === "" || tarjetaEspecialidad.includes(especialidadSeleccionada);
      const cumpleDisponibilidad = disponibilidadSeleccionada === "" || tarjetaDisponibilidad.includes(disponibilidadSeleccionada);

      // Muestra u oculta la tarjeta según los criterios
      if (cumpleEspecialidad && cumpleDisponibilidad) {
        tarjeta.style.display = "inline"; // Muestra la tarjeta
      } else {
        tarjeta.style.display = "none"; // Oculta la tarjeta
      }
    });
    
  });
});

*/





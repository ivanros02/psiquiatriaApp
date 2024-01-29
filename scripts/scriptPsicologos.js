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

// Obtener el input de búsqueda


//cards:
document.addEventListener("DOMContentLoaded", function () {
  const cardContainer = document.getElementById("cardContainer");
  const searchInput = document.getElementById('searchInput');
  const noResultsMessage = document.getElementById('noResults');

  // Información de los psicólogos
  const psychologistsData = [
    {
      id: 1,
      imagen: "img/Lic. Ana Maria Pinto.jpg",
      nombre: "Lic. Ana Maria Pinto",
      rating: 4.5,
      titulo: "Lic. en Psicología Terapia Psicoanalítica",
      especialidad: "Ansiedad y estrés. Desarrollo personal. Miedos o fobias. Terapia de pareja. Problemas vinculares. Duelo.",
      disponibilidad:"24hs",
    },

    {
      id: 2,
      imagen: "img/Lic. Vanesa Pérez.jpg",
      nombre: "Lic. Vanesa Pérez",
      rating: 4.5,
      titulo: "Lic. en Psicología Terapia Psicoanalítica",
      especialidad: "Ansiedad y estrés.",
      disponibilidad:"24hs",
    },

    {
      imagen: "img/modelo.jpg",
      nombre: "Lic. Vanesa Pérez",
      rating: 4.5,
      titulo: "Lic. en Psicología Terapia Psicoanalítica",
      especialidad: "Ansiedad y estrés. Desarrollo personal. Miedos o fobias. Terapia de pareja. Problemas vinculares. Duelo.",
      disponibilidad:"24hs",
    },
    
    // Agrega las demás tarjetas aquí
  ];

  // Función para crear una tarjeta
  function createCard(psychologist) {
    const cardHTML = `
    <div class="col-lg-4 col-md-6 mb-3 d-flex justify-content-center">
        <div class="card">
        <img src="${psychologist.imagen}" class="card-img-top" alt="...">
          <div class="card-body">
          <h5 class="card-title">${psychologist.nombre}</h5>
            <!-- Estrellas para calidad de atención -->
            <div class="rating">
              <span class="fa fa-star checked"></span>
              <span class="fa fa-star checked"></span>
              <span class="fa fa-star checked"></span>
              <span class="fa fa-star checked"></span>
              <span class="fa fa-star unchecked"></span>
              <p>${psychologist.rating}</p>
            </div>
            <!-- Fin estrellas para calidad de atención -->
            <h5 class="card-titleDos">${psychologist.titulo}</h5>
            <p class="card-text">${psychologist.especialidad}</p>
            <p class="card-text-diponibilidad">Disponibilidad en: ${psychologist.disponibilidad}</p>
            <a href="#" class="btn btn-primary" data-id="${psychologist.id}" onclick="mostrarInformacion(this)">Más información</a>
          </div>
        </div>
      </div>
    `;

    return cardHTML;
  }

  // Generar las tarjetas dinámicamente
  function renderCards(psychologists) {
    cardContainer.innerHTML = psychologists.map(createCard).join('');

    // Mostrar u ocultar el mensaje de "No se encontraron resultados"
    noResultsMessage.style.display = psychologists.length === 0 ? 'block' : 'none';
  }

  // Inicializar con todas las tarjetas
  renderCards(psychologistsData);

  // Función para filtrar las cards
  function filterCards(searchTerm) {
    const term = searchTerm.toLowerCase();
    const filteredPsychologists = psychologistsData.filter(psychologist =>
      psychologist.nombre.toLowerCase().includes(term) ||
      psychologist.titulo.toLowerCase().includes(term) ||
      psychologist.especialidad.toLowerCase().includes(term) ||
      psychologist.disponibilidad.toString().includes(term)
    );

    renderCards(filteredPsychologists);
  }

  // Evento input para el input de búsqueda
  searchInput.addEventListener('input', (e) => {
    const searchTerm = e.target.value.trim();
    filterCards(searchTerm);
  });
});

function mostrarInformacion(button) {
  const psychologistId = button.dataset.id;
  // Aquí puedes redirigir o realizar otras acciones con el ID
  // Por ejemplo, redirigir a la página de presentación con el ID
  window.location.href = `presentacion/presentacionProfesional.php?id=${psychologistId}`;
}

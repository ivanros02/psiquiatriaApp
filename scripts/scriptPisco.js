let menu = document.querySelector('.fa-bars');
let navbar = document.querySelector('.navbar');

menu.addEventListener('click',function(){
    menu.classList.toggle('fa-times');
    navbar.classList.toggle('nav-toggle');
});

window.addEventListener('scroll', () =>{
    menu.classList.remove('fa-times');
    navbar.classList.remove('nav-toggle');
});

// Obtener el input de búsqueda
const searchInput = document.getElementById('searchInput');

// Obtener todas las cards
const cards = document.querySelectorAll('.col-md-4');

// Función para filtrar las cards
const filterCards = (searchTerm) => {
  const term = searchTerm.toLowerCase();
  
  cards.forEach(card => {
    const title = card.querySelector('.card-title').textContent.toLowerCase();
    const titleDos = card.querySelector('.card-titleDos').textContent.toLowerCase();
    const cardText = card.querySelector('.card-text').textContent.toLowerCase();
    const cardTextDos = card.querySelector('.card-textDos').textContent.toLowerCase();
    
    if (
      title.includes(term) ||
      titleDos.includes(term) ||
      cardText.includes(term) ||
      cardTextDos.includes(term)
    ) {
      card.style.display = 'block';
    } else {
      card.style.display = 'none';
    }
  });
};

// Evento input para el input de búsqueda
searchInput.addEventListener('input', (e) => {
  const searchTerm = e.target.value.trim();
  filterCards(searchTerm);
});









  
  
  
  
  
  
  
  

  
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


function searchCards() {
  var input = document.getElementById('searchInput');
  var filter = input.value.toUpperCase().trim();

  var cards = document.querySelectorAll('.card');

  cards.forEach(function(card) {
    var title = card.querySelector('.card-title').textContent.toUpperCase();
    var text = card.querySelector('.card-text').textContent.toUpperCase();

    if (filter === '' || title.indexOf(filter) > -1 || text.indexOf(filter) > -1) {
      card.style.display = 'block'; // Mostrar la tarjeta si coincide
    } else {
      card.style.display = 'none'; // Ocultar la tarjeta si no coincide
    }
  });
}

document.getElementById('searchInput').addEventListener('input', searchCards);

// Restablecer la búsqueda y mostrar todas las tarjetas al borrar el texto
document.getElementById('searchInput').addEventListener('keyup', function(event) {
  if (event.keyCode === 8 || event.keyCode === 46) {
    searchCards();
  }
});


  
  
  
  
  
  
  
  

  
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






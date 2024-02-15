let menu = document.querySelector('.fa-bars');
let navbar = document.querySelector('.navbar');("data-psychologist-id");


menu.addEventListener('click', function () {
  menu.classList.toggle('fa-times');
  navbar.classList.toggle('nav-toggle');
});

window.addEventListener('scroll', () => {
  menu.classList.remove('fa-times');
  navbar.classList.remove('nav-toggle');
});
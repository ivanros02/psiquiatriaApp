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

function toggleText() {
    var moreText = document.getElementById("moreText");
    var buttonText = document.querySelector('.btn');

    if (moreText.style.display === "none") {
        moreText.style.display = "inline";
        buttonText.innerHTML = "Leer menos";
    } else {
        moreText.style.display = "none";
        buttonText.innerHTML = "Leer más";
    }
}


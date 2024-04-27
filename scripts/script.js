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

// Definir la función loadShow y las variables al inicio
let items = document.querySelectorAll('.slider .item');
let active = 3;

function loadShow() {
    // Reset all items
    items.forEach(item => {
        item.style.transform = `none`;
        item.style.zIndex = 0;
        item.style.filter = 'none';
        item.style.opacity = 0;
        item.style.fontWeight = 900;
        
        item.style.fontSize = '1.5rem';
    });

    let stt = 0;
    for (let i = active; i < items.length; i++) {
        items[i].style.transform = `translateX(${120 * stt}px) scale(${1 - 0.2 * stt}) perspective(16px)`;
        items[i].style.zIndex = -stt;
        items[i].style.filter = `blur(${9 * stt}px)`; 
        items[i].style.opacity = stt > 2 ? 0 : 0.8; // Adjust blur dynamically
        stt++;
    }

    stt = 0;
    for (let i = active - 1; i >= 0; i--) {
        items[i].style.transform = `translateX(${-120 * (stt + 1)}px) scale(${1 - 0.2 * (stt + 1)}) perspective(16px)`;
        items[i].style.zIndex = -stt;
        items[i].style.filter = `blur(${5 * (stt + 1)}px)`;
        items[i].style.opacity = stt > 2 ? 0 : 0.8;  // Adjust blur dynamically
        stt++;
    }
}


let touchStartX = 0;
let touchEndX = 0;


// Llamar a loadShow al cargar la página
window.onload = loadShow;

// Asignar los eventos a los botones next y prev
next.onclick = function(){
    active = (active + 1) % items.length;
    loadShow();
};

prev.onclick = function(){
    active = (active - 1 + items.length) % items.length;
    loadShow();
};

// Evento táctil para detectar el deslizamiento en dispositivos móviles
document.addEventListener('touchstart', function(event) {
    touchStartX = event.touches[0].clientX;
});

document.addEventListener('touchend', function(event) {
    touchEndX = event.changedTouches[0].clientX;
    handleGesture();
});

function handleGesture() {
    if (touchStartX - touchEndX > 50) {
        // Deslizamiento hacia la izquierda
        active = (active + 1) % items.length;
        loadShow();
    }

    if (touchEndX - touchStartX > 50) {
        // Deslizamiento hacia la derecha
        active = (active - 1 + items.length) % items.length;
        loadShow();
    }
}



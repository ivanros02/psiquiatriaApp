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



//ventana emergente

document.addEventListener("DOMContentLoaded", function () {
    const modal = document.querySelector('.modal');
    const btnCerrarModal = document.querySelector('.close');
    modal.style.display = 'none';

    function abrirModal() {
        modal.style.display = 'flex';
    }

    function cerrarModal() {
        modal.style.display = 'none';
        isButtonCreated = false; // Restablecer la variable isButtonCreated
    }

    // Asigna la función abrirModal al botón Contactar
    document.getElementById('checkout-btn').addEventListener('click', function() {
        abrirModal();

    });

    // Asigna la función cerrarModal al botón cerrar
    btnCerrarModal.addEventListener('click', cerrarModal);
});


/*
const mp = new MercadoPago("TEST-97eb7f19-9988-4b2b-823c-0f7e0524e295", {
    locale: "es-AR"
});

//url para create_preference
//const baseURL = 'https://tudominio.com';
// Coloca esta variable global para controlar si el botón ya fue creado
let isButtonCreated = false;
document.getElementById("checkout-btn").addEventListener("click", async () => {
    try {
        const orderData = {
            title: document.querySelector(".card-title").innerText,
            quantity: 1,
            price: 2000,
        };

        //const response = await fetch(`${baseURL}/create_preference`, {
        const response = await fetch("http://localhost:3000/create_preference", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
            },
            body: JSON.stringify(orderData),
        });

        const preference = await response.json();
        // Si el botón aún no ha sido creado, crea el botón
        if (!isButtonCreated) {
            createCheckoutButton(preference.id);
            isButtonCreated = true; // Marca el botón como creado
        }
    }
    catch (error) {
        alert("error:(");
    }

});

const createCheckoutButton = (preferenceId) => {
    const bricksBuilder = mp.bricks();

    const renderComponent = async () => {
        if (window.checkoutButton) window.checkoutButton.unmount();
        await bricksBuilder.create("wallet", "wallet_container", {
            initialization: {
                preferenceId: preferenceId,
            },
        });
    };

    renderComponent();
};
*/
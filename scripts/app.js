let menu = document.querySelector('.fa-bars');
let navbar = document.querySelector('.navbar');
// Obtén el valor del atributo data-psychologist-id
let psychologistId = document.getElementById("checkout-btn").getAttribute("data-psychologist-id");


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
    document.getElementById('contact').addEventListener('click', function () {
        abrirModal();

    });

    // Asigna la función cerrarModal al botón cerrar
    btnCerrarModal.addEventListener('click', cerrarModal);
});


//  TEST-97eb7f19-9988-4b2b-823c-0f7e0524e295
const mp = new MercadoPago("APP_USR-ebcfb544-a26e-44bf-8c55-7605f5ecb7d8", {
    locale: "es-AR"
});

const generateIdempotencyKey = () => {
    const length = 20
    const characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
    const charactersLength = characters.length;
    let idempotencyKey = '';
    for (let i = 0; i < length; i++) {
      idempotencyKey += characters.charAt(Math.floor(Math.random() * charactersLength));
    }
    return idempotencyKey;
  }
  
  const idempotencyKey = generateIdempotencyKey();
 

//url para create_preference
//const baseURL = 'https://tudominio.com';
// Coloca esta variable global para controlar si el botón ya fue creado
let isButtonCreated = false;
document.getElementById("checkout-btn").addEventListener("click", async () => {
    try {
        // Captura el valor del correo electrónico
        const userEmail = document.getElementById("user-email").value;
        // Verifica si el campo de correo electrónico no está vacío
        if (!userEmail.trim()) {
            alert("Por favor, ingresa tu correo electrónico.");
            return; // Detén la ejecución si el campo está vacío
        }

        // Crea un objeto con los datos a enviar al servidor
        const formData = {
            userEmail: userEmail,
            psychologistId: psychologistId,
        };

        const tooltipElement = document.querySelector('.tooltiptext');
        const precio = tooltipElement.getAttribute('data-valor');

        const orderData = {
            title: document.querySelector(".card-title").innerText,
            quantity: 1,
            price: parseFloat(precio),
            psychologistId: document.getElementById("checkout-btn").getAttribute("data-psychologist-id"),
            userEmail: userEmail, // Agrega el correo electrónico al objeto orderData
            formData: formData,
        };



        const response = await fetch("https://terapialibre.com.ar/create_preference", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-Idempotency-Key":idempotencyKey,
            },
            body: JSON.stringify(orderData),
        });

        const preference = await response.json();
        if (!isButtonCreated) {
            createCheckoutButton(preference.id);
            isButtonCreated = true;
        }
    } catch (error) {
        console.error("Error:", error);
        alert("Ocurrió un error. Por favor, consulta la consola para más detalles.");
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

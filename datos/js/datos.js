$(document).ready(function() {
    // Obtener el ID del psicólogo desde la URL
    const urlParams = new URLSearchParams(window.location.search);
    const psychologistId = urlParams.get('id');

    if (psychologistId) {
        $.ajax({
            url: '../presentacion/gets/get_presentacion.php?id=' + psychologistId, // Cambia a la ruta correcta
            method: 'GET',
            dataType: 'json',
            success: function(data) {
                if (data.length > 0) {
                    const psychologist = data[0]; // Asumimos que solo hay un psicólogo
                    $('#cardContainer').html(`
                        <div class="col-md-6 col-lg-4 mt-7">
                            <div class="card mb-4">
                                <img src="${psychologist.rutaImagen}" class="card-img-top" alt="${psychologist.nombre}">
                                <div class="card-body">
                                    <h5 class="card-title">${psychologist.nombre}</h5>
                                    <h5 class="card-titleDos">${psychologist.titulo}</h5>
                                    <p class="card-text">Matrícula: MN ${psychologist.matricula} (AR)<br>Matrícula: MP ${psychologist.matriculaP} (AR)</p>
                                    <div class="cajitas">
                                        <a class="iconito icon-whatsapp" href="https://api.whatsapp.com/send?phone=${psychologist.whatsapp}&text=Hola%20me%20contacto%20desde%20Terapia%20Libre.%20Quiero%20solicitar%20un%20turno!" aria-label="Contactar por WhatsApp">
                                            <i class="fab fa-whatsapp"></i>
                                        </a>
                                        <a class="iconito icon-instagram" href="https://www.instagram.com/${psychologist.instagram}" aria-label="Ver Instagram">
                                            <i class="fab fa-instagram"></i>
                                        </a>
                                        <a class="iconito icon-gmail" href="mailto:${psychologist.mail}" aria-label="Enviar correo">
                                            <i class="far fa-envelope"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                    `);
                } else {
                    alert('No se encontró el psicólogo con el ID proporcionado.');
                }
            },
            error: function(xhr, status, error) {
                console.error('Error en la solicitud:', error);
                alert('Ocurrió un error al cargar los datos del psicólogo.');
            }
        });
    } else {
        alert('ID de psicólogo no válido.');
    }
});
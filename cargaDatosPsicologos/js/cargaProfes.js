$(document).ready(function () {
    // Hacer la llamada AJAX al archivo PHP para obtener las especialidades
    $.ajax({
        url: '../psicologos/gets/obtener_especialidades.php', // Ajusta la ruta al archivo PHP
        type: 'GET',
        dataType: 'json',
        success: function (data) {
            var especialidadesContainer = $('#especialidades-container');
            especialidadesContainer.empty(); // Limpiar el contenedor antes de agregar datos

            // Recorrer las especialidades y agregarlas al contenedor
            data.forEach(function (especialidad, index) { // Agregamos el índice para generar un id único
                var checkboxId = `especialidad_${index}`; // Crear un id único para cada checkbox
                
                var especialidadHtml = `
                <div class="col-md-6 mb-2">
                    <div class="form-check">
                        <input type="checkbox" id="${checkboxId}" name="especialidad[]" value="${especialidad.id}" class="form-check-input">
                        <label class="form-check-label" for="${checkboxId}">${especialidad.especi}</label>
                    </div>
                </div>`;
                especialidadesContainer.append(especialidadHtml);
            });
        },
        error: function (xhr, status, error) {
            console.error("Error al cargar las especialidades: " + error);
        }
    });
});

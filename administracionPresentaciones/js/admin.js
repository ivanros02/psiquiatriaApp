// Variable global temporal
let presentacionTemp = {};

// Función para cargar las presentaciones desde el servidor
function cargarPresentaciones() {
    $.ajax({
        url: './manejoPresentaciones/obtenerPresentaciones.php', // Ruta del archivo PHP que obtiene las presentaciones
        method: 'GET',
        dataType: 'json',
        success: function (data) {
            let rows = '';
            data.forEach(function (presentacion) {
                // Almacenar cada presentación en la variable global
                presentacionTemp[presentacion.id] = presentacion;

                rows += `
                    <tr>
                        <td>${presentacion.id}</td>
                        <td><img src="${presentacion.rutaImagen}" alt="${presentacion.nombre}"></td>
                        <td>${presentacion.nombre}</td>
                        <td>${presentacion.titulo}</td>
                        <td>${presentacion.mail}</td>
                        <td>${presentacion.whatsapp}</td>
                        <td>${presentacion.aprobado == 1 ? 'Sí' : 'No'}</td>
                        <td>
                            <button class="btn btn-sm btn-success" onclick="cambiarEstado(${presentacion.id}, 1)">Aprobar</button>
                            <button class="btn btn-sm btn-danger" onclick="cambiarEstado(${presentacion.id}, 0)">Rechazar</button>
                        </td>
                        <td>
                            <button class="btn btn-sm btn-warning" onclick="abrirModalEditar(${presentacion.id})">Editar</button>
                            <button class="btn btn-sm btn-danger" onclick="eliminarPresentacion(${presentacion.id})">Eliminar</button>
                        </td>
                    </tr>
                `;
            });
            $('#presentaciones-list').html(rows);
        }
    });
}


// Función para abrir el modal de edición con los datos de la presentación
function abrirModalEditar(id) {
    const p = presentacionTemp[id]; // Recuperar los datos de la variable global
    if (p) {
        $('#editarId').val(p.id);
        // Mostrar la imagen actual como vista previa
        if (p.rutaImagen) {
            $('#previewImagen').attr('src', p.rutaImagen).show();
        } else {
            $('#previewImagen').hide();
        }
        $('#editarNombre').val(p.nombre);
        $('#editarTitulo').val(p.titulo);
        $('#editarMatricula').val(p.matricula);
        $('#editarMatriculaP').val(p.matriculaP);
        $('#editarDescripcion').val(p.descripcion);
        $('#editarTelefono').val(p.telefono);
        $('#editarDisponibilidad').val(p.disponibilidad);
        $('#editarValor').val(p.valor);
        $('#editarMail').val(p.mail);
        $('#editarWhatsapp').val(p.whatsapp);
        $('#editarInstagram').val(p.instagram);
        $('#editarModal').modal('show');
    }
}

// Función para guardar los cambios de la edición
function guardarCambios() {
    const id = $('#editarId').val();
    const nombre = $('#editarNombre').val();
    const titulo = $('#editarTitulo').val();
    const matricula = $('#editarMatricula').val();
    const matriculaP = $('#editarMatriculaP').val();
    const descripcion = $('#editarDescripcion').val();
    const telefono = $('#editarTelefono').val();
    const disponibilidad = $('#editarDisponibilidad').val();
    const valor = $('#editarValor').val();
    const mail = $('#editarMail').val();
    const whatsapp = $('#editarWhatsapp').val();
    const instagram = $('#editarInstagram').val();

    // Crear el objeto FormData
    const formData = new FormData();
    formData.append('id', id);
    formData.append('nombre', nombre);
    formData.append('titulo', titulo);
    formData.append('matricula', matricula);
    formData.append('matriculaP', matriculaP);
    formData.append('descripcion', descripcion);
    formData.append('telefono', telefono);
    formData.append('disponibilidad', disponibilidad);
    formData.append('valor', valor);
    formData.append('mail', mail);
    formData.append('whatsapp', whatsapp);
    formData.append('instagram', instagram);

    // Añadir la imagen seleccionada si existe
    const fileInput = $('#editarRutaImagen')[0].files[0];
    if (fileInput) {
        formData.append('imagen', fileInput);
    }


    $.ajax({
        url: './manejoPresentaciones/editarPresentacion.php',
        method: 'POST',
        data: formData,
        processData: false, // No procesar los datos como una cadena de consulta
        contentType: false, // No establecer contentType, deja que el navegador lo maneje
        dataType: 'json',
        success: function (response) {
            if (response.status === 'success') {
                alert('Presentación actualizada con éxito');
                $('#editarModal').modal('hide');
                cargarPresentaciones(); // Recargar la lista de presentaciones
            } else {
                alert('Error al actualizar la presentación');
            }
        }
    });
}



// Función para eliminar una presentación
function eliminarPresentacion(id) {
    if (confirm('¿Estás seguro de que deseas eliminar esta presentación?')) {
        $.ajax({
            url: './manejoPresentaciones/eliminarPresentacion.php', // Ruta para eliminar la presentación
            method: 'POST',
            data: { id: id },
            dataType: 'json',
            success: function (response) {
                if (response.status === 'success') {
                    console.log(response)
                    alert('Presentación eliminada con éxito');
                    cargarPresentaciones(); // Recargar la lista de presentaciones
                } else {
                    alert('Error al eliminar la presentación');
                }
            }
        });
    }
}

// Función para cambiar el estado de aprobación de una presentación
function cambiarEstado(id, aprobado) {
    $.ajax({
        url: './manejoPresentaciones/cambiarEstado.php', // Ruta del archivo PHP que actualiza el estado
        method: 'POST',
        data: { id: id, aprobado: aprobado },
        dataType: 'json',
        success: function (response) {
            if (response.status === 'success') {
                alert('Estado actualizado con éxito');
                cargarPresentaciones(); // Recargar la lista de presentaciones
            } else {
                alert('Error al actualizar el estado');
            }
        }
    });
}

// Cargar las presentaciones cuando la página esté lista
$(document).ready(function () {
    cargarPresentaciones();
});

// Función para cargar la lista de comentarios
function cargarComentarios() {
    $.ajax({
        url: './manejoPresentaciones/listar_comentarios_ajax.php', // Archivo PHP que genera la tabla
        method: 'GET',
        success: function (data) {
            $('#comentarios-list').html(data); // Cargar el HTML recibido en el contenedor
        }
    });
}

// Llamada inicial para cargar los comentarios
$(document).ready(function () {
    cargarComentarios();

    // Acción para abrir el modal de edición
    $(document).on('click', '.edit-btn', function () {
        const id = $(this).data('id');
        const comentario = $(this).data('comentario');
        const nombre = $(this).data('nombre');

        $('#editId').val(id);
        $('#editComentario').val(comentario);
        $('#editNombre').val(nombre);
        $('#editModal').modal('show');
    });

    // Acción para eliminar con confirmación
    $(document).on('click', '.delete-btn', function () {
        const id = $(this).data('id');
        if (confirm('¿Estás seguro de que deseas eliminar este comentario?')) {
            $.ajax({
                url: './manejoPresentaciones/eliminar_comentario.php',
                method: 'POST',
                data: { id: id },
                success: function (response) {
                    alert(response); // Mostrar respuesta
                    cargarComentarios(); // Recargar la lista de comentarios
                }
            });
        }
    });

    // Formulario para editar comentario
    $('#editForm').submit(function (e) {
        e.preventDefault();
        $.ajax({
            url: './manejoPresentaciones/editar_comentario.php',
            method: 'POST',
            data: $(this).serialize(),
            success: function (response) {
                alert(response);
                $('#editModal').modal('hide');
                cargarComentarios();
            }
        });
    });
});
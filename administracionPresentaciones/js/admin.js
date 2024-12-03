// Variable global temporal
let paginaActual = 1; // Página inicial
const registrosPorPagina = 30; // Registros por página

// Función para cargar las presentaciones desde el servidor
function cargarPresentaciones(pagina = 1) {
    $.ajax({
        url: './manejoPresentaciones/obtenerPresentaciones.php',
        method: 'GET',
        data: { pagina },
        dataType: 'json',
        success: function (response) {
            const { presentaciones, total, registrosPorPagina } = response;
            let rows = '';

            presentaciones.forEach(function (presentacion) {
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

            // Generar la paginación
            generarPaginacion(total, registrosPorPagina, pagina);
        }
    });
}

// Función para generar botones de paginación
function generarPaginacion(total, registrosPorPagina, paginaActual) {
    const totalPaginas = Math.ceil(total / registrosPorPagina);
    let paginationHTML = '';

    for (let i = 1; i <= totalPaginas; i++) {
        paginationHTML += `
            <button class="btn btn-sm ${i === paginaActual ? 'btn-primary' : 'btn-outline-primary'}"
                onclick="cargarPresentaciones(${i})">${i}</button>
        `;
    }

    $('#pagination').html(paginationHTML);
}

// Inicializar la carga de presentaciones
$(document).ready(function () {
    cargarPresentaciones();
});


function abrirModalEditar(id) {
    fetch(`./manejoPresentaciones/obtenerPresentacionPorId.php?id=${id}`)
        .then(response => {
            if (!response.ok) {
                throw new Error("Error al obtener los datos de la presentación.");
            }
            return response.json();
        })
        .then(p => {
            if (!p) {
                alert("No se encontraron datos para esta presentación.");
                return;
            }

            // Llenar el formulario con los datos recibidos
            $('#editarId').val(p.id);
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
            $('#editarValorInternacional').val(p.valor_internacional);
            $('#editarMail').val(p.mail);
            $('#editarWhatsapp').val(p.whatsapp);
            $('#editarInstagram').val(p.instagram);

            // Mostrar el modal de edición
            $('#editarModal').modal('show');
        })
        .catch(error => {
            console.error("Error:", error);
            alert("Ocurrió un error al cargar los datos de la presentación.");
        });
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
    const valor_internacional = $('#editarValorInternacional').val();
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
    formData.append('valor_internacional', valor_internacional);
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

function cargarComentarios(pagina = 1) {
    const registrosPorPagina = 10; // Configura cuántos registros mostrar por página
    $.ajax({
        url: './manejoPresentaciones/listar_comentarios_ajax.php',
        method: 'GET',
        data: { pagina, registrosPorPagina },
        success: function (data) {
            $('#comentarios-list').html(data); // Cargar el HTML recibido en el contenedor
        }
    });
}

// Cargar la primera página al iniciar
document.addEventListener('DOMContentLoaded', () => {
    cargarComentarios();
});


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

document.addEventListener('DOMContentLoaded', () => {
    const botonGenerarReporte = document.getElementById('generarReporte');
    if (botonGenerarReporte) {
        botonGenerarReporte.addEventListener('click', async () => {
            const fechaDesde = document.getElementById('fechaDesde').value;
            const fechaHasta = document.getElementById('fechaHasta').value;

            if (!fechaDesde || !fechaHasta) {
                alert("Por favor, selecciona las fechas.");
                return;
            }

            try {
                const response = await fetch('./gets/generar-reporte.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({ fechaDesde, fechaHasta }),
                });

                if (!response.ok) {
                    throw new Error("Error al obtener los datos del servidor");
                }

                const data = await response.json();

                if (data.length === 0) {
                    alert("No se encontraron datos para las fechas seleccionadas.");
                    return;
                }

                const formatDate = (date) => {
                    const [year, month, day] = date.split('-');
                    return `${day}-${month}-${year}`;
                };

                const { jsPDF } = window.jspdf;
                const pdf = new jsPDF();
                const pageWidth = pdf.internal.pageSize.getWidth();
                let y = 20;

                // Encabezado
                pdf.setFontSize(16);
                pdf.text("Reporte de Liquidación de Profesionales", pageWidth / 2, y, { align: 'center' });
                y += 10;
                pdf.setFontSize(12);
                pdf.text(`Rango de fechas: ${formatDate(fechaDesde)} a ${formatDate(fechaHasta)}`, pageWidth / 2, y, { align: 'center' });
                y += 20;

                const headers = [["Nombre", "Cant. Nacional", "Total Nacional", "Cant. Internacional", "Total Internacional"]];
                const rows = data.map(item => [
                    item.nombre,
                    item.cantidad_nacional,
                    `$${item.total_nacional.toFixed(2)}`,
                    item.cantidad_internacional,
                    `$${item.total_internacional.toFixed(2)}`
                ]);

                pdf.autoTable({
                    startY: y,
                    head: headers,
                    body: rows,
                    theme: 'grid',
                    styles: {
                        fontSize: 10,
                        halign: 'center',
                    },
                    headStyles: {
                        fillColor: [0, 102, 204],
                        textColor: [255, 255, 255],
                        fontSize: 11,
                    },
                });


                // Abrir en una nueva pestaña para vista previa
                window.open(pdf.output('bloburl'));
            } catch (error) {
                console.error("Error:", error);
                alert("Hubo un problema al generar el reporte.");
            }
        });
    } else {
        console.error("El botón generarReporte no fue encontrado en el DOM.");
    }
});





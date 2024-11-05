<?php
session_start();

// Verificar si el usuario está logueado
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    // Redirigir al login si no está logueado
    header("Location: inicioAdmin.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administración</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>
    <script src="./js/admin.js"></script>

    <style>
        body {
            background-color: #f8f9fa;
        }

        .table img {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border-radius: 5px;
        }

        .table th,
        .table td {
            vertical-align: middle;
        }

        .btn {
            margin-right: 5px;
        }
    </style>
</head>

<body>
    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3">Bienvenido, <?php echo $_SESSION['username']; ?></h1>
            <a href="./manejoUsuario/logout.php" class="btn btn-danger">Cerrar sesión</a>
        </div>

        <h2 class="mb-4">Listado de Presentaciones</h2>
        <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover">
                <thead class="thead-dark">
                    <tr>
                        <th>ID</th>
                        <th>Imagen</th>
                        <th>Nombre</th>
                        <th>Título</th>
                        <th>Mail</th>
                        <th>WhatsApp</th>
                        <th>Aprobado</th>
                        <th>Aprobar</th>
                        <th>Acción</th>
                    </tr>
                </thead>
                <tbody id="presentaciones-list">
                    <!-- Las filas de presentaciones se generarán aquí con JS -->
                </tbody>
            </table>
        </div>
    </div>

    <div class="container mt-5">
        <h2>Lista de Comentarios</h2>
        <!-- Botón para agregar un nuevo comentario -->
        <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addModal">Agregar
            Comentario</button>

        <div id="comentarios-list"></div> <!-- Contenedor donde cargaremos la tabla con AJAX -->
    </div>

    <!-- Modal para agregar comentario -->
    <!-- Modal para agregar un nuevo comentario -->
    <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="addForm" action="./manejoPresentaciones/agregar_comentario.php" method="POST">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addModalLabel">Agregar Comentario</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="selectPresentacion" class="form-label">Seleccionar Profesional</label>
                            <select class="form-select" id="selectPresentacion" name="profesional_id" required>
                                <option value="" disabled selected>Elige una presentación</option>
                                <?php
                                // Conexión a la base de datos
                                require_once '../php/conexion.php';
                                $presentaciones = $conexion->query("SELECT id, nombre FROM presentaciones");
                                while ($row = $presentaciones->fetch_assoc()) {
                                    echo "<option value='{$row['id']}'>{$row['nombre']}</option>";
                                }
                                $conexion->close();
                                ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <div class="form-floating">
                                <input type="text" class="form-control" id="addComentario" name="comentario"
                                    placeholder="Comentario" required>
                                <label for="addComentario">Comentario</label>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="form-floating">
                                <input type="text" class="form-control" id="addNombre" name="nombre"
                                    placeholder="Nombre" required>
                                <label for="addNombre">Nombre</label>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary">Agregar Comentario</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Modal para editar comentario -->
        <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form id="editForm">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editModalLabel">Editar Comentario</h5>
                            <!-- Botón de cierre actualizado para Bootstrap 5 -->
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" id="editId" name="id">
                            <div class="col-12 form-floating">
                                <input type="text" class="form-control" id="editComentario" name="comentario"
                                    placeholder="Comentario" required>
                                <label for="editComentario">Comentario</label>
                            </div>

                            <div class="form-group">
                                <label for="editNombre">Nombre</label>
                                <input type="text" class="form-control" id="editNombre" name="nombre" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <!-- Cambiar data-dismiss por data-bs-dismiss -->
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                            <button type="submit" class="btn btn-primary">Guardar cambios</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>


        <!-- Modal para editar presentacion -->
        <div class="modal fade" id="editarModal" tabindex="-1" aria-labelledby="editarModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editarModalLabel">Editar Presentación</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="editarForm">
                            <input type="hidden" id="editarId">
                            <div class="mb-3">
                                <label for="editarRutaImagen" class="form-label">Vista previa de la imagen</label>
                                <!-- Elemento para vista previa de la imagen con estilos ajustados -->
                                <img id="previewImagen" src="" alt="Vista previa de la imagen"
                                    style="max-width: 200px; max-height: 200px; display: none; margin-bottom: 10px;">
                                <input type="file" class="form-control" id="editarRutaImagen" accept="image/*">
                            </div>


                            <div class="mb-3">
                                <label for="editarNombre" class="form-label">Nombre</label>
                                <input type="text" class="form-control" id="editarNombre">
                            </div>
                            <div class="mb-3">
                                <label for="editarTitulo" class="form-label">Título</label>
                                <input type="text" class="form-control" id="editarTitulo">
                            </div>
                            <div class="mb-3">
                                <label for="editarMatricula" class="form-label">Matrícula</label>
                                <input type="number" class="form-control" id="editarMatricula">
                            </div>
                            <div class="mb-3">
                                <label for="editarMatriculaP" class="form-label">Matrícula Profesional</label>
                                <input type="number" class="form-control" id="editarMatriculaP">
                            </div>
                            <div class="mb-3">
                                <label for="editarDescripcion" class="form-label">Descripción</label>
                                <textarea class="form-control" id="editarDescripcion" rows="3"></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="editarTelefono" class="form-label">Teléfono</label>
                                <input type="text" class="form-control" id="editarTelefono">
                            </div>
                            <div class="mb-3">
                                <label for="editarDisponibilidad" class="form-label">Disponibilidad</label>
                                <select class="form-control" id="editarDisponibilidad">
                                    <option value="24">24 horas</option>
                                    <option value="48">48 horas</option>
                                    <option value="96">96 horas</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="editarValor" class="form-label">Valor</label>
                                <input type="number" class="form-control" id="editarValor">
                            </div>
                            <div class="mb-3">
                                <label for="editarMail" class="form-label">Mail</label>
                                <input type="email" class="form-control" id="editarMail">
                            </div>
                            <div class="mb-3">
                                <label for="editarWhatsapp" class="form-label">WhatsApp</label>
                                <input type="text" class="form-control" id="editarWhatsapp">
                            </div>
                            <div class="mb-3">
                                <label for="editarInstagram" class="form-label">Instagram</label>
                                <input type="text" class="form-control" id="editarInstagram">
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="button" class="btn btn-primary" onclick="guardarCambios()">Guardar
                            cambios</button>
                    </div>
                </div>
            </div>
        </div>




</body>

</html>
<!-- recuperar_contraseña.php -->
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-5">
            <div class="card p-4">
                <h2 class="text-center">Recuperar Contraseña</h2>
                <hr>
                <form action="./enviar_email.php" method="POST">
                    <div class="mb-3">
                        <label for="email" class="form-label">Correo electrónico</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Enviar enlace de recuperación</button>
                </form>
            </div>
        </div>
    </div>
</div>

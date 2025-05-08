<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Iniciar Sesión</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-4">
                <h2>Iniciar Sesión</h2>

                <?php if ($this->session->flashdata('error')): ?>
                    <div class="alert alert-danger">
                        <?php echo $this->session->flashdata('error'); ?>
                    </div>
                <?php endif; ?>

                <?php if ($this->session->flashdata('success')): ?>
                    <div class="alert alert-success">
                        <?php echo $this->session->flashdata('success'); ?>
                    </div>
                <?php endif; ?>

                <?php echo validation_errors('<div class="alert alert-danger">', '</div>'); ?>

                <?php echo form_open('auth/process_login', ['class' => 'needs-validation', 'novalidate' => '']); ?>

                <div class="mb-3">
                    <label for="identifier" class="form-label">Usuario o Email:</label>
                    <input type="text" name="identifier" id="identifier" class="form-control" value="<?php echo set_value('identifier'); ?>" required>
                </div>

                <div class="mb-3">
                    <label for="contrasena" class="form-label">Contraseña:</label>
                    <input type="password" name="contrasena" id="contrasena" class="form-control" required>
                </div>

                <div class="d-grid">
                    <button type="submit" class="btn btn-primary">Ingresar</button>
                </div>
                <?php echo form_close(); ?>

                <p class="mt-3 text-center">
                    <a href="<?php echo site_url('auth/forgot_password'); ?>">¿Olvidaste tu contraseña?</a>
                </p>
                <p class="text-center">
                    ¿No tienes cuenta? <a href="<?php echo site_url('auth/register'); ?>">Regístrate aquí</a>
                </p>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
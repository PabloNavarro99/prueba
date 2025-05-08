<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>ToDo List</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
    <div class="container">
        <div class="row mt-3 mb-3">
            <div class="col-sm-12">
                <h1>ToDo List</h1>
                <p>Bienvenido/a. <a href="<?php echo site_url('auth/logout'); ?>">Cerrar Sesión</a></p>
            </div>
        </div>

        <?php if ($this->session->flashdata('success')): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?php echo $this->session->flashdata('success'); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>
        <?php if ($this->session->flashdata('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?php echo $this->session->flashdata('error'); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>
        <?php
        if ($this->session->flashdata('error_form_agregar')) { // Para errores específicos del form de agregar
            echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">' . $this->session->flashdata('error_form_agregar') . '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
        }

        ?>
        <div class="row mb-3">
            <div class="col-md-12">
                <h3>Agregar Nueva Tarea</h3>
                <?php echo form_open('tareas/agregar', ['class' => 'row g-3 align-items-center']); ?>
                <div class="col-sm-5">
                    <label for="descripcion" class="visually-hidden">Nueva tarea</label>
                    <input type="text" name="descripcion" id="descripcion" placeholder="Nueva tarea" required class="form-control">
                </div>
                <div class="col-sm-5">
                    <label for="categoria" class="visually-hidden">Categoría</label>
                    <input type="text" name="categoria" id="categoria" placeholder="Categoría" required class="form-control">
                </div>
                <div class="col-sm-2">
                    <button type="submit" class="btn btn-primary w-100">Agregar</button>
                </div>
                <?php echo form_close(); ?>
            </div>
        </div>
        <div class="row p-3">
            <div class="col-md-12">
                <h3>Mis Tareas</h3>
                <?php if (empty($tareas)): ?>
                    <p>No tienes tareas pendientes. ¡Añade una nueva!</p>
                <?php else: ?>
                    <table class="table table-bordered table-striped">
                        <thead class="table-dark">
                            <tr>
                                <th>Descripción de la Tarea</th>
                                <th>Categoría</th>
                                <th style="width: 280px;">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($tareas as $tarea): ?>
                                <tr>
                                    <?php if ($tarea->completada): ?>
                                        <td><del><?php echo html_escape($tarea->descripcion); ?></del></td>
                                        <td><del><?php echo html_escape($tarea->categoria); ?></del></td>
                                        <td>
                                            <?php echo form_open('tareas/eliminar/' . $tarea->id, ['style' => 'display:inline;']); ?>
                                            <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                                            <?php echo form_close(); ?>
                                        </td>
                                    <?php else: // Tarea NO completada 
                                    ?>
                                        <?php echo form_open('tareas/actualizar/' . $tarea->id); ?>
                                        <td>
                                            <input type="text" class="form-control form-control-sm" name="descripcion" value="<?php echo html_escape($tarea->descripcion); ?>" required>
                                        </td>
                                        <td>
                                            <input type="text" class="form-control form-control-sm" name="categoria" value="<?php echo html_escape($tarea->categoria); ?>" required>
                                        </td>
                                        <td>
                                            <div class="d-flex flex-wrap gap-1">
                                                <button type="submit" class="btn btn-warning btn-sm">Actualizar</button>
                                                <?php echo form_close(); // Cierre del form de actualizar 
                                                ?>

                                                <?php echo form_open('tareas/completar/' . $tarea->id, ['class' => '']); ?>
                                                <button type="submit" class="btn btn-success btn-sm">Completar</button>
                                                <?php echo form_close(); ?>

                                                <?php echo form_open('tareas/eliminar/' . $tarea->id, ['class' => '']); ?>
                                                <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                                                <?php echo form_close(); ?>
                                            </div>
                                        </td>
                                        <?php echo form_close(); // ESTE FORM_CLOSE NO CORRESPONDE A NINGÚN FORM_OPEN. Eliminar si el anterior ya cerró el form de actualizar 
                                        ?>
                                    <?php endif; ?>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>

</html>
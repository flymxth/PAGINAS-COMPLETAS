<?php 
require 'empleados.php'; // Asegúrate de que este archivo maneja las consultas a la base de datos y las acciones del CRUD.
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD con Bootstrap, PHP y MySQL</title>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.slim.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
    <div class="container">
        <form action="" method="post" enctype="multipart/form-data">
            <!-- Modal -->
            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Empleado</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="form-row">
                                <input type="hidden" name="txtID" value="<?php echo $txtID; ?>" id="txtID">
                                <div class="row g-3">
                                    <div class="form-group col-md-4">
                                        <label for="txtNombre">Nombre(s):</label>
                                        <input type="text" class="form-control <?php echo (isset($error['nombre'])) ? "is-invalid" : ""; ?>" name="txtNombre" value="<?php echo $txtNombre; ?>" id="txtNombre">
                                        <div class="invalid-feedback">
                                            <?php echo (isset($error['nombre'])) ? $error['nombre'] : ""; ?>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="txtApellidoP">Apellido Paterno:</label>
                                        <input type="text" class="form-control <?php echo (isset($error['apellidop'])) ? "is-invalid" : ""; ?>" name="txtApellidoP" value="<?php echo $txtApellidoP; ?>" id="txtApellidoP">
                                        <div class="invalid-feedback">
                                            <?php echo (isset($error['apellidop'])) ? $error['apellidop'] : ""; ?>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="txtApellidoM">Apellido Materno:</label>
                                        <input type="text" class="form-control" name="txtApellidoM" required value="<?php echo $txtApellidoM; ?>" id="txtApellidoM">
                                    </div>
                                </div>
                                <div class="form-group col-md-12">
                                    <label for="txtCorreo">Correo:</label>
                                    <input type="email" class="form-control" name="txtCorreo" required value="<?php echo $txtCorreo; ?>" id="txtCorreo">
                                </div>
                                <div class="form-group col-md-12">
                                    <label for="txtFoto">Foto:</label>
                                    <?php if ($txtFoto != "") { ?>
                                        <br>
                                        <img class="img-thumbnail rounded mx-auto d-block" width="100px" src="../imagenes/<?php echo $txtFoto; ?>">
                                        <br><br>
                                    <?php } ?>
                                    <input type="file" class="form-control" accept="image/*" name="txtFoto" id="txtFoto">
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button value="btnAgregar" <?php echo $accionAgregar; ?> class="btn btn-success" type="submit" name="accion">Agregar</button>
                            <button value="btnModificar" <?php echo $accionModificar; ?> class="btn btn-warning" type="submit" name="accion">Modificar</button>
                            <button value="btnEliminar" <?php echo $accionEliminar; ?> class="btn btn-danger" type="submit" name="accion">Eliminar</button>
                            <button value="btnCancelar" <?php echo $accionCancelar; ?> class="btn btn-primary" type="submit" name="accion">Cancelar</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Button trigger modal -->
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                Agregar registro +
            </button>
        </form>

        <div class="row">
            <table class="table table-hover table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th>Foto</th>
                        <th>Nombre</th>
                        <th>Correo</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($listaEmpleados as $empleado){ ?>
                        <tr>
                            <td><img class="img-thumbnail" width="100px" src="../imagenes/<?php echo $empleado['foto']; ?>" alt=""></td>
                            <td><?php echo $empleado['nombre'] . " " . $empleado['apellidop'] . " " . $empleado['apellidom']; ?></td>
                            <td><?php echo $empleado['correo']; ?></td>
                            <td>
                                <form action="" method="post">
                                    <input type="hidden" name="txtID" value="<?php echo $empleado['id']; ?>">
                                    <input type="submit" class="btn btn-info" value="Seleccionar" name="accion">
                                    <input type="submit" onclick="return Confirmar('¿Realmente deseas borrar?');" class="btn btn-danger" value="Eliminar" name="accion">
                                </form>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>

        <?php if ($mostrarModal) { ?>
            <script>
                $(document).ready(function () {
                    $('#exampleModal').modal('show');
                });
            </script>
        <?php } ?>

        <script>
            function Confirmar(mensaje) {
                return confirm(mensaje);
            }
        </script>
    </div>
</body>
</html>

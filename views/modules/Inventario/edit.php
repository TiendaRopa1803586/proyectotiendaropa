<?php
require("../../partials/routes.php");
require("../../../app/Controllers/UsuariosController.php");

use app\Controllers\UsuariosController; ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <title><?= getenv('TITLE_SITE') ?> | Editar Usuario</title>
    <?php require("../../partials/head_imports.php"); ?>
</head>
<body class="hold-transition sidebar-mini">

<!-- Site wrapper -->
<div class="wrapper">
    <?php require("../../partials/navbar_customization.php"); ?>

    <?php require("../../partials/sliderbar_main_menu.php"); ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Editar Nuevo Usuario</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="<?= $baseURL; ?>/views/">Proyectotiendaropa</a></li>
                            <li class="breadcrumb-item active">Inicio</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">

            <?php if(!empty($_GET['respuesta'])){ ?>
            <?php if ($_GET['respuesta'] == "error"){ ?>
            <div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h5><i class="icon fas fa-ban"></i> Error!</h5>
                Error al modificar el usuario: <?= ($_GET['mensaje']) ?? "" ?>
            </div>
            <?php } ?>
            <?php } else if (empty($_GET['documento'])) { ?>
            <div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h5><i class="icon fas fa-ban"></i> Error!</h5>
                Faltan criterios de busqueda <?= ($_GET['mensaje']) ?? "" ?>
            </div>
            <?php } ?>
            <!-- Horizontal Form -->
            <p class="card card-info"></p>
                <div class="card-header">
                    <h3 class="card-title">Horizontal Form</h3>
                </div>
                <!-- /.card-header -->
                <?php if(!empty($_GET["documento"]) && isset($_GET["documento"])){ ?>


                    <?php
                    $Persona = UsuariosController::searchForDocumento($_GET["documento"]);
                        if(!empty($Persona)){
                    ?>
                            <!-- form start -->
                            <form class="form-horizontal" method="post" id="frmEditUsuario" name="frmEditUsuario" action="../../../app/Controllers/UsuariosController.php?action=edit">
                                <div class="card-body">
                                    <input id="Documento" name="Documento" value="<?php echo $Persona->getDocumento(); ?>" hidden
                                           required="required" type="text">
                                    <div class="form-group row">
                                        <label for="Nombre" class="col-sm-2 col-form-label">Nombre</label>
                                        <div class="col-sm-10">
                                            <input required type="text" class="form-control" id="Nombre" name="Nombre" value="<?= $Persona->getNombre(); ?>" placeholder="Ingrese sus nombres">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="Apellido" class="col-sm-2 col-form-label">Apellidos</label>
                                        <div class="col-sm-10">
                                            <input required type="text" class="form-control" id="Apellido" name="Apellido" value="<?= $Persona->getApellido(); ?>" placeholder="Ingrese sus apellidos">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="Genero" class="col-sm-2 col-form-label">Genero</label>
                                        <div class="col-sm-10">
                                            <select id="Genero" name="Genero" class="custom-select">
                                                <option <?= ($Persona->getGenero() == "masculino") ? "selected":""; ?> value="masculino">masculino</option>
                                                <option <?= ($Persona->getGenero() == "femenino") ? "selected":""; ?> value="femenino">femenino</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="Correo" class="col-sm-2 col-form-label">Correo</label>
                                        <div class="col-sm-10">
                                            <input required type="email" class="form-control" id="Correo" name="Correo" value="<?= $Persona->getCorreo(); ?>" placeholder="Ingrese sus Correo">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="Telefono" class="col-sm-2 col-form-label">Telefono</label>
                                        <div class="col-sm-10">
                                            <input required type="number" minlength="6" class="form-control" id="Telefono" name="Telefono" value="<?= $Persona->getTelefono(); ?>" placeholder="Ingrese su telefono">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="Direccion" class="col-sm-2 col-form-label">Direccion</label>
                                        <div class="col-sm-10">
                                            <input required type="text" class="form-control" id="Direccion" name="Direccion" value="<?= $Persona->getDireccion(); ?>" placeholder="Ingrese su direccion">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="Rol" class="col-sm-2 col-form-label">Rol</label>
                                        <div class="col-sm-10">
                                            <select id="Rol" name="Rol" class="custom-select">
                                                <option <?= ($Persona->getRol() == "Proveedor") ? "selected":""; ?> value="proveedor">proveedor</option>
                                                <option <?= ($Persona->getRol() == "Vendedor") ? "selected":""; ?> value="vendedor">vendedor</option>
                                                <option <?= ($Persona->getRol() == "Cliente") ? "selected":""; ?> value="cliente">cliente</option>
                                                <option <?= ($Persona->getRol() == "administrador") ? "selected":""; ?> value="administrador">administrador</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="Contrasena" class="col-sm-2 col-form-label">Contrasena</label>
                                        <div class="col-sm-10">
                                            <input required type="text" class="form-control" id="Contrasena" name="Contrasena" value="<?= $Persona->getContrasena(); ?>" placeholder="Ingrese su Contrasena">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="Estado" class="col-sm-2 col-form-label">Estado</label>
                                        <div class="col-sm-10">
                                            <select id="Estado" name="Estado" class="custom-select">
                                                <option <?= ($Persona->getEstado() == "activo") ? "selected":""; ?> value="activo">Activo</option>
                                                <option <?= ($Persona->getEstado() == "inactivo") ? "selected":""; ?> value="inactivo">Inactivo</option>
                                            </select>
                                        </div>
                                    </div>

                                </div>
                                <!-- /.card-body -->
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-info">Enviar</button>
                                    <a href="index.php" role="button" class="btn btn-default float-right">Cancelar</a>
                                </div>
                                <!-- /.card-footer -->
                            </form>
                    <?php }else{ ?>
                            <div class="alert alert-danger alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                <h5><i class="icon fas fa-ban"></i> Error!</h5>
                                No se encontro ningun registro con estos parametros de busqueda <?= ($_GET['mensaje']) ?? "" ?>
                            </div>
                    <?php } ?>

                <?php } ?>
            </div>
            <!-- /.card -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <?php require ('../../partials/footer.php');?>
</div>
<!-- ./wrapper -->
<?php require ('../../partials/scripts.php');?>
</body>
</html>

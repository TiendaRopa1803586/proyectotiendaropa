<?php
require_once("../../../App/Controllers/UsuariosController.php");
require("../../partials/routes.php");

use App\Controllers\UsuariosController;


?>
<!DOCTYPE html>
<html>
<head>
    <title><?= getenv('TITLE_SITE') ?> | Modificar Elemento</title>
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
                        <h1>Modificar Usuario</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="<?= $baseURL; ?>/views/">Proyecto</a></li>
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
                        Error al editar la Usuario: <?= ($_GET['mensaje']) ?? "" ?>
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
            <div class="card card-warning">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-edit"></i> <strong> Elemento</strong></h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="card-refresh"
                                data-source="create.php" data-source-selector="#card-refresh-content"
                                data-load-on-init="false"><i class="fas fa-sync-alt"></i></button>
                        <button type="button" class="btn btn-tool" data-card-widget="maximize"><i
                                    class="fas fa-expand"></i></button>
                        <button type="button" class="btn btn-tool" data-card-widget="collapse"><i
                                    class="fas fa-minus"></i></button>
                    </div>
                </div>
                <!-- /.card-header -->
                <?php if(!empty($_GET["documento"]) && isset($_GET["documento"])){ ?>
                    <p>
                    <?php
                    $DataProducto = UsuariosController::searchForId($_GET["documento"]);
                    if(!empty($DataProducto)){
                        ?>
                        <!-- form start -->
                        <form class="form-horizontal" method="post" id="frmModificarSubcatego" name="frmModificarSubcategoria" action="../../../App/Controllers/UsuariosController.php?action=edit">
                            <input id="Documento" name="Documento" value="<?php echo $DataProducto->getDocumento(); ?>" hidden required="required" type="text">

                            <div class="card-body">
                                <div class="form-group row">
                                    <label for="Nombre" class="col-sm-2 col-form-label">Nombre</label>
                                    <div class="col-sm-10">
                                        <input required type="text" class="form-control" id="Nombre" name="Nombre" value="<?= $DataProducto->getNombre(); ?>" placeholder="Ingrese nombre de la Categoria">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="Apellido" class="col-sm-2 col-form-label">Apellido</label>
                                    <div class="col-sm-10">
                                        <input required type="text" class="form-control" id="Apellido" name="Apellido" value="<?= $DataProducto->getApellido(); ?>" placeholder="Ingrese Apellido">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="Genero" class="col-sm-2 col-form-label">Genero</label>
                                    <div class="col-sm-10">
                                        <select id="Genero" name="Genero" class="custom-select">
                                            <option <?= ($DataProducto->getGenero() == "masculino") ? "selected":""; ?> value="masculino">masculino</option>
                                            <option <?= ($DataProducto->getGenero() == "femenino") ? "selected":""; ?> value="femenino">femenino</option>>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="Correo" class="col-sm-2 col-form-label">Correo</label>
                                    <div class="col-sm-10">
                                        <input required type="text" class="form-control" id="Correo" name="Correo" value="<?= $DataProducto->getCorreo(); ?>" placeholder="Ingrese Apellido">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="Telefono" class="col-sm-2 col-form-label">Telefono</label>
                                    <div class="col-sm-10">
                                        <input required type="text" class="form-control" id="Telefono" name="Telefono" value="<?= $DataProducto->getTelefono(); ?>" placeholder="Ingrese Apellido">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="Direccion" class="col-sm-2 col-form-label">Direccion</label>
                                    <div class="col-sm-10">
                                        <input required type="text" class="form-control" id="Direccion" name="Direccion" value="<?= $DataProducto->getDireccion(); ?>" placeholder="Ingrese Direccion">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="Rol" class="col-sm-2 col-form-label">Genero</label>
                                    <div class="col-sm-10">
                                        <select id="Rol" name="Rol" class="custom-select">
                                            <option <?= ($DataProducto->getRol() == "Administrador") ? "selected":""; ?> value="Administrador">Administrador</option>
                                            <option <?= ($DataProducto->getRol() == "Vendedor") ? "selected":""; ?> value="Vendedor">Vendedor</option>
                                            <option <?= ($DataProducto->getRol() == "Cliente") ? "selected":""; ?> value="Cliente">Cliente</option>
                                            <option <?= ($DataProducto->getRol() == "Proveedor") ? "selected":""; ?> value="Proveedor">Proveedor</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="Contrasena" class="col-sm-2 col-form-label">Contrasena</label>
                                    <div class="col-sm-10">
                                        <input required type="text" class="form-control" id="Contrasena" name="Contrasena" value="<?= $DataProducto->getContrasena(); ?>" placeholder="Ingrese Direccion">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="Estado" class="col-sm-2 col-form-label">Estado</label>
                                    <div class="col-sm-10">
                                        <select id="Estado" name="Estado" class="custom-select">
                                            <option <?= ($DataProducto->getEstado() == "activo") ? "selected":""; ?> value="activo">Activo</option>
                                            <option <?= ($DataProducto->getEstado() == "inactivo") ? "selected":""; ?> value="inactivo">Inactivo</option>>
                                        </select>
                                    </div>
                                </div>
                                <!-- /.card-body -->
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-warning">Enviar</button>
                                    <a href="show.php" role="button" class="btn btn-dark float-right">Cancelar</a>
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
                    </p>
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
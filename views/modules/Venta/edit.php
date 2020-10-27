<?php
require_once("../../../App/Controllers/UsuariosController.php");
require_once("../../../App/Controllers/SedeController.php");
require_once("../../../App/Controllers/VentaController.php");
require("../../partials/routes.php");

use App\Controllers\UsuariosController;
use App\Controllers\SedeController;
use App\Controllers\VentaController;


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
                        <h1>Modificar Venta</h1>
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
                        Error al editar la Venta: <?= ($_GET['mensaje']) ?? "" ?>
                    </div>
                <?php } ?>
            <?php } else if (empty($_GET['id'])) { ?>
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
                <?php if(!empty($_GET["id"]) && isset($_GET["id"])){ ?>
                    <p>
                    <?php
                    $DataProducto = VentaController::searchForID($_GET["id"]);
                    if(!empty($DataProducto)){
                        ?>
                        <!-- form start -->
                        <form class="form-horizontal" method="post" id="frmModificarVenta" name="frmModificarVenta" action="../../../App/Controllers/VentaController.php?action=edit">
                            <input id="Codigo" name="Codigo" value="<?php echo $DataProducto->getCodigo(); ?>" hidden required="required" type="text">

                            <div class="card-body">
                                <div class="form-group row">
                                    <label for="Fecha" class="col-sm-2 col-form-label">Fecha</label>
                                    <div class="col-sm-10">
                                        <input required type="date" class="form-control" id="Fecha" name="Fecha" value="<?= $DataProducto->getFecha(); ?>" placeholder="Ingrese Fecha">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="Vendedor" class="col-sm-2 col-form-label">Vendedor</label>
                                    <div class="col-sm-10">
                                        <?= UsuariosController::selectUsuario(false,
                                            true,
                                            'Vendedor',
                                            'Vendedor',
                                            (!empty($DataProducto)) ? $DataProducto->getVendedor()->getDocumento() : '',
                                            'form-control select2bs4 select2-info',
                                            "")
                                        ?>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="Cliente" class="col-sm-2 col-form-label">Cliente</label>
                                    <div class="col-sm-10">
                                        <?= UsuariosController::selectUsuario(false,
                                            true,
                                            'Cliente',
                                            'Cliente',
                                            (!empty($DataProducto)) ? $DataProducto->getCliente()->getDocumento() : '',
                                            'form-control select2bs4 select2-info',
                                            "")
                                        ?>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="Sede" class="col-sm-2 col-form-label">Sede</label>
                                    <div class="col-sm-10">
                                        <?= SedeController::selectSede(false,
                                            true,
                                            'Sede',
                                            'Sede',
                                            (!empty($DataProducto)) ? $DataProducto->getSede()->getCodigo() : '',
                                            'form-control select2bs4 select2-info',
                                            "")
                                        ?>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="MetodoPago" class="col-sm-2 col-form-label">MetodoPago</label>
                                    <div class="col-sm-10">
                                        <input required type="text" class="form-control" id="MetodoPago" name="MetodoPago" value="<?= $DataProducto->getMetodoPago(); ?>" placeholder="Ingrese MetodoPago">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="Total" class="col-sm-2 col-form-label">Total</label>
                                    <div class="col-sm-10">
                                        <input required type="text" class="form-control" id="Total" name="Total" value="<?= $DataProducto->getTotal(); ?>" placeholder="Ingrese Fecha">
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
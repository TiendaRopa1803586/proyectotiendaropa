<?php

require_once("../../../App/Controllers/UsuariosController.php");
require_once("../../../App/Controllers/SedeController.php");
require("../../partials/routes.php");

use App\Controllers\UsuariosController;
use App\Controllers\SedeController;
use App\Controllers\VentaController;



 ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <title><?= getenv('TITLE_SITE') ?> | Crear Venta</title>
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
                        <h1>Crear Venta</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="<?= $baseURL; ?>/views/">proyectotiendaropa</a></li>
                            <li class="breadcrumb-item active">Inicio</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">

            <?php if(!empty($_GET['respuesta'])){ ?>
                <?php if ($_GET['respuesta'] != "correcto"){ ?>
                    <div class="alert alert-danger alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <h5><i class="icon fas fa-ban"></i> Error!</h5>
                        Error al crear Venta: <?= $_GET['mensaje'] ?>
                    </div>
                <?php } ?>
            <?php } ?>

            <!-- Horizontal Form -->
            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title"> Formulario Venta</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form class="form-horizontal" method="post" id="frmCreateVenta" name="frmCreateVenta" action="../../../App/Controllers/VentaController.php?action=create">
                    <div class="card-body">
                        <div class="form-group row">
                            <label for="Fecha" class="col-sm-2 col-form-label">Fecha</label>
                            <div class="col-sm-10">
                                <input required type="date" class="form-control" id="Fecha" name="Fecha" placeholder="Ingrese Fecha">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="Vendedor" class="col-sm-2 col-form-label">Vendedor</label>
                            <div class="col-sm-10">
                                <?= UsuariosController::selectUsuario(false,
                                    true,
                                    'Vendedor',
                                    'Vendedor',
                                    (!empty($dataProducto)) ? $dataProducto->getVendedor()->getCodigo() : '',
                                    'form-control select2bs4 select2-info',
                                    "Estado = 'Activo'")
                                ?>
                            </div>
                        </div>

                        <div class="form-group row">.
                            <label for="Sede" class="col-sm-2 col-form-label">Sede</label>
                            <div class="col-sm-8">
                                <?= SedeController::selectSede(false,
                                    true,
                                    'Sede',
                                    'Sede',
                                    (!empty($dataProducto)) ? $dataProducto->getSede()->getCodigo() : '',
                                    'form-control select2bs4 select2-info',
                                    "Estado = 'Activo'")
                                ?>
                            </div>
                        </div>
                        <div class="form-group row">.
                            <label for="Cliente" class="col-sm-2 col-form-label">Cliente</label>
                            <div class="col-sm-8">
                                <?= UsuariosController::selectUsuario(false,
                                    true,
                                    'Cliente',
                                    'Cliente',
                                    (!empty($dataProducto)) ? $dataProducto->getCliente()->getCodigo() : '',
                                    'form-control select2bs4 select2-info',
                                    "Estado = 'Activo'")
                                ?>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="MetodoPago" class="col-sm-2 col-form-label">MetodoPago</label>
                            <div class="col-sm-10">
                                <select id="MetodoPago" name="MetodoPago" class="custom-select">
                                    <option value="TarjetadeCredito">TarjetadeCredito</option>
                                    <option value="Efectivo">Efectivo</option>
                                    <option value="Tarjetadebito">Tarjetadebito</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="Total" class="col-sm-2 col-form-label">Total</label>
                            <div class="col-sm-10">

                                <input required type="text" class="form-control" id="Total" name="Total" placeholder="Ingrese Total">
                            </div>
                        </div>


                        <div class="form-group row">
                            <label for="Estado" class="col-sm-2 col-form-label">Estado</label>
                            <div class="col-sm-10">
                                <select id="Estado" name="Estado" class="custom-select">
                                    <option value="activo">Activo</option>
                                    <option value="inactivo">Inactivo</option>
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

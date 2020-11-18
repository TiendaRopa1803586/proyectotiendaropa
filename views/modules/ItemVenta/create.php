<?php
require_once("../../../App/Controllers/VentaController.php");
require_once("../../../App/Controllers/InventarioController.php");

require("../../partials/routes.php");

use App\Controllers\VentaController;
use App\Controllers\InventarioController;
use App\Controllers\ItemVentaController;



 ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <title><?= getenv('TITLE_SITE') ?> | Crear ItemVenta</title>
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
                        <h1>Crear ItemVenta</h1>
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
                        Error al crear ItemVenta: <?= $_GET['mensaje'] ?>
                    </div>
                <?php } ?>
            <?php } ?>

            <!-- Horizontal Form -->
            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title"> Formulario ItemVenta</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form class="form-horizontal" method="post" id="frmCreateItemVenta" name="frmCreateItemVenta" action="../../../App/Controllers/ItemVentaController.php?action=create">
                    <div class="card-body">
                        <div class="form-group row">.
                            <label for="Venta" class="col-sm-2 col-form-label">Venta</label>
                            <div class="col-sm-8">
                                <?= VentaController::selectVenta(false,
                                    true,
                                    'Venta',
                                    'Venta',
                                    (!empty($dataProducto)) ? $dataProducto->getVenta()->getCodigo() : '',
                                    'form-control select2bs4 select2-info',
                                    "Estado = 'Activo'")
                                ?>
                            </div>
                        </div>
                        <div class="form-group row">.
                            <label for="Inventario" class="col-sm-2 col-form-label">Inventario</label>
                            <div class="col-sm-8">
                                <?= InventarioController::selectInventario(false,
                                    true,
                                    'Inventario',
                                    'Inventario',
                                    (!empty($dataProducto)) ? $dataProducto->getInventario()->getCodigo() : '',
                                    'form-control select2bs4 select2-info',
                                    "Estado = 'Activo'")
                                ?>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="Cantidad" class="col-sm-2 col-form-label">Total</label>
                            <div class="col-sm-10">

                                <input required type="text" class="form-control" id="Cantidad" name="Cantidad" placeholder="Ingrese Cantidad">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="Precio" class="col-sm-2 col-form-label">Precio</label>
                            <div class="col-sm-10">

                                <input required type="text" class="form-control" id="Precio" name="Precio" placeholder="Ingrese Precio">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="IVA" class="col-sm-2 col-form-label">IVA</label>
                            <div class="col-sm-10">

                                <input required type="text" class="form-control" id="IVA" name="IVA" placeholder="Ingrese IVA">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="PrecioTotal" class="col-sm-2 col-form-label">PrecioTotal</label>
                            <div class="col-sm-10">

                                <input required type="text" class="form-control" id="PrecioTotal" name="PrecioTotal" placeholder="Ingrese PrecioTotal">
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

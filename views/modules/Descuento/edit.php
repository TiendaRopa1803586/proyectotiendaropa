<?php
require("../../../app/Controllers/ProductoController.php");
require("../../../app/Controllers/DescuentoController.php");
require("../../partials/routes.php");

use App\Controllers\ProductoController;
use App\Controllers\DescuentoController; ?>
<!DOCTYPE html>
<html>
<head>
    <title><?= getenv('TITLE_SITE') ?> | Modificar Descuento</title>
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
                        <h1>Modificar Descuento</h1>
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
                <?php if ($_GET['respuesta'] == "error"){ ?>
                    <div class="alert alert-danger alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <h5><i class="icon fas fa-ban"></i> Error!</h5>
                            Error al editar el descuento: <?= ($_GET['mensaje']) ?? "" ?>
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
            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">Form Modificar Descuento</h3>
                </div>
                <!-- /.card-header -->
                <?php if(!empty($_GET["id"]) && isset($_GET["id"])){ ?>
                    <p>
                    <?php
                    $DataDescuento = DescuentoController::searchForID($_GET["id"]);
                        if(!empty($DataDescuento)){
                    ?>
                            <!-- form start -->
                            <form class="form-horizontal" method="post" id="frmModificardescuento" name="frmModificardescuento" action="../../../App/Controllers/DescuentoController.php?action=edit">
                                <input id="Codigo" name="Codigo" value="<?php echo $DataDescuento->getCodigo(); ?>" hidden required="required" type="text">
                                <div class="card-body">
                                    <div class="form-group row">
                                        <label for="Nombre" class="col-sm-2 col-form-label">Nombre</label>
                                        <div class="col-sm-10">
                                            <input required type="text" class="form-control" id="Nombre" name="Nombre" value="<?= $DataDescuento->getNombre(); ?>" placeholder="Ingrese nombre del descuento">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="Porcentaje" class="col-sm-2 col-form-label">Porcentaje</label>
                                        <div class="col-sm-10">
                                            <input required type="text" class="form-control" id="Porcentaje" name="Porcentaje" value="<?= $DataDescuento->getporcentaje(); ?>" placeholder="Ingrese el porcentaje">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="Fecha_inicio" class="col-sm-2 col-form-label">FechaInicio</label>
                                        <div class="col-sm-10">
                                            <input required type="date" class="form-control" id="Fecha_inicio" name="Fecha_inicio" value="<?= $DataDescuento->getFecha_inicio(); ?>" placeholder="Ingrese la fecha inicio">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="Fecha_fin" class="col-sm-2 col-form-label">FechaFin</label>
                                        <div class="col-sm-10">
                                            <input required type="date" class="form-control" id="Fecha_fin" name="Fecha_fin" value="<?= $DataDescuento->getFecha_fin(); ?>" placeholder="Ingrese la fecha fin">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="Producto" class="col-sm-2 col-form-label">Producto</label>
                                        <div class="col-sm-10">
                                            <?= ProductoController::selectProducto(false,
                                                true,
                                                'Producto',
                                                'Producto',
                                                (!empty($DataDescuento)) ? $DataDescuento->getProducto()->getCodigo() : '',
                                                'form-control select2bs4 select2-info',
                                                "")
                                            ?>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="Estado" class="col-sm-2 col-form-label">Estado</label>
                                        <div class="col-sm-10">
                                            <select id="Estado" name="Estado" class="custom-select">
                                                <option <?= ($DataDescuento->getEstado() == "activo") ? "selected":""; ?> value="activo">Activo</option>
                                                <option <?= ($DataDescuento->getEstado() == "inactivo") ? "selected":""; ?> value="inactivo">Inactivo</option>>
                                            </select>
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

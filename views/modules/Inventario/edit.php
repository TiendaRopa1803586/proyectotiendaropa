<?php

require_once("../../../App/Controllers/ProductoController.php");
require_once("../../../App/Controllers/CompraController.php");
require_once("../../../App/Controllers/InventarioController.php");
require("../../partials/routes.php");

use App\Controllers\ProductoController;
use App\Controllers\CompraController;
use App\Controllers\InventarioController;


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
                        <h1>Modificar Inventario</h1>
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
                        Error al editar la Inventario: <?= ($_GET['mensaje']) ?? "" ?>
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
                    $DataProducto = InventarioController::searchForID($_GET["id"]);
                    if(!empty($DataProducto)){
                        ?>
                        <!-- form start -->
                        <form class="form-horizontal" method="post" id="frmModificarInventario" name="frmModificarInventario" action="../../../App/Controllers/InventarioController.php?action=edit">
                            <input id="Codigo" name="Codigo" value="<?php echo $DataProducto->getCodigo(); ?>" hidden required="required" type="text">

                            <div class="card-body">
                                <div class="form-group row">
                                    <label for="Producto" class="col-sm-2 col-form-label">Producto</label>
                                    <div class="col-sm-10">
                                        <?= ProductoController::selectProducto(false,
                                            true,
                                            'Producto',
                                            'Producto',
                                            (!empty($DataProducto)) ? $DataProducto->getProducto()->getCodigo() : '',
                                            'form-control select2bs4 select2-info',
                                            "")
                                        ?>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="Compra" class="col-sm-2 col-form-label">Compra</label>
                                    <div class="col-sm-10">
                                        <?= CompraController::selectCompra(false,
                                            true,
                                            'Compra',
                                            'Compra',
                                            (!empty($DataProducto)) ? $DataProducto->getCompra()->getCodigo() : '',
                                            'form-control select2bs4 select2-info',
                                            "")
                                        ?>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="Cantidad" class="col-sm-2 col-form-label">Cantidad</label>
                                    <div class="col-sm-10">
                                        <input required type="text" class="form-control" id="Cantidad" name="Cantidad" value="<?= $DataProducto->getCantidad(); ?>" placeholder="Ingrese Cantidad">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="Precio" class="col-sm-2 col-form-label">Precio</label>
                                    <div class="col-sm-10">
                                        <input required type="text" class="form-control" id="Precio" name="Precio" value="<?= $DataProducto->getPrecio(); ?>" placeholder="Ingrese Precio">
                                    </div>
                                </div> <div class="form-group row">
                                    <label for="IVA" class="col-sm-2 col-form-label">IVA</label>
                                    <div class="col-sm-10">
                                        <input required type="text" class="form-control" id="IVA" name="IVA" value="<?= $DataProducto->getIVA(); ?>" placeholder="Ingrese IVA">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="Talla" class="col-sm-2 col-form-label">Talla</label>
                                    <div class="col-sm-10">
                                        <select id="Talla" name="Talla" class="custom-select">
                                            <option <?= ($DataProducto->getTalla() == "S") ? "selected":""; ?> value="S">S</option>
                                            <option <?= ($DataProducto->getTalla() == "M") ? "selected":""; ?> value="M">M</option>>
                                            <option <?= ($DataProducto->getTalla() == "L") ? "selected":""; ?> value="L">L</option>>
                                            <option <?= ($DataProducto->getTalla() == "X") ? "selected":""; ?> value="X">X</option>>
                                            <option <?= ($DataProducto->getTalla() == "XL") ? "selected":""; ?> value="XL">XL</option>>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="Color" class="col-sm-2 col-form-label">Color</label>
                                    <div class="col-sm-10">
                                        <select id="Color" name="Color" class="custom-select">
                                            <option <?= ($DataProducto->getColor() == "Rojo") ? "selected":""; ?> value="Rojo">Rojo</option>
                                            <option <?= ($DataProducto->getColor() == "Verde") ? "selected":""; ?> value="Verde">Verde</option>
                                            <option <?= ($DataProducto->getColor() == "Azul") ? "selected":""; ?> value="Azul">Azul</option>
                                        </select>
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
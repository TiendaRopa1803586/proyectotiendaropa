<?php
require("../../partials/routes.php");
require_once("../../../App/Controllers/ProductoController.php");
use App\Controllers\ProductoController;
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <title><?= getenv('TITLE_SITE') ?> | Crear Descuento</title>
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
                        <h1>Crear Descuento</h1>
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
                            Error al crear el descuento: <?= $_GET['mensaje'] ?>
                    </div>
                <?php } ?>
            <?php } ?>

            <!-- Horizontal Form -->
            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title"> Formulario Descuento</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form class="form-horizontal" method="post" id="frmCreatedescuento" name="frmCreatedescuento" action="../../../App/Controllers/DescuentoController.php?action=create">
                    <div class="card-body">
                        <div class="form-group row">
                            <label for="Nombre" class="col-sm-2 col-form-label">Nombre</label>
                            <div class="col-sm-10">
                                <input required type="text" class="form-control" id="Nombre" name="Nombre" placeholder="Ingrese nombre del Descuento">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="porcentaje" class="col-sm-2 col-form-label">Porcentaje</label>
                            <div class="col-sm-10">
                                <input required type="text" class="form-control" id="Porcentaje" name="Porcentaje" placeholder="Ingrese el porcentaje">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="Fecha_inicio" class="col-sm-2 col-form-label"> Fecha_inicio</label>
                            <div class="col-sm-10">
                                <input required type="date" class="form-control" id="Fecha_inicio" name="Fecha_inicio" placeholder="Ingrese la fecha de inicio">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="Fecha_fin" class="col-sm-2 col-form-label">Fecha_fin</label>
                            <div class="col-sm-10">
                                <input required type="date" class="form-control" id="Fecha_fin" name="Fecha_fin" placeholder="Ingrese la fecha de fin">
                            </div>
                        </div>
                        <div class="form-group row">.
                            <label for="Producto" class="col-sm-2 col-form-label">Subcategoria</label>
                            <div class="col-sm-8">
                                <?= ProductoController::selectProducto(false,
                                    true,
                                    'Producto',
                                    'Producto',
                                    (!empty($dataProducto)) ? $dataProducto->getProducto()->getCodigo() : '',
                                    'form-control select2bs4 select2-info',
                                    "Estado = 'Activo'")
                                ?>
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

<?php
require_once("../../../App/Controllers/SubcategoriaController.php");
require_once("../../../App/Controllers/MarcaController.php");
require_once("../../../App/Controllers/ProductoController.php");
require("../../partials/routes.php");

use App\Controllers\SubcategoriaController;
use App\Controllers\MarcaController;
use App\Controllers\ProductoController;


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
                        <h1>Modificar Producto</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="<?= $baseURL; ?>/views/">Proyecto-ABC</a></li>
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
                        Error al editar la Subcategoria: <?= ($_GET['mensaje']) ?? "" ?>
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
                    $DataProducto = ProductoController::searchForID($_GET["id"]);
                    if(!empty($DataProducto)){
                        ?>
                        <!-- form start -->
                        <form class="form-horizontal" method="post" id="frmModificarSubcatego" name="frmModificarSubcategoria" action="../../../App/Controllers/ProductoController.php?action=edit">
                            <input id="Codigo" name="Codigo" value="<?php echo $DataProducto->getCodigo(); ?>" hidden required="required" type="text">

                            <div class="card-body">
                                <div class="form-group row">
                                    <label for="Nombre" class="col-sm-2 col-form-label">Nombre</label>
                                    <div class="col-sm-10">
                                        <input required type="text" class="form-control" id="Nombre" name="Nombre" value="<?= $DataProducto->getNombre(); ?>" placeholder="Ingrese nombre de la Categoria">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="Importado" class="col-sm-2 col-form-label">Importado</label>
                                    <div class="col-sm-10">
                                        <input required type="text" class="form-control" id="Importado" name="Importado" value="<?= $DataProducto->getImportado(); ?>" placeholder="Ingrese nombre de la Categoria">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="Descripcion" class="col-sm-2 col-form-label">Descripcion</label>
                                    <div class="col-sm-10">
                                        <input required type="text" class="form-control" id="Descripcion" name="Descripcion" value="<?= $DataProducto->getDescripcion(); ?>" placeholder="Ingrese nombre de la Categoria">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="Marca" class="col-sm-2 col-form-label">Marca</label>
                                    <div class="col-sm-10">
                                        <?= MarcaController::selectMarca(false,
                                            true,
                                            'Marca',
                                            'Marca',
                                            (!empty($DataProducto)) ? $DataProducto->getMarca()->getCodigo() : '',
                                            'form-control select2bs4 select2-info',
                                            "")
                                        ?>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="Subcategoria" class="col-sm-2 col-form-label">Subcategoria</label>
                                    <div class="col-sm-10">
                                        <?= SubcategoriaController::selectSubcategoria(false,
                                            true,
                                            'Subcategoria',
                                            'Subcategoria',
                                            (!empty($DataProducto)) ? $DataProducto->getSubcategoria()->getCodigo() : '',
                                            'form-control select2bs4 select2-info',
                                            "")
                                        ?>
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
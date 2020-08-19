<?php require("../../partials/routes.php"); ?>
<!DOCTYPE html>

<head>
    <title><?= getenv('TITLE_SITE') ?> | Crear Usuario</title>
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
                        <h1>Crear un Nuevo Usuario</h1>
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
                            Error al crear el usuario: <?= $_GET['mensaje'] ?>
                    </div>
                <?php } ?>
            <?php } ?>

            <!-- Horizontal Form -->
            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">Formulario</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form class="form-horizontal" method="post" id="frmCreateUsuario" name="frmCreateUsuario" action="../../../app/Controllers/InventariosController.php?action=create">
                    <div class="card-body">
                        <div class="form-group row">
                            <label for="Producto" class="col-sm-2 col-form-label">Producto</label>
                            <div class="col-sm-10">
                                <input required type="number" class="form-control" id="Producto" name="Producto" placeholder="Ingrese Producto">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="Compra" class="col-sm-2 col-form-label">Compra</label>
                            <div class="col-sm-10">
                                <input required type="number" minlength="6" class="form-control" id="Compra" name="Compra" placeholder="Ingrese su Compra">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="Cantidad" class="col-sm-2 col-form-label">Cantidad</label>
                            <div class="col-sm-10">
                                <input required type="number" minlength="6" class="form-control" id="Cantidad" name="Cantidad" placeholder="Ingrese Cantidad">
                            </div>
                        </div>


                        <div class="form-group row">
                            <label for="Precio" class="col-sm-2 col-form-label">Precio</label>
                            <div class="col-sm-10">
                                <input required type="number" class="form-control" id="Precio" name="Precio" placeholder="Ingrese precio">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="IVA" class="col-sm-2 col-form-label">IVA</label>
                            <div class="col-sm-10">
                                <input required type="number" minlength="6" class="form-control" id="IVA" name="IVA" placeholder="Ingrese IVA">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="Talla" class="col-sm-2 col-form-label">Talla</label>
                            <div class="col-sm-10">
                                <select id="Talla" name="Talla" class="custom-select">
                                    <option value="S">S</option>
                                    <option value="M">M</option>
                                    <option value="L">L</option>
                                    <option value="X">X</option>
                                    <option value="xl">xl</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="Color" class="col-sm-2 col-form-label">Color</label>
                            <div class="col-sm-10">
                                <select id="Color" name="Color" class="custom-select">
                                    <option value="Rojo">Rojo</option>
                                    <option value="Verde">Verde</option>
                                    <option value="Azul">Azul</option>

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

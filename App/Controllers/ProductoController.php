<?php

namespace App\Controllers;
require(__DIR__.'/../Models/Producto.php');

use App\Models\GeneralFunctions;
use App\Models\Marca;
use App\Models\Producto;
use App\Models\Subcategoria;

if(!empty($_GET['action'])){
    ProductoController::main($_GET['action']);
}

class ProductoController{

    static function main($action)
    {
        if ($action == "create") {
            ProductoController::create();
        } else if ($action == "edit") {
            ProductoController::edit();
        } else if ($action == "searchForID") {
            ProductoController::searchForID($_REQUEST['idProducto']);
        } else if ($action == "searchAll") {
            ProductoController::getAll();
        } else if ($action == "activate") {
            ProductoController::activate();
        } else if ($action == "inactivate") {
            ProductoController::inactivate();
        }/*else if ($action == "login"){
           ProductoController::login();
        }else if($action == "cerrarSession"){
            ProductoController::cerrarSession();
        }*/

    }
//funcion crear producto
    static public function create()
    {
        try {
            $arrayProducto = array();
            $arrayProducto['Nombre'] = $_POST['Nombre'];
            $arrayProducto['Importado'] = $_POST['Importado'];
            $arrayProducto['Descripcion'] = $_POST['Descripcion'];
            $arrayProducto['Marca'] = Marca::searchForId($_POST['Marca']);
            $arrayProducto['Subcategoria'] = Subcategoria::searchForId($_POST['Subcategoria']);
            $arrayProducto['Estado'] = 'Activo';


            if(!Producto::ProductoRegistrado($arrayProducto['Nombre'])){
                $Producto = new Producto ($arrayProducto);
                if($Producto->create()){
                    header("Location: ../../views/modules/Producto/index.php?respuesta=correcto");
                }
            }else{
                header("Location: ../../views/modules/Producto/create.php?respuesta=error&mensaje=Producto ya registrada");
            }
        } catch (Exception $e) {
            header("Location: ../../views/modules/Producto/create.php?respuesta=error&mensaje=" . $e->getMessage());
        }
    }

    static public function edit (){
        try {
            $arrayProducto = array();
            $arrayProducto['Nombre'] = $_POST['Nombre'];
            $arrayProducto['Importado'] = $_POST['Importado'];
            $arrayProducto['Descripcion'] = $_POST['Descripcion'];
            $arrayProducto['Marca'] = Marca::searchForId($_POST['Marca']);
            $arrayProducto['Subcategoria'] = Subcategoria::searchForId($_POST['Subcategoria']);
            $arrayProducto['Estado'] = 'Activo';

            $Producto = new Producto($arrayProducto);
            $Producto->update();

            header("Location: ../../views/modules/Producto/show.php?id=".$Producto->getCodigo()."&respuesta=correcto");
        } catch (\Exception $e) {
            var_dump($e);
            //header("Location: ../../views/modules/Producto/edit.php?respuesta=error&mensaje" . $e->getMessage());
        }
    }
//funcion activa de la Producto
    static public function activate (){
        try {
            $ObjProducto = Producto::searchForId($_GET['Id']);
            $ObjProducto->setEstado("activo");
            if($ObjProducto->update()){
                header("Location: ../../views/modules/Producto/index.php?respuesta=correcto");
            }else{
                header("Location: ../../views/modules/Producto/index.php?respuesta=error&mensaje=Error al guardar");
            }
        } catch (\Exception $e) {
            //var_dump($e);
            header("Location: ../../views/modules/Producto/index.php?respuesta=error&mensaje=".$e->getMessage());
        }
    }
//funcion inactiva de la producto
    static public function inactivate (){
        try {
            $ObjProducto = Producto::searchForId($_GET['Id']);
            $ObjProducto->setEstado("inactivo");
            if($ObjProducto->update()){
                header("Location: ../../views/modules/Producto/index.php?respuesta=correcto");
            }else{
                header("Location: ../../views/modules/Producto/index.php?respuesta=error&mensaje=Error al guardar");
            }
        } catch (\Exception $e) {
            //var_dump($e);
            header("Location: ../../views/modules/Producto/index.php?respuesta=error&mensaje" . $e-> getMessage());
        }
    }

    static public function searchForID ($id){
        try {
            return Producto::searchForId($id);
        } catch (\Exception $e) {
            var_dump($e);
            GeneralFunctions::console( $e, 'error', 'errorStack');
            //header("Location: ../../views/modules/Producto/manager.php?respuesta=error");
        }
    }

    static public function getAll (){
        try {
            return Producto::getAll();
        } catch (\Exception $e) {
            var_dump($e);
            //header("Location: ../Vista/modules/Producto/manager.php?respuesta=error");
        }
    }
}
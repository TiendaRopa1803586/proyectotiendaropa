<?php

namespace App\Controllers;
require(__DIR__.'/../Models/ItemVenta.php');



use App\Models\GeneralFunctions;
use App\Models\Venta;
use App\Models\Inventario;
use App\Models\ItemVenta;

if(!empty($_GET['action'])){
    ItemVentaController::main($_GET['action']);
}

class ItemVentaController{

    static function main($action)
    {
        if ($action == "create") {
            ItemVentaController::create();
        } else if ($action == "edit") {
            ItemVentaController::edit();
        } else if ($action == "searchForId") {
            ItemVentaController::searchForId($_REQUEST['Id']);
        } else if ($action == "searchAll") {
            ItemVentaController::getAll();
        } else if ($action == "activate") {
            ItemVentaController::activate();
        } else if ($action == "inactivate") {
            ItemVentaController::inactivate();
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
            $arrayProducto['Venta'] = Venta::searchForId($_POST['Venta']);
            $arrayProducto['Inventario'] = Inventario::searchForId($_POST['Inventario']);
            $arrayProducto['Cantidad'] = $_POST['Cantidad'];
            $arrayProducto['Precio'] = $_POST['Precio'];
            $arrayProducto['IVA'] = $_POST['IVA'];
            $arrayProducto['PrecioTotal'] = $_POST['PrecioTotal'];
            $arrayProducto['Estado'] = $_POST['Estado'];


            $Producto = new ItemVenta($arrayProducto);
            if(!ItemVenta::ItemVentaRegistrado($arrayProducto['Cantidad'])){
                $Producto = new ItemVenta($arrayProducto);
                if($Producto->create()){
                   header("Location: ../../views/modules/ItemVenta/index.php?respuesta=correcto");
                }
            }else{
                header("Location: ../../views/modules/ItemVenta/create.php?respuesta=error&mensaje=Producto ya registrado");
            }
        } catch (Exception $e) {
            GeneralFunctions::console( $e, 'error', 'errorStack');
            header("Location: ../../views/modules/ItemVenta/create.php?respuesta=error&mensaje=" . $e->getMessage());
        }
    }

    static public function edit (){
        try {
            $arrayVenta = array();
            $arrayVenta['Venta'] = Venta::searchForId($_POST['Venta']);
            $arrayVenta['Inventario'] = Inventario::searchForId($_POST['Inventario']);
            $arrayVenta['Cantidad'] = $_POST['Cantidad'];
            $arrayVenta['Precio'] = $_POST['Precio'];
            $arrayVenta['IVA'] = $_POST['IVA'];
            $arrayVenta['PrecioTotal'] = $_POST['PrecioTotal'];
            $arrayVenta['Estado'] = $_POST['Estado'];
            $arrayVenta['Codigo'] = $_POST['Codigo'];

            $Venta = new ItemVenta($arrayVenta);
            $Venta->update();

            header("Location: ../../views/modules/ItemVenta/show.php?id=".$Venta->getCodigo()."&respuesta=correcto");
        } catch (\Exception $e) {
            //GeneralFunctions::console( $e, 'error', 'errorStack');
            header("Location: ../../views/modules/ItemVenta/edit.php?respuesta=error&mensaje=".$e->getMessage());
        }
    }
//funcion activa de la Producto
    static public function activate()
    {
        try {
            $ObjUsuario = ItemVenta::searchForId($_GET['Id']);
            $ObjUsuario->setEstado("activo");
            if ($ObjUsuario->update()) {
                header("Location: ../../views/modules/ItemVenta/index.php");
            } else {
                header("Location: ../../views/modules/ItemVenta/index.php?respuesta=error&mensaje=Error al guardar");
            }
        } catch (\Exception $e) {
            // GeneralFunctions::console( $e, 'error', 'errorStack');
            //var_dump($e);
            header("Location: ../../views/modules/ItemVenta/index.php?respuesta=error&mensaje=" . $e->getMessage());
        }
    }
//funcion inactiva de la producto
    static public function inactivate ()
    {
        try {
            $ObjProducto = ItemVenta::searchForId($_GET['Id']);
            $ObjProducto->setEstado("inactivo");
            if($ObjProducto->update()){
                header("Location: ../../views/modules/ItemVenta/index.php?respuesta=correcto");
            }else{
                header("Location: ../../views/modules/ItemVenta/index.php?respuesta=error&mensaje=Error al guardar");
            }
        } catch (\Exception $e) {
            //var_dump($e);
            header("Location: ../../views/modules/ItemVenta/index.php?respuesta=error&mensaje" . $e-> getMessage());
        }
    }

    static public function searchForId ($id){
        try {
            return ItemVenta::searchForId($id);
        } catch (\Exception $e) {
            var_dump($e);
            GeneralFunctions::console( $e, 'error', 'errorStack');
            //header("Location: ../../views/modules/Producto/manager.php?respuesta=error");
        }
    }

    static public function getAll (){
        try {
            return ItemVenta::getAll();
        } catch (\Exception $e) {
            var_dump($e);
            header("Location: ../views/modules/Compra/manager.php?respuesta=error");
        }
    }
}
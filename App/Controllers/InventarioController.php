<?php

namespace App\Controllers;

require(__DIR__.'/../Models/Inventario.php');



use App\Models\GeneralFunctions;
use App\Models\Producto;
use App\Models\Compra;
use App\Models\Inventario;

if(!empty($_GET['action'])){
    InventarioController::main($_GET['action']);
}

class InventarioController{

    static function main($action)
    {
        if ($action == "create") {
            InventarioController::create();
        } else if ($action == "edit") {
            InventarioController::edit();
        } else if ($action == "searchForId") {
            InventarioController::searchForId($_REQUEST['Id']);
        } else if ($action == "searchAll") {
            InventarioController::getAll();
        } else if ($action == "activate") {
            InventarioController::activate();
        } else if ($action == "inactivate") {
            InventarioController::inactivate();
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
            $arrayProducto['Producto'] = Producto::searchForId($_POST['Producto']);
            $arrayProducto['Compra'] = Compra::searchForId($_POST['Compra']);
            $arrayProducto['Cantidad'] = $_POST['Cantidad'];
            $arrayProducto['Precio'] = $_POST['Precio'];
            $arrayProducto['IVA'] = $_POST['IVA'];
            $arrayProducto['Talla'] = $_POST['Talla'];
            $arrayProducto['Color'] = $_POST['Color'];
            $arrayProducto['Estado'] = $_POST['Estado'];


            $Producto = new Inventario($arrayProducto);
            if(!Inventario::InventarioRegistrado($arrayProducto['Precio'])){
                $Producto = new Inventario($arrayProducto);
                if($Producto->create()){
                   header("Location: ../../views/modules/Inventario/index.php?respuesta=correcto");
                }
            }else{
                header("Location: ../../views/modules/Inventario/create.php?respuesta=error&mensaje=Producto ya registrado");
            }
        } catch (Exception $e) {
            GeneralFunctions::console( $e, 'error', 'errorStack');
            header("Location: ../../views/modules/Inventario/create.php?respuesta=error&mensaje=" . $e->getMessage());
        }
    }

    static public function edit (){
        try {
            $arrayVenta = array();
            $arrayVenta['Producto'] = Producto::searchForId($_POST['Producto']);
            $arrayVenta['Compra'] = Compra::searchForId($_POST['Compra']);
            $arrayVenta['Cantidad'] = $_POST['Cantidad'];
            $arrayVenta['Precio'] = $_POST['Precio'];
            $arrayVenta['IVA'] = $_POST['IVA'];
            $arrayVenta['Talla'] = $_POST['Talla'];
            $arrayVenta['Color'] = $_POST['Color'];
            $arrayVenta['Estado'] = $_POST['Estado'];
            $arrayVenta['Codigo'] = $_POST['Codigo'];

            $Venta = new Inventario($arrayVenta);
            $Venta->update();

            header("Location: ../../views/modules/Inventario/show.php?id=".$Venta->getCodigo()."&respuesta=correcto");
        } catch (\Exception $e) {
           // GeneralFunctions::console( $e, 'error', 'errorStack');
            header("Location: ../../views/modules/Inventario/edit.php?respuesta=error&mensaje=".$e->getMessage());
        }
    }
//funcion activa de la Producto
    static public function activate()
    {
        try {
            $ObjUsuario = Inventario::searchForId($_GET['Id']);
            $ObjUsuario->setEstado("activo");
            if ($ObjUsuario->update()) {
                header("Location: ../../views/modules/Inventario/index.php");
            } else {
                header("Location: ../../views/modules/Inventario/index.php?respuesta=error&mensaje=Error al guardar");
            }
        } catch (\Exception $e) {
            // GeneralFunctions::console( $e, 'error', 'errorStack');
            //var_dump($e);
            header("Location: ../../views/modules/Inventario/index.php?respuesta=error&mensaje=" . $e->getMessage());
        }
    }
//funcion inactiva de la producto
    static public function inactivate ()
    {
        try {
            $ObjProducto = Inventario::searchForId($_GET['Id']);
            $ObjProducto->setEstado("inactivo");
            if($ObjProducto->update()){
                header("Location: ../../views/modules/Inventario/index.php?respuesta=correcto");
            }else{
                header("Location: ../../views/modules/Inventario/index.php?respuesta=error&mensaje=Error al guardar");
            }
        } catch (\Exception $e) {
            //var_dump($e);
            header("Location: ../../views/modules/Inventario/index.php?respuesta=error&mensaje" . $e-> getMessage());
        }
    }

    static public function searchForId ($id){
        try {
            return Inventario::searchForId($id);
        } catch (\Exception $e) {
            var_dump($e);
            GeneralFunctions::console( $e, 'error', 'errorStack');
            //header("Location: ../../views/modules/Producto/manager.php?respuesta=error");
        }
    }

    static public function getAll (){
        try {
            return Inventario::getAll();
        } catch (\Exception $e) {
            var_dump($e);
            header("Location: ../views/modules/Inventario/manager.php?respuesta=error");
        }
    }
    private static function InventarioIsInArray($codigoMarca, $ArrMarca){
        if(count($ArrMarca) > 0){
            foreach ($ArrMarca as $Marca){
                if($Marca->getCodigo() == $codigoMarca){
                    return true;
                }
            }
        }
        return false;
    }
    static public function selectInventario ($isMultiple=false,
                                        $isRequired=true,
                                        $id="Inventario",
                                        $nombre="Inventario",
                                        $defaultValue="",
                                        $class="form-control",
                                        $where="",
                                        $arrExcluir = array()){
        $arrMarca = array();
        if($where != ""){
            $base = "SELECT * FROM Inventario WHERE ";
            $arrMarca = Inventario::search($base.' '.$where);
        }else{
            $arrMarca = Inventario::getAll();
        }

        $htmlSelect = "<select ".(($isMultiple) ? "multiple" : "")." ".(($isRequired) ? "required" : "")." id= '".$id."' name='".$nombre."' class='".$class."' style='width: 100%;'>";
        $htmlSelect .= "<option value='' >Seleccione</option>";
        if(count($arrMarca) > 0){
            foreach ($arrMarca as $Marca)
                if (!InventarioController::InventarioIsInArray($Marca->getCodigo(),$arrExcluir))
                    $htmlSelect .= "<option ".(($Marca != "") ? (($defaultValue == $Marca->getCodigo()) ? "selected" : "" ) : "")." value='".$Marca->getCodigo()."'>".$Marca->getPrecio()."</option>";
        }
        $htmlSelect .= "</select>";
        return $htmlSelect;
    }
}
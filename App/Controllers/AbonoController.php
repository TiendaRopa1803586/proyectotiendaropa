<?php

namespace App\Controllers;
require(__DIR__.'/../Models/Abono.php');



use App\Models\GeneralFunctions;
use App\Models\Venta;
use App\Models\Abono;

if(!empty($_GET['action'])){
    AbonoController::main($_GET['action']);
}

class AbonoController{

    static function main($action)
    {
        if ($action == "create") {
            AbonoController::create();
        } else if ($action == "edit") {
            AbonoController::edit();
        } else if ($action == "searchForId") {
            AbonoController::searchForId($_REQUEST['Id']);
        } else if ($action == "searchAll") {
            AbonoController::getAll();
        } else if ($action == "activate") {
            AbonoController::activate();
        } else if ($action == "inactivate") {
            AbonoController::inactivate();
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
            $arrayProducto['Fecha'] = $_POST['Fecha'];
            $arrayProducto['Descripcion'] = $_POST['Descripcion'];
            $arrayProducto['MetodoPago'] = $_POST['MetodoPago'];
            $arrayProducto['Valor'] = $_POST['Valor'];
            $arrayProducto['Estado'] = $_POST['Estado'];


            $Producto = new Abono($arrayProducto);
            if(!Abono::AbonoRegistrada($arrayProducto['Fecha'])){
                $Producto = new Abono($arrayProducto);
                if($Producto->create()){
                   header("Location: ../../views/modules/Abono/index.php?respuesta=correcto");
                }
            }else{
                header("Location: ../../views/modules/Abono/create.php?respuesta=error&mensaje=Producto ya registrado");
            }
        } catch (Exception $e) {
            GeneralFunctions::console( $e, 'error', 'errorStack');
            header("Location: ../../views/modules/Abono/create.php?respuesta=error&mensaje=" . $e->getMessage());
        }
    }

    static public function edit (){
        try {
            $arrayVenta = array();
            $arrayVenta['Venta'] = Venta::searchForId($_POST['Venta']);
            $arrayVenta['Fecha'] = $_POST['Fecha'];
            $arrayVenta['Descripcion'] = $_POST['Descripcion'];
            $arrayVenta['MetodoPago'] = $_POST['MetodoPago'];
            $arrayVenta['Valor'] = $_POST['Valor'];
            $arrayVenta['Estado'] = $_POST['Estado'];
            $arrayVenta['Codigo'] = $_POST['Codigo'];

            $Venta = new Abono($arrayVenta);
            $Venta->update();

            header("Location: ../../views/modules/Abono/show.php?id=".$Venta->getCodigo()."&respuesta=correcto");
        } catch (\Exception $e) {
            GeneralFunctions::console( $e, 'error', 'errorStack');
            header("Location: ../../views/modules/Abono/edit.php?respuesta=error&mensaje=".$e->getMessage());
        }
    }
//funcion activa de la Producto
    static public function activate()
    {
        try {
            $ObjUsuario = Abono::searchForId($_GET['Id']);
            $ObjUsuario->setEstado("activo");
            if ($ObjUsuario->update()) {
                header("Location: ../../views/modules/Abono/index.php");
            } else {
                header("Location: ../../views/modules/Abono/index.php?respuesta=error&mensaje=Error al guardar");
            }
        } catch (\Exception $e) {
            // GeneralFunctions::console( $e, 'error', 'errorStack');
            //var_dump($e);
            header("Location: ../../views/modules/Abono/index.php?respuesta=error&mensaje=" . $e->getMessage());
        }
    }
//funcion inactiva de la producto
    static public function inactivate ()
    {
        try {
            $ObjProducto = Abono::searchForId($_GET['Id']);
            $ObjProducto->setEstado("inactivo");
            if($ObjProducto->update()){
                header("Location: ../../views/modules/Abono/index.php?respuesta=correcto");
            }else{
                header("Location: ../../views/modules/Abono/index.php?respuesta=error&mensaje=Error al guardar");
            }
        } catch (\Exception $e) {
            //var_dump($e);
            header("Location: ../../views/modules/Abono/index.php?respuesta=error&mensaje" . $e-> getMessage());
        }
    }

    static public function searchForId ($id){
        try {
            return Abono::searchForId($id);
        } catch (\Exception $e) {
            var_dump($e);
            GeneralFunctions::console( $e, 'error', 'errorStack');
            //header("Location: ../../views/modules/Producto/manager.php?respuesta=error");
        }
    }

    static public function getAll (){
        try {
            return Abono::getAll();
        } catch (\Exception $e) {
            var_dump($e);
            header("Location: ../views/modules/Compra/manager.php?respuesta=error");
        }
    }
    private static function AbonoIsInArray($codigoMarca, $ArrMarca){
        if(count($ArrMarca) > 0){
            foreach ($ArrMarca as $Marca){
                if($Marca->getCodigo() == $codigoMarca){
                    return true;
                }
            }
        }
        return false;
    }
    static public function selectAbono ($isMultiple=false,
                                        $isRequired=true,
                                        $id="Compra",
                                        $nombre="Compra",
                                        $defaultValue="",
                                        $class="form-control",
                                        $where="",
                                        $arrExcluir = array()){
        $arrMarca = array();
        if($where != ""){
            $base = "SELECT * FROM Abono WHERE ";
            $arrMarca = Abono::search($base.' '.$where);
        }else{
            $arrMarca = Abono::getAll();
        }

        $htmlSelect = "<select ".(($isMultiple) ? "multiple" : "")." ".(($isRequired) ? "required" : "")." id= '".$id."' name='".$nombre."' class='".$class."' style='width: 100%;'>";
        $htmlSelect .= "<option value='' >Seleccione</option>";
        if(count($arrMarca) > 0){
            foreach ($arrMarca as $Marca)
                if (!AbonoController::AbonoIsInArray($Marca->getCodigo(),$arrExcluir))
                    $htmlSelect .= "<option ".(($Marca != "") ? (($defaultValue == $Marca->getCodigo()) ? "selected" : "" ) : "")." value='".$Marca->getCodigo()."'>".$Marca->getFecha()."</option>";
        }
        $htmlSelect .= "</select>";
        return $htmlSelect;
    }
}
<?php

namespace App\Controllers;
require(__DIR__.'/../Models/Compra.php');



use App\Models\GeneralFunctions;
use App\Models\Sede;
use App\Models\Persona;
use App\Models\Compra;

if(!empty($_GET['action'])){
    CompraController::main($_GET['action']);
}

class CompraController{

    static function main($action)
    {
        if ($action == "create") {
            CompraController::create();
        } else if ($action == "edit") {
            CompraController::edit();
        } else if ($action == "searchForId") {
            CompraController::searchForId($_REQUEST['Id']);
        } else if ($action == "searchAll") {
            CompraController::getAll();
        } else if ($action == "activate") {
            CompraController::activate();
        } else if ($action == "inactivate") {
            CompraController::inactivate();
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
            $arrayProducto['Fecha'] = $_POST['Fecha'];
            $arrayProducto['Sede'] = Sede::searchForId($_POST['Sede']);
            $arrayProducto['Proveedor'] = Persona::searchForId($_POST['Proveedor']);
            $arrayProducto['Total'] = $_POST['Total'];
            $arrayProducto['Estado'] = $_POST['Estado'];


            $Producto = new Compra($arrayProducto);
            if(!Compra::CompraRegistrada($arrayProducto['Fecha'])){
                $Producto = new Compra($arrayProducto);
                if($Producto->create()){
                   header("Location: ../../views/modules/Compra/index.php?respuesta=correcto");
                }
            }else{
                header("Location: ../../views/modules/Compra/create.php?respuesta=error&mensaje=Producto ya registrado");
            }
        } catch (Exception $e) {
            GeneralFunctions::console( $e, 'error', 'errorStack');
            header("Location: ../../views/modules/Compra/create.php?respuesta=error&mensaje=" . $e->getMessage());
        }
    }

    static public function edit (){
        try {
            $arrayVenta = array();
            $arrayVenta['Fecha'] = $_POST['Fecha'];
            $arrayVenta['Sede'] = Sede::searchForId($_POST['Sede']);
            $arrayVenta['Proveedor'] = Persona::searchForId($_POST['Proveedor']);
            $arrayVenta['Total'] = $_POST['Total'];
            $arrayVenta['Estado'] = $_POST['Estado'];
            $arrayVenta['Codigo'] = $_POST['Codigo'];

            $Venta = new Compra($arrayVenta);
            $Venta->update();

            header("Location: ../../views/modules/Compra/show.php?id=".$Venta->getCodigo()."&respuesta=correcto");
        } catch (\Exception $e) {
            GeneralFunctions::console( $e, 'error', 'errorStack');
            header("Location: ../../views/modules/Compra/edit.php?respuesta=error&mensaje=".$e->getMessage());
        }
    }
//funcion activa de la Producto
    static public function activate()
    {
        try {
            $ObjUsuario = Compra::searchForId($_GET['Id']);
            $ObjUsuario->setEstado("activo");
            if ($ObjUsuario->update()) {
                header("Location: ../../views/modules/Compra/index.php");
            } else {
                header("Location: ../../views/modules/Compra/index.php?respuesta=error&mensaje=Error al guardar");
            }
        } catch (\Exception $e) {
            // GeneralFunctions::console( $e, 'error', 'errorStack');
            //var_dump($e);
            header("Location: ../../views/modules/Compra/index.php?respuesta=error&mensaje=" . $e->getMessage());
        }
    }
//funcion inactiva de la producto
    static public function inactivate ()
    {
        try {
            $ObjProducto = Compra::searchForId($_GET['Id']);
            $ObjProducto->setEstado("inactivo");
            if($ObjProducto->update()){
                header("Location: ../../views/modules/Compra/index.php?respuesta=correcto");
            }else{
                header("Location: ../../views/modules/Compra/index.php?respuesta=error&mensaje=Error al guardar");
            }
        } catch (\Exception $e) {
            //var_dump($e);
            header("Location: ../../views/modules/Compra/index.php?respuesta=error&mensaje" . $e-> getMessage());
        }
    }

    static public function searchForId ($id){
        try {
            return Compra::searchForId($id);
        } catch (\Exception $e) {
            var_dump($e);
            GeneralFunctions::console( $e, 'error', 'errorStack');
            //header("Location: ../../views/modules/Producto/manager.php?respuesta=error");
        }
    }

    static public function getAll (){
        try {
            return Compra::getAll();
        } catch (\Exception $e) {
            var_dump($e);
            header("Location: ../views/modules/Compra/manager.php?respuesta=error");
        }
    }
    private static function CompraIsInArray($codigoMarca, $ArrMarca){
        if(count($ArrMarca) > 0){
            foreach ($ArrMarca as $Marca){
                if($Marca->getCodigo() == $codigoMarca){
                    return true;
                }
            }
        }
        return false;
    }
    static public function selectCompra ($isMultiple=false,
                                           $isRequired=true,
                                           $id="Compra",
                                           $nombre="Compra",
                                           $defaultValue="",
                                           $class="form-control",
                                           $where="",
                                           $arrExcluir = array()){
        $arrMarca = array();
        if($where != ""){
            $base = "SELECT * FROM Compra WHERE ";
            $arrMarca = Compra::search($base.' '.$where);
        }else{
            $arrMarca = Compra::getAll();
        }

        $htmlSelect = "<select ".(($isMultiple) ? "multiple" : "")." ".(($isRequired) ? "required" : "")." id= '".$id."' name='".$nombre."' class='".$class."' style='width: 100%;'>";
        $htmlSelect .= "<option value='' >Seleccione</option>";
        if(count($arrMarca) > 0){
            foreach ($arrMarca as $Marca)
                if (!CompraController::CompraIsInArray($Marca->getCodigo(),$arrExcluir))
                    $htmlSelect .= "<option ".(($Marca != "") ? (($defaultValue == $Marca->getCodigo()) ? "selected" : "" ) : "")." value='".$Marca->getCodigo()."'>".$Marca->getFecha()."</option>";
        }
        $htmlSelect .= "</select>";
        return $htmlSelect;
    }
}
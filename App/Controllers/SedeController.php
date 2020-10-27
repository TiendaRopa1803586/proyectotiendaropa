<?php

namespace App\Controllers;
require(__DIR__.'/../Models/Sede.php');



use App\Models\GeneralFunctions;
use App\Models\Persona;
use App\Models\Sede;

if(!empty($_GET['action'])){
    SedeController::main($_GET['action']);
}

class SedeController{

    static function main($action)
    {
        if ($action == "create") {
            SedeController::create();
        } else if ($action == "edit") {
            SedeController::edit();
        } else if ($action == "searchForId") {
            SedeController::searchForId($_REQUEST['Id']);
        } else if ($action == "searchAll") {
            SedeController::getAll();
        } else if ($action == "activate") {
            SedeController::activate();
        } else if ($action == "inactivate") {
            SedeController::inactivate();
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
            $arrayProducto['Direccion'] = $_POST['Direccion'];
            $arrayProducto['Encargado'] = Persona::searchForId($_POST['Encargado']);
            $arrayProducto['Estado'] = $_POST['Estado'];
            var_dump("Array", $arrayProducto);

            $Producto = new Sede($arrayProducto);
            if(!Sede::SedeRegistrado($arrayProducto['Nombre'])){
                $Producto = new Sede($arrayProducto);
                if($Producto->create()){
                    header("Location: ../../views/modules/Sede/index.php?respuesta=correcto");
                }
            }else{
                header("Location: ../../views/modules/Sede/create.php?respuesta=error&mensaje=Producto ya registrado");
            }
        } catch (Exception $e) {
            GeneralFunctions::console( $e, 'error', 'errorStack');
            header("Location: ../../views/modules/Sede/create.php?respuesta=error&mensaje=" . $e->getMessage());
        }
    }

    static public function edit (){
        try {
            $arrayVenta = array();
            $arrayVenta['Nombre'] = $_POST['Nombre'];
            $arrayVenta['Direccion'] = $_POST['Direccion'];
            $arrayVenta['Encargado'] = Persona::searchForId($_POST['Encargado']);
            $arrayVenta['Estado'] = $_POST['Estado'];
            $arrayVenta['Codigo'] = $_POST['Codigo'];

            $Venta = new Sede($arrayVenta);
            $Venta->update();

            header("Location: ../../views/modules/Sede/show.php?id=".$Venta->getCodigo()."&respuesta=correcto");
        } catch (\Exception $e) {
            GeneralFunctions::console( $e, 'error', 'errorStack');
            header("Location: ../../views/modules/Sede/edit.php?respuesta=error&mensaje=".$e->getMessage());
        }
    }
//funcion activa de la Producto
    static public function activate()
    {
        try {
            $ObjUsuario = Sede::searchForId($_GET['Id']);
            $ObjUsuario->setEstado("activo");
            if ($ObjUsuario->update()) {
                header("Location: ../../views/modules/Sede/index.php");
            } else {
                header("Location: ../../views/modules/Sede/index.php?respuesta=error&mensaje=Error al guardar");
            }
        } catch (\Exception $e) {
            // GeneralFunctions::console( $e, 'error', 'errorStack');
            //var_dump($e);
            header("Location: ../../views/modules/Sede/index.php?respuesta=error&mensaje=" . $e->getMessage());
        }
    }
//funcion inactiva de la producto
    static public function inactivate ()
    {
        try {
            $ObjProducto = Sede::searchForId($_GET['Id']);
            $ObjProducto->setEstado("inactivo");
            if($ObjProducto->update()){
                header("Location: ../../views/modules/Sede/index.php?respuesta=correcto");
            }else{
                header("Location: ../../views/modules/Sede/index.php?respuesta=error&mensaje=Error al guardar");
            }
        } catch (\Exception $e) {
            //var_dump($e);
            header("Location: ../../views/modules/Sede/index.php?respuesta=error&mensaje" . $e-> getMessage());
        }
    }

    static public function searchForId ($id){
        try {
            return Sede::searchForId($id);
        } catch (\Exception $e) {
            var_dump($e);
            GeneralFunctions::console( $e, 'error', 'errorStack');
            //header("Location: ../../views/modules/Producto/manager.php?respuesta=error");
        }
    }

    static public function getAll (){
        try {
            return Sede::getAll();
        } catch (\Exception $e) {
            var_dump($e);
            header("Location: ../views/modules/Sede/manager.php?respuesta=error");
        }
    }
    private static function SedeIsInArray($codigoMarca, $ArrMarca){
        if(count($ArrMarca) > 0){
            foreach ($ArrMarca as $Marca){
                if($Marca->getCodigo() == $codigoMarca){
                    return true;
                }
            }
        }
        return false;
    }
    static public function selectSede ($isMultiple=false,
                                        $isRequired=true,
                                        $id="Sede",
                                        $nombre="Sede",
                                        $defaultValue="",
                                        $class="form-control",
                                        $where="",
                                        $arrExcluir = array()){
        $arrMarca = array();
        if($where != ""){
            $base = "SELECT * FROM Sede WHERE ";
            $arrMarca = Sede::search($base.' '.$where);
        }else{
            $arrMarca = Sede::getAll();
        }

        $htmlSelect = "<select ".(($isMultiple) ? "multiple" : "")." ".(($isRequired) ? "required" : "")." id= '".$id."' name='".$nombre."' class='".$class."' style='width: 100%;'>";
        $htmlSelect .= "<option value='' >Seleccione</option>";
        if(count($arrMarca) > 0){
            foreach ($arrMarca as $Marca)
                if (!SedeController::SedeIsInArray($Marca->getCodigo(),$arrExcluir))
                    $htmlSelect .= "<option ".(($Marca != "") ? (($defaultValue == $Marca->getCodigo()) ? "selected" : "" ) : "")." value='".$Marca->getCodigo()."'>".$Marca->getNombre()."</option>";
        }
        $htmlSelect .= "</select>";
        return $htmlSelect;
    }
}
<?php

namespace App\Controllers;
require(__DIR__.'/../Models/Venta.php');



use App\Models\GeneralFunctions;
use App\Models\Persona;
use App\Models\Sede;
use App\Models\Venta;

if(!empty($_GET['action'])){
    VentaController::main($_GET['action']);
}

class VentaController{

    static function main($action)
    {
        if ($action == "create") {
            VentaController::create();
        } else if ($action == "edit") {
            VentaController::edit();
        } else if ($action == "searchForId") {
            VentaController::searchForId($_REQUEST['Id']);
        } else if ($action == "searchAll") {
            VentaController::getAll();
        } else if ($action == "activate") {
            VentaController::activate();
        } else if ($action == "inactivate") {
            VentaController::inactivate();
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
            $arrayProducto['Vendedor'] = Persona::searchForId($_POST['Vendedor']);
            $arrayProducto['Cliente'] = Persona::searchForId($_POST['Cliente']);
            $arrayProducto['Sede'] = Sede::searchForId($_POST['Sede']);
            $arrayProducto['MetodoPago'] = $_POST['MetodoPago'];
            $arrayProducto['Total'] = $_POST['Total'];
            $arrayProducto['Estado'] = $_POST['Estado'];


            $Producto = new Venta($arrayProducto);
            if(!Venta::VentaRegistrado($arrayProducto['Fecha'])){
                $Producto = new Venta($arrayProducto);
                if($Producto->create()){
                   header("Location: ../../views/modules/Venta/index.php?respuesta=correcto");
                }
            }else{
                header("Location: ../../views/modules/Venta/create.php?respuesta=error&mensaje=Producto ya registrado");
            }
        } catch (Exception $e) {
            GeneralFunctions::console( $e, 'error', 'errorStack');
            header("Location: ../../views/modules/Venta/create.php?respuesta=error&mensaje=" . $e->getMessage());
        }
    }

    static public function edit (){
        try {
            $arrayVenta = array();
            $arrayVenta['Fecha'] = $_POST['Fecha'];
            $arrayVenta['Vendedor'] = Persona::searchForId($_POST['Vendedor']);
            $arrayVenta['Cliente'] =Persona::searchForId($_POST['Cliente']);
            $arrayVenta['Sede'] = Sede::searchForId($_POST['Sede']);
            $arrayVenta['MetodoPago'] = $_POST['MetodoPago'];
            $arrayVenta['Total'] = $_POST['Total'];
            $arrayVenta['Estado'] = $_POST['Estado'];
            $arrayVenta['Codigo'] = $_POST['Codigo'];

            $Venta = new Venta($arrayVenta);
            $Venta->update();

            header("Location: ../../views/modules/Venta/show.php?id=".$Venta->getCodigo()."&respuesta=correcto");
        } catch (\Exception $e) {
            GeneralFunctions::console( $e, 'error', 'errorStack');
            header("Location: ../../views/modules/Venta/edit.php?respuesta=error&mensaje=".$e->getMessage());
        }
    }
//funcion activa de la Producto
    static public function activate()
    {
        try {
            $ObjUsuario = Venta::searchForId($_GET['Id']);
            $ObjUsuario->setEstado("activo");
            if ($ObjUsuario->update()) {
                header("Location: ../../views/modules/Venta/index.php");
            } else {
                header("Location: ../../views/modules/Venta/index.php?respuesta=error&mensaje=Error al guardar");
            }
        } catch (\Exception $e) {
            // GeneralFunctions::console( $e, 'error', 'errorStack');
            //var_dump($e);
            header("Location: ../../views/modules/Venta/index.php?respuesta=error&mensaje=" . $e->getMessage());
        }
    }
//funcion inactiva de la producto
    static public function inactivate ()
    {
        try {
            $ObjProducto = Venta::searchForId($_GET['Id']);
            $ObjProducto->setEstado("inactivo");
            if($ObjProducto->update()){
                header("Location: ../../views/modules/Venta/index.php?respuesta=correcto");
            }else{
                header("Location: ../../views/modules/Venta/index.php?respuesta=error&mensaje=Error al guardar");
            }
        } catch (\Exception $e) {
            //var_dump($e);
            header("Location: ../../views/modules/Venta/index.php?respuesta=error&mensaje" . $e-> getMessage());
        }
    }

    static public function searchForId ($id){
        try {
            return Venta::searchForId($id);
        } catch (\Exception $e) {
            var_dump($e);
            GeneralFunctions::console( $e, 'error', 'errorStack');
            //header("Location: ../../views/modules/Producto/manager.php?respuesta=error");
        }
    }

    static public function getAll (){
        try {
            return Venta::getAll();
        } catch (\Exception $e) {
            var_dump($e);
            header("Location: ../views/modules/Venta/manager.php?respuesta=error");
        }
    }
    private static function VentaIsInArray($codigoMarca, $ArrMarca){
        if(count($ArrMarca) > 0){
            foreach ($ArrMarca as $Marca){
                if($Marca->getCodigo() == $codigoMarca){
                    return true;
                }
            }
        }
        return false;
    }
    static public function selectVenta ($isMultiple=false,
                                        $isRequired=true,
                                        $id="Venta",
                                        $nombre="Venta",
                                        $defaultValue="",
                                        $class="form-control",
                                        $where="",
                                        $arrExcluir = array()){
        $arrMarca = array();
        if($where != ""){
            $base = "SELECT * FROM Venta WHERE ";
            $arrMarca = Venta::search($base.' '.$where);
        }else{
            $arrMarca = Venta::getAll();
        }

        $htmlSelect = "<select ".(($isMultiple) ? "multiple" : "")." ".(($isRequired) ? "required" : "")." id= '".$id."' name='".$nombre."' class='".$class."' style='width: 100%;'>";
        $htmlSelect .= "<option value='' >Seleccione</option>";
        if(count($arrMarca) > 0){
            foreach ($arrMarca as $Marca)
                if (!VentaController::VentaIsInArray($Marca->getCodigo(),$arrExcluir))
                    $htmlSelect .= "<option ".(($Marca != "") ? (($defaultValue == $Marca->getCodigo()) ? "selected" : "" ) : "")." value='".$Marca->getCodigo()."'>".$Marca->getFecha()."</option>";
        }
        $htmlSelect .= "</select>";
        return $htmlSelect;
    }
}
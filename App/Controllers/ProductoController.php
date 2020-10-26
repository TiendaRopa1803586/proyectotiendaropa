<?php

namespace App\Controllers;
require(__DIR__.'/../Models/Producto.php');
require(__DIR__.'/../Models/GeneralFunctions.php');


use App\Models\GeneralFunctions;
use App\Models\Marca;
use App\Models\Subcategoria;
use App\Models\Producto;

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
        } else if ($action == "searchForId") {
            ProductoController::searchForId($_REQUEST['Id']);
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
            $arrayProducto['Estado'] = $_POST['Estado'];
            var_dump("Array", $arrayProducto);

            $Producto = new Producto($arrayProducto);
            if(!Producto::productoRegistrado($arrayProducto['Nombre'])){
                $Producto = new Producto($arrayProducto);
                if($Producto->create()){
                    header("Location: ../../views/modules/Producto/index.php?respuesta=correcto");
                }
            }else{
                header("Location: ../../views/modules/Producto/create.php?respuesta=error&mensaje=Producto ya registrado");
            }
        } catch (Exception $e) {
            GeneralFunctions::console( $e, 'error', 'errorStack');
            header("Location: ../../views/modules/Producto/create.php?respuesta=error&mensaje=" . $e->getMessage());
        }
    }

    static public function edit (){
        try {
            $arrayVenta = array();
            $arrayVenta['Nombre'] = $_POST['Nombre'];
            $arrayVenta['Importado'] = $_POST['Importado'];
            $arrayVenta['Descripcion'] = $_POST['Descripcion'];
            $arrayVenta['Marca'] = Marca::searchForId($_POST['Marca']);
            $arrayVenta['Subcategoria'] = Subcategoria::searchForId($_POST['Subcategoria']);
            $arrayVenta['Estado'] = $_POST['Estado'];
            $arrayVenta['Codigo'] = $_POST['Codigo'];

            $Venta = new Producto($arrayVenta);
            $Venta->update();

            header("Location: ../../views/modules/Producto/show.php?id=".$Venta->getCodigo()."&respuesta=correcto");
        } catch (\Exception $e) {
            GeneralFunctions::console( $e, 'error', 'errorStack');
            header("Location: ../../views/modules/Producto/edit.php?respuesta=error&mensaje=".$e->getMessage());
        }
    }
//funcion activa de la Producto
    static public function activate()
    {
        try {
            $ObjUsuario = Producto::searchForId($_GET['Id']);
            $ObjUsuario->setEstado("activo");
            if ($ObjUsuario->update()) {
                header("Location: ../../views/modules/Producto/index.php");
            } else {
                header("Location: ../../views/modules/Producto/index.php?respuesta=error&mensaje=Error al guardar");
            }
        } catch (\Exception $e) {
            // GeneralFunctions::console( $e, 'error', 'errorStack');
            //var_dump($e);
            header("Location: ../../views/modules/Producto/index.php?respuesta=error&mensaje=" . $e->getMessage());
        }
    }
//funcion inactiva de la producto
    static public function inactivate ()
    {
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

    static public function searchForId ($id){
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
            header("Location: ../views/modules/Producto/manager.php?respuesta=error");
        }
    }
    private static function ProductoIsInArray($codigoMarca, $ArrMarca){
        if(count($ArrMarca) > 0){
            foreach ($ArrMarca as $Marca){
                if($Marca->getCodigo() == $codigoMarca){
                    return true;
                }
            }
        }
        return false;
    }
    static public function selectProducto ($isMultiple=false,
                                        $isRequired=true,
                                        $id="Producto",
                                        $nombre="Producto",
                                        $defaultValue="",
                                        $class="form-control",
                                        $where="",
                                        $arrExcluir = array()){
        $arrMarca = array();
        if($where != ""){
            $base = "SELECT * FROM Producto WHERE ";
            $arrMarca = Producto::search($base.' '.$where);
        }else{
            $arrMarca = Producto::getAll();
        }

        $htmlSelect = "<select ".(($isMultiple) ? "multiple" : "")." ".(($isRequired) ? "required" : "")." id= '".$id."' name='".$nombre."' class='".$class."' style='width: 100%;'>";
        $htmlSelect .= "<option value='' >Seleccione</option>";
        if(count($arrMarca) > 0){
            foreach ($arrMarca as $Marca)
                if (!ProductoController::ProductoIsInArray($Marca->getCodigo(),$arrExcluir))
                    $htmlSelect .= "<option ".(($Marca != "") ? (($defaultValue == $Marca->getCodigo()) ? "selected" : "" ) : "")." value='".$Marca->getCodigo()."'>".$Marca->getNombre()."</option>";
        }
        $htmlSelect .= "</select>";
        return $htmlSelect;
    }
}
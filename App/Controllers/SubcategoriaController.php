<?php

namespace App\Controllers;
require(__DIR__.'/../Models/Subcategoria.php');

use App\Models\Categoria;
use App\Models\Subcategoria;

if(!empty($_GET['action'])){
    SubcategoriaController::main($_GET['action']);
}

class SubcategoriaController{

    static function main($action)
    {
        if ($action == "create") {
            SubcategoriaController::create();
        } else if ($action == "edit") {
            SubcategoriaController::edit();
        } else if ($action == "searchForID") {
            SubcategoriaController::searchForID($_REQUEST['idSubcatgeoria']);
        } else if ($action == "searchAll") {
            SubcategoriaController::getAll();
        } else if ($action == "activate") {
            SubcategoriaController::activate();
        } else if ($action == "inactivate") {
            SubcategoriaController::inactivate();
        }/*else if ($action == "login"){
           SubcategoriaController::login();
        }else if($action == "cerrarSession"){
            SubcategoriaController::cerrarSession();
        }*/

    }
//funcion crear Marca
    static public function create()
    {
        try {
            $arraySubcategoria = array();
            $arraySubcategoria['Nombre'] = $_POST['Nombre'];
            $arraySubcategoria['Descripcion'] = $_POST['Descripcion'];
            $arraySubcategoria['Estado'] = 'Activo';
            $arraySubcategoria['Categoria'] = Categoria::searchForId($_POST['Categoria']);

            if(!Subcategoria::SubcategoriaRegistrado($arraySubcategoria['Nombre'])){
                $Subcategoria = new Subcategoria ($arraySubcategoria);
                if($Subcategoria->create()){
                    header("Location: ../../views/modules/Subcategoria/index.php?respuesta=correcto");
                }
            }else{
                header("Location: ../../views/modules/Subcategoria/create.php?respuesta=error&mensaje=Marca ya registrada");
            }
        } catch (Exception $e) {
            header("Location: ../../views/modules/Subcategoria/create.php?respuesta=error&mensaje=" . $e->getMessage());
        }
    }

    static public function edit (){
        try {
            $arraySubcategoria= array();
            $arraySubcategoria['Nombre'] = $_POST['Nombre'];
            $arraySubcategoria['Descripcion'] = $_POST['Descripcion'];
            $arraySubcategoria['Estado'] = $_POST['Estado'];
            $arraySubcategoria['Codigo'] = $_POST['Codigo'];
            $arraySubcategoria['Categoria'] = Categoria::searchForId($_POST['Categoria']);

            $Subcategoria = new Subcategoria($arraySubcategoria);
            $Subcategoria->update();

            header("Location: ../../views/modules/Subcategoria/show.php?id=".$Subcategoria->getCodigo()."&respuesta=correcto");
        } catch (\Exception $e) {
            var_dump($e);
            //header("Location: ../../views/modules/Subcategroia/edit.php?respuesta=error&mensaje" . $e->getMessage());
        }
    }
//funcion activa de la supcategoria
    static public function activate (){
        try {
            $ObjSubcategoria = Subcategoria::searchForId($_GET['Id']);
            $ObjSubcategoria->setEstado("activo");
            if($ObjSubcategoria->update()){
                header("Location: ../../views/modules/Subcategoria/index.php?respuesta=correcto");
            }else{
                header("Location: ../../views/modules/Subcategoria/index.php?respuesta=error&mensaje=Error al guardar");
            }
        } catch (\Exception $e) {
            //var_dump($e);
            header("Location: ../../views/modules/Subcategoria/index.php?respuesta=error&mensaje=".$e->getMessage());
        }
    }
//funcion inactiva de la Supcategoria
    static public function inactivate (){
        try {
            $ObjSubcategoria = Subcategoria::searchForId($_GET['Id']);
            $ObjSubcategoria->setEstado("inactivo");
            if($ObjSubcategoria->update()){
                header("Location: ../../views/modules/Subcategoria/index.php?respuesta=correcto");
            }else{
                header("Location: ../../views/modules/Subcategoria/index.php?respuesta=error&mensaje=Error al guardar");
            }
        } catch (\Exception $e) {
            //var_dump($e);
            header("Location: ../../views/modules/Subcategoria/index.php?respuesta=error&mensaje" . $e-> getMessage());
        }
    }

    static public function searchForID ($id){
        try {
            return Subcategoria::searchForId($id);
        } catch (\Exception $e) {
            var_dump($e);
            //header("Location: ../../views/modules/Subcategoria/manager.php?respuesta=error");
        }
    }

    static public function getAll (){
        try {
            return Subcategoria::getAll();
        } catch (\Exception $e) {
            var_dump($e);
            //header("Location: ../Vista/modules/Subcategoria/manager.php?respuesta=error");
        }
    }
    private static function SubcategoriaIsInArray($codigoSubcategoria, $ArrSubcategoria){
        if(count($ArrSubcategoria) > 0){
            foreach ($ArrSubcategoria as $Subcategoria){
                if($Subcategoria->getCodigo() == $codigoSubcategoria){
                    return true;
                }
            }
        }
        return false;
    }
    static public function selectSubcategoria ($isMultiple=false,
                                        $isRequired=true,
                                        $id="Subcategoria",
                                        $nombre="Subcategoria",
                                        $defaultValue="",
                                        $class="form-control",
                                        $where="",
                                        $arrExcluir = array()){
        $arrSubcategoria = array();
        if($where != ""){
            $base = "SELECT * FROM Subcategoria WHERE ";
            $arrSubcategoria = Subcategoria::search($base.' '.$where);
        }else{
            $arrSubcategoria = Subcategoria::getAll();
        }

        $htmlSelect = "<select ".(($isMultiple) ? "multiple" : "")." ".(($isRequired) ? "required" : "")." id= '".$id."' name='".$nombre."' class='".$class."' style='width: 100%;'>";
        $htmlSelect .= "<option value='' >Seleccione</option>";
        if(count($arrSubcategoria) > 0){
            foreach ($arrSubcategoria as $Subcategoria)
                if (!SubcategoriaController::SubcategoriaIsInArray($Subcategoria->getCodigo(),$arrExcluir))
                    $htmlSelect .= "<option ".(($Subcategoria != "") ? (($defaultValue == $Subcategoria->getCodigo()) ? "selected" : "" ) : "")." value='".$Subcategoria->getCodigo()."'>".$Subcategoria->getNombre()."</option>";
        }
        $htmlSelect .= "</select>";
        return $htmlSelect;
    }


}
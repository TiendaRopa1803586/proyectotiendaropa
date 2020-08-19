<?php

namespace App\Controllers;
require(__DIR__.'/../Models/Marca.php');

use App\Models\Categoria;
use App\Models\Marca;

if(!empty($_GET['action'])){
    MarcaController::main($_GET['action']);
}

    class MarcaController{

    static function main($action)
    {
        if ($action == "create") {
            MarcaController::create();
        } else if ($action == "edit") {
            MarcaController::edit();
        } else if ($action == "searchForID") {
            MarcaController::searchForID($_REQUEST['idMarca']);
        } else if ($action == "searchAll") {
            MarcaController::getAll();
        } else if ($action == "activate") {
            MarcaController::activate();
        } else if ($action == "inactivate") {
            MarcaController::inactivate();
        }/*else if ($action == "login"){
          MarcaController::login();
        }else if($action == "cerrarSession"){
           MarcaController::cerrarSession();
        }*/

    }
//funcion crear Marca
    static public function create()
    {
        try {
            $arrayMarca = array();
            $arrayMarca['Nombre'] = $_POST['Nombre'];
            $arrayMarca['Descripcion'] = $_POST['Descripcion'];
            $arrayMarca['Estado'] = 'Activo';
            if(!Marca::MarcaRegistrado($arrayMarca['Nombre'])){
                $Marca = new Marca ($arrayMarca);
                if($Marca->create()){
                    header("Location: ../../views/modules/Marca/index.php?respuesta=correcto");
                }
            }else{
                header("Location: ../../views/modules/Marca/create.php?respuesta=error&mensaje=Marca ya registrada");
            }
        } catch (Exception $e) {
            header("Location: ../../views/modules/Marca/create.php?respuesta=error&mensaje=" . $e->getMessage());
        }
    }

    static public function edit (){
        try {
            $arrayMarca= array();
            $arrayMarca['Nombre'] = $_POST['Nombre'];
            $arrayMarca['Descripcion'] = $_POST['Descripcion'];
            $arrayMarca['Estado'] = $_POST['Estado'];
            $arrayMarca['Codigo'] = $_POST['Codigo'];

            $Marca = new Marca($arrayMarca);
            $Marca->update();

            header("Location: ../../views/modules/Marca/show.php?id=".$Marca->getCodigo()."&respuesta=correcto");
        } catch (\Exception $e) {
            var_dump($e);
            //header("Location: ../../views/modules/Marca/edit.php?respuesta=error&mensaje" . $e->getMessage());
        }
    }
//funcion activa de la Marca
    static public function activate (){
        try {
            $ObjMarca = Marca::searchForId($_GET['Id']);
            $ObjMarca->setEstado("activo");
            if($ObjMarca->update()){
                header("Location: ../../views/modules/Marca/index.php?respuesta=correcto");
            }else{
                header("Location: ../../views/modules/Marca/index.php?respuesta=error&mensaje=Error al guardar");
            }
        } catch (\Exception $e) {
            //var_dump($e);
            header("Location: ../../views/modules/Marca/index.php?respuesta=error&mensaje=".$e->getMessage());
        }
    }
//funcion inactiva de la Marc
    static public function inactivate (){
        try {
            $ObjMarca = Marca::searchForId($_GET['Id']);
            $ObjMarca->setEstado("inactivo");
            if($ObjMarca->update()){
                header("Location: ../../views/modules/Marca/index.php?respuesta=correcto");
            }else{
                header("Location: ../../views/modules/Marca/index.php?respuesta=error&mensaje=Error al guardar");
            }
        } catch (\Exception $e) {
            //var_dump($e);
            header("Location: ../../views/modules/Marca/index.php?respuesta=error&mensaje" . $e-> getMessage());
        }
    }

    static public function searchForID ($id){
        try {
            return Marca::searchForId($id);
        } catch (\Exception $e) {
            var_dump($e);
            //header("Location: ../../views/modules/Marca/manager.php?respuesta=error");
        }
    }

    static public function getAll (){
        try {
            return Marca::getAll();
        } catch (\Exception $e) {
            var_dump($e);
            //header("Location: ../Vista/modules/Marca/manager.php?respuesta=error");
        }
    }
    private static function MarcaIsInArray($codigoMarca, $ArrMarca){
        if(count($ArrMarca) > 0){
            foreach ($ArrMarca as $Marca){
                if($Marca->getCodigo() == $codigoMarca){
                    return true;
                }
            }
        }
        return false;
    }
    static public function selectMarca ($isMultiple=false,
                                            $isRequired=true,
                                            $Id="CodigoMarca",
                                            $Nombre="CodigoMa++rca",
                                            $defaultValue="",
                                            $class="form-control",
                                            $where="",
                                            $arrExcluir = array()){
        $arrMarca = array();
        if($where != ""){
            $base = "SELECT * FROM Marca WHERE ";
            $arrMarca = Marca::search($base.' '.$where);
        }else{
            $arrMarca = Marca::getAll();
        }

        $htmlSelect = "<select ".(($isMultiple) ? "multiple" : "")." ".(($isRequired) ? "required" : "")." id= '".$Id."' name='".$Nombre."' class='".$class."' style='width: 100%;'>";
        $htmlSelect .= "<option value='' >Seleccione</option>";
        if(count($arrMarca) > 0){
            foreach ($arrMarca as $Marca)
                if (!MarcaController::MarcaIsInArray($Marca->getCodigo(),$arrExcluir))
                    $htmlSelect .= "<option ".(($Marca != "") ? (($defaultValue == $Marca->getCodigo()) ? "selected" : "" ) : "")." value='".$Marca->getCodigo()."'>".$Marca->getNombre()."</option>";
        }
        $htmlSelect .= "</select>";
        return $htmlSelect;
    }
}
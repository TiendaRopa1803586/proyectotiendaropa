<?php


namespace App\Controllers;

require(__DIR__.'/../Models/Descuento.php');
use App\Models\Descuento;

if(!empty($_GET['action'])){
    DescuentoController::main($_GET['action']);
}
class DescuentoController
{

    static function main($action)
    {
        if ($action == "create") {
            DescuentoController::create();
        } else if ($action == "edit") {
            DescuentoController::edit();
        } else if ($action == "searchForID") {
            DescuentoController::searchForID($_REQUEST['idDescuento']);
        } else if ($action == "searchAll") {
            DescuentoController::getAll();
        } else if ($action == "activate") {
            DescuentoController::activate();
        } else if ($action == "inactivate") {
            DescuentoController::inactivate();
        }/*else if ($action == "login"){
         DescuentoController::login();
        }else if($action == "cerrarSession"){
          DescuentoController::cerrarSession();
        }*/

    }
    //funcion crear Descuento
    static public function create()
    {
        try {
            $arrayDescuento = array();
            $arrayDescuento['Nombre'] = $_POST['Nombre'];
            $arrayDescuento['Porcentaje'] = $_POST['Porcentaje'];
            $arrayDescuento['Fecha_inicio'] = $_POST['Fecha_inicio'];
            $arrayDescuento['Fecha_fin'] = $_POST['Fecha_fin'];
            $arrayDescuento['Estado'] = 'Activo';
            if(!Descuento::DescuentoRegistrado($arrayDescuento['Nombre'])){
                $Descuento = new Descuento ($arrayDescuento);
                if($Descuento->create()){
                    header("Location: ../../views/modules/Descuento/index.php?respuesta=correcto");
                }
            }else{
                header("Location: ../../views/modules/Descuento/create.php?respuesta=error&mensaje=Descuento ya registrado");
            }
        } catch (Exception $e) {
            header("Location: ../../views/modules/Descuento/create.php?respuesta=error&mensaje=" . $e->getMessage());
        }
    }

    static public function edit (){
        try {
            $arrayDescuento= array();
            $arrayDescuento['Nombre'] = $_POST['Nombre'];
            $arrayDescuento['Porcentaje'] = $_POST['Porcentaje'];
            $arrayDescuento['Fecha_inicio'] = $_POST['Fecha_inicio'];
            $arrayDescuento['Fecha_fin'] = $_POST['Fecha_fin'];
            $arrayDescuento['Codigo'] = $_POST['Codigo'];

            $Descuento = new Descuento($arrayDescuento);
            $Descuento->update();

            header("Location: ../../views/modules/Descuento/show.php?id=".$Descuento->getCodigo()."&respuesta=correcto");
        } catch (\Exception $e) {
            var_dump($e);
            //header("Location: ../../views/modules/Descuento/edit.php?respuesta=error&mensaje" . $e->getMessage());
        }
    }
    //funcion activa del descuento
    static public function activate (){
        try {
            $ObjDescuento = Descuento::searchForId($_GET['Id']);
            $ObjDescuento>setEstado("activo");
            if($ObjDescuento->update()){
                header("Location: ../../views/modules/Descuento/index.php?respuesta=correcto");
            }else{
                header("Location: ../../views/modules/Descuento/index.php?respuesta=error&mensaje=Error al guardar");
            }
        } catch (\Exception $e) {
            //var_dump($e);
            header("Location: ../../views/modules/Descuento/index.php?respuesta=error&mensaje=".$e->getMessage());
        }
    }
    //funcion inactiva del Descuento
    static public function inactivate (){
        try {
            $ObjDescuento = Descuento::searchForId($_GET['Id']);
            $ObjDescuento->setEstado("inactivo");
            if($ObjDescuento->update()){
                header("Location: ../../views/modules/Descuento/index.php?respuesta=correcto");
            }else{
                header("Location: ../../views/modules/Descuento/index.php?respuesta=error&mensaje=Error al guardar");
            }
        } catch (\Exception $e) {
            //var_dump($e);
            header("Location: ../../views/modules/Descuento/index.php?respuesta=error&mensaje" . $e-> getMessage());
        }
    }
    static public function searchForID ($id){
        try {
            return Descuento::searchForId($id);
        } catch (\Exception $e) {
            var_dump($e);
            //header("Location: ../../views/modules/Descuento/manager.php?respuesta=error");
        }
    }
    static public function getAll (){
        try {
            return Descuento::getAll();
        } catch (\Exception $e) {
            var_dump($e);
            //header("Location: ../Vista/modules/Descuento/manager.php?respuesta=error");
        }
    }
}
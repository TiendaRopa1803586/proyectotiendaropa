<?php

namespace App\Controllers;
require(__DIR__.'/../Models/Categoria.php');
use App\Models\Categoria;

if(!empty($_GET['action'])){
    CategoriaController::main($_GET['action']);
}

class CategoriaController{

    static function main($action)
    {
        if ($action == "create") {
            CategoriaController::create();
        } else if ($action == "edit") {
           CategoriaController::edit();
        } else if ($action == "searchForID") {
           CategoriaController::searchForID($_REQUEST['idCategoria']);
        } else if ($action == "searchAll") {
          CategoriaController::getAll();
        } else if ($action == "activate") {
            CategoriaController::activate();
        } else if ($action == "inactivate") {
           CategoriaController::inactivate();
        }/*else if ($action == "login"){
          CategoriaController::login();
        }else if($action == "cerrarSession"){
           CategoriaController::cerrarSession();
        }*/

    }
//funcion crear categoria
    static public function create()
    {
        try {
            $arrayCategoria = array();
            $arrayCategoria['Nombre'] = $_POST['Nombre'];
            $arrayCategoria['Descripcion'] = $_POST['Descripcion'];
            $arrayCategoria['Estado'] = 'Activo';
            if(!Categoria::CategoriaRegistrado($arrayCategoria['Nombre'])){
                $Categoria = new Categoria ($arrayCategoria);
                if($Categoria->create()){
                    header("Location: ../../views/modules/Categoria/index.php?respuesta=correcto");
                }
            }else{
                header("Location: ../../views/modules/Categoria/create.php?respuesta=error&mensaje=Categoria ya registrada");
            }
        } catch (Exception $e) {
            header("Location: ../../views/modules/Categoria/create.php?respuesta=error&mensaje=" . $e->getMessage());
        }
    }

    static public function edit (){
        try {
            $arrayCategoria= array();
            $arrayCategoria['Nombre'] = $_POST['Nombre'];
            $arrayCategoria['Descripcion'] = $_POST['Descripcion'];
            $arrayCategoria['Estado'] = $_POST['Estado'];
            $arrayCategoria['Codigo'] = $_POST['Codigo'];

            $Categoria = new Categoria($arrayCategoria);
            $Categoria->update();

            header("Location: ../../views/modules/Categoria/show.php?id=".$Categoria->getCodigo()."&respuesta=correcto");
        } catch (\Exception $e) {
            var_dump($e);
            //header("Location: ../../views/modules/Categoria/edit.php?respuesta=error&mensaje" . $e->getMessage());
        }
    }
//funcion activa de la categoria
    static public function activate (){
        try {
            $ObjCategoria = Categoria::searchForId($_GET['Id']);
            $ObjCategoria->setEstado("activo");
            if($ObjCategoria->update()){
                header("Location: ../../views/modules/Categoria/index.php?respuesta=correcto");
            }else{
                header("Location: ../../views/modules/Categoria/index.php?respuesta=error&mensaje=Error al guardar");
            }
        } catch (\Exception $e) {
            //var_dump($e);
            header("Location: ../../views/modules/Categoria/index.php?respuesta=error&mensaje=".$e->getMessage());
        }
    }
//funcion inactiva de la categoria
    static public function inactivate (){
        try {
            $ObjCategoria = Categoria::searchForId($_GET['Id']);
            $ObjCategoria->setEstado("inactivo");
            if($ObjCategoria->update()){
                header("Location: ../../views/modules/Categoria/index.php?respuesta=correcto");
            }else{
                header("Location: ../../views/modules/Categoria/index.php?respuesta=error&mensaje=Error al guardar");
            }
        } catch (\Exception $e) {
            //var_dump($e);
            header("Location: ../../views/modules/Categoria/index.php?respuesta=error&mensaje" . $e-> getMessage());
        }
    }

    static public function searchForID ($id){
        try {
            return Categoria::searchForId($id);
        } catch (\Exception $e) {
            var_dump($e);
            //header("Location: ../../views/modules/Categoria/manager.php?respuesta=error");
        }
    }

    static public function getAll (){
        try {
            return Categoria::getAll();
        } catch (\Exception $e) {
            var_dump($e);
            //header("Location: ../Vista/modules/Categoria/manager.php?respuesta=error");
        }
    }
}
<?php

namespace app\Controllers;
require(__DIR__.'/../Models/Persona.php');
require_once(__DIR__.'/../Models/GeneralFunctions.php');

use App\Models\GeneralFunctions;
use app\Models\Inventario;
use app\Models\Persona;

if(!empty($_GET['action'])){
    UsuariosController::main($_GET['action']);
}

class UsuariosController
{

    static function main($action)
    {
        if ($action == "create") {
            UsuariosController::create();
        } else if ($action == "edit") {
            UsuariosController::edit();
        } else if ($action == "searchForDocumento") {
            UsuariosController::searchForDocumento($_REQUEST['Documento']);
        } else if ($action == "searchAll") {
            UsuariosController::getAll();
        } else if ($action == "activate") {
            UsuariosController::activate();
        } else if ($action == "inactivate") {
            UsuariosController::inactivate();
        }/*else if ($action == "login"){
            UsuariosController::login();
        }else if($action == "cerrarSession"){
            UsuariosController::cerrarSession();
        }*/

    }

    static public function create()
    {
        try {
            $arrayUsuario = array();
            $arrayUsuario['Codigo'] = $_POST['Codigo'];
            $arrayUsuario['Producto'] = $_POST['Producto'];
            $arrayUsuario['Compra'] = $_POST['Compra'];
            $arrayUsuario['Cantidad'] = $_POST['Cantidad'];
            $arrayUsuario['Precio'] = $_POST['Precio'];
            $arrayUsuario['IVA'] = $_POST['IVA'];
            $arrayUsuario['Talla'] = $_POST['Talla'];
            $arrayUsuario['Color'] = $_POST['Color'];
            if (!Inventario::usuarioregistrado($arrayUsuario['Codigo'])) {
                $Persona = new Inventario($arrayUsuario);
                if ($Persona->create()) {
                    header("Location: ../../views/modules/Inventario/index.php?respuesta=correcto");
                }
            } else {
                header("Location: ../../views/modules/Inventario/create.php?respuesta=error&mensaje=Usuario ya registrado");
            }
        } catch (Exception $e) {
            header("Location: ../../views/modules/Inventario/create.php?respuesta=error&mensaje=" . $e->getMessage());
        }
    }

    static public function edit()
    {
        try {
            $arrayUsuario = array();
            $arrayUsuario['Documento'] = $_POST['Documento'];
            $arrayUsuario['Nombre'] = $_POST['Nombre'];
            $arrayUsuario['Apellido'] = $_POST['Apellido'];
            $arrayUsuario['Genero'] = $_POST['Genero'];
            $arrayUsuario['Correo'] = $_POST['Correo'];
            $arrayUsuario['Telefono'] = $_POST['Telefono'];
            $arrayUsuario['Direccion'] = $_POST['Direccion'];
            $arrayUsuario['Rol'] = $_POST['Rol'];
            $arrayUsuario['Contrasena'] = $_POST['Contrasena'];
            $arrayUsuario['Estado'] = $_POST['Estado'];


            $Persona = new Persona($arrayUsuario);
            $Persona->update();

            header("Location: ../../views/modules/Persona/show.php?id=".$Persona->getDocumento()."&respuesta=correcto");
        } catch (\Exception $e) {
            GeneralFunctions::console( $e, 'error', 'errorStack');
            //var_dump($e);
            //header("Location: ../../views/modules/Persona/edit.php?respuesta=error&mensaje=" . $e->getMessage());
        }
    }

    static public function activate()
    {
        try {
            $ObjUsuario = Persona::searchForDocumento($_GET['Id']);
            $ObjUsuario->setEstado("activo");
            if ($ObjUsuario->update()) {
                header("Location: ../../views/modules/Persona/index.php");
            } else {
                header("Location: ../../views/modules/Persona/index.php?respuesta=error&mensaje=Error al guardar");
            }
        } catch (\Exception $e) {
           // GeneralFunctions::console( $e, 'error', 'errorStack');
            //var_dump($e);
            header("Location: ../../views/modules/Persona/index.php?respuesta=error&mensaje=" . $e->getMessage());
        }
    }

    static public function inactivate()
    {
        try {
            $ObjUsuario = Persona::searchForDocumento($_GET['Id']);
            $ObjUsuario->setEstado("Inactivo");
            if ($ObjUsuario->update()) {
                header("Location: ../../views/modules/Persona/index.php");
            } else {
                header("Location: ../../views/modules/Persona/index.php?respuesta=error&mensaje=Error al guardar");
            }
        } catch (\Exception $e) {
            //var_dump($e);
            header("Location: ../../views/modules/Persona/index.php?respuesta=error");
        }
    }

    public static function searchForDocumento($Documento){
        try {
            return Persona::searchForDocumento($Documento);
        } catch (\Exception $e) {
            var_dump($e);
            header("Location: ../../views/modules/Persona/manager.php?respuesta=error");
        }
    }

    public static function getAll(){
        try {
            return Persona::getAll();
        } catch (\Exception $e) {
            var_dump($e);
            //header("Location: ../Vista/modules/persona/manager.php?respuesta=error");
        }
    }

    private static function usuarioIsInArray($idUsuario, $arrUsuarios){
        if(count($arrUsuarios) > 0){
            foreach ($arrUsuarios as $Usuario){
                if($Usuario->getId() == $idUsuario){
                    return true;
                }
            }
        }
        return false;
    }

    static public function selectUsuario ($isMultiple=false,
                                          $isRequired=true,
                                          $id="idUsuario",
                                          $nombre="idUsuario",
                                          $defaultValue="",
                                          $class="form-control",
                                          $where="",
                                          $arrExcluir = array()){
        $arrUsuarios = array();
        if($where != ""){
            $base = "SELECT * FROM Persona WHERE ";
            $arrUsuarios = Persona ::search($base.' '.$where);
        }else{
            $arrUsuarios = Persona::getAll();
        }

        $htmlSelect = "<select ".(($isMultiple) ? "multiple" : "")." ".(($isRequired) ? "required" : "")." id= '".$id."' name='".$nombre."' class='".$class."' style='width: 100%;'>";
        $htmlSelect .= "<option value='' >Seleccione</option>";
        if(count($arrUsuarios) > 0){
            foreach ($arrUsuarios as $usuario)
                if (!UsuariosController::usuarioIsInArray($usuario->getDocumento(),$arrExcluir))
                    $htmlSelect .= "<option ".(($usuario != "") ? (($defaultValue == $usuario->getDocumento()) ? "selected" : "" ) : "")." value='".$usuario->getDocumento()."'>".$usuario->getDocumento()." - ".$usuario->getNombres()." ".$usuario->getApellidos()."</option>";
        }
        $htmlSelect .= "</select>";
        return $htmlSelect;
    }

    /*public static function personaIsInArray($idPersona, $ArrPersonas){
        if(count($ArrPersonas) > 0){
            foreach ($ArrPersonas as $Persona){
                if($Persona->getIdPersona() == $idPersona){
                    return true;
                }
            }
        }
        return false;
    }

    static public function selectPersona ($isMultiple=false,
                                          $isRequired=true,
                                          $id="idConsultorio",
                                          $nombre="idConsultorio",
                                          $defaultValue="",
                                          $class="",
                                          $where="",
                                          $arrExcluir = array()){
        $arrPersonas = array();
        if($where != ""){
            $base = "SELECT * FROM persona WHERE ";
            $arrPersonas = Persona::buscar($base.$where);
        }else{
            $arrPersonas = Persona::getAll();
        }

        $htmlSelect = "<select ".(($isMultiple) ? "multiple" : "")." ".(($isRequired) ? "required" : "")." id= '".$id."' name='".$nombre."' class='".$class."'>";
        $htmlSelect .= "<option value='' >Seleccione</option>";
        if(count($arrPersonas) > 0){
            foreach ($arrPersonas as $persona)
                if (!UsuariosController::personaIsInArray($persona->getIdPersona(),$arrExcluir))
                    $htmlSelect .= "<option ".(($persona != "") ? (($defaultValue == $persona->getIdPersona()) ? "selected" : "" ) : "")." value='".$persona->getIdPersona()."'>".$persona->getNombres()." ".$persona->getApellidos()."</option>";
        }
        $htmlSelect .= "</select>";
        return $htmlSelect;
    }*/

    /*
    public function buscar ($Query){
        try {
            return Persona::buscar($Query);
        } catch (Exception $e) {
            header("Location: ../Vista/modules/persona/manager.php?respuesta=error");
        }
    }

    static public function asociarEspecialidad (){
        try {
            $Persona = new Persona();
            $Persona->asociarEspecialidad($_POST['Persona'],$_POST['Especialidad']);
            header("Location: ../Vista/modules/persona/managerSpeciality.php?respuesta=correcto&id=".$_POST['Persona']);
        } catch (Exception $e) {
            header("Location: ../Vista/modules/persona/managerSpeciality.php?respuesta=error&mensaje=".$e->getMessage());
        }
    }

    static public function eliminarEspecialidad (){
        try {
            $ObjPersona = new Persona();
            if(!empty($_GET['Persona']) && !empty($_GET['Especialidad'])){
                $ObjPersona->eliminarEspecialidad($_GET['Persona'],$_GET['Especialidad']);
            }else{
                throw new Exception('No se recibio la informacion necesaria.');
            }
            header("Location: ../Vista/modules/persona/managerSpeciality.php?id=".$_GET['Persona']);
        } catch (Exception $e) {
            var_dump($e);
            //header("Location: ../Vista/modules/persona/manager.php?respuesta=error");
        }
    }

    public static function login (){
        try {
            if(!empty($_POST['Usuario']) && !empty($_POST['Contrasena'])){
                $tmpPerson = new Persona();
                $respuesta = $tmpPerson->Login($_POST['Usuario'], $_POST['Contrasena']);
                if (is_a($respuesta,"Persona")) {
                    $hydrator = new ReflectionHydrator(); //Instancia de la clase para convertir objetos
                    $ArrDataPersona = $hydrator->extract($respuesta); //Convertimos el objeto persona en un array
                    unset($ArrDataPersona["datab"],$ArrDataPersona["isConnected"],$ArrDataPersona["relEspecialidades"]); //Limpiamos Campos no Necesarios
                    $_SESSION['UserInSession'] = $ArrDataPersona;
                    echo json_encode(array('type' => 'success', 'title' => 'Ingreso Correcto', 'text' => 'Sera redireccionado en un momento...'));
                }else{
                    echo json_encode(array('type' => 'error', 'title' => 'Error al ingresar', 'text' => $respuesta)); //Si la llamda es por Ajax
                }
                return $respuesta; //Si la llamada es por funcion
            }else{
                echo json_encode(array('type' => 'error', 'title' => 'Datos Vacios', 'text' => 'Debe ingresar la informacion del usuario y contraseña'));
                return "Datos Vacios"; //Si la llamada es por funcion
            }
        } catch (Exception $e) {
            var_dump($e);
            header("Location: ../login.php?respuesta=error");
        }
    }

    public static function cerrarSession (){
        session_unset();
        session_destroy();
        header("Location: ../Vista/modules/persona/login.php");
    }*/

}
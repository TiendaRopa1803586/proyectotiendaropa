<?php


namespace App\Models;
use http\QueryString;

require ('BasicModel.php');


class Persona extends BasicModel
{
    private $Documento;
    private $Nombre;
    private $Apellido;
    private $Genero;
    private $Correo;
    private $Telefono;
    private $Direccion;
    private $Rol;
    private $Contrasena;
    private $Estado;

    /**
     * Persona constructor.
     * @param $Documento
     * @param $Nombre
     * @param $Apellido
     * @param $Genero
     * @param $Correo
     * @param $Telefono
     * @param $Direccion
     * @param $Rol
     * @param $Contrasena
     * @param $Estado

     **/
    public function __construct($Persona = array())
    {
        parent::__construct(); //Llama al contructor padre "la clase conexion" para conectarme a la BD
        $this->Documento = $Persona['Documento'] ?? null;
        $this->Nombre = $Persona['Nombre'] ?? null;
        $this->Apellido = $Persona['Apellido'] ?? null;
        $this->Genero = $Persona['Genero'] ?? null;
        $this->Correo = $Persona['Correo'] ?? null;
        $this->Telefono = $Persona['Telefono'] ?? null;
        $this->Direccion = $Persona['Direccion'] ?? null;
        $this->Rol = $Persona['ROL'] ?? null;
        $this->Contrasena = $Persona['Contrasena'] ?? null;
        $this->Estado = $Persona['Estado'] ?? null;

    }

    /* Metodo destructor cierra la conexion. */
    function __destruct() {
        $this->Disconnect();
    }

    /**
     * @return int
     */
    public function getDocumento() : int
    {
        return $this->Documento;
    }

    /**
     * @param int $Documento
     */
    public function setDocumento(int $Documento): void
    {
        $this->Documento = $Documento;
    }

    /**
     * @return string
     */
    public function getNombre() : string
    {
        return $this->Nombre;
    }

    /**
     * @param string $Nombre
     */
    public function setNombre(string $Nombre): void
    {
        $this->Nombre = $Nombre;
    }

    /**
     * @return string
     */
    public function getApellido() : string
    {
        return $this->Apellido;
    }

    /**
     * @param string $Apellido
     */
    public function setApellido(string $Apellido): void
    {
        $this->Apellido = $Apellido;
    }

    /**
     * @return String
     */
    public function getGenero() : String
    {
        return $this->Genero;
    }

    /**
     * @param String $Genero
     */
    public function setGenero(String $Genero): void
    {
        $this->Genero = $Genero;
    }

    /**
     * @return String
     */
    public function getCorreo() : String
    {
        return $this->Correo;
    }


    /**
     * @param String $Correo
     */
    public function setCorreo(String $Correo): void
    {
        $this->Correo = $Correo;
    }

    /**
     * @return int
     */
    public function getTelefono() : int
    {
        return $this->Telefono;
    }

    /**
     * @param int $Telefono
     */
    public function setTelefono(int $Telefono): void
    {
        $this->Telefono = $Telefono;
    }

    /**
     * @return String
     */
    public function getDireccion() : String
    {
        return $this->Direccion;
    }

    /**
     * @param String $Direccion
     */
    public function setDireccion(String $Direccion): void
    {
        $this->Genero = $Direccion;
    }

    /**
     * @return String
     */
    public function getRol() : String
    {
        return $this->Rol;
    }

    /**
     * @param String $Rol
     */
    public function setRol(String $Rol): void
    {
        $this->Rol = $Rol;
    }
    /**
     * @return String
     */
    public function getContrasena() : String
    {
        return $this->Contrasena;
    }

    /**
     * @param String $Contrasena
     */
    public function setContrasena(String $Contrasena): void
    {
        $this->Contrasena = $Contrasena;
    }

    /**
     * @return String
     */
    public function getEstado() : String
    {
        return $this->Estado;
    }

    /**
     * @param String $Estado
     */
    public function setEstado(String $Estado): void
    {
        $this->Estado = $Estado;
    }

    public function create() : bool
    {
        $result = $this->insertRow("INSERT INTO proyectotiendaropa.Persona VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)", array(
                $this->Documento,
                $this->Nombre,
                $this->Apellido,
                $this->Genero,
                $this->Correo,
                $this->Telefono,
                $this->Direccion,
                $this->Rol,
                $this->Contrasena,
                $this->Estado,



            )
        );
        $this->Disconnect();
        return $result;
    }

    public function update() : bool
    {
        $result = $this->updateRow("UPDATE proyectotiendaropa.Persona SET Documento = ?, Nombre = ?, Apellido = ?, Genero = ?, Correo = ?, Telefono=? , Direccion=? , rol=? , Contrasena=? , Estado=?  WHERE Documento = ?", array(
                $this->Documento,
                $this->Nombre,
                $this->Apellido,
                $this->Genero,
                $this->Correo,
                $this->Telefono,
                $this->Direccion,
                $this->Rol,
                $this->Contrasena,
                $this->Estado,
            )
        );
        $this->Disconnect();
        return $result;
    }
// PREGUNTAR SOBRE LA PRIMERA VARIABLE
    public function deleted($Documento) : void
    {
       $Person = Persona::searchForId($Documento);
       $this->setEstado("inactivo");
       $this->update();
        // TODO: Implement deleted() method.
    }

    public static function search($query) : array
    {
        $arrPersona = array();
        $tmp = new Persona();
        $getrows = $tmp->getRows($query);

        foreach ($getrows as $valor) {
            $Persona = new Persona();
            $Persona->Documento = $valor['Documento'];
            $Persona->Nombre = $valor['Nombre'];
            $Persona->Apellido = $valor['Apellido'];
            $Persona->Genero = $valor['Genero'];
            $Persona->Correo = $valor['Correo'];
            $Persona->Telefono = $valor['Telefono'];
            $Persona->Direccion = $valor['Direccion'];
            $Persona->Rol = $valor['Rol'];
            $Persona->Contrasena = $valor['Contrasena'];
            $Persona->Estado = $valor['Estado'];
          $Persona->Disconnect();
          array_push($arrPersona, $Persona);

        }
        $tmp->Disconnect();
        return $arrPersona;
    }
//FALTA TERMINAR ESTO DE ABAJO
    public static function searchForId($Documento) : Persona
    {
        $Persona=null;
        if ($Documento > 0){
            $Persona = new Persona();
        $getrow = $Persona->getRow("SELECT * FROM proyectotiendaropa.Persona WHERE Documento =?", array($Documento));
            $Persona->Documento = $getrow['Documento'];
            $Persona->Nombre = $getrow['Nombre'];
            $Persona->Apellido = $getrow['Apellido'];
            $Persona->Genero = $getrow['Genero'];
            $Persona->Correo = $getrow['Correo'];
            $Persona->Telefono = $getrow['Telefono'];
            $Persona->Direccion = $getrow['Direccion'];
            $Persona->Rol = $getrow['Rol'];
            $Persona->Contrasena= $getrow['Contraseña'];
            $Persona->Estado = $getrow['Estado'];
        }
        $Persona->Disconnect();
        return $Persona;
    }

    public static function getAll() : array
    {
        return Persona::search("SELECT * FROM proyectotiendaropa.Persona");
    }

   /* public static function Persona ($Fecha) : bool
    {
        $result = Persona::search("SELECT Documento FROM proyectotiendaropa.Persona where Fecha = ".$Fecha);
        if (count($result) > 0){
            return true;
        }else{
            return false;
        }
    }
*/

}
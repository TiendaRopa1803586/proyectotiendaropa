<?php


namespace app\Models;
use http\QueryString;
require_once('BasicModel.php');

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
     */
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
        $this->Rol = $Persona['Rol'] ?? null;
        $this->Contrasena = $Persona['Contrasena'] ?? null;
        $this->Estado = $Persona['Estado'] ?? null;
    }
    /**
     * @return array
     */
    public static function getAll(): array
    {
        return Persona::search("SELECT * FROM merempresac.Persona");
    }
    /**
     * @param $query
     * @return Persona|array
     * @throws \Exception
     */
    public static function search ($query)
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
    /**
     * @param $documento
     * @return bool
     * @throws \Exception
     */
    public static function usuarioregistrado ($Documento): bool
    {
        $result = Persona::search("SELECT * FROM merempresac.Persona where Documento = ".$Documento );
        if (count($result) > 0) {
            return true;
        } else {
            return false;
        }
    }
    /**
     *
     */
    function __destruct()
    {
        $this->Disconnect();
    }
    /**
     * @return int
     */
    public function getDocumento(): int
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
    public function getNombre(): string
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
     *
     */
    public function getApellido(): string
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
     * @return string
     */
    public function getGenero(): string
    {
        return $this->Genero;
    }

    /**
     * @param string $Genero
     */
    public function setGenero(string $Genero): void
    {
        $this->Genero = $Genero;
    }

    /**
     * @return string
     */
    public function getCorreo(): string
    {
        return $this->Correo;
    }

    /**
     * @param string $Correo
     */
    public function setCorreo(string $Correo): void
    {
        $this->Correo = $Correo;
    }

    /**
     * @return int
     */
    public function getTelefono(): int
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
     * @return string
     */
    public function getDireccion(): string
    {
        return $this->Direccion;
    }

    /**
     * @param string $Direccion
     */
    public function setDireccion(string $Direccion): void
    {
        $this->Direccion = $Direccion;
    }

    /**
     * @return string
     */
    public function getRol(): string
    {
        return $this->Rol;
    }

    /**
     * @param string $Rol
     */
    public function setRol(string $Rol): void
    {
        $this->Rol = $Rol;
    }

    /**
     * @return string
     */
    public function getContrasena(): string
    {
        return $this->Contrasena;
    }

    /**
     * @param string $Contrasena
     */
    public function setContrasena(string $Contrasena): void
    {
        $this->Contrasena = $Contrasena;
    }

    /**
     * @return string
     */
    public function getEstado(): string
    {
        return $this->Estado;
    }

    /**
     * @param string $Estado
     */
    public function setEstado(string $Estado): void
    {
        $this->Estado = $Estado;
    }
    /**
     * @return bool
     * @throws \Exception
     */
   public function create(): bool
    {
        $result = $this->insertRow("INSERT INTO merempresac.persona VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)", array(
                $this->Documento,
                $this->Nombre,
                $this->Apellido,
                $this->Genero,
                $this->Correo,
                $this->Telefono,
                $this->Direccion,
                $this->Rol,
                $this->Contrasena,
                $this->Estado
            )

        );
        $this->Disconnect();
        return $result;
    }
    /**
     * @param $id
     * @return bool
     */
    public function deleted($id): bool
    {
        $User = Persona::searchForId($id); //Buscando un usuario por el ID
        $User->setEstado("Inactivo"); //Cambia el estado del Usuario
        return $User->update();                    //Guarda los cambios..
    }

    /**
     * @param $Documento
     * @return Persona
     * @throws \Exception
     */
    public static function searchForId($id): Persona
    {
        $Persona = null;
        if ($id > 0) {
            $Persona = new Persona();
            $getrow = $Persona->getRow("SELECT * FROM merempresac.Persona WHERE Documento =?", array($id));
            $Persona->Documento = $getrow['Documento'];
            $Persona->Nombre = $getrow['Nombre'];
            $Persona->Apellido = $getrow['Apellido'];
            $Persona->Genero = $getrow['Genero'];
            $Persona->Correo = $getrow['Correo'];
            $Persona->Telefono = $getrow['Telefono'];
            $Persona->Direccion = $getrow['Direccion'];
            $Persona->Rol = $getrow['Rol'];
            $Persona->Contrasena = $getrow['Contrasena'];
            $Persona->Estado = $getrow['Estado'];
        }
        $Persona->Disconnect();
        return $Persona;
    }

    /**
     * @return bool
     */
    public function update(): bool
    {
        $result = $this->updateRow("UPDATE merempresac.Persona SET  Nombre = ?, Apellido = ?, Genero = ?, Correo = ?, Telefono=?, Direccion=?, Rol=?, Contrasena=?, Estado=?  WHERE Documento = ?", array(

                $this->Nombre,
                $this->Apellido,
                $this->Genero,
                $this->Correo,
                $this->Telefono,
                $this->Direccion,
                $this->Rol,
                $this->Contrasena,
                $this->Estado,
                $this->Documento
            )
        );
        $this->Disconnect();
        return $result;
    }

    /**
     * @return string
     */
    public function nombresCompletos()
    {
        return $this->Nombre . " " . $this->Apellido;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return "Documento: $this->Documento, Nombre: $this->Nombre, Apellido: $this->Apellido, Genero: $this->Genero, Correo: $this->Correo, Telefono: $this->Telefono,Direccion: $this->Direccion,Rol: $this->Rol,Contrasena: $this->Contrasena,Contrasena: $this->Estado";
    }


    /*
    public function __toString()
    {
        return $this->documentPerson." ".$this->namePerson." ".$this->dateBornPerson." ".$this->rhperson
            ." ".$this->emailPerson ." ".$this->phonePerson." ".$this->adressPerson." ".$this->genereperson." ".$this->userperson
            ." ".$this->passwordPerson." ".$this->typePerson." ".$this->statePerson." ".$this->photoperson;


    }


    public function delete($idCategoria): bool
    {
        $CategoriaDelet = Categoria::searchForId($idCategoria);
        $CategoriaDelet->setestado("Inactivo");
        return $CategoriaDelet->update();
    }

*/






}


<?php


namespace App\Models;
use http\QueryString;
require('BasicModel.php');
#Creacion de la clase con herencia de la clase Basic Model

class Categoria extends BasicModel
{
    private $Codigo;
    private $Nombre;
    private $Descripcion;
    private $Estado;

    /**
     *Categoria constructor.
     * @param $Codigo
     * @param $Nombre
     * @param $Descripcion
     * @param $Estado

     */
    public function __construct($Categoria = array())
    {
        parent::__construct(); //Llama al contructor padre "la clase conexion" para conectarme a la BD
        $this->Codigo = $Categoria['Codigo'] ?? null;
        $this->Nombre = $Categoria['Nombre'] ?? null;
        $this->Descripcion = $Categoria['Descripcion'] ?? null;
        $this->Estado = $Categoria['Estado'] ?? null;
    }
    /* Metodo destructor cierra la conexion. */
    function __destruct() {
        $this->Disconnect();
    }

    /**
     * @return int
     */
    public function getCodigo(): ?int
    {
        return $this->Codigo;
    }

    /**
     * @param int $Codigo
     */
    public function setCodigo(?int $Codigo): void
    {
        $this->Codigo = $Codigo;
    }

    /**
     * @return string
     */
    public function getNombre(): ?string
    {
        return $this->Nombre;
    }

    /**
     * @param string $Nombre
     */
    public function setNombre(?string $Nombre): void
    {
        $this->Nombre = $Nombre;
    }

    /**
     * @return string
     */
    public function getDescripcion(): ?string
    {
        return $this->Descripcion;
    }

    /**
     * @param string $Descripcion
     */
    public function setDescripcion(?string $Descripcion): void
    {
        $this->Descripcion = $Descripcion;
    }

    /**
     * @return string
     */
    public function getEstado(): ?string
    {
        return $this->Estado;
    }

    /**
     * @param string $Estado
     */
    public function setEstado(?string $Estado): void
    {
        $this->Estado = $Estado;
    }
    //creacion del metodo create
    public function create() : bool
    {
        $result = $this->insertRow("INSERT INTO merempresac.Categoria VALUES (NULL, ?, ?, ?)", array(
                $this->Nombre,
                $this->Descripcion,
                $this->Estado,

            )
        );
        $this->Disconnect();
        return $result;
    }
    public function update() : bool
    {
        $result = $this->updateRow("UPDATE merempresac.Categoria SET Nombre = ?, Descripcion = ?, Estado = ? WHERE Codigo = ?", array(
                $this->Nombre,
                $this->Descripcion,
                $this->Estado,
                $this->Codigo,
            )
        );
        $this->Disconnect();
        return $result;
    }
    //Creacion del la funcion eliminar o cambiar estado de una persona segun el Id
    public function deleted($Codigo) : void
    {
        // TODO: Implement deleted() method.
    }
    //buscar por query
    public static function search($query) : array
    {
        $arrCategoria = array();
        $tmp = new Categoria();
        $getrows = $tmp->getRows($query);

        foreach ($getrows as $valor) {
            $Categoria = new Categoria();
            $Categoria->Codigo = $valor['Codigo'];
            $Categoria->Nombre = $valor['Nombre'];
            $Categoria->Descripcion = $valor['Descripcion'];
            $Categoria->Estado = $valor['Estado'];
            $Categoria->Disconnect();
            array_push($arrCategoria, $Categoria);
        }
        $tmp->Disconnect();
        return $arrCategoria;
    }
    public static function searchForId($Codigo) : Categoria
    {
        $Categoria= null;
        if ($Codigo > 0){
            $Categoria= new Categoria();
            $getrow = $Categoria->getRow("SELECT * FROM merempresac.Categoria WHERE Codigo =?", array($Codigo));
            $Categoria->Codigo = $getrow['Codigo'];
            $Categoria->Nombre = $getrow['Nombre'];
            $Categoria->Descripcion = $getrow['Descripcion'];
            $Categoria->Estado = $getrow['Estado'];

        }
        $Categoria->Disconnect();
        return $Categoria;
    }


    public static function getAll() : array
    {
        return Categoria::search("SELECT * FROM merempresac.Categoria");
    }

    public static function CategoriaRegistrado ($Nombre) : bool
    {
        $result = Categoria::search("SELECT * FROM merempresac.categoria where Nombre = '".$Nombre . "'");
        if (count($result) > 0){
            return true;
        }else{
            return false;
        }
    }
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
}
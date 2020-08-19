<?php


namespace App\Models;
use http\QueryString;
require('BasicModel.php');
#Creacion de la clase con herencia de la clase Basic Model

class Marca extends BasicModel
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
    public function __construct($Marca = array())
    {
        parent::__construct(); //Llama al contructor padre "la clase conexion" para conectarme a la BD
        $this->Codigo = $Marca['Codigo'] ?? null;
        $this->Nombre = $Marca['Nombre'] ?? null;
        $this->Descripcion = $Marca['Descripcion'] ?? null;
        $this->Estado = $Marca['Estado'] ?? null;
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
        $result = $this->insertRow("INSERT INTO merempresac.Marca VALUES (NULL, ?, ?, ?)", array(
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
        $result = $this->updateRow("UPDATE merempresac.Marca SET Nombre = ?, Descripcion = ?, Estado = ? WHERE Codigo = ?", array(
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
        $arrMarca = array();
        $tmp = new Marca();
        $getrows = $tmp->getRows($query);

        foreach ($getrows as $valor) {
            $Marca = new Marca();
            $Marca->Codigo = $valor['Codigo'];
            $Marca->Nombre = $valor['Nombre'];
            $Marca->Descripcion = $valor['Descripcion'];
            $Marca->Estado = $valor['Estado'];
            $Marca->Disconnect();
            array_push($arrMarca, $Marca);
        }
        $tmp->Disconnect();
        return $arrMarca;
    }
    public static function searchForId($Codigo) : Marca
    {
        $Marca= null;
        if ($Codigo > 0){
            $Marca= new Marca();
            $getrow = $Marca->getRow("SELECT * FROM merempresac.Marca WHERE Codigo =?", array($Codigo));
            $Marca->Codigo = $getrow['Codigo'];
            $Marca->Nombre = $getrow['Nombre'];
            $Marca->Descripcion = $getrow['Descripcion'];
            $Marca->Estado = $getrow['Estado'];

        }
        $Marca->Disconnect();
        return $Marca;
    }


    public static function getAll() : array
    {
        return Marca::search("SELECT * FROM merempresac.Marca");
    }

    public static function MarcaRegistrado ($Nombre) : bool
    {
        $result = Marca::search("SELECT * FROM merempresac.Marca where Nombre = '".$Nombre . "'");
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


    public function delete($idMarca): bool
    {
        $MarcaDelet = Marca::searchForId($idMarca);
        $MarcaDelet->setestado("Inactivo");
        return $MarcaDelet->update();
    }
}
<?php


namespace App\Models;

require_once('BasicModel.php');
require_once('Categoria.php');
#Creacion de la clase con herencia de la clase Basic Model

use App\Models\Categoria;

class Subcategoria extends BasicModel
{
    private $Codigo;
    private $Nombre;
    private $Descripcion;
    private $Estado;
    private  Categoria  $Categoria;
    /**
     *Categoria constructor.
     * @param $Codigo
     * @param $Nombre
     * @param $Descripcion
     * @param $Estado
     * @param $Categoria

     */
    public function __construct($Subcategoria = array())
    {
        parent::__construct(); //Llama al contructor padre "la clase conexion" para conectarme a la BD
        $this->Codigo = $Subcategoria['Codigo'] ?? null;
        $this->Nombre = $Subcategoria ['Nombre'] ?? null;
        $this->Descripcion = $Subcategoria['Descripcion'] ?? null;
        $this->Estado = $Subcategoria['Estado'] ?? null;
        $this->Categoria = $Subcategoria['Categoria'] ?? new Categoria();
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

    /**
     * @return Categoria
     */
    public function getCategoria(): ? Categoria
    {
        return $this->Categoria;
    }

    /**
     * @param Categoria $Subcategoria
     */
    public function setCategoria(?Categoria $Subcategoria): void
    {
        $this->Subcategoria = $Subcategoria;
    }

    //creacion del metodo create

    public function create() : bool
    {
        $result = $this->insertRow("INSERT INTO merempresac.Subcategoria VALUES (NULL, ?, ?, ?, ?)", array(
                $this->Nombre,
                $this->Descripcion,
                $this->Estado,
                $this->Categoria->getCodigo(),

            )
        );
        $this->Disconnect();
        return $result;
    }
    public function update() : bool
    {
        $result = $this->updateRow("UPDATE merempresac.Subcategoria SET Nombre = ?, Descripcion = ?, Estado = ?, Categoria = ? WHERE Codigo = ?", array(
                $this->Nombre,
                $this->Descripcion,
                $this->Estado,
                $this->Categoria->getCodigo(),
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
        $arrSubcategoria = array();
        $tmp = new Subcategoria();
        $getrows = $tmp->getRows($query);

        foreach ($getrows as $valor) {
            $Subcategoria = new Subcategoria();
            $Subcategoria->Codigo = $valor['Codigo'];
            $Subcategoria->Nombre = $valor['Nombre'];
            $Subcategoria->Descripcion = $valor['Descripcion'];
            $Subcategoria->Estado = $valor['Estado'];
            $Subcategoria->Categoria = Categoria::searchForId($valor['Categoria']);
            $Subcategoria->Disconnect();
            array_push($arrSubcategoria, $Subcategoria);
        }
        $tmp->Disconnect();
        return $arrSubcategoria ;
    }
    public static function searchForId($Codigo) : Subcategoria
    {
        $Subcategoria= null;
        if ($Codigo > 0){
            $Subcategoria= new Subcategoria();
            $getrow = $Subcategoria->getRow("SELECT * FROM merempresac.subcategoria WHERE Codigo =?", array($Codigo));
            $Subcategoria->Codigo = $getrow['Codigo'];
            $Subcategoria ->Nombre = $getrow['Nombre'];
            $Subcategoria->Descripcion = $getrow['Descripcion'];
            $Subcategoria->Estado = $getrow['Estado'];
            $Subcategoria->Categoria = Categoria::searchForId($getrow['Categoria']);

        }
        $Subcategoria->Disconnect();
        return $Subcategoria;
    }


    public static function getAll() : array
    {
        return Subcategoria::search("SELECT * FROM merempresac.Subcategoria");
    }

    public static function SubcategoriaRegistrado ($Nombre) : bool
    {
        $result = Subcategoria::search("SELECT * FROM merempresac.Subcategoria where Nombre = '".$Nombre . "'");
        if (count($result) > 0){
            return true;
        }else{
            return false;
        }
    }
    public function __toString()
    {
        return $this->getNombre()." ".$this->getDescripcion()." ".$this->getEstado()." ".$this->getCodigo()
            ." ".$this->getCategoria()->getNombre();
    }


    public function delete($idSubcategoria): bool
    {
        $SubcategoriaDelet = Subcategoria::searchForId($idSubcategoria);
        $SubcategoriaDelet->setEstado("inactivo");
        return $SubcategoriaDelet->update();
    }
}
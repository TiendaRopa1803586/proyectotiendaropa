<?php


namespace App\Models;

require_once('BasicModel.php');
require_once('Categoria.php');
#Creacion de la clase con herencia de la clase Basic Model

use App\Models\Marca;
use App\Models\Subcategoria;


class Producto extends BasicModel
{
    private $Codigo;
    private $Nombre;
    private $Importado;
    private $Descripcion;
    private $Marca;
    private $Subcategoria;
    private $Estado;


    /**
     *Categoria constructor.
     * @param $Codigo
     * @param $Nombre
     * @param $Importado
     * @param $Descripcion
     * @param $Marca
     * @param $Subcategoria
     * @param $Estado


     */
    public function __construct($Producto = array())
    {
        parent::__construct(); //Llama al contructor padre "la clase conexion" para conectarme a la BD
        $this->Codigo = $Producto['Codigo'] ?? null;
        $this->Nombre = $Producto ['Nombre'] ?? null;
        $this->Importado = $Producto['Importado'] ?? null;
        $this->Marca = $Producto['Marca'] ?? new Marca();
        $this->Subcatgeoria = $Producto['Subcatgeoria'] ?? new Subcategoria();
        $this->Descripcion = $Producto['Descripcion'] ?? null;
        $this->Estado = $Producto['Estado'] ?? null;

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
    public function getImportado(): ?string
    {
        return $this->Importado;
    }

    /**
     * @param string $Importado
     */
    public function setImportado(?string $Importado): void
    {
        $this->Importado = $Importado;
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
     * @return Marca
     */
    public function getMarca(): ? Marca
    {
        return $this->Marca;
    }

    /**
     * @param Marca $Producto
     */
    public function setMarca(?Marca $Producto): void
    {
        $this->Producto = $Producto;
    }
    /**
     * @return Subcategoria
     */
    public function getSubcategoria(): ? Subcategoria
    {
        return $this->Subcategoria;
    }

    /**
     * @param Subcategoria $Producto
     */
    public function setSubcategoria(?Subcategoria $SProducto): void
    {
        $this->Producto = $SProducto;
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
        $result = $this->insertRow("INSERT INTO merempresac.Producto VALUES (NULL, ?, ?, ?, ?,?,?)", array(
                $this->Nombre,
                $this->Importado,
                $this->Descripcion,
                $this->Marca->getCodigo(),
                $this->Subcategoria->getCodigo(),
                $this->Estado,

            )
        );
        $this->Disconnect();
        return $result;
    }
    public function update() : bool
    {
        $result = $this->updateRow("UPDATE merempresac.Producto SET Nombre = ?,Importado = ?, Descripcion = ?,Marca = ?, Subcategoria = ? Estado = ? WHERE Codigo = ?", array(

                $this->Nombre,
                $this->Importado,
                $this->Descripcion,
                $this->Marca->getCodigo(),
                $this->Subcategoria->getCodigo(),
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
        $arrProducto = array();
        $tmp = new Producto();
        $getrows = $tmp->getRows($query);

        foreach ($getrows as $valor) {
            $Producto = new Producto();
            $Producto->Codigo = $valor['Codigo'];
            $Producto->Nombre = $valor['Nombre'];
            $Producto->Importado = $valor['Importado'];
            $Producto->Descripcion = $valor['Descripcion'];
            $Producto->Marca = Marca::searchForId($valor['Marca']);
            $Producto->Subcategoria = Subcategoria::searchForId($valor['Subcategoria']);
            $Producto->Estado = $valor['Estado'];

            $Producto->Disconnect();
            array_push($arrProducto, $Producto);
        }
        $tmp->Disconnect();
        return $arrProducto ;
    }
    public static function searchForId($Codigo) : Producto
    {
        $Producto= null;
        if ($Codigo > 0){
            $Producto= new Producto();
            $getrow = $Producto->getRow("SELECT * FROM merempresac.Producto WHERE Codigo =?", array($Codigo));
            $Producto->Codigo = $getrow['Codigo'];
            $Producto ->Nombre = $getrow['Nombre'];
            $Producto ->Importado = $getrow['Importado'];
            $Producto->Descripcion = $getrow['Descripcion'];
            $Producto->Marca = Marca::searchForId($getrow['Marcq']);
            $Producto->Subcategoria  = Subcategoria::searchForId($getrow['Subcategoria']);
            $Producto->Estado = $getrow['Estado'];


        }
        $Producto->Disconnect();
        return $Producto;
    }


    public static function getAll() : array
    {
        return Producto::search("SELECT * FROM merempresac.Producto ");
    }

    public static function ProductoRegistrado ($Nombre) : bool
    {
        $result = Producto::search("SELECT * FROM merempresac.Producto where Nombre = '".$Nombre . "'");
        if (count($result) > 0){
            return true;
        }else{
            return false;
        }
    }
    public function __toString()
    {
        return $this->getNombre()." ".$this->getImportado()." ".$this->getDescripcion()."".
               $this->getMarca()->getNombre()."".$this->getSupCategoria()->getNombre()." ".
               $this->getEstado()." ".$this->getCodigo();
    }


    public function delete($idProducto): bool
    {
        $ProductoDelet = Producto::searchForId($idProducto);
        $ProductoDelet->setEstado("inactivo");
        return $ProductoDelet->update();
    }
}
<?php


namespace App\Models;


require_once (__DIR__ .'/../../vendor/autoload.php');
require_once ('Producto.php');
require_once ('Compra.php');
require_once('BasicModel.php');

use App\Models\Producto;
use App\Models\Compra;



class Inventario extends BasicModel
{
    private $Codigo;
    private $Producto;
    private $Compra;
    private $Cantidad;
    private $Precio;
    private $IVA;
    private $Talla;
    private $Color;
    private $Estado;


    /**
     *Categoria constructor.
     * @param $Codigo
     * @param $Producto
     * @param $Compra
     * @param $Cantidad
     * @param $Precio
     * @param $IVA
     * @param $Talla
     * @param $Color
     * @param $Estado


     */
    public function __construct($Producto = array())
    {
        parent::__construct(); //Llama al contructor padre "la clase conexion" para conectarme a la BD
        $this->Codigo = $Producto['Codigo'] ?? null;
        $this->Producto = $Producto ['Producto'] ?? null;
        $this->Compra = $Producto['Compra'] ?? null;
        $this->Cantidad = $Producto['Cantidad'] ?? null;
        $this->Precio = $Producto['Precio'] ?? null;
        $this->IVA = $Producto['IVA'] ?? null;
        $this->Talla = $Producto['Talla'] ?? null;
        $this->Color = $Producto['Color'] ?? null;
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
    public function setCodigo($Codigo): void
    {
        $this->Codigo = $Codigo;
    }

    /**
     * @return Producto
     */
    public function getProducto(): ?Producto
    {
        return $this->Producto;
    }

    /**
     * @param Producto $Producto
     */
    public function setProducto(?Producto $Producto): void
    {
        $this->Producto = $Producto;
    }

    /**
     * @return Compra
     */
    public function getCompra(): ?Compra
    {
        return $this->Compra;
    }

    /**
     * @param Compra $Compra
     */
    public function setCompra(?Compra $Compra): void
    {
        $this->Compra = $Compra;
    }

    /**
     * @return int
     */
    public function getCantidad(): ?int
    {
        return $this->Cantidad;
    }

    /**
     * @param int $Cantidad
     */
    public function setCantidad(?int $Cantidad): void
    {
        $this->Cantidad = $Cantidad;
    }

    /**
     * @return int
     */
    public function getPrecio(): ?int
    {
        return $this->Precio;
    }

    /**
     * @param int $Precio
     */
    public function setPrecio(?int $Precio): void
    {
        $this->Precio = $Precio;
    }

    /**
     * @return int
     */
    public function getIVA(): ?int
    {
        return $this->IVA;
    }

    /**
     * @param int $IVA
     */
    public function setIVA(?int $IVA): void
    {
        $this->IVA = $IVA;
    }

    /**
     * @return string
     */
    public function getTalla(): ?string
    {
        return $this->Talla;
    }

    /**
     * @param string $Talla
     */
    public function setTalla(?string $Talla): void
    {
        $this->Talla = $Talla;
    }

    /**
     * @return string
     */
    public function getColor(): ?string
    {
        return $this->Color;
    }

    /**
     * @param string $Color
     */
    public function setColor(?string $Color): void
    {
        $this->Color = $Color;
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
            $result = $this->insertRow("INSERT INTO merempresac.Inventario VALUES (NULL, ?, ?, ?, ?, ?, ?, ?, ?)", array(

                $this->Producto->getCodigo(),
                $this->Compra->getCodigo(),
                $this->Cantidad,
                $this->Precio,
                $this->IVA,
                $this->Talla,
                $this->Color,
                $this->Estado

            )
        );

        $this->setCodigo(($result) ? $this->getLastId() : null);
        $this->Disconnect();
        return $result;
    }
    public function update() : bool
    {
        $result = $this->updateRow("UPDATE merempresac.Inventario SET Producto = ?,Compra = ?, Cantidad = ?,Precio = ?,IVA = ?,Talla = ?,Color = ?, Estado = ? WHERE Codigo = ?", array(

                $this->Producto->getCodigo(),
                $this->Compra->getCodigo(),
                $this->Cantidad,
                $this->Precio,
                $this->IVA,
                $this->Talla,
                $this->Color,
                $this->Estado,
                $this->Codigo

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
        $tmp = new Inventario();
        $getrows = $tmp->getRows($query);

        foreach ($getrows as $valor) {
            $Producto = new Inventario();
            $Producto->Codigo = $valor['Codigo'];
            $Producto->Producto = Producto::searchForId($valor['Producto']);
            $Producto->Compra = Compra::searchForId($valor['Compra']);
            $Producto->Cantidad = $valor['Cantidad'];
            $Producto->Precio = $valor['Precio'];
            $Producto->IVA = $valor['IVA'];
            $Producto->Talla = $valor['Talla'];
            $Producto->Color = $valor['Color'];
            $Producto->Estado = $valor['Estado'];

            $Producto->Disconnect();
            array_push($arrProducto, $Producto);
        }
        $tmp->Disconnect();
        return $arrProducto ;
    }
    public static function searchForId($Codigo) : Inventario
    {
        $Producto= null;
        if ($Codigo > 0){
            $Producto= new Inventario();
            $getrow = $Producto->getRow("SELECT * FROM merempresac.Inventario WHERE Codigo =?", array($Codigo));
            $Producto->Codigo = $getrow['Codigo'];
            $Producto->Producto  = Producto::searchForId($getrow['Producto']);
            $Producto->Compra  = Compra::searchForId($getrow['Compra']);
            $Producto ->Cantidad = $getrow['Cantidad'];
            $Producto ->Precio = $getrow['Precio'];
            $Producto ->IVA = $getrow['IVA'];
            $Producto ->Talla = $getrow['Talla'];
            $Producto ->Color = $getrow['Color'];
            $Producto->Estado = $getrow['Estado'];


        }
        $Producto->Disconnect();
        return $Producto;
    }


    public static function getAll() : array
    {
        return Inventario::search("SELECT * FROM merempresac.Inventario ");
    }

    public static function InventarioRegistrado($Nombre) : bool
    {
        $result = Inventario::search("SELECT Codigo FROM merempresac.Inventario where Precio = '".$Nombre. "'");
        if (count($result) > 0){
            return true;
        }else{
            return false;
        }
    }
    public function __toString()
    {
        return
               $this->getProducto()->getNombre()."".$this->getCompra()->getCodigo()." ".
               $this->getEstado()." ".$this->getCodigo();
    }


    public function delete($idProducto): bool
    {
        $ProductoDelet = Inventario::searchForId($idProducto);
        $ProductoDelet->setEstado("inactivo");
        return $ProductoDelet->update();
    }
}
<?php


namespace App\Models;


require_once (__DIR__ .'/../../vendor/autoload.php');
require_once ('Venta.php');
require_once ('Inventario.php');
require_once('BasicModel.php');

use App\Models\Venta;
use App\Models\Inventario;



class ItemVenta extends BasicModel
{
    private $Codigo;
    private $Venta;
    private $Inventario;
    private $Cantidad;
    private $Precio;
    private $IVA;
    private $PrecioTotal;
    private $Estado;


    /**
     *Categoria constructor.
     * @param $Codigo
     * @param $Venta
     * @param $Inventario
     * @param $Cantidad
     * @param $Precio
     * @param $IVA
     * @param $PrecioTotal
     * @param $Estado


     */
    public function __construct($Producto = array())
    {
        parent::__construct(); //Llama al contructor padre "la clase conexion" para conectarme a la BD
        $this->Codigo = $Producto['Codigo'] ?? null;
        $this->Venta = $Producto ['Venta'] ?? null;
        $this->Inventario = $Producto['Inventario'] ?? null;
        $this->Cantidad = $Producto['Cantidad'] ?? null;
        $this->Precio = $Producto['Precio'] ?? null;
        $this->IVA = $Producto['IVA'] ?? null;
        $this->PrecioTotal = $Producto['PrecioTotal'] ?? null;
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
     * @return Venta
     */
    public function getVenta(): ?Venta
    {
        return $this->Venta;
    }

    /**
     * @param Venta $Venta
     */
    public function setVenta(?Venta $Venta): void
    {
        $this->Venta = $Venta;
    }

    /**
     * @return Inventario
     */
    public function getInventario(): ?Inventario
    {
        return $this->Inventario;
    }

    /**
     * @param Inventario $Inventario
     */
    public function setInventario(?Inventario $Inventario): void
    {
        $this->Inventario = $Inventario;
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
     * @return int
     */
    public function getPrecioTotal(): ?int
    {
        return $this->PrecioTotal;
    }

    /**
     * @param int $PrecioTotal
     */
    public function setPrecioTotal(?int $PrecioTotal): void
    {
        $this->PrecioTotal = $PrecioTotal;
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
        $result = $this->insertRow("INSERT INTO merempresac.ItemVenta VALUES (NULL, ?, ?, ?, ?, ?, ?, ?)", array(

                $this->Venta->getCodigo(),
                $this->Inventario->getCodigo(),
                $this->Cantidad,
                $this->Precio,
                $this->IVA,
                $this->PrecioTotal,
                $this->Estado

            )
        );

        $this->setCodigo(($result) ? $this->getLastId() : null);
        $this->Disconnect();
        return $result;
    }
    public function update() : bool
    {
        $result = $this->updateRow("UPDATE merempresac.ItemVenta SET Venta = ?,Inventario = ?, Cantidad = ?,Precio = ?, IVA = ?,PrecioTotal = ?,Estado = ? WHERE Codigo = ?", array(

                $this->Venta->getCodigo(),
                $this->Inventario->getCodigo(),
                $this->Cantidad,
                $this->Precio,
                $this->IVA,
                $this->PrecioTotal,
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
        $tmp = new ItemVenta();
        $getrows = $tmp->getRows($query);

        foreach ($getrows as $valor) {
            $Producto = new ItemVenta();
            $Producto->Codigo = $valor['Codigo'];
            $Producto->Venta = Venta::searchForId($valor['Venta']);
            $Producto->Inventario = Inventario::searchForId($valor['Inventario']);
            $Producto->Cantidad = $valor['Cantidad'];
            $Producto->Precio = $valor['Precio'];
            $Producto->IVA = $valor['IVA'];
            $Producto->PrecioTotal = $valor['PrecioTotal'];
            $Producto->Estado = $valor['Estado'];

            $Producto->Disconnect();
            array_push($arrProducto, $Producto);
        }
        $tmp->Disconnect();
        return $arrProducto ;
    }
    public static function searchForId($Codigo) : ItemVenta
    {
        $Producto= null;
        if ($Codigo > 0){
            $Producto= new ItemVenta();
            $getrow = $Producto->getRow("SELECT * FROM merempresac.ItemVenta WHERE Codigo =?", array($Codigo));
            $Producto->Codigo = $getrow['Codigo'];
            $Producto->Venta  = Venta::searchForId($getrow['Venta']);
            $Producto->Inventario = Inventario::searchForId($getrow['Inventario']);
            $Producto ->Cantidad = $getrow['Cantidad'];
            $Producto ->Precio = $getrow['Precio'];
            $Producto ->IVA = $getrow['IVA'];
            $Producto ->PrecioTotal = $getrow['PrecioTotal'];
            $Producto->Estado = $getrow['Estado'];


        }
        $Producto->Disconnect();
        return $Producto;
    }


    public static function getAll() : array
    {
        return ItemVenta::search("SELECT * FROM merempresac.ItemVenta ");
    }

    public static function ItemVentaRegistrado($Nombre) : bool
    {
        $result = ItemVenta::search("SELECT Codigo FROM merempresac.ItemVenta where Codigo = '".$Nombre. "'");
        if (count($result) > 0){
            return true;
        }else{
            return false;
        }
    }
    public function __toString()
    {
        return
               $this->getVenta()->getCodigo()."".$this->getInventario()->getCodigo()." ".
               $this->getEstado()." ".$this->getCodigo();
    }


    public function delete($idProducto): bool
    {
        $ProductoDelet = ItemVenta::searchForId($idProducto);
        $ProductoDelet->setEstado("inactivo");
        return $ProductoDelet->update();
    }
}
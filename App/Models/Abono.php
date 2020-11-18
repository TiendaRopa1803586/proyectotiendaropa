<?php


namespace App\Models;


require_once (__DIR__ .'/../../vendor/autoload.php');
require_once ('Venta.php');
require_once('BasicModel.php');

use App\Models\Venta;




class Abono extends BasicModel
{
    private $Codigo;
    private $Venta;
    private $Fecha;
    private $Descripcion;
    private $MetodoPago;
    private $Valor;
    private $Estado;


    /**
     *Categoria constructor.
     * @param $Codigo
     * @param $Venta
     * @param $Fecha
     * @param $Descripcion
     * @param $MetodoPago
     * @param $Valor
     * @param $Estado


     */
    public function __construct($Producto = array())
    {
        parent::__construct(); //Llama al contructor padre "la clase conexion" para conectarme a la BD
        $this->Codigo = $Producto['Codigo'] ?? null;
        $this->Venta = $Producto['Venta'] ?? null;
        $this->Fecha = $Producto ['Fecha'] ?? null;
        $this->Descripcion = $Producto['Descripcion'] ?? null;
        $this->MetodoPago = $Producto['MetodoPago'] ?? null;
        $this->Valor = $Producto['Valor'] ?? null;
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
     * @return string
     */
    public function getFecha(): ?string
    {
        return $this->Fecha;
    }

    /**
     * @param string $Fecha
     */
    public function setFecha(?string $Fecha): void
    {
        $this->Fecha = $Fecha;
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
    public function getMetodoPago(): ?string
    {
        return $this->MetodoPago;
    }

    /**
     * @param string $MetodoPago
     */
    public function setMetodoPago(?string $MetodoPago): void
    {
        $this->MetodoPago = $MetodoPago;
    }

    /**
     * @return int
     */
    public function getValor(): ?int
    {
        return $this->Valor;
    }

    /**
     * @param int $Valor
     */
    public function setValor(?int $Valor): void
    {
        $this->Valor = $Valor;
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
        $result = $this->insertRow("INSERT INTO merempresac.Abono VALUES (NULL, ?, ?, ?, ?, ?, ?)", array(

                $this->Venta->getCodigo(),
                $this->Fecha,
                $this->Descripcion,
                $this->MetodoPago,
                $this->Valor,
                $this->Estado

            )
        );

        $this->setCodigo(($result) ? $this->getLastId() : null);
        $this->Disconnect();
        return $result;
    }
    public function update() : bool
    {
        $result = $this->updateRow("UPDATE merempresac.Abono SET Fecha = ?,Venta = ?, Descripcion = ?,MetodoPago = ?, Valor = ?,Estado = ? WHERE Codigo = ?", array(

                $this->Fecha,
                $this->Venta->getCodigo(),
                $this->Descripcion,
                $this->MetodoPago,
                $this->Valor,
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
        $tmp = new Abono();
        $getrows = $tmp->getRows($query);

        foreach ($getrows as $valor) {
            $Producto = new Abono();
            $Producto->Codigo = $valor['Codigo'];
            $Producto->Venta = Venta::searchForId($valor['Venta']);
            $Producto->Fecha = $valor['Fecha'];
            $Producto->Descripcion = $valor['Descripcion'];
            $Producto->MetodoPago = $valor['MetodoPago'];
            $Producto->Valor = $valor['Valor'];
            $Producto->Estado = $valor['Estado'];

            $Producto->Disconnect();
            array_push($arrProducto, $Producto);
        }
        $tmp->Disconnect();
        return $arrProducto ;
    }
    public static function searchForId($Codigo) : Abono
    {
        $Producto= null;
        if ($Codigo > 0){
            $Producto= new Abono();
            $getrow = $Producto->getRow("SELECT * FROM merempresac.Abono WHERE Codigo =?", array($Codigo));
            $Producto->Codigo = $getrow['Codigo'];
            $Producto->Venta  = Venta::searchForId($getrow['Venta']);
            $Producto ->Fecha = $getrow['Fecha'];
            $Producto ->Descripcion = $getrow['Descripcion'];
            $Producto ->MetodoPago = $getrow['MetodoPago'];
            $Producto ->Valor = $getrow['Valor'];
            $Producto->Estado = $getrow['Estado'];


        }
        $Producto->Disconnect();
        return $Producto;
    }


    public static function getAll() : array
    {
        return Abono::search("SELECT * FROM merempresac.Abono ");
    }

    public static function AbonoRegistrada($Nombre) : bool
    {
        $result = Abono::search("SELECT Codigo FROM merempresac.Abono where Fecha = '".$Nombre. "'");
        if (count($result) > 0){
            return true;
        }else{
            return false;
        }
    }
    public function __toString()
    {
        return $this->getFecha()." ".
               $this->getVenta()->getFecha()."".
               $this->getEstado()." ".$this->getCodigo();
    }


    public function delete($idProducto): bool
    {
        $ProductoDelet = Abono::searchForId($idProducto);
        $ProductoDelet->setEstado("inactivo");
        return $ProductoDelet->update();
    }
}
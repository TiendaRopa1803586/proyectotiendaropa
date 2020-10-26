<?php


namespace App\Models;
use http\QueryString;
require_once (__DIR__ .'/../../vendor/autoload.php');
require_once ('Producto.php');
require_once('BasicModel.php');

use App\Models\Producto;
#Creacion de la clase con herencia de la clase Basic Model

class Descuento extends BasicModel
{
    private $Codigo;
    private $Nombre;
    private $Porcentaje;
    private $Fecha_inicio;
    private $Fecha_fin;
    private $Producto;
    private $Estado;
    /**
     * Descuento constructor.
     * @param $Codigo
     * @param $Nombre
     * @param $Porcentaje
     * @param $Fecha_inicio
     * @param $Fecha_fin
      * @param $Producto
     *  * @param $Estado

     */
    public function __construct($DESCUENTO = array())
    {
        parent::__construct(); //Llama al contructor padre "la clase conexion" para conectarme a la BD
        $this->Codigo = $DESCUENTO['Codigo'] ?? null;
        $this->Nombre= $DESCUENTO['Nombre'] ?? null;
        $this->Porcentaje = $DESCUENTO['Porcentaje'] ?? null;
        $this->Fecha_inicio = $DESCUENTO['Fecha_inicio'] ?? null;
        $this->Fecha_fin = $DESCUENTO['Fecha_fin'] ?? null;
        $this->Producto = $DESCUENTO['Producto'] ?? null;
        $this->Estado = $DESCUENTO['Estado'] ?? null;

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
     * @return float
     */
    public function getPorcentaje(): ?float
    {
        return $this->Porcentaje;
    }

    /**
     * @param float $Porcentaje
     */
    public function setPorcentaje(?float $Porcentaje): void
    {
        $this->Porcentaje = $Porcentaje;
    }

    /**
     * @return string
     */
    public function getFecha_inicio(): ?string
    {
        return $this->Fecha_inicio;
    }

    /**
     * @param string $Fecha_inicio
     */
    public function setFecha_incio (?string$Fecha_inicio): void
    {
        $this->Fecha_inicio = $Fecha_inicio;
    }

    /**
     * @return string
     */
    public function getFecha_fin(): ?string
    {
        return $this->Fecha_fin;
    }

    /**
     * @param string $Fecha_fin
     */
    public function setFecha_fin(?string $Fecha_fin): void
    {
        $this->Fecha_fin = $Fecha_fin;
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


    public function create() : bool
    {
        $result = $this->insertRow("INSERT INTO merempresac.Descuento VALUES (NULL, ?, ?, ?, ?, ?, ?)", array(
                $this->Nombre,
                $this->Porcentaje,
                $this->Fecha_inicio,
                $this->Fecha_fin,
                $this->Producto->getCodigo(),
                $this->Estado

            )
        );
        $this->Disconnect();
        return $result;
    }
    public function update() : bool
    {
        $result = $this->updateRow("UPDATE merempresac.Descuento SET Nombre= ?, Porcentaje = ?, Fecha_inicio = ?, Fecha_fin = ? , Producto = ? , Estado = ? WHERE Codigo = ?", array(
                $this->Nombre,
                $this->Porcentaje,
                $this->Fecha_inicio,
                $this->Fecha_fin,
                $this->Producto->getCodigo(),
                $this->Estado,
                $this->Codigo,
            )
        );
        $this->Disconnect();
        return $result;
    }
    public function deleted($Codigo) : void
    {
        // TODO: Implement deleted() method.
    }

    public static function search($query) : array
    {
        $arrDescuento= array();
        $tmp = new Descuento();
        $getrows = $tmp->getRows($query);

        foreach ($getrows as $valor) {
            $Descuento = new Descuento();
            $Descuento->Codigo = $valor['Codigo'];
            $Descuento->Nombre= $valor['Nombre'];
            $Descuento->Porcentaje = $valor['Porcentaje'];
            $Descuento->Fecha_inicio = $valor['Fecha_inicio'];
            $Descuento->Fecha_fin = $valor['Fecha_fin'];
            $Descuento->Producto = Producto::searchForId($valor['Producto']);
            $Descuento->Estado = $valor['Estado'];
            $Descuento->Disconnect();
            array_push($arrDescuento, $Descuento);
        }
        $tmp->Disconnect();
        return $arrDescuento;
    }
    public static function searchForId($Codigo) : Descuento
    {
        $Descuento = null;
        if ($Codigo > 0){
            $Descuento = new Descuento();
            $getrow = $Descuento->getRow("SELECT * FROM merempresac.Descuento WHERE Codigo =?", array($Codigo));
            $Descuento->Codigo = $getrow['Codigo'];
            $Descuento->Nombre= $getrow['Nombre'];
            $Descuento->Porcentaje= $getrow['Porcentaje'];
            $Descuento->Fecha_inicio = $getrow['Fecha_inicio'];
            $Descuento->Fecha_fin = $getrow['Fecha_fin'];
            $Descuento->Producto = Producto::searchForId($getrow['Producto']);
            $Descuento->Estado = $getrow['Estado'];

        }
        $Descuento->Disconnect();
        return $Descuento;
    }

    public static function getAll() : array
    {
        return Descuento::search("SELECT * FROM merempresac.Descuento");
    }

    public static function DescuentoRegistrado ($Nombre) : bool
    {
        $result = Descuento::search("SELECT Codigo FROM merempresac.Descuento where Porcentaje = ".$Nombre  );
        if (count($result) > 0){
            return true;
        }else{
            return false;
        }
    }
}
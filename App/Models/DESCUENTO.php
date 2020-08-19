<?php


namespace App\Models;
use http\QueryString;
require_once('BasicModel.php');
#Creacion de la clase con herencia de la clase Basic Model

class DESCUENTO extends BasicModel
{
    private $Codigo;
    private $Nombre;
    private $Porcentaje;
    private $Fecha_inicio;
    private $Fecha_fin;
    /**
     * DESCUENTO constructor.
     * @param $Codigo
     * @param $Nombre
     * @param $Porcentaje
     * @param $Fecha_inicio
     * @param $Fecha_fin

     */
    public function __construct($DESCUENTO = array())
    {
        parent::__construct(); //Llama al contructor padre "la clase conexion" para conectarme a la BD
        $this->Codigo = $DESCUENTO['Codigo'] ?? null;
        $this->Nombre= $DESCUENTO['Nombre'] ?? null;
        $this->Porcentaje = $DESCUENTO['Porcentaje'] ?? null;
        $this->Fecha_inicio = $DESCUENTO['Fecha_inicio'] ?? null;
        $this->Fecha_fin = $DESCUENTO['Fecha_fin'] ?? null;

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
     * @return date
     */
    public function getFechaInicio(): ?date
    {
        return $this->Fecha_inicio;
    }

    /**
     * @param date $Fecha_inicio
     */
    public function setFechaInicio(?date$Fecha_inicio): void
    {
        $this->Fecha_inicio = $Fecha_inicio;
    }

    /**
     * @return date
     */
    public function getFechaFin(): ?date
    {
        return $this->Fecha_fin;
    }

    /**
     * @param date $Fecha_fin
     */
    public function setFechaFin(?date $Fecha_fin): void
    {
        $this->Fecha_fin = $Fecha_fin;
    }

    public function create() : bool
    {
        $result = $this->insertRow("INSERT INTO merempresac.Descuento VALUES (NULL, ?, ?, ?, ?)", array(
                $this->Nombre,
                $this->Porcentaje,
                $this->Fecha_inicio,
                $this->Fecha_fin,

            )
        );
        $this->Disconnect();
        return $result;
    }
    public function update() : bool
    {
        $result = $this->updateRow("UPDATE merempresac.Descuento SET Nombre= ?, Porcentaje = ?, Fecha_inicio = ?, Fecha_fin = ? WHERE Codigo = ?", array(
                $this->Nombre,
                $this->Porcentaje,
                $this->Fecha_inicio,
                $this->Fecha_fin,
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
        $result = Descuento::search("SELECT Codigo FROM merempresac.Descuento where Nombre = ".$Nombre  );
        if (count($result) > 0){
            return true;
        }else{
            return false;
        }
    }
}
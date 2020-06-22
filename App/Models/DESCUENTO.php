<?php


namespace App\Models;


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
        $result = $this->insertRow("INSERT INTO proyectotiendaropa.DESCUENTO VALUES (NULL, ?, ?, ?, ?)", array(
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
        $result = $this->updateRow("UPDATE proyectotiendaropa.DESCUENTO SET Nombre= ?, Porcentaje = ?, Fecha_inicio = ?, Fecha_fin = ? WHERE Codigo = ?", array(
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
        $arrDESCUENTO= array();
        $tmp = new DESCUENTO();
        $getrows = $tmp->getRows($query);

        foreach ($getrows as $valor) {
            $DESCUENTO = new DESCUENTO();
            $DESCUENTO->Codigo = $valor['Codigo'];
            $DESCUENTO->Nombre= $valor['Nombre'];
            $DESCUENTO->Porcentaje = $valor['Porcentaje'];
            $DESCUENTO->Fecha_inicio = $valor['Fecha_inicio'];
            $DESCUENTO->Fecha_fin = $valor['Fecha_fin'];
            $DESCUENTO->Disconnect();
            array_push($arrDESCUENTO, $DESCUENTO);
        }
        $tmp->Disconnect();
        return $arrDESCUENTO;
    }
    public static function searchForId($Codigo) : DESCUENTO
    {
        $DESCUENTO = null;
        if ($Codigo > 0){
            $DESCUENTO = new DESCUENTO();
            $getrow = $DESCUENTO->getRow("SELECT * FROM proyectotiendaropa.DESCUENTO WHERE Codigo =?", array($Codigo));
            $DESCUENTO->Codigo = $getrow['Codigo'];
            $DESCUENTO->Nombre= $getrow['Nombre'];
            $DESCUENTO->Porcentaje= $getrow['Porcentaje'];
            $DESCUENTO->Fecha_inicio = $getrow['Fecha_inicio'];
            $DESCUENTO->Fecha_fin = $getrow['Fecha_fin'];

        }
        $DESCUENTO->Disconnect();
        return $DESCUENTO;
    }

    public static function getAll() : array
    {
        return DESCUENTO::search("SELECT * FROM proyectotiendaropa.DESCUENTO");
    }

    public static function DESCUENTORegistrado ($Nombre) : bool
    {
        $result = DESCUENTO::search("SELECT Codigo FROM proyectotiendaropa.DESCUENTO where Nombre = ".$Nombre);
        if (count($result) > 0){
            return true;
        }else{
            return false;
        }
    }
}
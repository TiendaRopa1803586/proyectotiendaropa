<?php


namespace App\Models;


class COMPRA extends BasicModel
{
    private $Codigo;
    private $Fecha;
    private $Total;
    private $Estado;


    /**
     * COMPRA constructor.
     * @param $Codigo
     * @param $Fecha
     * @param $Total
     * @param $Estado


     */
    public function __construct($COMPRA = array())
    {
        parent::__construct(); //Llama al contructor padre "la clase conexion" para conectarme a la BD
        $this->Codigo = $COMPRA['Codigo'] ?? null;
        $this->Fecha = $COMPRA['Fecha'] ?? null;
        $this->Total = $COMPRA['Total'] ?? null;
        $this->Estado = $COMPRA['Estado'] ?? null;


    }

    /* Metodo destructor cierra la conexion. */
    function __destruct() {
        $this->Disconnect();
    }

    /**
     * @return int
     */
    public function getCodigo() : int
    {
        return $this->Codigo;
    }

    /**
     * @param int $Codigo
     */
    public function setCodigo(int $Codigo): void
    {
        $this->Codigo = $Codigo;
    }

    /**
     * @return string
     */
    public function getFecha() : string
    {
        return $this->Fecha;
    }

    /**
     * @param string $Fecha
     */
    public function setFecha(string $Fecha): void
    {
        $this->Fecha = $Fecha;
    }

    /**
     * @return int
     */
    public function getTotal() : int
    {
        return $this->Total;
    }

    /**
     * @param int $Total
     */
    public function setTotal(int $Total): void
    {
        $this->Total = $Total;
    }

    /**
     * @return int
     */
    public function getEstado() : int
    {
        return $this->Estado;
    }

    /**
     * @param int $Estado
     */
    public function setEstado(int $Estado): void
    {
        $this->Estado = $Estado;
    }



    public function create() : bool
    {
        $result = $this->insertRow("INSERT INTO proyectotiendaropa.COMPRA VALUES (NULL, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)", array(
                $this->Fecha,
                $this->Total,
                $this->Estado,



            )
        );
        $this->Disconnect();
        return $result;
    }

    public function update() : bool
    {
        $result = $this->updateRow("UPDATE proyectotiendaropa.COMPRA SET Fecha = ?, Total = ?, Estado = ? WHERE Codigo = ?", array(
                $this->Fecha,
                $this->Total,
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
        $arrCOMPRA = array();
        $tmp = new COMPRA();
        $getrows = $tmp->getRows($query);

        foreach ($getrows as $valor) {
            $COMPRA = new COMPRA();
            $COMPRA->Codigo = $valor['Codigo'];
            $COMPRA->Fecha = $valor['Fecha'];
            $COMPRA->Total = $valor['Total'];
            $COMPRA->Estado = $valor['Estado'];

            $COMPRA->Disconnect();
            array_push($arrCOMPRA, $COMPRA);
        }
        $tmp->Disconnect();
        return $arrCOMPRA;
    }

    public static function searchForId($Codigo) : COMPRA
    {
        $COMPRA = null;
        if ($Codigo > 0){
            $COMPRA = new COMPRA();
            $getrow = $COMPRA->getRow("SELECT * FROM proyectotiendaropa.COMPRA WHERE Codigo =?", array($Codigo));
            $COMPRA->Codigo = $getrow['Codigo'];
            $COMPRA->Fecha = $getrow['Fecha'];
            $COMPRA->Total = $getrow['Total'];
            $COMPRA->Estado = $getrow['Estado'];


        }
        $COMPRA->Disconnect();
        return $COMPRA;
    }

    public static function getAll() : array
    {
        return COMPRA::search("SELECT * FROM proyectotiendaropa.COMPRA");
    }

    public static function COMPRARegistrada ($Fecha) : bool
    {
        $result = COMPRA::search("SELECT Codigo FROM proyectotiendaropa.COMPRA where Fecha = ".$Fecha);
        if (count($result) > 0){
            return true;
        }else{
            return false;
        }
    }

}
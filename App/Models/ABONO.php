<?php


namespace App\Models;

require('BasicModel.php');

class ABONO extends BasicModel
{

    private $Codigo;
    private $Fecha;
    private $Descripcion;
    private $MetodoPago;
    private $Valor;

    /**
     * ABONO constructor.
     * @param $Codigo
     * @param $Fecha
     * @param $Descripcion
     * @param $MetodoPago
     * @param $Valor

     */
    public function __construct($ABONO = array())
    {
        parent::__construct(); //Llama al contructor padre "la clase conexion" para conectarme a la BD
        $this->Codigo = $ABONO['Codigo'] ?? null;
        $this->Fecha = $ABONO['Fecha'] ?? null;
        $this->Descripcion = $ABONO['Descripcion'] ?? null;
        $this->MetodoPago = $ABONO['MetodoPago'] ?? null;
        $this->Valor = $ABONO['Valor'] ?? null;

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
     * @return string
     */
    public function getDescripcion() : string
    {
        return $this->Descripcion;
    }

    /**
     * @param string $Descripcion
     */
    public function setDescripcion(string $Descripcion): void
    {
        $this->Descripcion = $Descripcion;
    }

    /**
     * @return int
     */
    public function getMetodoPago() : int
    {
        return $this->MetodoPago;
    }

    /**
     * @param int $MetodoPago
     */
    public function setMetodoPago(int $MetodoPago): void
    {
        $this->MetodoPago = $MetodoPago;
    }

    /**
     * @return double
     */
    public function getValor() : double
    {
        return $this->Valor;
    }

    /**
     * @param double $Valor
     */
    public function setValor(double $Valor): void
    {
        $this->Valor = $Valor;
    }

    public function create() : bool
    {
        $result = $this->insertRow("INSERT INTO merempresac.ABONO VALUES (NULL, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)", array(
                $this->Fecha,
                $this->Descripcion,
                $this->MetodoPago,
                $this->Valor,


            )
        );
        $this->Disconnect();
        return $result;
    }

    public function update() : bool
    {
        $result = $this->updateRow("UPDATE merempresac.ABONO SET Fecha = ?, Descripcion = ?, MetodoPago = ?, Valor = ? WHERE Codigo = ?", array(
                $this->Fecha,
                $this->Descripcion,
                $this->MetodoPago,
                $this->Valor,
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
        $arrABONO = array();
        $tmp = new ABONO();
        $getrows = $tmp->getRows($query);

        foreach ($getrows as $valor) {
            $ABONO = new ABONO();
            $ABONO->Codigo = $valor['Codigo'];
            $ABONO->Fecha = $valor['Fecha'];
            $ABONO->Descripcion = $valor['Descripcion'];
            $ABONO->MetodoPago = $valor['MetodoPago'];
            $ABONO->Valor = $valor['Valor'];
            $ABONO->Disconnect();
            array_push($arrABONO, $ABONO);
        }
        $tmp->Disconnect();
        return $arrABONO;
    }

    public static function searchForId($Codigo) : ABONO
    {
        $ABONO = null;
        if ($Codigo > 0){
            $ABONO = new ABONO();
            $getrow = $ABONO->getRow("SELECT * FROM merempresac.ABONO WHERE Codigo =?", array($Codigo));
            $ABONO->Codigo = $getrow['Codigo'];
            $ABONO->Fecha = $getrow['Fecha'];
            $ABONO->Descripcion = $getrow['Descripcion'];
            $ABONO->MetodoPago = $getrow['MetodoPago'];
            $ABONO->Valor = $getrow['Valor'];

        }
        $ABONO->Disconnect();
        return $ABONO;
    }

    public static function getAll() : array
    {
        return ABONO::search("SELECT * FROM merempresac.ABONO");
    }

    public static function ABONORegistrado ($Fecha) : bool
    {
        $result = ABONO::search("SELECT Codigo FROM merempresac.ABONO where Fecha = ".$Fecha);
        if (count($result) > 0){
            return true;
        }else{
            return false;
        }
    }


}
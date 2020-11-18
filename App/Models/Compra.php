<?php


namespace App\Models;


require_once (__DIR__ .'/../../vendor/autoload.php');
require_once ('Sede.php');
require_once ('Persona.php');
require_once('BasicModel.php');

use App\Models\Sede;
use App\Models\Persona;



class Compra extends BasicModel
{
    private $Codigo;
    private $Fecha;
    private $Sede;
    private $Proveedor;
    private $Total;
    private $Estado;


    /**
     *Categoria constructor.
     * @param $Codigo
     * @param $Fecha
     * @param $Sede
     * @param $MetodoPago
     * @param $Total
     * @param $Estado


     */
    public function __construct($Producto = array())
    {
        parent::__construct(); //Llama al contructor padre "la clase conexion" para conectarme a la BD
        $this->Codigo = $Producto['Codigo'] ?? null;
        $this->Fecha = $Producto ['Fecha'] ?? null;
        $this->Sede = $Producto['Sede'] ?? null;
        $this->Proveedor = $Producto['Proveedor'] ?? null;
        $this->Total = $Producto['Total'] ?? null;
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
     * @return Sede
     */
    public function getSede(): ?Sede
    {
        return $this->Sede;
    }

    /**
     * @param Sede $Sede
     */
    public function setSede(?Sede $Sede): void
    {
        $this->Sede = $Sede;
    }

    /**
     * @return Persona
     */
    public function getProveedor(): ?Persona
    {
        return $this->Proveedor;
    }

    /**
     * @param Persona $Proveedor
     */
    public function setProveedor(?Persona $Proveedor): void
    {
        $this->Proveedor = $Proveedor;
    }



    /**
     * @return int
     */
    public function getTotal(): ?int
    {
        return $this->Total;
    }

    /**
     * @param int $Total
     */
    public function setTotal(?int $Total): void
    {
        $this->Total = $Total;
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
        $result = $this->insertRow("INSERT INTO merempresac.Compra VALUES (NULL, ?, ?, ?, ?, ?)", array(

                $this->Fecha,
                $this->Sede->getCodigo(),
                $this->Proveedor->getDocumento(),
                $this->Total,
                $this->Estado

            )
        );

        $this->setCodigo(($result) ? $this->getLastId() : null);
        $this->Disconnect();
        return $result;
    }
    public function update() : bool
    {
        $result = $this->updateRow("UPDATE merempresac.Compra SET Fecha = ?,Sede = ?, Proveedor = ?,Total = ?, Estado = ? WHERE Codigo = ?", array(

                $this->Fecha,
                $this->Sede->getCodigo(),
                $this->Proveedor->getDocumento(),
                $this->Total,
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
        $tmp = new Compra();
        $getrows = $tmp->getRows($query);

        foreach ($getrows as $valor) {
            $Producto = new Compra();
            $Producto->Codigo = $valor['Codigo'];
            $Producto->Fecha = $valor['Fecha'];
            $Producto->Sede = Sede::searchForId($valor['Sede']);
            $Producto->Proveedor = Persona::searchForId($valor['Proveedor']);
            $Producto->Total = $valor['Total'];
            $Producto->Estado = $valor['Estado'];

            $Producto->Disconnect();
            array_push($arrProducto, $Producto);
        }
        $tmp->Disconnect();
        return $arrProducto ;
    }
    public static function searchForId($Codigo) : Compra
    {
        $Producto= null;
        if ($Codigo > 0){
            $Producto= new Compra();
            $getrow = $Producto->getRow("SELECT * FROM merempresac.Compra WHERE Codigo =?", array($Codigo));
            $Producto->Codigo = $getrow['Codigo'];
            $Producto ->Fecha = $getrow['Fecha'];
            $Producto->Sede  = Sede::searchForId($getrow['Sede']);
            $Producto->Proveedor = Persona::searchForId($getrow['Proveedor']);
            $Producto ->Total = $getrow['Total'];
            $Producto->Estado = $getrow['Estado'];


        }
        $Producto->Disconnect();
        return $Producto;
    }


    public static function getAll() : array
    {
        return Compra::search("SELECT * FROM merempresac.Compra ");
    }

    public static function CompraRegistrada($Nombre) : bool
    {
        $result = Compra::search("SELECT Codigo FROM merempresac.Compra where Fecha = '".$Nombre. "'");
        if (count($result) > 0){
            return true;
        }else{
            return false;
        }
    }
    public function __toString()
    {
        return $this->getFecha()." ".
               $this->getSede()->getNombre()."".$this->getProveedor()->getNombre()." ".
               $this->getEstado()." ".$this->getCodigo();
    }


    public function delete($idProducto): bool
    {
        $ProductoDelet = Compra::searchForId($idProducto);
        $ProductoDelet->setEstado("inactivo");
        return $ProductoDelet->update();
    }
}
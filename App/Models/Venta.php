<?php


namespace App\Models;


require_once (__DIR__ .'/../../vendor/autoload.php');
require_once ('Persona.php');
require_once ('Sede.php');
require_once('BasicModel.php');


use App\Models\Persona;
use App\Models\Sede;


class Venta extends BasicModel
{
    private $Codigo;
    private $Fecha;
    private $Vendedor;
    private $Cliente;
    private $Sede;
    private $MetodoPago;
    private $Total;
    private $Estado;


    /**
     *Categoria constructor.
     * @param $Codigo
     * @param $Fecha
     * @param $Vendedor
     * @param $Cliente
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
        $this->Vendedor = $Producto['Vendedor'] ?? null;
        $this->Cliente = $Producto['Cliente'] ?? null;
        $this->Sede = $Producto['Sede'] ?? null;
        $this->MetodoPago = $Producto['MetodoPago'] ?? null;
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
     * @return Persona
     */
    public function getVendedor(): ?Persona
    {
        return $this->Vendedor;
    }

    /**
     * @param Persona $Vendedor
     */
    public function setVendedor(?Persona $Vendedor): void
    {
        $this->Vendedor = $Vendedor;
    }

    /**
     * @return Persona
     */
    public function getCliente(): ?Persona
    {
        return $this->Cliente;
    }

    /**
     * @param Persona $Cliente
     */
    public function setCliente(?Persona $Cliente): void
    {
        $this->Cliente = $Cliente;
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
        $result = $this->insertRow("INSERT INTO merempresac.Venta VALUES (NULL, ?, ?, ?, ?, ?, ?, ?)", array(

                $this->Fecha,
                $this->Vendedor->getDocumento(),
                $this->Cliente->getDocumento(),
                $this->Sede->getCodigo(),
                $this->MetodoPago,
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
        $result = $this->updateRow("UPDATE merempresac.Venta SET Fecha = ?,Vendedor = ?, Cliente = ?,Sede = ?, MetodoPago = ?,Total = ?, Estado = ? WHERE Codigo = ?", array(

                $this->Fecha,
                $this->Vendedor->getDocumento(),
                $this->Cliente->getDocumento(),
                $this->Sede->getCodigo(),
                $this->MetodoPago,
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
        $tmp = new Venta();
        $getrows = $tmp->getRows($query);

        foreach ($getrows as $valor) {
            $Producto = new Venta();
            $Producto->Codigo = $valor['Codigo'];
            $Producto->Fecha = $valor['Fecha'];
            $Producto->Vendedor = Persona::searchForId($valor['Vendedor']);
            $Producto->Cliente = Persona::searchForId($valor['Cliente']);
            $Producto->Sede = Sede::searchForId($valor['Sede']);
            $Producto->MetodoPago = $valor['MetodoPago'];
            $Producto->Total = $valor['Total'];
            $Producto->Estado = $valor['Estado'];

            $Producto->Disconnect();
            array_push($arrProducto, $Producto);
        }
        $tmp->Disconnect();
        return $arrProducto ;
    }
    public static function searchForId($Codigo) : Venta
    {
        $Producto= null;
        if ($Codigo > 0){
            $Producto= new Venta();
            $getrow = $Producto->getRow("SELECT * FROM merempresac.Venta WHERE Codigo =?", array($Codigo));
            $Producto->Codigo = $getrow['Codigo'];
            $Producto ->Fecha = $getrow['Fecha'];
            $Producto->Vendedor = Persona::searchForId($getrow['Vendedor']);
            $Producto->Cliente  = Persona::searchForId($getrow['Cliente']);
            $Producto->Sede  = Sede::searchForId($getrow['Sede']);
            $Producto ->MetodoPago = $getrow['MetodoPago'];
            $Producto ->Total = $getrow['Total'];
            $Producto->Estado = $getrow['Estado'];


        }
        $Producto->Disconnect();
        return $Producto;
    }


    public static function getAll() : array
    {
        return Venta::search("SELECT * FROM merempresac.Venta ");
    }

    public static function VentaRegistrado($Nombre) : bool
    {
        $result = Venta::search("SELECT Codigo FROM merempresac.Venta where Fecha = '".$Nombre. "'");
        if (count($result) > 0){
            return true;
        }else{
            return false;
        }
    }
    public function __toString()
    {
        return $this->getNombre()." ".$this->getImportado()." ".$this->getDescripcion()."".
               $this->getMarca()->getNombre()."".$this->getSubcategoria()->getNombre()." ".
               $this->getEstado()." ".$this->getCodigo();
    }


    public function delete($idProducto): bool
    {
        $ProductoDelet = Venta::searchForId($idProducto);
        $ProductoDelet->setEstado("inactivo");
        return $ProductoDelet->update();
    }
}
<?php


namespace App\Models;


require_once (__DIR__ .'/../../vendor/autoload.php');
require_once ('Persona.php');
require_once('BasicModel.php');


use App\Models\Persona;

class Sede extends BasicModel
{
    private $Codigo;
    private $Nombre;
    private $Direccion;
    private $Encargado;
    private $Estado;


    /**
     *Categoria constructor.
     * @param $Codigo
     * @param $Nombre
     * @param $Direccion
     * @param $Encargado
     * @param $Estado


     */
    public function __construct($Producto = array())
    {
        parent::__construct(); //Llama al contructor padre "la clase conexion" para conectarme a la BD
        $this->Codigo = $Producto['Codigo'] ?? null;
        $this->Nombre = $Producto ['Nombre'] ?? null;
        $this->Direccion = $Producto['Direccion'] ?? null;
        $this->Encargado = $Producto['Encargado'] ?? null;
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
     * @return string
     */
    public function getDireccion(): ?string
    {
        return $this->Direccion;
    }

    /**
     * @param string $Direccion
     */
    public function setDireccion(?string $Direccion): void
    {
        $this->Direccion = $Direccion;
    }

    /**
     * @return Persona
     */
    public function getEncargado(): ?Persona
    {
        return $this->Encargado;
    }

    /**
     * @param Persona $Encargado
     */
    public function setEncargado(?Persona $Encargado): void
    {
        $this->Encargado = $Encargado;
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
        $result = $this->insertRow("INSERT INTO merempresac.Sede VALUES (NULL, ?, ?, ?, ?)", array(

                $this->Nombre,
                $this->Direccion,
                $this->Encargado->getDocumento(),
                $this->Estado

            )
        );

        $this->setCodigo(($result) ? $this->getLastId() : null);
        $this->Disconnect();
        return $result;
    }
    public function update() : bool
    {
        $result = $this->updateRow("UPDATE merempresac.Sede SET Nombre = ?,Direccion = ?, Encargado = ?, Estado = ? WHERE Codigo = ?", array(

                $this->Nombre,
                $this->Direccion,
                $this->Encargado->getDocumento(),
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
        $tmp = new Sede();
        $getrows = $tmp->getRows($query);

        foreach ($getrows as $valor) {
            $Producto = new Sede();
            $Producto->Codigo = $valor['Codigo'];
            $Producto->Nombre = $valor['Nombre'];
            $Producto->Direccion = $valor['Direccion'];
            $Producto->Encargado = Persona::searchForId($valor['Encargado']);
            $Producto->Estado = $valor['Estado'];

            $Producto->Disconnect();
            array_push($arrProducto, $Producto);
        }
        $tmp->Disconnect();
        return $arrProducto ;
    }
    public static function searchForId($Codigo) : Sede
    {
        $Producto= null;
        if ($Codigo > 0){
            $Producto= new Sede();
            $getrow = $Producto->getRow("SELECT * FROM merempresac.Sede WHERE Codigo =?", array($Codigo));
            $Producto->Codigo = $getrow['Codigo'];
            $Producto ->Nombre = $getrow['Nombre'];
            $Producto ->Direccion = $getrow['Direccion'];
            $Producto->Encargado  = Persona::searchForId($getrow['Encargado']);
            $Producto->Estado = $getrow['Estado'];


        }
        $Producto->Disconnect();
        return $Producto;
    }


    public static function getAll() : array
    {
        return Sede::search("SELECT * FROM merempresac.Sede ");
    }

    public static function SedeRegistrado($Nombre) : bool
    {
        $result = Sede::search("SELECT Codigo FROM merempresac.Sede where Nombre = '".$Nombre. "'");
        if (count($result) > 0){
            return true;
        }else{
            return false;
        }
    }
    public function __toString()
    {
        return $this->getNombre()." ".$this->getDireccion()." ".
               $this->getEncargado()->getNombre()."".
               $this->getEstado()." ".$this->getCodigo();
    }


    public function delete($idProducto): bool
    {
        $ProductoDelet = Sede::searchForId($idProducto);
        $ProductoDelet->setEstado("inactivo");
        return $ProductoDelet->update();
    }
}
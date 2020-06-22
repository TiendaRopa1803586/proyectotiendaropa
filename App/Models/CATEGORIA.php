<?php


namespace App\Models;


class CATEGORIA extends BasicModel
{
    private $Codigo;
    private $Nombre;
    private $Descripcion;
    private $Estado;

    /**
     * CATEGORIA constructor.
     * @param $Codigo
     * @param $Nombre
     * @param $Descripcion
     * @param $Estado

     */
    public function __construct($CATEGORIA = array())
    {
        parent::__construct(); //Llama al contructor padre "la clase conexion" para conectarme a la BD
        $this->Codigo = $CATEGORIA['Codigo'] ?? null;
        $this->Nombre = $CATEGORIA['Nombre'] ?? null;
        $this->Descripcion = $CATEGORIA['Descripcion'] ?? null;
        $this->Estado = $CATEGORIA['Estado'] ?? null;
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
        $result = $this->insertRow("INSERT INTO proyectotiendaropa.CATEGORIA VALUES (NULL, ?, ?, ?)", array(
                $this->Nombre,
                $this->Descripcion,
                $this->Estado,

            )
        );
        $this->Disconnect();
        return $result;
    }
    public function update() : bool
    {
        $result = $this->updateRow("UPDATE proyectotiendaropa.CATEGORIA SET Nombre = ?, Descripcion = ?, Estado = ? WHERE Codigo = ?", array(
                $this->Nombre,
                $this->Descripcion,
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
        $arrCATEGORIA = array();
        $tmp = new CATEGORIA();
        $getrows = $tmp->getRows($query);

        foreach ($getrows as $valor) {
            $CATEGORIA = new CATEGORIA();
            $CATEGORIA->Codigo = $valor['Codigo'];
            $CATEGORIA->Nombre = $valor['Nombre'];
            $CATEGORIA->Descripcion = $valor['Descripcion'];
            $CATEGORIA->Estado = $valor['Estado'];
            $CATEGORIA->Disconnect();
            array_push($arrCATEGORIA, $CATEGORIA);
        }
        $tmp->Disconnect();
        return $arrCATEGORIA;
    }
    public static function searchForId($Codigo) : ABONO
    {
        $CATEGORIA= null;
        if ($Codigo > 0){
            $CATEORIA= new CATEGORIA();
            $getrow = $CATEGORIA->getRow("SELECT * FROM proyectotiendaropa.CATEGORIA WHERE Codigo =?", array($Codigo));
            $CATEGORIA->Codigo = $getrow['Codigo'];
            $CATEORIA->Nombre = $getrow['Nombre'];
            $CATEORIA->Descripcion = $getrow['Descripcion'];
            $CATEORIA->Estado = $getrow['Estado'];

        }
        $CATEGORIA->Disconnect();
        return $CATEGORIA;
    }


    public static function getAll() : array
    {
        return CATEGORIA::search("SELECT * FROM proyectotiendaropa.CATEORIA");
    }

    public static function CATEGORIARegistrado ($Nombre) : bool
    {
        $result = CATEGORIA::search("SELECT Codigo FROM proyectotiendaropa.CATEGORIA where Nombre = ".$Nombre);
        if (count($result) > 0){
            return true;
        }else{
            return false;
        }
    }
}
<?php


namespace app\Models;
use http\QueryString;
require_once('BasicModel.php');

class Inventario extends BasicModel
{
    private $Codigo;
    private $Producto;
    private $Compra;
    private $Cantidad;
    private $Precio;
    private $IVA;
    private $Talla;
    private $Color;

    /**
     * Persona constructor.
     * @param $Codigo
     * @param $Producto
     * @param $Compra
     * @param $Cantidad
     * @param $Precio
     * @param $IVA
     * @param $Talla
     * @param $Color
     */
    public function __construct($Inventario = array())
    {
        parent::__construct(); //Llama al contructor padre "la clase conexion" para conectarme a la BD
        $this->Codigo = $Inventario['Codigo'] ?? null;
        $this->Producto = $Inventario['Producto'] ?? null;
        $this->Compra = $Inventario['Compra'] ?? null;
        $this->Cantidad = $Inventario['Cantidad'] ?? null;
        $this->Precio = $Inventario['Precio'] ?? null;
        $this->IVA = $Inventario['IVA'] ?? null;
        $this->Talla = $Inventario['Talla'] ?? null;
        $this->Color = $Inventario['Color'] ?? null;
    }
    /**
     * @return array
     */
    public static function getAll(): array
    {
        return Inventario::search("SELECT * FROM merempresac.Inventario");
    }
    /**
     * @param $query
     * @return Inventario|array
     * @throws \Exception
     */
    public static function search ($query)
    {
        $arrInventario = array();
        $tmp = new Inventario();
        $getrows = $tmp->getRows($query);

        foreach ($getrows as $valor) {
            $Inventario = new Inventario();
            $Inventario->Codigo = $valor['Codigo'];
            $Inventario->Producto = $valor['Producto'];
            $Inventario->Compra = $valor['Compra'];
            $Inventario->Cantidad = $valor['Cantidad'];
            $Inventario->Precio = $valor['Precio'];
            $Inventario->IVA = $valor['IVA'];
            $Inventario->Talla = $valor['Talla'];
            $Inventario->Color = $valor['Color'];
            $Inventario->Disconnect();
            array_push($arrInventario, $Inventario);
        }
        $tmp->Disconnect();
        return $arrInventario;
    }
    /**
     * @param $Codigo
     * @return bool
     * @throws \Exception
     */
    public static function usuarioregistrado ($Codigo): bool
    {
        $result = Inventario::search("SELECT * FROM merempresac.Inventario where Codigo = ".$Codigo );
        if (count($result) > 0) {
            return true;
        } else {
            return false;
        }
    }
    /**
     *
     */
    function __destruct()
    {
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
     * @return int
     */
    public function getProducto(): ?int
    {
        return $this->Producto;
    }

    /**
     * @param int $Producto
     */
    public function setProducto(?int $Producto): void
    {
        $this->Producto = $Producto;
    }

    /**
     * @return int
     */
    public function getCompra(): ?int
    {
        return $this->Compra;
    }

    /**
     * @param int $Compra
     */
    public function setCompra(?int $Compra): void
    {
        $this->Compra = $Compra;
    }

    /**
     * @return int
     */
    public function getCantidad(): ?int
    {
        return $this->Cantidad;
    }

    /**
     * @param int $Cantidad
     */
    public function setCantidad(?int $Cantidad): void
    {
        $this->Cantidad = $Cantidad;
    }

    /**
     * @return int
     */
    public function getPrecio(): ?int
    {
        return $this->Precio;
    }

    /**
     * @param int $Precio
     */
    public function setPrecio(?int $Precio): void
    {
        $this->Precio = $Precio;
    }

    /**
     * @return int
     */
    public function getIVA(): ?int
    {
        return $this->IVA;
    }

    /**
     * @param int $IVA
     */
    public function setIVA(?int $IVA): void
    {
        $this->IVA = $IVA;
    }

    /**
     * @return String
     */
    public function getTalla(): ?String
    {
        return $this->Talla;
    }

    /**
     * @param String $Talla
     */
    public function setTalla(?String $Talla): void
    {
        $this->Talla = $Talla;
    }

    /**
     * @return String
     */
    public function getColor(): ?String
    {
        return $this->Color;
    }

    /**
     * @param String $Color
     */
    public function setColor(?String $Color): void
    {
        $this->Color = $Color;
    }
    /**
     * @return int
     */

    /**
     * @return bool
     * @throws \Exception
     */
   public function create(): bool
    {
        $result = $this->insertRow("INSERT INTO merempresac.Inventario VALUES (NULL, ?, ?, ?, ?, ?, ?,?)", array(
                $this->Producto,
                $this->Compra,
                $this->Cantidad,
                $this->Precio,
                $this->IVA,
                $this->Talla,
                $this->Color

            )

        );
        $this->Disconnect();
        return $result;
    }
    /**
     * @param $Codigo
     * @return bool
     */
    public function deleted($Codigo): bool
    {
        $User = Inventario::searchForDocumento($Codigo); //Buscando un usuario por el ID
        $User->setEstado("Inactivo"); //Cambia el estado del Usuario
        return $User->update();                    //Guarda los cambios..
    }

    /**
     * @param $Codigo
     * @return Inventario
     * @throws \Exception
     */
    public static function searchForDocumento($Codigo): Persona
    {
        $Inventario = null;
        if ($Codigo > 0) {
            $Inventario = new Persona();
            $getrow = $Inventario->getRow("SELECT * FROM merempresac.Inventario WHERE Codigo =?", array($Codigo));
            $Inventario->Codigo = $getrow['Codigo'];
            $Inventario->Producto = $getrow['Producto'];
            $Inventario->Compra = $getrow['Compra'];
            $Inventario->Cantidad = $getrow['Cantidad'];
            $Inventario->Precio = $getrow['Precio'];
            $Inventario->IVA = $getrow['IVA'];
            $Inventario->Talla = $getrow['Talla'];
            $Inventario->Color = $getrow['Color'];
        }
        $Inventario->Disconnect();
        return $Inventario;
    }

    /**
     * @return bool
     */
    public function update(): bool
    {
        $result = $this->updateRow("UPDATE merempresac.Persona SET  Producto = ?, Compra = ?, Cantidad = ?, Precio=?, IVA=?, Rol=?, Talla=? WHERE Codigo = ?", array(

                $this->Producto,
                $this->Compra,
                $this->Cantidad,
                $this->Precio,
                $this->IVA,
                $this->Talla,
                $this->Codigo
            )
        );
        $this->Disconnect();
        return $result;
    }

    /**
     * @return string
     */
    /**
     * @return string
     */
    public function __toString()
    {
        return "Codigo: $this->Codigo, Producto: $this->Producto, Compra: $this->Compra, Cantidad: $this->Cantidad, Precio: $this->Precio, IVA: $this->IVA,Talla: $this->Talla,Color: $this->Color:,";
    }


    /*
    public function __toString()
    {
        return $this->documentPerson." ".$this->namePerson." ".$this->dateBornPerson." ".$this->rhperson
            ." ".$this->emailPerson ." ".$this->phonePerson." ".$this->adressPerson." ".$this->genereperson." ".$this->userperson
            ." ".$this->passwordPerson." ".$this->typePerson." ".$this->statePerson." ".$this->photoperson;


    }


    public function delete($idCategoria): bool
    {
        $CategoriaDelet = Categoria::searchForId($idCategoria);
        $CategoriaDelet->setestado("Inactivo");
        return $CategoriaDelet->update();
    }

*/






}


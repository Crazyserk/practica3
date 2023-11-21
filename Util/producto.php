<?php
class Producto{
    public int $idProducto;
    public String $nombredeProducto;
    public float $precio;
    public String $descripcion;
    public int $cantidad;
    public String $imagen;
    function __construct($idProducto, $nombreProducto, $precio, $descripcion, $cantidad, $imagen){
        $this->idProducto = $idProducto;
        $this->nombredeProducto = $nombreProducto;
        $this->precio = $precio;
        $this->descripcion = $descripcion;
        $this->cantidad = $cantidad;
        $this->imagen = $imagen;
    }
}
?>

















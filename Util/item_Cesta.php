<?php
class item_Cesta
{
    public float $precio;
    public string $nombre;
    public string $imagen;
    public int $cantidad;

    function __construct(string $nombre, float $precio, string $imagen, int $cantidad)
    {
        $this->precio = $precio;
        $this->nombre = $nombre;
        $this->imagen = $imagen;
        $this->cantidad = $cantidad;
    }
}

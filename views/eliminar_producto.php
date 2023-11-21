<?php
    session_start();
    require "../util/base_de_datos.php";
    $id = $_POST["id"];
    $precio = $_POST["precioTotal"];
    $idCesta = $_POST["idCesta"];
    $usuario = $_SESSION["usuario"];
    
    $sqlcantidad = "SELECT cantidad FROM productosCestas WHERE idProducto = $id";
    $cantidad = $conexion->query($sqlcantidad)->fetch_assoc()["cantidad"];
    
    $sql = "DELETE FROM productosCestas WHERE idProducto = $id";
    $conexion->query($sql);
    
    $sql2 = "UPDATE Cestas SET precioTotal = '$precio'  WHERE idCesta = '$idCesta'";
    $conexion->query($sql2);
    
    $sql3 = "UPDATE productos SET cantidad = cantidad + $cantidad WHERE idProducto = $id";
    $conexion->query($sql3);
    
    header("Location: cestilla.php");
?>
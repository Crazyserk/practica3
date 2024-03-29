<?php
session_start();
require "../util/base_de_datos.php";
require "../util/producto.php";
require "../util/item_Cesta.php";


if (isset($_SESSION["usuario"])) {
    $usuario = $_SESSION["usuario"];
    $numeroProductos = 0;
    $sql1 = "SELECT * FROM Cestas WHERE usuario = '$usuario'";
    $resultado = $conn->query($sql1);
    while ($fila = $resultado->fetch_assoc()) {
        $idCesta = $fila["idCesta"];
        $precioTotal = $fila["precioTotal"];
    }
    if (isset($idCesta)) {
        $sql2 = "SELECT p.nombredeProducto as nombre, p.precio as precio, p.imagen as imagen, pc.cantidad as cantidad FROM productos p JOIN productosCestas pc ON p.idProducto = pc.idProducto WHERE pc.idCesta = $idCesta";
        $resultado2 = $conn->query($sql2);
        $productosCesta = [];
        while ($fila = $resultado2->fetch_assoc()) {
            $nuevo_producto = new ProductoCesta($fila["nombre"], $fila["precio"], $fila["imagen"], $fila["cantidad"]);
            array_push($productosCesta, $nuevo_producto);
            $numeroProductos++;
        }
    } else {
        $productosCesta = [];
        $numeroProductos = 0;
        $precioTotal = 0;
    }
} else {
    header("Location: iniciar_sesion.php");
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cesta</title>
    <link rel="stylesheet" href="styles/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>

<body>
    <div class="container">
        <h1>Cesta</h1>
        <?php
        if (isset($_SESSION["usuario"])) {
            echo "<h2>Bienvenido " . $_SESSION["usuario"] . "</h2>";
        } else {
            header("Location: iniciar_sesion.php");
        }
        ?>
        <header>
            <nav class="navegador">
                <ul>
                    <li><a href="index.php">Inicio</a></li>
                    <?php
                    if (isset($_SESSION["rol"])) {
                        if ($_SESSION["rol"] == "admin") {
                            echo "<li><a href='Formulario_anadir_productos.php'>Añadir Productos</a></li>";
                            echo "<li><a href='modificación.php'>Modificar Cantidad de Productos</a></li>";
                        }
                    }
                    ?>
                    <?php
                    if (!isset($_SESSION["usuario"])) {
                        echo "<li><a href='iniciar_sesion.php'>Login</a></li>";
                        echo "<li><a href='Formulario_anadir_Usuario.php'> Añadir Usuario</a></li>";
                    } else {
                        echo "<li><a href='cestilla.php'>Cesta</a></li>";
                        echo "<li><a href='cerrar_sesion.php'>Salir</a></li>";
                    }
                    ?>
                </ul>
            </nav>
        </header>
        <main>
            <table class="table table-secondary table-hover">
                <thead class="table table-striped">
                    <tr>
                        <th>Nombre</th>
                        <th>Imagen</th>
                        <th>Cantidad</th>
                        <th>Precio Unitario</th>
                        <th>Eliminar</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($productosCesta as $producto) {
                        echo "<tr>";
                        echo "<td>" . $producto->nombre . "</td>";
                        echo "<td><img src='$producto->imagen' width='50%' height='50%'></td>";
                        echo "<td>" . $producto->cantidad . "</td>";
                        echo "<td>" . $producto->precio . "</td>";
                    ?>
                        <td>
                            <form action="eliminar_producto.php" method="POST">
                                <?php
                                $sqlID = "SELECT idProducto FROM productos WHERE nombredeProducto = '$producto->nombre'";
                                $resultadoID = $conn->query($sqlID);
                                while ($fila = $resultadoID->fetch_assoc()) {
                                    $idProducto = $fila["idProducto"];
                                }
                                ?>
                                <input type="hidden" name="id" value="<?php echo $idProducto ?>">
                                <?php
                                $precioEliminar  = $producto->precio * $producto->cantidad;
                                $precioTotal2 = $precioTotal - $precioEliminar;
                                ?>
                                <input type="hidden" name="precioTotal" value="<?php echo $precioTotal2 ?>">
                                <input type="hidden" name="idCesta" value="<?php echo $idCesta ?>">
                                <input type="submit" value="Eliminar" class="btn btn-danger">
                            </form>
                        </td>
                    <?php
                        echo "</tr>";
                    }
                    ?>
                </tbody>
                <tfoot class="table table-info">
                    <tr>
                        <td colspan="4">Total del carrito</td>
                        <td><?php echo $precioTotal; ?></td>
                    </tr>
                </tfoot>
            </table>
            <form method="post" action="hacerpedido.php">
                <input type="hidden" name="precioTotal" value="<?php echo $precioTotal ?>">
                <input type="hidden" name="idCesta" value="<?php echo $idCesta ?>">
                <input type="hidden" name="numeroProductos" value="<?php echo $numeroProductos ?>">
                <input type="submit" name="ENVIAR" value="Realizar el pago" class="btn btn-success">
            </form>
        </main>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>

</html>
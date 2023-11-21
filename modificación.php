<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar Cantidad de Producto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <?php require "../util/base_de_datos.php" ?>
    <?php require "../util/depuracion.php" ?>
    <?php require "../util/producto.php" ?>
    <link rel="stylesheet" href="styles/style.css">
</head>

<body>
    <?php
    session_start();
    if ($_SESSION["rol"] != "admin") {
        header("Location: index.php");
    }
    $sql = "SELECT * FROM productos";
    $resultado = $conn->query($sql);
    $productos = [];
    while ($fila = $resultado->fetch_assoc()) {
        $nuevo_producto = new Producto($fila["idProducto"], $fila["nombreProducto"], $fila["precio"], $fila["descripcion"], $fila["cantidad"], $fila["imagen"]);
        array_push($productos, $nuevo_producto);
    }
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST["idProducto"])) {
            $idProducto = depuracion($_POST["idProducto"]);
            $temp_cantidad = depuracion($_POST["cantidad"]);
            //Compruebo cantidad
            if ($temp_cantidad <= 0 || $temp_cantidad > 8) {
                $err_cantidad = "La cantidad debe ser entre 1 y 7";
            } else {
                $cantidad = $temp_cantidad;
            }
            $sqlCantidad = "SELECT cantidad FROM productos WHERE idProducto = $idProducto";
            $cantidadTotal = $conn->query($sqlCantidad)->fetch_assoc()["cantidad"];
            if (isset($cantidad)) {
                $cantidadTotal += $cantidad;
                $sqlCantidad = "UPDATE productos SET cantidad = $cantidadTotal WHERE idProducto = $idProducto";
                $resultado = $conn->query($sqlCantidad);
                header("Location: modificación.php");
            }
        }
    }
    ?>
    <div class="container">
        <h1>Inicio</h1>
        <?php
        if (isset($_SESSION["usuario"])) {
            echo "<h2>Bienvenido " . $_SESSION["usuario"] . "</h2>";
        }
        ?>
        <header>
            <nav class="navegador-2">
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
                        echo "<li><a href='cerrar_sesion.php'>Logout</a></li>";
                    }
                    ?>
                </ul>
            </nav>
        </header>
        <main>
            <table class="table table-secondary table-hover">
                <thead class="table table-striped">
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Precio</th>
                        <th>Descripcion</th>
                        <th>Cantidad</th>
                        <th>Imagen</th>
                        <?php
                        if (isset($_SESSION["usuario"])) {
                            echo "<th></th>";
                        }
                        ?>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($productos as $producto) { ?>
                        <tr>
                            <td><?php echo $producto->idProducto; ?></td>
                            <td><?php echo $producto->nombredeProducto; ?></td>
                            <td><?php echo $producto->precio; ?></td>
                            <td><?php echo $producto->descripcion; ?></td>
                            <td><?php echo $producto->cantidad; ?></td>
                            <td><img src="<?php echo $producto->imagen; ?>" alt='' width='50%' heigth='50%'></td>
                            <td>
                                <form action="" method="post">
                                    <input type="hidden" name="idProducto" value="<?php echo $producto->idProducto; ?>">
                                    <select name="cantidad" class="form-select">
                                        <option selected value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                    </select>
                                    <input type="submit" name="Añadir" value="Añadir" class="btn btn-success">
                                </form>
                            </td>
                        <?php
                    }
                        ?>
                        </tr>
                </tbody>
            </table>
        </main>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>

</html>
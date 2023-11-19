<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página Principal</title>
    <title>Inicio de sesión</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="styles/style.css">
    <?php require "../Util/producto.php" ?>
    <?php require "../Util/depuracion.php" ?>
    <?php require "../Util/base_de_datos.php" ?>

</head>

<body>
    <?php
    session_start();
    $sql = "SELECT * FROM productos";
    $resultado = $conn->query($sql);
    $productos = [];
    while ($fila = $resultado->fetch_assoc()) {
        $nuevo_producto = new Producto($fila["idProducto"], $fila["nombreProducto"], $fila["Precio"], $fila["descripcion"], $fila["Cantidad"], $fila["imagen"]);
        array_push($productos, $nuevo_producto);
    }
    ?>
    <div class="container">
        <h1>Página de Inicio</h1>
        <?php
        if (isset($_SESSION["usuario"])) {
            echo "<h2>Bienvenido " . $_SESSION["usuario"] . "</h2>";
        }
        ?>
        <header>
            <nav class="navegador">
                <ul>
                    <li><a href="index.php">Inicio</a></li>
                    <?php
                    if (isset($_SESSION["rol"])) {
                        if ($_SESSION["rol"] == "admin")
                            echo "<li><a href='Formulario_anadir_productos.php'>Añadir Productos</a></li>";
                    }
                    ?>
                    <?php
                    if (!isset($_SESSION["usuario"])) {
                        echo "<li><a href='iniciar_sesion.php'>Login</a></li>";
                        echo "<li><a href='Formulario_anadir_Usuario.php'>Añadir Usuario</a></li>";
                    } else
                        echo "<li><a href='cerrar_sesion.php'> Cierre de sesión </a></li>";
                    ?>
                </ul>
            </nav>
        </header>
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th class="col-sm-12">ID</th>
                    <th class="col-sm-12">Nombre</th>
                    <th class="col-sm-12">Precio</th>
                    <th class="col-sm-12">Descripción</th>
                    <th class="col-sm-12">Cantidad</th>
                    <th class="col-sm-12">Imagen</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($productos as $producto) {
                    echo "<tr>";
                    echo "<td>" . $producto->idProducto . "</td>";
                    echo "<td>" . $producto->nombreProducto . "</td>";
                    echo "<td>" . $producto->precio . "</td>";
                    echo "<td>" . $producto->descripcion . "</td>";
                    echo "<td>" . $producto->cantidad . "</td>";
                    echo "<td><img src='" . $producto->imagen . "' alt='' width='60%' height='60%'></td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</body>

</html>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página Principal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
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
        <h3>Página de Inicio</h3>
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
        <?php
        if (isset($_SESSION["usuario"])) {
            echo "<h2>Bienvenido " . $_SESSION["usuario"] . "</h2>";
        }
        ?>
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
            <?php
            foreach ($productos as $producto) {
                echo "<div class='col'>";
                echo "<div class='card'>";
                echo "<img src='" . $producto->imagen . "' class='card-img-top' alt='Product Image'>";
                echo "<div class='card-body'>";
                echo "<h3 class='card-title'>" . $producto->nombreProducto . "</h3>";
                echo "<p class='card-text'>Precio: " . $producto->precio . "</p>";
                echo "<p class='card-text'>Descripción: " . $producto->descripcion . "</p>";
                echo "<p class='card-text'>Cantidad: " . $producto->cantidad . "</p>";
                echo "</div>";
                echo "</div>";
                echo "</div>";
            }
            ?>
        </div>
    </div>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</body>
</html>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Producto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="styles/style.css">
    <?php require "../Util/depuracion.php" ?>
    <?php require "../Util/base_de_datos.php" ?>
    <?php require "../Util/producto.php" ?>
</head>
<body>
    <?php
    session_start();
    if ($_SESSION["rol"] != "admin") {
        header("Location: index.php");
    }
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST["nombre"])) {
            $temp_nombre = depuracion($_POST["nombre"]);
        } else {
            $temp_nombre = "";
        }
        if (isset($_POST["precio"])) {
            $temp_precio = depuracion($_POST["precio"]);
        } else {
            $temp_precio = "";
        }
        if (isset($_POST["descripcion"])) {
            $temp_descripcion = depuracion($_POST["descripcion"]);
        } else {
            $temp_descripcion = "";
        }
        if (isset($_POST["cantidad"])) {
            $temp_cantidad = depuracion($_POST["cantidad"]);
        } else {
            $temp_cantidad = "";
        }
        // Agregar imágenes 
        $nombre_imagen = $_FILES["imagen"]["name"];
        $ruta_temp = $_FILES["imagen"]["tmp_name"];
        $ruta_final = "images/" . $nombre_imagen;
        move_uploaded_file($ruta_temp, $ruta_final);
        // Validaciones
        // Validación del nombre
        if (!strlen($temp_nombre) > 0) {
            $err_nombre = "Error. El nombre es obligatorio";
        } else {
            if (strlen($temp_nombre) > 40) {
                $err_nombre = "No puede contener más de 40 caracteres";
            } else {
                $patron = "/^[a-zñA-ZÑ0-9\s]{1,40}$/";
                if (!preg_match($patron, $temp_nombre)) {
                    $err_nombre = "El nombre debe tener al menos 1 caracter y menos de 40 caracteres de los cuales puede tener letras, números y espacios";
                } else {
                    $nombre = $temp_nombre;
                }
            }
        }
        // Validación del precio
        if (!strlen($temp_precio) > 0) {
            $err_precio = "Error. El precio debe existir";
        } else {
            $temp_precio = (float) $temp_precio;
            if ($temp_precio < 0 || $temp_precio > 99999.99) {
                $err_precio = "Error el precio debe estar entre 0 y 99999.99";
            } else {
                $precio = $temp_precio;
            }
        }
        // Validación de la descripción
        if (!strlen($temp_descripcion) > 0) {
            $err_descripcion = "Error. La descripción debe existir";
        } else {
            if (strlen($temp_descripcion) > 255) {
                $err_descripcion = "Error. La descripción debe tener menos de 255 caracteres";
            } else {
                $descripcion = $temp_descripcion;
            }
        }
        // Validación de la cantidad
        if (!strlen($temp_cantidad) > 0) {
            $err_cantidad = "Error. La cantidad debe existir";
        } else {
            $temp_cantidad = (int) $temp_cantidad;
            if ($temp_cantidad < 0 || $temp_cantidad > 99999) {
                $err_cantidad = "Error. La cantidad debe estar entre 0 y 99999";
            } else {
                $cantidad = $temp_cantidad;
            }
        }
    }
    ?>
    <div class=container>
        <h3>Agrega tu producto</h3>
        <nav class="navegador-2">
            <ul>
                <li><a href="index.php">Inicio</a></li>
                <?php
                if ($_SESSION["rol"] == "admin")
                    echo "<li><a href='Formulario_agregar_productos.php'></a></li>";
                if (!isset($_SESSION["usuario"])) {
                    echo "<li><a href='iniciar_sesion.php'>Inicio de sesión </a></li>";
                    echo "<li><a href='Formulario_agregar_Usuario.php'> Agregar Usuario </a></li>";
                } else
                    echo "<li><a href='cerrar_sesion.php'>Cierre de sesión</a></li>";
                ?>
            </ul>
        </nav>
        <form method="POST" action="" enctype="multipart/form-data">
            <div clas="mb-3">
                <label for="nombre" class="form-label">Nombre:</label>
                <input type="text" name="nombre" id="nombre" placeholder="Nombre del producto" class="form-control">
                <?php
                if (isset($err_nombre)) {
                    echo $err_nombre;
                }
                ?>
            </div>
            <div clas="mb-3">
                <label for="precio" class="form-label">Precio:</label>
                <input type="text" name="precio" id="precio" placeholder="Precio del producto" class="form-control">
                <?php
                if (isset($err_precio)) {
                    echo $err_precio;
                }
                ?>
            </div>
            <div class="mb-3">
                <label for="descripcion" class="form-label">Descripción:</label>
                <input type="text" name="descripcion" id="descripcion" placeholder="Descripción del producto" class="form-control">
                <?php
                if (isset($err_descripcion)) {
                    echo $err_descripcion;
                }
                ?>
            </div>
            <div class="mb-3">
                <label for="cantidad" class="form-label">Cantidad:</label>
                <input type="text" name="cantidad" id="cantidad" placeholder="Cantidad del producto" class="form-control">
                <?php
                if (isset($err_cantidad)) {
                    echo $err_cantidad;
                }
                ?>
            </div>
            <div class="mb-3">
                <label for="imagen" class="form-label">Imagen:</label>
                <input type="file" name="imagen" id="imagen" class="form-control">
            </div>
            <button type="submit" class="btn btn-primary">Agregar</button>
        </form>
        <?php
        if (isset($nombre) && isset($precio) && isset($descripcion) && isset($cantidad)) {
            echo "<h3>Producto agregado correctamente</h3>";
            $sql = "INSERT INTO productos (nombreProducto, precio, descripcion, cantidad, imagen) VALUES ('$nombre', '$precio', '$descripcion', '$cantidad', '$ruta_final')";
            $conn->query($sql);
        }
        ?>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>
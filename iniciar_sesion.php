<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio de sesión</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="styles/style.css">
    <?php require "../Util/depuracion.php" ?>
    <?php require "../Util/base_de_datos.php" ?>
</head>

<body>
    <?php
    session_start();
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $temp_usuario = depuracion($_POST["usuario"]);
        $temp_contrasena = depuracion($_POST["contrasena"]);

        $sql = "SELECT * FROM usuarios WHERE usuario = '$temp_usuario'";
        $resultado = $conn->query($sql);
        $fila = $resultado->fetch_assoc();

        if (!$fila) {
    ?>
            <div class="alert alert-danger" role="alert"> El usuario no existe </div>
            <?php
        } else {
            $contrasenaCifrada = $fila['contrasena'];
            $rol = $fila['rol'];
            $accesoValido = password_verify($temp_contrasena, $contrasenaCifrada);

            if ($accesoValido) {
                echo "Validado correctamente";
                $_SESSION["usuario"] = $temp_usuario;
                $_SESSION["rol"] = $rol;
                header("Location: index.php");
                exit;
            } else {
            ?>
                <div class="alert alert-danger" role="alert"> Contraseña no válida </div>
    <?php
            }
        }
    }
    ?>
    <div class="container">
        <h1>Inicio de sesión</h1>
        <nav class="navegador">
            <ul>
                <li><a href="index.php"> Inicio </a></li>
                <?php
                if (isset($_SESSION["rol"]) && $_SESSION["rol"] == "admin") {
                    echo "<li><a href='Formulario_anadir_productos.php'> Añade productos </a></li>";
                }
                if (!isset($_SESSION["usuario"])) {
                    echo "<li><a href='iniciar_sesion.php'> Login </a></li>";
                    echo "<li><a href='Formulario_anadir_Usuario.php'> Añadir </a></li>";
                } else {
                    echo "<li><a href='cerrar_sesion.php'> Cierre de sesión </a></li>";
                }
                ?>
            </ul>
        </nav>
        <form method="post" action="">
            <div class="mb-3">
                <label for="usuario" class="form-label"> Usuario: </label>
                <input type="text" name="usuario" id="usuario" placeholder="Usuario" class="form-control">
            </div>
            <div class="mb-3">
                <label for="contrasena" class="form-label"> Contraseña: </label>
                <input type="password" name="contrasena" id="contrasena" placeholder="Contraseña" class="form-control">
            </div>
            <button type="submit" class="btn btn-primary">Inicio de sesión </button>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>

</html>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../styles.css">
    <?php require './conexion.php' ?>
</head>

<body>
    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $usuario = $_POST["usuario"];
        $contrasena = $_POST["contrasena"];

        $sql = "SELECT * FROM usuarios WHERE usuario = '$usuario'";
        $resultado = $conexion->query($sql);

        if ($resultado->num_rows === 0) {
            echo "NO EXISTE EL USUARIO";
        } else {
            while ($fila = $resultado->fetch_assoc()) {
                $contrasena_cifrada = $fila["contrasena"];
            }
            //Para comprobar si la contrasñea original es igual a la contraseña introducida
            $acceso_valido = password_verify($contrasena, $contrasena_cifrada);

            if ($acceso_valido) {
                echo "NOS HEMOS LOGEADO CON EXITO";
                //Crea una sesion nueva o recupera una existente
                session_start();
                $_SESSION["usuario"] = $usuario;
                header('location:principal.php');
            } else {
                echo "LA CONTRASEÑA ESTÁ MAL";
            }
        }
    }
    ?>

    <div class="container">
        <h1>Iniciar Sesión</h1>
        <form action="" method="post">
            <div class="mb-3">
                <label class="form-label">Usuario:</label>
                <input type="text" class="form-control" name="usuario">
            </div>
            <div class="mb-3">
                <label class="form-label">Contraseña:</label>
                <input type="passwd" class="form-control" name="contrasena">
            </div>
            <input class="btn btn-primary" type="submit" value="Registrarse">
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
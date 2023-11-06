<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrarse</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../styles.css">
    <?php  require './conexion.php' ?> 
</head>
<body>
    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $usuario = $_POST["usuario"];
        $contrasena = $_POST["contrasena"];
        //Para cifrar una contraseña 
        $contrasena_cifrada = password_hash($contrasena, PASSWORD_DEFAULT);
        echo $contrasena_cifrada;

        $sql = "INSERT INTO usuarios VALUES ('$usuario', '$contrasena_cifrada')";
        $conexion -> query($sql); 
    }
    ?>
    <div class="container">
    <h1>Registrarse</h1>
    <form action="" method="post">
        <div class="mb-3">
            <label class="form-label">Usuario:</label>
            <input type="text" class="form-control" name="usuario">
        </div>
        <div class="mb-3">
            <label class="form-label">Contraseña:</label>
            <input type="password" class="form-control" name="contrasena">
        </div>
        <div class="mb-3">
            <label class="form-label">Fecha de Nacimiento:</label>
            <input type="date" class="form-control" name="fecha_nacimiento">
        </div>
        <input class="btn btn-primary" type="submit" value="Registrarse">
    </form>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
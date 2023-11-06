<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página Principal</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../styles.css">
    <?php require './conexion.php' ?>
</head>

<body>
    <?php
    session_start();
    if (isset($_SESSION["usuario"])) {
        $usuario = $_SESSION["usuario"];
    } else {
        //header("Location: iniciar_sesion.php");
        $_SESSION["usuario"] = "invitado";
        $usuario = $_SESSION["usuario"];
    }
    ?>
    <div class="container">
        <h1>Página Principal</h1>
        <h2>Bienvenido
            <?php if (isset($_SESSION["usuario"])) {
                echo $usuario;
            } ?>
        </h2>

    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
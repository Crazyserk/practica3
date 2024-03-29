<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Registrate </title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
 <link rel="stylesheet" href="styles/style.css">
    <?php require "../Util/base_de_datos.php" ?>
    <?php require '../Util/depuracion.php'?>
</head>
<body>
    <div class=container>
        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (isset($_POST["usuario"])) {
                $temp_usuario = depuracion($_POST["usuario"]);
            } else {
                $temp_usuario = "";
            }
            if (isset($_POST["contrasena"])) {
                $temp_contrasena = depuracion($_POST["contrasena"]);
            } else {
                $temp_contrasena = "";
            }
            if (isset($_POST["fechaNacimiento"])) {
                $temp_fechaNacimiento = depuracion($_POST["fechaNacimiento"]);
            } else {
                $temp_fechaNacimiento = "";
            }
            //Validamos las restricciones
            if (!strlen($temp_usuario) > 0) {
                $err_usuario = "Error. El usuario es obligatorio";
            } else {
                if (strlen($temp_usuario) < 4  || strlen($temp_usuario) > 12) {
                    $err_usuario = "No puede contener menos de 4 caracteres ni más de 12";
                } else {
                    $patron = "/^[a-zA-Z_]{4,12}$/";
                    if (!preg_match($patron, $temp_usuario)) {
                        $err_usuario = "El usuario debe tener entre 4 y 12 caracteres, letras de la A a la Z y guiones bajos";
                    } else {
                        $usuario = $temp_usuario;
                    }
                }
            }
            //Validacion de contraseña
            if (!strlen($temp_contrasena) > 0) {
                $err_contrasena = "Error. La contraseña debe existir";
            } else {
                if (strlen($temp_contrasena) > 255) {
                    $err_contrasena = "No puede contener más de 255 caracteres";
                } else {
                    $contrasena = password_hash($temp_contrasena, PASSWORD_DEFAULT); // Ciframos la contraseña
                }
            }
            //Validacion de fecha de nacimiento
            if (strlen($temp_fechaNacimiento) == 0) {
                $err_fechaNacimiento = "La fecha de nacimiento es obligatoria";
            } else {
                $fecha_actual = date("Y-m-d"); //cojo la fecha actual
                list($anyo_actual, $mes_actual, $dia_actual) = explode("-", $fecha_actual);
                list($anyo, $mes, $dia) = explode("-", $temp_fechaNacimiento);
                if (($anyo_actual - $anyo > 12) && ($anyo_actual - $anyo < 120)) {
                    //es mayor de edad
                    $fecha_nacimiento = $temp_fechaNacimiento;
                } else if (($anyo_actual - $anyo) < 12 || ($anyo_actual - $anyo) > 120) {
                    $err_fechaNacimiento = "No puede ser menor de 12 años ni mayor de 120";
                } else {
                    if ($mes_actual - $mes > 0) {
                        //mayor de edad
                        $fecha_nacimiento = $temp_fechaNacimiento;
                    } else if ($mes_actual - $mes < 0) {
                        $err_fechaNacimiento = "No puedes ser menor de 12 años ni mayor de 120";
                    } else {
                        if ($dia_actual - $dia >= 0) {
                            //exito
                            $fecha_nacimiento = $temp_fechaNacimiento;
                        } else {
                            $err_fechaNacimiento = "No puedes ser menor de 12 años ni mayor de 120";
                        }
                    }
                }
            }
        }
        ?>
        <h1>Registro de Usuario</h1>
        <form method="POST" action="">
            <div class="mb-3">
                <label for="usuario" class="form-label">Usuario:</label>
                <input type="text" name="usuario" id="usuario" placeholder="Usuario" class="form-control">
                <?php
                if (isset($err_usuario)) {
                    echo $err_usuario;
                }
                ?>
            </div>
            <div class="mb-3">
                <label for="contrasena" class="form-label">Contraseña:</label>
                <input type="password" name="contrasena" id="contrasena" placeholder="Contraseña" class="form-control">
                <?php
                if (isset($err_contrasena)) {
                    echo $err_contrasena;
                }
                ?>
            </div>
            <div class="mb-3">
                <label for="fechaNacimiento" class="form-label">Fecha de Nacimiento:</label>
                <input type="date" name="fechaNacimiento" id="fechaNacimiento" class="form-control">
                <?php
                if (isset($err_fechaNacimiento)) {
                    echo $err_fechaNacimiento;
                }
                ?>
            </div>
            <button type="submit" class="btn btn-primary">Añadir</button>
        </form>
        <?php
        if (isset($usuario) && isset($contrasena) && isset($fecha_nacimiento)) {
            echo "<h3>¡Registro correcto!</h3>";
            $sql = "INSERT INTO usuarios (usuario, contrasena, fechaNacimiento) VALUES ('$usuario', '$contrasena', '$fecha_nacimiento')";
            $sql2 = "INSERT INTO cestas (usuario, precioTotal) VALUES ('$usuario', 0)";
            $conn->query($sql);
            //$conn->query($sql2);
        }
        ?>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>
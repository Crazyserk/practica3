<!DOCTYPE html>
<html>
<head>
    <title>Agregar Producto</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../styles.css">
</head>
<body>
<?php
// Conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "medac";
$dbname = "db_base";
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}
// Verifica si se envia el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos del formulario
    $nombreProducto = $_POST["nombreProducto"];
    $precio = $_POST["precio"];
    $descripcion = $_POST["descripcion"];
    $cantidad = $_POST["cantidad"];
    // Validar las restricciones
    if (strlen($nombreProducto) > 40) {
        echo "El nombre del producto debe tener como máximo 40 caracteres.";
    } elseif ($precio > 99999.99 || $precio < 0) {
        echo "El precio debe estar entre 0 y 99999.99.";
    } elseif (strlen($descripcion) > 255) {
        echo "La descripción debe tener como máximo 255 caracteres.";
    } elseif ($cantidad > 99999) {
        echo "La cantidad no puede ser mayor a 99999.";
    } else {
        // Insertar el producto en la base de datos
        $sql = "INSERT INTO Productos (nombreProducto, precio, descripcion, cantidad) VALUES ('$nombreProducto', $precio, '$descripcion', $cantidad)";
        if ($conn->query($sql) === TRUE) {
            echo "Producto agregado correctamente.";
        } else {
            echo "Error al agregar el producto: " . $conn->error;
        }
    }
}
$conn->close();
?>
<div class="container">
    <h2>Agregar Producto</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <div class="mb-3">
            <label for="nombreProducto" class="form-label">Nombre del Producto</label>
            <input type="text" class="form-control" id="nombreProducto" name="nombreProducto" required maxlength="40">
        </div>
        <div class="mb-3">
            <label for="precio" class="form-label">Precio </label>
            <input type="number" step="0.01" class="form-control" id="precio" name="precio"  max="99999.99">
        </div>
        <div class="mb-3">
            <label for="descripcion" class="form-label">Descripción </label>
            <textarea class="form-control" id="descripcion" name="descripcion" ></textarea>
        </div>
        <div class="mb-3">
            <label for="cantidad" class="form-label">Cantidad </label>
            <input type="number" class="form-control" id="cantidad" name="cantidad" >
        </div>
        <button type="submit" class="btn btn-primary">Agregar Producto</button>
    </form>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
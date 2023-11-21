
<?php require "../util/base_de_datos.php";
session_start();
if (!isset($_SESSION["usuario"])) {
    header("Location: iniciar_sesion.php");
}
$usuario = $_SESSION["usuario"];
$precioTotal = $_POST["precioTotal"];
$idCesta = isset($_POST["idCesta"]) ? $_POST["idCesta"] : null; // Verificar si se envió el valor de idCesta
$fechaActual = date('Y/m/d');
$numeroProductos = $_POST["numeroProductos"];
$sql = "INSERT INTO Pedidos (usuario, precioTotal, fechaPedido) VALUES ('$usuario', '$precioTotal', '$fechaActual')";
$conn->query($sql);
$sql2 = "SELECT idPedido FROM Pedidos WHERE usuario = '$usuario' AND precioTotal = '$precioTotal' AND fechaPedido = '$fechaActual'";
$idPedido = $conn->query($sql2)->fetch_assoc()["idPedido"];
$sql3 = "SELECT idProducto, cantidad FROM ProductosCestas WHERE idCesta = '$idCesta'";
$resAux = $conn->query($sql3);
$idProductos = [];
$cantidades = [];
while ($fila = $resAux->fetch_assoc()) {
    array_push($idProductos, $fila["idProducto"]);
    array_push($cantidades, $fila["cantidad"]);
}
for ($i = 0; $i < $numeroProductos; $i++) {
    $linea = $i + 1;
    $sqlAux2 = "SELECT precio FROM Productos WHERE idProducto = '$idProductos[$i]'";
    $precio = $conn->query($sqlAux2)->fetch_assoc()["precio"];
    $sql4 = "INSERT INTO lineaspedidos VALUES ('$linea', '$idProductos[$i]', '$idPedido', '$precio' , '$cantidades[$i]')";
    $conn->query($sql4);
}
$cont = 0;
while ($cont < $numeroProductos) {
    $sql5 = "DELETE FROM productoscestas WHERE idProducto = $idProductos[$cont]";
    $conn->query($sql5);
    $cont++;
}
$sql6 = "UPDATE cestas SET precioTotal = '0.0'  WHERE idCesta = '$idCesta'";
$conn->query($sql6);
header("Location: index.php");
?>

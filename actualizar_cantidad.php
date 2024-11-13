<?php
session_start();
$idUser = $_SESSION['user_id'];

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id']) && isset($_POST['cantidad'])) {
    $idProducto = $_POST['id'];
    $cantidad = $_POST['cantidad'];

    require "funciones/conecta.php";
    $con = conecta();

    $sql = "SELECT id FROM pedidos WHERE id_cliente = $idUser AND status = 0";
    $result = mysqli_query($con, $sql);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $idPedido = $row['id'];

        $sqlUpdate = "UPDATE pedidos_productos SET cantidad = $cantidad WHERE id_pedido = $idPedido AND id_producto = $idProducto";
        $resultUpdate = mysqli_query($con, $sqlUpdate);

        if (!$resultUpdate) {
            echo json_encode(['success' => false]);
        } else {
            echo json_encode(['success' => true]);
        }
    } else {
        echo json_encode(['success' => false]);
    }

    mysqli_close($con);
} else {
    echo json_encode(['success' => false]);
}
?>
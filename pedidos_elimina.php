<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $product_id = $_GET['id'];

    require "funciones/conecta.php";
    $con = conecta();

    $user_id = $_SESSION['user_id'];

   
    $sql_pedido = "SELECT id FROM pedidos WHERE id_cliente = $user_id AND status = 0";
    $res_pedido = $con->query($sql_pedido);

    if ($res_pedido->num_rows > 0) {
        $row_pedido = $res_pedido->fetch_assoc();
        $pedido_id = $row_pedido['id'];

        $sql_eliminar = "DELETE FROM pedidos_productos WHERE id_pedido = $pedido_id AND id_producto = $product_id";
        $res_eliminar = $con->query($sql_eliminar);

        if ($res_eliminar) {
            echo "1"; // Éxito: Producto eliminado exitosamente
        } else {
            echo "0"; // Error al eliminar el producto
        }
    } else {
        echo "0"; // No se encontró un pedido activo para el usuario
    }
} else {
    echo "0"; // ID de producto no válido
}
?>

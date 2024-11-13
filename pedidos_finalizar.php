<?php
    session_start();

    if (!isset($_SESSION['user_id'])) {
        http_response_code(401);
        exit(); 
    }

    $user_id = $_SESSION['user_id'];

    require "funciones/conecta.php";
    $con = conecta();

    $sql = "UPDATE pedidos SET status = 1 WHERE id_cliente = $user_id AND status = 0";
    $res = $con->query($sql);

    if ($res) {
        echo "1"; // Éxito: Pedido finalizado exitosamente
    } else {
        echo "0"; // Error al finalizar el pedido
    }
?>
<?php

session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit(); 
}

$user_id = $_SESSION['user_id'];

require "funciones/conecta.php";
$con = conecta();

$sql = "SELECT * FROM pedidos WHERE id_cliente = $user_id AND status = 0";
$res = $con->query($sql);

while ($row = $res->fetch_array()) {
    $id = $row["id"];
}

$sql = "SELECT * FROM pedidos_productos WHERE id_pedido = $id";
$res = $con->query($sql);

$data = array();

while ($row = $res->fetch_array()) {
    $id_producto = $row["id_producto"];
    $cantidad    = $row["cantidad"];
    $precio      = $row["precio"];

    $sql = "SELECT * FROM productos WHERE id = $id_producto";
    $res2 = $con->query($sql);
    $row2 = $res2->fetch_array();

    $nombre = $row2["nombre"];

    $subtotal = 0;
    $subtotal = $cantidad * $precio;

    $data[] = array(
        "id_producto" => $id_producto,
        "nombre"      => $nombre,
        "cantidad"    => $cantidad,
        "precio"      => $precio,
        "subtotal"    => $subtotal,
    );

}

echo json_encode($data);

?>



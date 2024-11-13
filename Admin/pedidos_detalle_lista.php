<?php

session_start();

if (!isset($_SESSION['nombreUser'])) {
    header("Location: index.php");
    exit(); 
}

require "funciones/conecta.php";
$con = conecta();
$id_pedido = $_GET['id'];


$sql = "SELECT * FROM pedidos_productos WHERE id_pedido = $id_pedido ";
$res = $con->query($sql);

$data = array(); 

while ($row = $res->fetch_array()) {
    $id_producto = $row["id_producto"];
    $cantidad    = $row["cantidad"];
    $precio      = $row["precio"];
    $subtotal    = 0;
    $subtotal    = $cantidad * $precio;

    $sql2 = "SELECT * FROM productos WHERE id = $id_producto";
    $res2 = $con->query($sql2);
    $row2 = $res2->fetch_array();

    $nombre_producto = $row2["nombre"];

    $data[] = array(
        "id_producto" => $id_producto,
        "nombre_producto" => $nombre_producto,
        "cantidad" => $cantidad,
        "precio" => $precio,
        "subtotal" => $subtotal
    );
}

echo json_encode($data);


?>



<?php

session_start();

if (!isset($_SESSION['nombreUser'])) {
    header("Location: index.php");
    exit(); 
}

require "funciones/conecta.php";
$con = conecta();

$sql = "SELECT * FROM pedidos WHERE status = 1";
$res = $con->query($sql);

$data = array(); 

while ($row = $res->fetch_array()) {
    $id         = $row["id"];
    $fecha      = $row["fecha"];
    $id_cliente = $row["id_cliente"];

    $data[] = array(
        "id" => $id,
        "fecha" => $fecha,
        "id_cliente" => $id_cliente
    );
}

echo json_encode($data);
?>



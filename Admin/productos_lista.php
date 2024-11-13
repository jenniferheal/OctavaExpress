<?php

session_start();

if (!isset($_SESSION['nombreUser'])) {
    header("Location: index.php");
    exit(); 
}

require "funciones/conecta.php";
$con = conecta();

$sql = "SELECT * FROM productos WHERE status = 1 AND eliminado = 0";
$res = $con->query($sql);

$data = array(); 

while ($row = $res->fetch_array()) {
    $id          = $row["id"];
    $nombre      = $row["nombre"];
    $codigo      = $row["codigo"];
    $costo       = $row["costo"];
    $stock       = $row["stock"];

    $data[] = array(
        "id"     => $id,
        "nombre" => $nombre,
        "codigo" => $codigo,
        "costo"  => $costo,
        "stock"  => $stock
    );
}

echo json_encode($data);
?>



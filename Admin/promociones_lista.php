<?php

session_start();

if (!isset($_SESSION['nombreUser'])) {
    header("Location: index.php");
    exit(); 
}

require "funciones/conecta.php";
$con = conecta();

$sql = "SELECT * FROM promociones WHERE status = 1 AND eliminado = 0";
$res = $con->query($sql);

$data = array(); 

while ($row = $res->fetch_array()) {
    $id          = $row["id"];
    $nombre      = $row["nombre"];

    $data[] = array(
        "id"     => $id,
        "nombre" => $nombre
    );
}

echo json_encode($data);
?>



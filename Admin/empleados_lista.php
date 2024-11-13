<?php

session_start();

if (!isset($_SESSION['nombreUser'])) {
    header("Location: index.php");
    exit(); 
}

require "funciones/conecta.php";
$con = conecta();

$sql = "SELECT * FROM empleados WHERE status = 1 AND eliminado = 0";
$res = $con->query($sql);

$data = array(); 

while ($row = $res->fetch_array()) {
    $id = $row["id"];
    $correo = $row["correo"];
    $nombreCompleto = $row["nombre"] . " " . $row["apellidos"];
    $rol = $row["rol"];

    $data[] = array(
        "id" => $id,
        "correo" => $correo,
        "nombreCompleto" => $nombreCompleto,
        "rol" => $rol
    );
}

echo json_encode($data);
?>



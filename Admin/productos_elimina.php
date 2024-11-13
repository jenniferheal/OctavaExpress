<?php

session_start();

if (!isset($_SESSION['nombreUser'])) {
    header("Location: index.php");
    exit(); 
}

require "funciones/conecta.php";
$con = conecta();
$id = $_REQUEST['id'];

$sql = "UPDATE productos SET eliminado = 1 WHERE id = $id";
$res = $con->query($sql);
$ban = 0;

if ($res) {
    $ban = 1; // Éxito
} else {
    $ban = 0; // Error
}

echo $ban;

?>

<?php
session_start();
require "funciones/conecta.php";
$con = conecta();

$correo   = $_POST['correo'];
$pass     = $_POST['pass'];


$sql = "SELECT * FROM usuarios WHERE correo = '$correo' AND pass = '$pass' AND status = 1 AND eliminado = 0";
$res = $con->query($sql);
$num = $res->num_rows;

if ($num == 1) {
    $row    = $res->fetch_array();
    $id     = $row["id"];
    $nombre = $row["nombre"].' '.$row["apellidos"];
    $correo = $row["correo"];

    $_SESSION['user_id']     = $id;
    $_SESSION['nombreUser'] = $nombre;
    $_SESSION['correoUser'] = $correo;
} 

echo $num;

?>

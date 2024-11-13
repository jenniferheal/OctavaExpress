<?php
    require "funciones/conecta.php";
    $con = conecta();

    $correo = $_REQUEST['correo'];
    $sql = "SELECT * FROM empleados WHERE correo = '$correo'";
    $res = $con->query($sql);
    $num = $res->num_rows;

    if ($num > 0) {
        echo "1"; // El correo existe
    } else {
        echo "0"; // El correo no existe
    }
 
?>

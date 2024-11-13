<?php
    require "funciones/conecta.php";
    $con = conecta();

    $codigo = $_REQUEST['codigo'];
    $sql = "SELECT * FROM productos WHERE codigo = '$codigo'";
    $res = $con->query($sql);
    $num = $res->num_rows;

    if ($num > 0) {
        echo "1"; // El codigo existe
    } else {
        echo "0"; // El codigo no existe
    }
 
?>

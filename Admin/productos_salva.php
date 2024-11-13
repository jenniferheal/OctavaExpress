<?php
       
        session_start();
    
        if (!isset($_SESSION['nombreUser'])) {
            header("Location: index.php");
            exit(); 
        }
    
        //empleados_salva.php

        require "funciones/conecta.php";
        $con = conecta();

        //Recibe variables
        $nombre      = $_REQUEST['nombre'];
        $codigo      = $_REQUEST['codigo'];
        $descripcion = $_REQUEST['descripcion'];
        $costo       = $_REQUEST['costo'];
        $stock       = $_REQUEST['stock'];

        $archivo_n = $_FILES['archivo']['name'];
        $archivo = $_FILES['archivo']['tmp_name'];
        $arreglo = explode(".", $archivo_n);
        $len = count($arreglo);
        $pos = $len - 1;
        $ext = $arreglo[$pos];
        $dir = "fotos_productos/";
        $file_enc = md5_file($archivo);

        if($archivo_n != ''){
                $fileName1 = "$file_enc.$ext";
                copy($archivo, $dir.$fileName1);
        }

        $sql = "INSERT INTO productos (nombre, codigo, descripcion, costo, stock, archivo_n, archivo)
                VALUES ('$nombre', '$codigo', '$descripcion', '$costo', '$stock', '$archivo_n', '$fileName1')";
        $res = $con->query($sql);

        header("Location: productosListado.php");
?>
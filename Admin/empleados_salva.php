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
        $nombre     = $_REQUEST['nombre'];
        $apellidos  = $_REQUEST['apellidos'];
        $correo     = $_REQUEST['correo'];
        $pass       = $_REQUEST['pass'];
        $rol        = $_REQUEST['rol'];
        $passEnc    = md5($pass);

        $archivo_n = $_FILES['archivo']['name'];
        $archivo = $_FILES['archivo']['tmp_name'];
        $arreglo = explode(".", $archivo_n);
        $len = count($arreglo);
        $pos = $len - 1;
        $ext = $arreglo[$pos];
        $dir = "fotos_empleados/";
        $file_enc = md5_file($archivo);

        if($archivo_n != ''){
                $fileName1 = "$file_enc.$ext";
                copy($archivo, $dir.$fileName1);
        }

        $sql = "INSERT INTO empleados (nombre, apellidos, correo, pass, rol, archivo_n, archivo)
                VALUES ('$nombre', '$apellidos', '$correo', '$pass', $rol, '$archivo_n', '$fileName1')";
        $res = $con->query($sql);

        header("Location: empleadosListado.php");
?>
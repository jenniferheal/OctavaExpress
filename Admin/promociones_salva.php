<?php
       
        session_start();
    
        if (!isset($_SESSION['nombreUser'])) {
            header("Location: index.php");
            exit(); 
        }
    

        require "funciones/conecta.php";
        $con = conecta();

        //Recibe variables
        $nombre      = $_REQUEST['nombre'];

        $archivo_n = $_FILES['archivo']['name'];
        $archivo = $_FILES['archivo']['tmp_name'];
        $arreglo = explode(".", $archivo_n);
        $len = count($arreglo);
        $pos = $len - 1;
        $ext = $arreglo[$pos];
        $dir = "fotos_promociones/";
        $file_enc = md5_file($archivo);

        if($archivo_n != ''){
                $fileName1 = "$file_enc.$ext";
                copy($archivo, $dir.$fileName1);
        }

        $sql = "INSERT INTO promociones (nombre, archivo)
                VALUES ('$nombre', '$fileName1')";
        $res = $con->query($sql);

        header("Location: promocionesListado.php");
?>
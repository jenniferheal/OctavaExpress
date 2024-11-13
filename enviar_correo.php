<?php

    require "funciones/conecta.php";
    $con = conecta();  

    $nombre = $_GET["nombre"];
    $correo = $_GET["correo"];
    $comentario = $_GET["comentario"];

    $destinatario = "jennifer.hernandez6246@alumnos.udg.mx"; 
    $asunto = "Nuevo mensaje de contacto";

    $mensaje = "Nombre: $nombre\n";
    $mensaje .= "Correo: $correo\n";
    $mensaje .= "Comentario:\n$comentario";

    $miCorreo = "From: jennifer.alv02@gmail.com";

    mail($destinatario, $asunto, $mensaje, $miCorreo);
    
    header("Location: contacto.php");
    exit();

?>

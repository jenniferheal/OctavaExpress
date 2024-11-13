<?php
require "funciones/conecta.php";
$con = conecta();

$id          = $_POST['id'];
$nombre      = $_POST['nombre'];

$is_file_uploaded = isset($_FILES['archivo']);

if (!empty($id)) {
    if ($is_file_uploaded) {
        $archivo_n = $_FILES['archivo']['name'];
        $archivo_tmp = $_FILES['archivo']['tmp_name'];

        if (!empty($archivo_tmp) && !empty($archivo_n)) {
            $arreglo = explode(".", $archivo_n);
            $len = count($arreglo);
            $pos = $len - 1;
            $ext = $arreglo[$pos];
            $dir = "fotos_promociones/";
            $file_enc = md5_file($archivo_tmp);

            $fileName1 = "$file_enc.$ext";
            move_uploaded_file($archivo_tmp, $dir . $fileName1);
        }
    }

    $sql = "UPDATE promociones SET nombre = ?";
    
    if ($is_file_uploaded && !empty($archivo_n)) {
        $sql .= ", archivo = ?";
    }

    $sql .= " WHERE id = ?";

    $stmt = $con->prepare($sql);
    if ($is_file_uploaded && !empty($archivo_n)) {
        $stmt->bind_param("ssi", $nombre, $fileName1, $id);
    } else {
        $stmt->bind_param("si", $nombre, $id);
    }

    $res = $stmt->execute();

    if (!$res) {
        exit("Error al actualizar en la base de datos: " . $stmt->error);
    }

    header("Location: promocionesListado.php");
} else {
    echo "ID no válido.";
}

$con->close();
?>
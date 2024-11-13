<?php
require "funciones/conecta.php";
$con = conecta();

$id          = $_POST['id'];
$nombre      = $_POST['nombre'];
$codigo      = $_POST['codigo'];
$descripcion = $_POST['descripcion'];
$costo       = $_POST['costo']; 
$stock       = $_POST['stock'];

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
            $dir = "fotos_productos/";
            $file_enc = md5_file($archivo_tmp);

            $fileName1 = "$file_enc.$ext";
            move_uploaded_file($archivo_tmp, $dir . $fileName1);
        }
    }

    $sql = "UPDATE productos SET nombre = '$nombre', codigo = '$codigo', descripcion = '$descripcion', costo = '$costo', stock = $stock";
    
    if ($is_file_uploaded && !empty($archivo_n)) {
        $sql .= ", archivo_n = '$archivo_n', archivo = '$fileName1'";
    }

    $sql .= " WHERE id = $id";

    $res = $con->query($sql);

    if (!$res) {
        exit("Error al actualizar en la base de datos: " . mysqli_error($con));
    }

    header("Location: productosListado.php");
} else {
    echo "ID no válido.";
}

$con->close();
?>

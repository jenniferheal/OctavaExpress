<?php
    session_start();
    require "funciones/conecta.php";
    $con = conecta();

    if (!isset($_REQUEST['productoId'])) {
        die('productoId no se ha establecido');
    }


    $id_producto = $_REQUEST['productoId'];
    $cantidad = $_REQUEST['cantidad_'];
    $id_cliente = $_SESSION['user_id'];

    $sql = "SELECT * FROM productos WHERE id = $id_producto";
    echo $sql;
    $res = $con->query($sql);
    if ($con->error) {
        echo $con->error; 
    }
    $num = $res->num_rows;
    $precio = 0;

    if ($num > 0) {
        $row = $res->fetch_assoc();
        $precio = $row['costo'];
    }

    // Validar si existe un pedido abierto
    $sql = "SELECT * FROM pedidos WHERE id_cliente = $id_cliente AND status = 0";
    $res = $con->query($sql);
    $num = $res->num_rows;

    if ($num == 0) {
        $fecha = date("Y-m-d H:i:s");
        $sql = "INSERT INTO pedidos (fecha, id_cliente) VALUES ('$fecha', $id_cliente)";
        $res = $con->query($sql);
        $id_pedido = $con->insert_id;
    } else {
        $row = $res->fetch_assoc();
        $id_pedido = $row['id'];
    }

    // Actualizar si el registro ya existe
    $sql = "SELECT * FROM pedidos_productos WHERE id_pedido = $id_pedido AND id_producto = $id_producto";
    $res = $con->query($sql);
    $num = $res->num_rows;

    if ($num > 0) {
        $row = $res->fetch_assoc();
        $cantidad = $cantidad + $row['cantidad'];
        $sql = "UPDATE pedidos_productos SET cantidad = $cantidad WHERE id_pedido = $id_pedido AND id_producto = $id_producto";
        $res = $con->query($sql);
    } else {
        $sql = "INSERT INTO pedidos_productos (id_pedido, id_producto, cantidad, precio) VALUES ($id_pedido, $id_producto, $cantidad, '$precio')";
        $res = $con->query($sql);
    }

    $sql = "SELECT * FROM pedidos_productos WHERE id_pedido = $id_pedido";
    $res = $con->query($sql);
    $num = $res->num_rows;

    if ($num > 0) {
        $total = 0;
        while ($row = $res->fetch_assoc()) {
            $total = $total + ($row['cantidad'] * $row['precio']);
        }
    }

    if ($num > 0) {
        echo "1"; // Producto agregado correctamente
    } else {
        echo "0"; // Producto no agregado
    }

?>


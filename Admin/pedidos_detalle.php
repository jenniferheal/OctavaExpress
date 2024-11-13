<?php
    session_start();

    if (!isset($_SESSION['nombreUser'])) {
        header("Location: index.php");
        exit(); 
    }

    $nombreUser = $_SESSION['nombreUser'];

    require "funciones/conecta.php";
    $con = conecta();

    $id= $_GET['id'];

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Detalle de Pedido</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
        }
        h1 {
            font-size: 24px;
        }
        table {
            width: 80%;
            margin: 0 auto;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid #ccc;
        }
        th, td {
            padding: 10px;
        }
        th {
            background-color: #f2f2f2;
        }

        .delete {
            background: red;
            border: none;
            color: white;
            cursor: pointer;
            border-radius: 10px;
            padding: px 18px;
        }

        .detalle_editar {
            background: rgb(236, 236, 236);
            border: none;
            color: black;
            cursor: pointer;
            border-radius: 10px;
            padding: px 18px;
        }

        #addProducto {
            background-color: #4caf50;
            color: white;
            border: none;
            padding: 12px 25px;
            margin-top: 20px;
            cursor: pointer;
            border-radius: 10px;
        }

        nav {
            background-color: #e0f7e0; 
            padding: 10px;
            text-align: center;
            position: fixed;
            width: 100%;
            top: 0;
            box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1);
            z-index: 1000;
            border-bottom-left-radius: 10px;
            border-bottom-right-radius: 10px;
            transition: background-color 0.3s ease;
        }

        nav a {
            color: #003300; 
            text-decoration: none;
            margin: 0 15px;
            font-weight: bold;
            padding: 8px 12px;
            border-radius: 5px;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        nav a:hover {
            background-color: #4caf50; 
            color: #fff; 
        }

        .botonRegresar {
            background-color: #f2f2f2; 
            color: #black; 
            border: none;
            padding: 4px 20px; 
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s ease;
        }

        .botonRegresar:hover {
            background-color: #e0f7ef;  
        }

    </style>

<script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>

<script>
    
    $(document).ready(function() {
    $.ajax({
        url: "pedidos_detalle_lista.php?id=" + <?php echo $id; ?>,
        method: "GET",
        dataType: "json",
        success: function(data) {
            var total = 0; // Variable para acumular el costo total

            // Iterar sobre los datos y agregar filas a la tabla
            data.forEach(function(pedido) {
                var id = pedido.id_producto;
                var nombre = pedido.nombre_producto;
                var cantidad = pedido.cantidad;
                var precio = pedido.precio;
                var subtotal = pedido.subtotal;
                
                total += subtotal; // Acumular el subtotal en el total

                var row = "<tr>";
                row += "<td>" + id + "</td>";
                row += "<td>" + nombre + "</td>";
                row += "<td>" + cantidad + "</td>";
                row += "<td>$" + precio + "</td>";
                row += "<td>$" + subtotal + "</td>";
                row += "</tr>";

                $("table tbody").append(row);
            });

            // Agregar una fila al final con el costo total
            var totalRow = "<tr>";
            totalRow += "<td colspan='4'>Total</td>";
            totalRow += "<td>$" + total + "</td>";
            totalRow += "</tr>";

            $("table tbody").append(totalRow);
        },
        error: function(xhr, status, error) {
            console.error("Error en la solicitud AJAX:", status, error);
        }
    });
});




</script>

</head>
<body>
    <nav>  
        <a href="bienvenido.php">Inicio</a>
        <a href="empleadosListado.php">Empleados</a>
        <a href="productosListado.php">Productos</a>
        <a href="promocionesListado.php">Promociones</a>
        <a href="pedidosListado.php">Pedidos</a>
        <a href="#">Bienvenid@ <?php echo $nombreUser; ?></a>
        <a href="cerrar_sesion.php">Cerrar Sesión</a>
    </nav>
    <br><br><br>

    <h1>DETALLE DE PEDIDO</h1>

    <table>
        <tr>
            <th>ID Producto</th>
            <th>Nombre</th>
            <th>Cantidad</th>
            <th>Costo</th>
            <th>Subtotal</th>

        </tr>

    </table>
    <br></br>
    <br><b1><a<button class='botonRegresar' id="botonRegresar" onclick="window.location.href='pedidosListado.php'">Regresar al listado</button></a></b1><br>

</body>
</html>

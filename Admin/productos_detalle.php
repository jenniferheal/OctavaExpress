<?php

    session_start();

    if (!isset($_SESSION['nombreUser'])) {
        header("Location: index.php");
        exit(); 
    }
    
    $nombreUser = $_SESSION['nombreUser'];

    require "funciones/conecta.php";
    $con = conecta();

    $id = $_GET['id'];

    $sql = "SELECT * FROM productos WHERE id = $id";
    $res = $con->query($sql);

    if ($res->num_rows > 0) {
        $producto = $res->fetch_assoc();

        $id          = $producto["id"];
        $nombre      = $producto["nombre"];
        $codigo      = $producto["codigo"];
        $descripcion = $producto["descripcion"];
        $costo       = $producto["costo"];
        $stock       = $producto["stock"];
        $status      = $producto["status"];
        $archivo     = $producto['archivo'];


        if ($status == 1){
            $status = "Activo";
        } else if ($status == 0) {
            $status = "Inactivo";
        }


    } else {
        echo "No se encontraron datos para el producto con el ID proporcionado.";
    }

    $con->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalle de Producto</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
        }
        
        t1 {
            font-size: 24px;
            padding: 10px;
            text-align: center;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 10px;
        }
       
        #Forma02 {
            width: 500px;
            height: 180px; 
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
            font-size: 24px;
            align-items: center;
            
        }

        b1 {
            font-size: 18px;
            color: #333;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        td {
            font-size: 16px;
            border: 1px solid #ccc;
            padding: 10px;
            background-color: #f2f2f2;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 10px;
            margin: 2px;
        }


        th.encapsulado {
            font-size: 16px;
            background-color: #e0f7e0;
            border: 1px solid #ccc;
            border-radius: 10px;
            margin: 2px;
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
                


    </style>
    
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

    <table id="Forma02">
        <t1>DETALLE DE PRODUCTO</t1>
        <tr>
            <th class="encapsulado">ID</th>
            <td><?php echo $id; ?></td>
        </tr>

        <tr>
            <th class="encapsulado">Nombre</th>
            <td><?php echo $nombre; ?></td>
        </tr>
        <tr>
            <th class="encapsulado">Codigo</th>
            <td><?php echo $codigo; ?></td>
        </tr>
        <tr>
            <th class="encapsulado">Descripcion</th>
            <td><?php echo $descripcion; ?></td>
        </tr>
        <tr>
            <th class="encapsulado">Costo</th>
            <td><?php echo $costo; ?></td>
        </tr>
        <tr>
            <th class="encapsulado">Stock</th>
            <td><?php echo $stock; ?></td>
        </tr>
        <tr>
            <th class="encapsulado">Status</th>
            <td><?php echo $status; ?></td>
        </tr>
        <tr>
            <th class="encapsulado">Foto</th>
            <td><img src="fotos_productos/<?php echo $archivo; ?>" alt="Imagen del producto" style="max-width: 120px; max-height: 130px; margin-bottom: 20px;"></td>
        </tr>

    </table>

    <br><b1><a<button class='botonRegresar' id="botonRegresar" onclick="window.location.href='productosListado.php'">Regresar al listado</button></a></b1><br>
</body>
</html>

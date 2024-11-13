<?php
    session_start();

    if (!isset($_SESSION['nombreUser'])) {
        header("Location: index.php");
        exit(); 
    }

    $nombre = $_SESSION['nombreUser'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenido</title>

    <style>
        body {
            margin: 0;
            font-family: 'Roboto', sans-serif; 
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

        #contenido {
            padding: 60px 20px 20px;
            text-align: center;
        }

        #mensajeBienvenidos {
            font-size: 32px; 
            font-family: 'Pacifico', cursive; 
            color: #333; 
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
        <a href="#">Bienvenid@ <?php echo $nombre; ?></a>
        <a href="cerrar_sesion.php">Cerrar Sesión</a>
    </nav>
    <br><br><br><br><br><br>
    <div id="contenido">
        <div id="mensajeBienvenidos">
            <p>Hola <?php echo $nombre; ?>, bienvenid@ al Sistema de Administración.</p>
        </div>
    </div>
</body>
</html>

<?php

    session_start();
    $isLoggedIn = isset($_SESSION['user_id']);

    require "funciones/conecta.php";
    $con = conecta();

    $productoId = isset($_GET['id']) ? $_GET['id'] : null;

    if (!$productoId) {
        header("Location: productos.php");
        exit();
    }

    $sql = "SELECT * FROM productos WHERE id = $productoId AND eliminado = 0";
    $result = $con->query($sql);

    $producto = null;

    if ($result->num_rows > 0) {
        $producto = $result->fetch_assoc();
    } else {
        header("Location: productos.php");
        exit();
    }

    $con->close();
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Octava Express</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"
        integrity="sha512-...." crossorigin="anonymous" referrerpolicy="no-referrer" />

    <style>
        body {
            margin: 0;
            font-family: 'Roboto', sans-serif;
            background-image: url('Logos/fondo5.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;
            color: #333;
        }

        nav {
            background-color: black;
            padding: 20px;
            text-align: center;
            position: fixed;
            width: 100%;
            top: 0;
            box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1);
            z-index: 1000;
            transition: background-color 0.3s ease;
        }

        .nav-item {
            display: inline-block;
        }

        #logo-container {
            display: inline-block;
            align-items: center;
            margin-right: 20px;
        }

        #logo-container img {
            width: 150px;
            height: auto;
            margin-right: 10px;
            vertical-align: middle;
        }

        nav a {
            color: white;
            text-decoration: none;
            margin: 0 15px;
            font-weight: bold;
            padding: 8px 12px;
            border-radius: 5px;
            transition: background-color 0.3s ease, color 0.3s ease, border-bottom 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        nav a:hover {
            background-color: white;
            color: black;
            border-bottom: 2px solid #333;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        nav.scrolled {
            background-color: #333;
        }

        #contenido {
            padding: 60px 20px 20px;
            text-align: center;
            background-color: #f8f8f8;
            border-radius: 10px;
        }

        #mensajeBienvenidos {
            font-size: 32px;
            font-family: 'Pacifico', cursive;
            color: #333;
            margin-bottom: 20px;
        }

        #detalle-producto-container {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top: 40px;
        }

        .producto {
            border: 1px solid #ddd;
            border-radius: 10px;
            padding: 20px;
            margin: 20px;
            text-align: center;
            max-width: 300px;
            background-color: #fff;
            color: #333;
            box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.1);
            font-family: 'Montserrat', sans-serif;
            transition: transform 0.3s ease;
        }

        .producto:hover {
            transform: scale(1.05);
        }

        .producto img {
            max-width: 100%;
            height: auto;
            border-radius: 10px;
            margin-bottom: 15px;
        }

        .producto-nombre {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .producto-info {
            font-size: 14px;
            margin-bottom: 10px;
        }

        .añadir-carrito {
            background-color: #f2f2f2;
            color: black;
            border: none;
            padding: 10px 20px;
            margin-top: 20px;
            cursor: pointer;
            border-radius: 10px;
            font-size: 14px;
            transition: background-color 0.3s ease;
        }

        .añadir-carrito:hover {
            background-color: #45a049;
            color: white;
        }

        .volver-btn {
            display: inline-block;
            text-decoration: none;
            background-color: #f2f2f2; 
            color: black; 
            padding: 8px 12px; 
            border-radius: 8px; 
            transition: background-color 0.3s ease;
            position: absolute;
            top: 20px;
            left: 20px;
        }

        .volver-btn i {
            margin-right: 5px;
            font-size: 14px; 
        }

        .volver-btn:hover {
            background-color: #ddd; 
        }

        input[type="number"] {
            width: 50px;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 5px;
            margin-top: 5px;
            font-size: 14px;
        }

        footer {
            background-color: #999;
            color: #fff;
            padding: 10px;
            text-align: center;
            position: fixed;
            width: 100%;
            bottom: 0;
        }

        footer a {
            color: #fff;
            text-decoration: none;
            margin: 0 10px;
            transition: color 0.3s ease;
        }

        footer a:hover {
            color: black;
        }

        #redes-sociales a i {
            font-size: 18px;
            margin: 0 10px;
        }



    </style>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap">

    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>


    <script>

        function agregarAlCarrito(productoId) {
                var cantidad = $('#cantidad_' + productoId).val();

                <?php
                    echo "var isLoggedIn = " . ($isLoggedIn ? "true" : "false") . ";";
                ?>
                if (isLoggedIn) {
                    $.ajax({
                        url: 'insertar_producto.php',
                        type: 'post',
                        dataType: 'text',
                        data: 'productoId=' + productoId + '&cantidad_=' + cantidad,
                        success: function (res) {
                            console.log(res);
                            if (res == "1") {
                                alert('Producto eliminado exitosamente!');
                                $('#cantidad' + productoId).val('1');
                            } else {
                                $('#mensaje').html('');
                            }
                        },
                        error: function () {
                            alert('Error: producto no encontrado...');
                        }
                    });
                } else {
                    alert('Debes iniciar sesión para agregar productos al carrito.');
                    window.location.href = 'login.php';
                }
            }

        function confirmLogout() {
            if (confirm("¿Seguro que desea cerrar sesión?")) {
                window.location.href = "logout.php";
            }
        }
        
        
    </script>

</head>

<body>
    <nav>
        <div id="logo-container" class="nav-item">
            <img src="Logos/OctavaBlanco.png" alt="Logo">
        </div>
        <a href="index.php" class="nav-item"><i class="fas fa-home"></i> Home</a>
        <a href="productos.php" class="nav-item"><i class="fas fa-box"></i> Productos</a>
        <a href="contacto.php" class="nav-item"><i class="fas fa-envelope"></i> Contacto</a>
        <a href="carrito1.php" class="nav-item"><i class="fas fa-shopping-cart"></i> Carrito</a>
        <?php
            if ($isLoggedIn) {
                echo '<a href="#" onclick="confirmLogout()" class="nav-item">Cerrar sesión</a>';
            } else {
                echo '<a href="login.php" class="nav-item">Iniciar sesión</a>';
            }
        ?>
    </nav>

    <br><br>

    <div id="detalle-producto-container">
        <div class="producto">
            <a href="productos.php" class="volver-btn"><i class="fas fa-arrow-left"></i></a>            
            <img src="Admin/fotos_productos/<?php echo $producto['archivo']; ?>" alt="<?php echo $producto['nombre']; ?>">
            <p class="producto-nombre"><?php echo $producto['nombre']; ?></p>
            <p class="producto-info">Código: <?php echo $producto['codigo']; ?></p>
            <p class="producto-info">Descripción: <?php echo $producto['descripcion']; ?></p>
            <p class="producto-info">Costo: $<?php echo $producto['costo']; ?></p>
            <input type="number" id="cantidad_<?php echo $producto['id']; ?>" value="1" min="1">            
            <button class="añadir-carrito" onclick="agregarAlCarrito(<?php echo $producto['id']; ?>)"><i class="fas fa-cart-plus"></i> Añadir al carrito</button>        
        </div>
    </div>

    <br><br><br><br>


</body>

<footer>
    <div id="terminos-condiciones">
    <a href="terminos_y_condiciones.php" style="font-size: 10px;">Términos y Condiciones    
        <?php echo date('Y'); ?> Octava Express. Todos los derechos reservados.
        <a href="https://www.facebook.com/OctavaExpress" target="_blank"><i class="fab fa-facebook"></i></a>
        <a href="https://twitter.com/OctavaExpress" target="_blank"><i class="fab fa-twitter"></i></a>
        <a href="https://www.instagram.com/OctavaExpress" target="_blank"><i class="fab fa-instagram"></i></a>
    </a>
    </div>
</footer>


</html>

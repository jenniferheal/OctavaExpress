<?php
    session_start();
    $isLoggedIn = isset($_SESSION['user_id']);

    require "funciones/conecta.php";
    $con = conecta();  

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Productos</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-...." crossorigin="anonymous" referrerpolicy="no-referrer" />

    <style>
        body {
            margin: 0;
            font-family: 'Roboto', sans-serif;
            background-image: url('Logos/fondo5.jpg'); 
            background-size: cover; 
            background-position: center; 
            background-repeat: no-repeat; 
            background-attachment: fixed;
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

        #FormaContacto {
            width: 320px;
            height: 350px;
            margin: 0 auto;
            background-color: #fff;
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
            font-size: 16px;
            text-align: center;
        }

        #FormaContacto t1 {
            font-size: 24px;
            font-family: 'Montserrat', sans-serif;
            color: #333;
            margin-bottom: 20px;
            display: block;
        }

        #FormaContacto input,
        #FormaContacto textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
            font-size: 14px;
            font-family: 'Roboto', sans-serif;
        }

        #FormaContacto textarea {
            resize: vertical;
            overflow: auto; 
        }

        .enviar {
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

        .enviar:hover {
            background-color: #45a049; 
            color: white;
        }

        .enviar i {
            margin-right: 5px; 
        }

        #mensaje {
            color: #333;
            margin-top: 10px;
            font-size: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        t1 {
            font-size: 24px;
            padding: 10px;
            text-align: center;
            display: flex;
            align-items: center;
            justify-content: center;
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
        function validar() {
            var nombre = document.FormaContacto.nombre.value;
            var correo = document.FormaContacto.correo.value;
            var comentario = document.FormaContacto.comentario.value;

            if (nombre === '' || correo === '' || comentario === '') {
                $('#mensaje').show();
                $('#mensaje').html('Faltan campos por llenar...');
                setTimeout(function () {
                    $('#mensaje').html('');
                    $('#mensaje').hide();
                }, 5000);
            } else {
                $('#mensaje').show();
                $('#mensaje').html('Gracias por tu mensaje, nos pondremos en contacto contigo pronto.');
                setTimeout(function () {
                    $('#mensaje').html('');
                    $('#mensaje').hide();
                }, 5000);

                document.FormaContacto.method = 'post';
                document.FormaContacto.action = 'enviar_correo.php'+ '?nombre=' + nombre + '&correo=' + correo + '&comentario=' + comentario;
                document.FormaContacto.submit();
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

    <br><br><br><br><br>
    <form name="FormaContacto" id="FormaContacto" enctype="multipart/form-data">
        <t1>Contáctanos...</t1>
        <input type="text" name="nombre" id="nombre" placeholder="Escribe tu nombre" /><br>
        <input type="text" name="correo" id="correo" placeholder="Escribe tu correo" /><br>
        <textarea type="text" name="comentario" id="comentario" placeholder="Escribe tu comentario"></textarea>
        <button class="enviar" onclick="validar(); return false;"><i class="fas fa-arrow-right"></i> Enviar</button><br>
        <div id="mensaje"></div>
    </form>

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

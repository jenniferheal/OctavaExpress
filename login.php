<?php
session_start();

if (isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit(); 
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>

    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        #Forma01 {
            width: 300px;
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
            text-align: center;
        }

        t1 {
            font-size: 24px;
            margin-bottom: 20px;
            color: #333;
            font-weight: bold;
        }

        input {
            width: 100%;
            padding: 10px;
            margin: 8px 0;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }

        #ingresar {
            background-color: #4caf50;
            color: white;
            border: none;
            padding: 10px 15px;
            margin-top: 20px;
            cursor: pointer;
            border-radius: 5px;
            font-size: 16px;
        }

        #ingresar:hover {
            background-color: #45a049;
        }

        #mensaje {
            color: red;
            margin-top: 10px;
            font-size: 16px;
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

    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <script>

    function validarUsuario(correo, pass) {
        
        var correo = $('#correo').val();
        var pass   = $('#pass').val();
        $.ajax({
            url: 'iniciar_sesion.php',
            type: 'post',
            data: { correo: correo, pass: pass },
            dataType: 'text',
            success: function(res) {
                console.log(res);
                if (res == 1) {
                    window.location.href = "index.php";
                } else {
                    $('#mensaje').html('Usuario y/o contraseña incorrectos. Intente nuevamente...');
                    setTimeout("$('#mensaje').html(''); $('#mensaje').hide();", 5000);
                }
            },
            error: function () {
                alert('Error: archivo no encontrado...');
            }
        });
    }
    
    function validar() {
        var correo = document.Forma01.correo.value;
        var pass = document.Forma01.pass.value;

        if (correo === '' || pass === '') {
            $('#mensaje').show();
            $('#mensaje').html('Faltan campos por llenar...');
            setTimeout("$('#mensaje').html(''); $('#mensaje').hide();", 5000);
        } else {
            validarUsuario(correo, pass);
        }
    }

    </script>
</head>
<body>
    <form name="Forma01" id="Forma01" enctype="multipart/form-data">
        <t1>Iniciar Sesión</t1>
        <input type="text" name="correo" id="correo" placeholder="Escribe tu correo" />
        <br>
        <input type="password" name="pass" id="pass" placeholder="Escribe tu contraseña" />
        <br>
        <button class="ingresar" id="ingresar" type="button" onclick="validar(); return false;">Ingresar</button>
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

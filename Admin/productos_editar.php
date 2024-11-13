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

        $nombre      = $producto["nombre"];
        $codigo      = $producto["codigo"];
        $descripcion = $producto["descripcion"];
        $costo       = $producto["costo"];
        $stock       = $producto["stock"];
        $archivo     = $producto['archivo'];

    } else {
        echo "No se encontró el producto con el ID proporcionado.";
    }

    $con->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edición de productos</title>

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
        }
       
        #Forma01 {
            width: 30%;
            margin: 0 auto;
            background-color: #fff;
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
            font-size: 24px;
            text-align: center;
        }

        #Forma01 label {
            font-size: 18px;
            color: #333;
            display: inline-block;
            width: 30%; 
            text-align: right;
            margin-right: 5%; 
            margin-bottom: 10px;
        }

        #Forma01 input {
            width: 50%; 
            padding: 8px;
            margin-bottom: 10px;
        }

        b1 {
            font-size: 18px;
            color: #333;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        #actualizar {
            background-color: #4caf50;
            color: white;
            border: none;
            padding: 8px 15px;
            margin-top: 20px;
            cursor: pointer;
            border-radius: 10px;
            margin: 0 auto; 
        }

        #mensaje {
            color: red;
            margin-top: 10px;
            font-size: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
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

    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <script>

    function validar() {
        var nombre = document.Forma01.nombre.value;
        var codigo = document.Forma01.codigo.value;
        var descripcion = document.Forma01.descripcion.value;
        var costo = document.Forma01.costo.value;
        var stock = document.Forma01.stock.value;
        var archivo = document.Forma01.archivo.value;
        var extensionesPermitidas = /(.jpg|.jpeg|.png)$/i;

        if (nombre === '' || codigo === '' || descripcion === '' || costo === '' || stock === '0') {
            $('#mensaje').show();
            $('#mensaje').html('Faltan campos por llenar...');
            setTimeout("$('#mensaje').html(''); $('#mensaje').hide();", 5000);
        } else if (archivo !== '' && !extensionesPermitidas.exec(archivo)) {
            $('#mensaje').show();
            $('#mensaje').html('Formato de imagen no permitido. Utilice formatos JPEG o PNG.');
            setTimeout("$('#mensaje').html(''); $('#mensaje').hide();", 5000);
        } else {
            document.Forma01.method = 'post';
            document.Forma01.action = 'productos_actualizar.php';
            document.Forma01.submit();
        }
    }


    function codigoExistente(codigo) {
    
        var codigo = $('#codigo').val();
        $.ajax({
            url: 'verificarCodigo.php',
            type: 'post',
            dataType: 'text',
            data: 'codigo=' + codigo,
            success: function (res) {
                console.log(res);
                if (res == "1") {
                    $('#mensaje').html('El codigo ' + codigo + ' ya existe.');
                    $('#codigo').val('');
                    setTimeout(function () {
                        $('#mensaje').html('');
                    }, 5000);
                } else {
                    $('#mensaje').html('');
                }
            },
            error: function () {
                alert('Error: archivo no encontrado...');
            }
        });
    }

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

    <form name="Forma01" id="Forma01" enctype="multipart/form-data">
        <t1>EDICIÓN DE PRODUCTOS</t1><br>
        <input type="hidden" name="id" value="<?php echo $id; ?>"> 
        <label for="nombre">Nombre:</label>
        <input value="<?php echo $nombre; ?>" type="text" name="nombre" id="nombre" placeholder="Escribe el nombre"/> <br>
        
        <label for="codigo">Codigo:</label>
        <input value="<?php echo $codigo; ?>" type="text" name="codigo" id="codigo" placeholder="Escribe el codigo" onblur="codigoExistente(codigo)" /><br>
        
        <label for="descripcion">Descripcion:</label>
        <input value="<?php echo $descripcion; ?>" type="text" name="descripcion" id="descripcion" placeholder="Escribe la descripcion" /><br>
        
        <label for="costo">Costo:</label>
        <input value="<?php echo $costo; ?>" type="text" name="costo" id="costo" placeholder="Escribe el costo" />
        
        <label for="stock">Stock:</label>
        <input value="<?php echo $stock; ?>" type="text" name="stock" id="stock" placeholder="Escribe el stock" />
        <br>
        <input type="file" name="archivo" id="archivo" accept="image/*" />
        <br>
        <button class="actualizar" id="actualizar" type="submit" onclick="validar(); return false;">Actualizar</button>
        <div id="mensaje"></div>
    </form>
    
    <br><b1><a<button class='botonRegresar' id="botonRegresar" onclick="window.location.href='productosListado.php'">Regresar al listado</button></a></b1><br>

</body>
</html>
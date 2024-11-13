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
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap">
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

        h1 {
            font-size: 24px;
            text-align: center;
            font-family: 'Montserrat', sans-serif;
        }

        table {
            width: 85%;
            margin: 20px auto;
            border-collapse: separate;
            border-spacing: 2px;
            border-radius: 10px;
            overflow: hidden;
            background-color: transparent;
            font-size: 18px;
        }

        td {
            border: 1px solid #ccc;
            padding: 10px;
            text-align: center;
            background-color: #fff;
            
        }

        th {
            border: 1px solid #ccc;
            padding: 15px;
            text-align: center;
            background-color: #999; 
            color: #fff;
        }

    

        
        table th:first-child {
            border-top-left-radius: 10px;
        }

        table th:last-child{
            border-top-right-radius: 10px;
        }

     
        table tr:last-child td:first-child {
            border-bottom-left-radius: 10px;
        }

        table tr:last-child td:last-child {
            border-bottom-right-radius: 10px;
        }

        table td:nth-child(2) {
            width: 10%;
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

        .continuar-container {
            display: flex;
            justify-content: center;
        }

        .continuar{
            background-color: #f2f2f2;
            color: black;
            border: none;
            padding: 15px 30px; 
            margin: 20px; 
            cursor: pointer;
            border-radius: 10px;
            font-size: 18px;
            transition: background-color 0.3s ease;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1); 
        }

        .continuar:hover {
            background-color: #45a049; 
            color: white;
        }

        .delete {
            background-color: #f2f2f2;
            color: black;
            border: none;
            padding: 10px 10px;
            cursor: pointer;
            border-radius: 15px;
            font-size: 18px;
            transition: background-color 0.3s ease;
        }

        .delete:hover {
            background-color: red; 
            color: white;
        }

        input[type="number"] {
            width: 50px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            margin-top: 5px;
            font-size: 18px;
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
        function confirmLogout() {
            if (confirm("¿Seguro que desea cerrar sesión?")) {
                window.location.href = "logout.php";
            }
        }

        $(document).ready(function() {
        $.ajax({
            url: "pedidos_lista.php",
            method: "GET",
            dataType: "json",
            success: function(data) {
                var total = 0;
                data.forEach(function(pedido) {
                    var id = pedido.id_producto;
                    var nombre = pedido.nombre;
                    var cantidad = pedido.cantidad;
                    var precio = pedido.precio;
                    var subtotal = pedido.subtotal;
                    total += subtotal;
                    var row = "<tr>";
                    row += "<td>" + nombre + "</td>";
                    row += '<td><input type="number" class="cantidad" id="cantidad_' + id + '" value="' + cantidad + '" min="1"></td>';
                    row += "<td>$" + precio + "</td>";
                    row += "<td>$" + subtotal + "</td>";
                    row += "<td><button class='delete' onclick='eliminarProducto(" + id + ")'>Eliminar</button></td>";
                    row += "</tr>";

                    $("table tbody").append(row);
                });
                var totalRow = "<tr>";
                totalRow += "<td colspan='3'>Total</td>";
                totalRow += "<td>$" + total + "</td>";
                totalRow += "<td></td>";
                totalRow += "</tr>";

                $("table tbody").append(totalRow);

                
                $(".cantidad").change(function() {
                    var id = $(this).attr('id');
                    var productId = id.split('_')[1];
                    console.log('ID del input:', id);
                    console.log('ID del producto:', productId);
                    var cantidad = $(this).val();
                    var precio = parseFloat($(this).closest('tr').find('td:nth-child(3)').text().substring(1)); 
                    var subtotal = cantidad * precio;
                    $(this).closest('tr').find('td:nth-child(4)').text("$" + subtotal.toFixed(2)); 

                    var total = 0;
                    $("table tbody tr td:nth-child(4)").each(function() {
                        total += parseFloat($(this).text().substring(1)); 
                    });
                    $("table tbody tr:last-child td:nth-child(2)").text("$" + total.toFixed(2)); 
                    actualizarCantidad(productId, $(this).val());
                });
                },
            });
        });
    
        function actualizarCantidad(id, cantidad) {
            console.log('Actualizando cantidad:', id, cantidad);

            $.ajax({
                url: "actualizar_cantidad.php",
                type: "POST",
                data: { id: id, cantidad: cantidad },
                dataType: "json",
                success: function (response) {
                    console.log('Respuesta del servidor:', response);
                    
                },
                error: function (xhr, status, error) {
                    console.error('Error en la solicitud Ajax:', status, error);
                    alert('Error al actualizar la cantidad en la base de datos.');
                }
            });
        }


    function eliminarProducto(id) {
        if (confirm("¿Seguro que desea eliminar este producto de su pedido?")) {
            $.ajax({
                url: "pedidos_elimina.php?id=" + id,
                type: "POST",
                dataType: "text",
                success: function(res){
                    location.reload();
                }, error: function(){
                    alert('Error archivo no encontrado...');
                }
            });
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

    <br><br><br><br>

    <table>
        <tr>
            <th>Producto</th>
            <th>Cantidad</th>
            <th>Costo Unitario</th>
            <th>Subtotal</th>
            <th>Eliminar</th>
        </tr>
    </table>
    <div class="continuar-container">
        <button class="continuar" id="continuar" onclick='window.location.href="carrito2.php"'>Continuar</button>
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
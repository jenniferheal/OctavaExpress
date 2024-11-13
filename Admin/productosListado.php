<?php
    session_start();

    if (!isset($_SESSION['nombreUser'])) {
        header("Location: index.php");
        exit(); 
    }

    $nombreUser = $_SESSION['nombreUser'];
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>PRODUCTOS</title>
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

    </style>

<script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
<script>
    
    function detalleProducto(id) {
        window.location.href = "productos_detalle.php?id=" + id;
    }

    function editarProducto(id) {
        window.location.href = "productos_editar.php?id=" + id;
    }


    $(document).ready(function() {
        $.ajax({
            url: "productos_lista.php",
            method: "GET",
            dataType: "json",
            success: function(data) {

                data.forEach(function(producto) {
                    var id = producto.id;
                    var nombre = producto.nombre;
                    var codigo = producto.codigo;
                    var costo = producto.costo;
                    var stock = producto.stock;
                    
                    var row = "<tr>";
                    row += "<td>" + id + "</td>";
                    row += "<td>" + nombre + "</td>";
                    row += "<td>" + codigo + "</td>";
                    row += "<td>" + costo+ "</td>";
                    row += "<td>" + stock+ "</td>";
                    row += "<td><button class='detalle_editar' onclick='detalleProducto(" + id + ")'>Ver detalle</button></td>";
                    row += "<td><button class='detalle_editar' onclick='editarProducto(" + id + ")'>Editar</button></td>";
                    row += "<td><button class='delete' onclick='eliminarProducto(" + id + ")'>Eliminar</button></td>";
                    row += "</tr>";

                    $("table tbody").append(row);
                });
            },
            
        });
    });

    function eliminarProducto(id) {
        if (confirm("¿Seguro que desea eliminar este producto de la lista?")) {
            $.ajax({
                url: "productos_elimina.php?id=" + id,
                type: "POST",
                dataType: "text",
                success: function(res){
                    console.log(res);
                    //location.reload();
                    $('#mensaje').show();
                    
                    if(res == 1){
                        alert('Producto eliminado exitosamente!');
                    }else{
                        alert('Error al eliminar el producto...');
                    }
                    setTimeout("$('#mensaje').html(''); $('#mensaje').hide();", 3000);
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
        <a href="bienvenido.php">Inicio</a>
        <a href="empleadosListado.php">Empleados</a>
        <a href="productosListado.php">Productos</a>
        <a href="promocionesListado.php">Promociones</a>
        <a href="pedidosListado.php">Pedidos</a>
        <a href="#">Bienvenid@ <?php echo $nombreUser; ?></a>
        <a href="cerrar_sesion.php">Cerrar Sesión</a>
    </nav>
    <br><br><br>

    <h1>LISTA DE PRODUCTOS</h1>

    <table>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Codigo</th>
            <th>Costo</th>
            <th>Stock</th>
            <th>Detalle</th>
            <th>Editar</th>
            <th>Eliminar</th>
        </tr>

    </table>

    <button class="addProducto" id="addProducto" onclick='window.location.href="productos_alta.php"'>Nuevo registro</button>

    <br></br>
    <div id="mensaje" style="display: none;"></div>

</body>
</html>

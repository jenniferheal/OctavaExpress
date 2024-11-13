<?php
    session_start();

    if (!isset($_SESSION['nombreUser'])) {
        header("Location: index.php");
        exit(); 
    }

    $nombre = $_SESSION['nombreUser'];

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>B6. Adjuntar Archivo</title>
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

        #addEmpleado {
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
    
    function detalleEmpleado(id) {
        window.location.href = "empleados_detalle.php?id=" + id;
    }

    function editarEmpleado(id) {
        window.location.href = "empleados_editar.php?id=" + id;
    }


    $(document).ready(function() {
        $.ajax({
            url: "empleados_lista.php",
            method: "GET",
            dataType: "json",
            success: function(data) {

                data.forEach(function(empleado) {
                    var id = empleado.id;
                    var correo = empleado.correo;
                    var nombreCompleto = empleado.nombreCompleto;
                    if (empleado.rol == 1){
                        rol = "Gerente";
                    } else if (empleado.rol == 2) {
                        rol = "Ejecutivo";
                    }
                    
                    var row = "<tr>";
                    row += "<td>" + id + "</td>";
                    row += "<td>" + correo + "</td>";
                    row += "<td>" + nombreCompleto + "</td>";
                    row += "<td>" + rol + "</td>";
                    row += "<td><button class='detalle_editar' onclick='detalleEmpleado(" + id + ")'>Ver detalle</button></td>";
                    row += "<td><button class='detalle_editar' onclick='editarEmpleado(" + id + ")'>Editar</button></td>";
                    row += "<td><button class='delete' onclick='eliminarEmpleado(" + id + ")'>Eliminar</button></td>";
                    row += "</tr>";

                    $("table tbody").append(row);
                });
            },
            
        });
    });

    function eliminarEmpleado(id) {
        if (confirm("¿Seguro que desea eliminar a este empleado de la lista?")) {
            $.ajax({
                url: "empleados_elimina.php?id=" + id,
                type: "POST",
                dataType: "text",
                success: function(res){
                    console.log(res);
                    //location.reload();
                    $('#mensaje').show();
                    
                    if(res == 1){
                        alert('Empleado eliminado exitosamente!');
                        //$('#mensaje').html('Empleado eliminado exitosamente!');
                    }else{
                        alert('Error al eliminar el empleado...');
                        //$('#mensaje').html('Error al eliminar el empleado...');
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
        <a href="#">Bienvenid@ <?php echo $nombre; ?></a>
        <a href="cerrar_sesion.php">Cerrar Sesión</a>
    </nav>

    <br><br><br>
    
    <h1>LISTA DE EMPLEADOS</h1>

    <table>
        <tr>
            <th>ID</th>
            <th>Correo</th>
            <th>Nombre completo</th>
            <th>Rol</th>
            <th>Detalle</th>
            <th>Editar</th>
            <th>Eliminar</th>
        </tr>

    </table>

    <button class="addEmpleado" id="addEmpleado" onclick='window.location.href="empleados_alta.php"'>Nuevo registro</button>

    <br></br>
    <div id="mensaje" style="display: none;"></div>

</body>
</html>

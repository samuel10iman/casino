<?php
session_start();
include('../conexion.php'); // Ajusta la ruta según la ubicación de tu archivo conexion.php

// Obtener todas las sucursales
$sucursales_query = "SELECT Sucursal_ID, Ubicacion FROM Sucursal";
$sucursales_result = mysqli_query($enlace, $sucursales_query);

// Obtener todos los clientes
$clientes_query = "SELECT Cliente_ID, Nombres, Apellidos FROM Cliente";
$clientes_result = mysqli_query($enlace, $clientes_query);

// Obtener todos los empleados del personal para seleccionar el crupier
$empleados_query = "SELECT Personal_ID, Nombre FROM Personal";
$empleados_result = mysqli_query($enlace, $empleados_query);

$mensaje_exito = isset($_SESSION['mensaje_exito']) ? $_SESSION['mensaje_exito'] : '';
unset($_SESSION['mensaje_exito']);

$mensaje_error = isset($_SESSION['mensaje_error']) ? $_SESSION['mensaje_error'] : '';
unset($_SESSION['mensaje_error']);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Juego</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        form {
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 10px;
            background-color: #f9f9f9;
        }

        label {
            display: block;
            margin-bottom: 10px;
        }

        select, input {
            width: 100%;
            padding: 8px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .button {
            display: inline-block;
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
            text-align: center;
            text-decoration: none;
            outline: none;
            color: #fff;
            background-color: #4CAF50;
            border: none;
            border-radius: 15px;
            box-shadow: 0 9px #999;
            margin-right: 10px;
        }

        .button:hover {
            background-color: #3e8e41;
        }

        .button:active {
            background-color: #3e8e41;
            box-shadow: 0 5px #666;
            transform: translateY(4px);
        }

        .error-message {
            color: red;
            font-weight: bold;
        }
    </style>
</head>
<body>

<h1>Agregar Juego</h1>

<?php if ($mensaje_exito): ?>
    <p style="color: green;"><?php echo $mensaje_exito; ?></p>
<?php endif; ?>

<?php if ($mensaje_error): ?>
    <p class="error-message"><?php echo $mensaje_error; ?></p>
<?php endif; ?>

<a href="index.php" class="button">Volver a index.php</a>

<form id="agregarJuegoForm" method="post" action="procesar_agregar_juego.php">
    <label for="tipoJuego">Tipo de Juego:</label>
    <select name="tipoJuego" id="tipoJuego" onchange="showFields(this.value)">
        <option value="maquina">Juego de Máquina</option>
        <option value="mesa">Juego de Mesa</option>
    </select>

    <div id="sucursalField" style="display: none;">
        <label for="sucursal">Seleccione una sucursal:</label>
        <select name="sucursal" id="sucursal">
            <option value="">Seleccione una sucursal</option>
            <?php while ($row = mysqli_fetch_assoc($sucursales_result)): ?>
                <option value="<?php echo $row['Sucursal_ID']; ?>"><?php echo $row['Ubicacion']; ?></option>
            <?php endwhile; ?>
        </select>
    </div>

    <label for="nombreJuego">Nombre del Juego:</label>
    <input type="text" name="nombreJuego" id="nombreJuego" required>

    <div id="clienteField" style="display: none;">
        <label for="cliente">Seleccione un cliente:</label>
        <select name="cliente" id="cliente">
            <option value="">Seleccione un cliente</option>
            <?php while ($row = mysqli_fetch_assoc($clientes_result)): ?>
                <option value="<?php echo $row['Cliente_ID']; ?>"><?php echo $row['Nombres'] . ' ' . $row['Apellidos']; ?></option>
            <?php endwhile; ?>
        </select>
    </div>

    <div id="numeroMesaField" style="display: none;">
        <label for="numeroMesa">Número de Mesa:</label>
        <input type="text" name="numeroMesa" id="numeroMesa">
    </div>

    <div id="crupierField" style="display: none;">
        <label for="crupier">Seleccione un crupier:</label>
        <select name="crupier" id="crupier">
            <option value="">Seleccione un crupier</option>
            <?php while ($row = mysqli_fetch_assoc($empleados_result)): ?>
                <option value="<?php echo $row['Personal_ID']; ?>"><?php echo $row['Nombre']; ?></option>
            <?php endwhile; ?>
        </select>
    </div>

    <button type="submit" class="button">Agregar Juego</button>
</form>

<script>
    function showFields(value) {
        var sucursalField = document.getElementById('sucursalField');
        var clienteField = document.getElementById('clienteField');
        var numeroMesaField = document.getElementById('numeroMesaField');
        var crupierField = document.getElementById('crupierField');

        if (value === 'maquina') {
            sucursalField.style.display = 'block';
            clienteField.style.display = 'block';
            numeroMesaField.style.display = 'none';
            crupierField.style.display = 'none';
        } else if (value === 'mesa') {
            sucursalField.style.display = 'block';
            clienteField.style.display = 'none';
            numeroMesaField.style.display = 'block';
            crupierField.style.display = 'block';
        }
    }
</script>

</body>
</html>

<?php
mysqli_close($enlace);
?>

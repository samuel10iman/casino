<?php
include('../conexion.php'); // Asegúrate de incluir tu archivo de conexión

// Consulta para obtener todas las sucursales
$query = "SELECT Sucursal_ID, Ubicacion FROM Sucursal";
$result = mysqli_query($enlace, $query);

if (!$result) {
    die("Consulta a la base de datos fallida: " . mysqli_error($enlace));
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buscar Cliente</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }

        h1 {
            color: #333;
            text-align: center;
        }

        form {
            max-width: 400px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        label {
            display: block;
            margin-bottom: 10px;
            font-weight: bold;
        }

        select, input[type="submit"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        input[type="submit"] {
            background-color: #28a745;
            color: white;
            border: none;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #218838;
        }

        .footer {
            text-align: center;
            margin-top: 20px;
        }

        .footer a {
            color: #007bff;
            text-decoration: none;
        }

        .footer a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <h1>Buscar Cliente por Sucursal</h1>
    <form action="buscarClienteResultado.php" method="post">
        <label for="sucursal">Selecciona una Sucursal:</label>
        <select name="sucursal" id="sucursal">
            <?php
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<option value='" . $row['Sucursal_ID'] . "'>" . $row['Ubicacion'] . "</option>";
            }
            ?>
        </select>
        <input type="submit" value="Buscar">
    </form>
    <div class="footer">
        <a href="index.php">Volver a la página principal</a>
    </div>
</body>
</html>

<?php
// Liberar el resultado de la consulta
mysqli_free_result($result);

// Cerrar la conexión a la base de datos
mysqli_close($enlace);
?>

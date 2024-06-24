<?php
include('../conexion.php'); // Asegúrate de incluir tu archivo de conexión

// Consulta para obtener todos los proveedores y sus teléfonos
$query = "SELECT p.RUC, p.Nombre, p.Tipo_Empresa, p.Ubicacion, p.Anio_Fin, pt.Telefono 
          FROM Proveedor p 
          LEFT JOIN proveedor_telefono pt ON p.RUC = pt.RUC";

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
    <title>Buscar Proveedor</title>
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

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table th, table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        table th {
            background-color: #f2f2f2;
        }

        .delete-button {
            background-color: #dc3545;
            color: white;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
        }

        .delete-button:hover {
            background-color: #c82333;
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
    <h1>Lista de Proveedores</h1>

    <table>
        <thead>
            <tr>
                <th>RUC</th>
                <th>Nombre</th>
                <th>Tipo de Empresa</th>
                <th>Ubicación</th>
                <th>Año de Fin</th>
                <th>Teléfono</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>" . $row['RUC'] . "</td>";
                echo "<td>" . $row['Nombre'] . "</td>";
                echo "<td>" . $row['Tipo_Empresa'] . "</td>";
                echo "<td>" . $row['Ubicacion'] . "</td>";
                echo "<td>" . $row['Anio_Fin'] . "</td>";
                echo "<td>" . $row['Telefono'] . "</td>";
                echo "<td><button class='delete-button' onclick='eliminarProveedor(\"" . $row['RUC'] . "\")'>Eliminar</button></td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>

    <div class="footer">
        <a href="index.php">Volver a la página principal</a>
    </div>

    <script>
        function eliminarProveedor(ruc) {
            if (confirm('¿Estás seguro de que quieres eliminar este proveedor?')) {
                // Redireccionar a la página de eliminación con el RUC del proveedor
                window.location.href = 'eliminarProveedor.php?ruc=' + ruc;
            }
        }
    </script>
</body>
</html>

<?php
// Liberar el resultado de la consulta
mysqli_free_result($result);

// Cerrar la conexión a la base de datos
mysqli_close($enlace);
?>

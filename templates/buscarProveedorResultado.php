<?php
include('../conexion.php'); // Asegúrate de incluir tu archivo de conexión

// Obtener el ID de la sucursal seleccionada del formulario
$sucursal_id = $_POST['sucursal'];

// Consulta para obtener los clientes de la sucursal seleccionada y sus correos y teléfonos
$query = "
    SELECT 
        Proveedor.ID, 
        Proveedor.Nombres, 
        Proveedor.Apellidos, 
        Proveedor.Tipo_Empresa, 
        Proveeedor.Direccion,
        Proveedor.RUC
        Proveedor.Edad,
        Proveedor.Teléfono, 
        GROUP_CONCAT(DISTINCT Proveedor_Correo.Correo SEPARATOR ', ') AS Correos,
        GROUP_CONCAT(DISTINCT Proveedor_Telefono.Telefono SEPARATOR ', ') AS Telefonos,
        GROUP_CONCAT(DISTINCT CONCAT(Juego_Mesa.Nombre, ' (Mesa ', Juego_Mesa.Numero_Mesa, ')') SEPARATOR ', ') AS Mesas
    FROM Proveedor
    LEFT JOIN Proveedor_Correo ON Proveedor.Proveedor_ID = Proveedor_Correo.Proveedor_ID
    LEFT JOIN Proveedpr_Telefono ON Proveedor.Proveedor_ID = Proveedor_Telefono.Proveedor_ID
    WHERE Proveedor.Empresa_ID = ?
";

// Aplicar filtros según los campos proporcionados en el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Filtrar por nombres que comienzan con cierta letra
    if (!empty($_POST["letra"])) {
        $letra = mysqli_real_escape_string($enlace, $_POST["letra"]);
        $query .= " AND Proveedor.Nombres LIKE '$letra%'";
    }

    // Filtrar por rango de edad
    if (!empty($_POST["edad_min"])) {
        $edad_min = mysqli_real_escape_string($enlace, $_POST["edad_min"]);
        $query .= " AND Proveedor.Edad >= $edad_min";
    }
    if (!empty($_POST["edad_max"])) {
        $edad_max = mysqli_real_escape_string($enlace, $_POST["edad_max"]);
        $query .= " AND Proveedor.Edad <= $edad_max";
    }
}

$query .= "
    GROUP BY Proveedor.Proveedor_ID, Proveedor.Nombres, Proveedor.Apellidos, Proveedor.Direccion, Proveedor.RUC, Proveedor.Edad, Proveedor.Empresa_ID, Proovedor.Telefono
";

$stmt = mysqli_prepare($enlace, $query);
mysqli_stmt_bind_param($stmt, 'i', $sucursal_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if (!$result) {
    die("Consulta a la base de datos fallida: " . mysqli_error($enlace));
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultados de Búsqueda</title>
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
            margin-bottom: 20px;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
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

        .form-group {
            margin-bottom: 10px;
        }

        .form-group label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .form-group input[type=text], 
        .form-group input[type=number] {
            width: 100%;
            padding: 8px;
            box-sizing: border-box;
        }

        .form-group input[type=submit] {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
        }

        .form-group input[type=submit]:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <h1>Resultados de Búsqueda</h1>
    <div class="form-container">
        <form method="post">
            <div class="form-group">
                <label for="letra">Buscar por nombre que empiece con:</label>
                <input type="text" id="letra" name="letra" placeholder="Escribe una letra">
            </div>
            <div class="form-group">
                <label for="edad_min">Edad mínima:</label>
                <input type="number" id="edad_min" name="edad_min" placeholder="Edad mínima">
            </div>
            <div class="form-group">
                <label for="edad_max">Edad máxima:</label>
                <input type="number" id="edad_max" name="edad_max" placeholder="Edad máxima">
            </div>
            <input type="hidden" name="empresa" value="<?php echo $empresa_id; ?>">
            <div class="form-group">
                <input type="submit" value="Buscar">
            </div>
        </form>
    </div>

    <?php
    if (mysqli_num_rows($result) > 0) {
        echo "<table>";
        echo "<tr>
                <th>Proveedor ID</th>
                <th>Nombres</th>
                <th>Apellidos</th>
                <th>Dirección</th>
                <th>RUC</th>
                <th>Edad</th>
                <th>Teléfonos</th>
              </tr>";
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>" . $row['Proveedor_ID'] . "</td>";
            echo "<td>" . $row['Nombres'] . "</td>";
            echo "<td>" . $row['Apellidos'] . "</td>";
            echo "<td>" . $row['Direccion'] . "</td>";
            echo "<td>" . $row['RUC'] . "</td>";
            echo "<td>" . $row['Edad'] . "</td>";
            echo "<td>" . $row['Correos'] . "</td>";
            echo "<td>" . $row['Telefonos'] . "</td>";
            // Enlace para eliminar Proveedor
            echo "<td><a href='eliminarproveedor.php?id=" . $row['Proveedor_ID'] . "'><i class='fas fa-trash-alt'></i> Eliminar</a></td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "<p>No se encontraron resultados para la empresaa seleccionada.</p>";
    }

    // Liberar el resultado de la consulta
    mysqli_free_result($result);

    // Cerrar la conexión a la base de datos
    mysqli_close($enlace);
    ?>

    <div class="footer">
        <a href="buscarProveedor.php">Volver a la búsqueda</a>
    </div>
</body>
</html>
<?php
include('../conexion.php'); // Asegúrate de incluir tu archivo de conexión

// Obtener el ID de la sucursal seleccionada del formulario
$sucursal_id = $_POST['sucursal'];

// Consulta básica para obtener el personal de la sucursal seleccionada
$query = "
    SELECT 
        p.Personal_ID,
        p.Nombre, 
        p.Nacionalidad, 
        p.Fecha_Contrato, 
        p.Fecha_Fin_Contrato, 
        p.Horario, 
        p.Sueldo, 
        p.Tipo_Contrato,
        t.Telefono,
        c.Correo
    FROM Personal p
    LEFT JOIN personal_telefono t ON p.Personal_ID = t.Personal_ID
    LEFT JOIN personal_correo c ON p.Personal_ID = c.Personal_ID
    WHERE p.Sucursal_ID = ?
";

// Aplicar filtros según los campos proporcionados en el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Filtrar por nombres que comienzan con cierta letra
    if (!empty($_POST["letra"])) {
        $letra = mysqli_real_escape_string($enlace, $_POST["letra"]);
        $query .= " AND Nombre LIKE '$letra%'";
    }
}

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

    <?php if (mysqli_num_rows($result) > 0): ?>
        <table>
            <tr>
                <th>Nombre</th>
                <th>Nacionalidad</th>
                <th>Fecha de Contrato</th>
                <th>Fecha de Fin de Contrato</th>
                <th>Horario</th>
                <th>Sueldo</th>
                <th>Tipo de Contrato</th>
                <th>Teléfono</th>
                <th>Correo</th>
                <th>Acciones</th> <!-- Agregado -->
            </tr>
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['Nombre']); ?></td>
                    <td><?php echo htmlspecialchars($row['Nacionalidad']); ?></td>
                    <td><?php echo htmlspecialchars($row['Fecha_Contrato']); ?></td>
                    <td><?php echo htmlspecialchars($row['Fecha_Fin_Contrato']); ?></td>
                    <td><?php echo htmlspecialchars($row['Horario']); ?></td>
                    <td><?php echo htmlspecialchars($row['Sueldo']); ?></td>
                    <td><?php echo htmlspecialchars($row['Tipo_Contrato']); ?></td>
                    <td><?php echo htmlspecialchars($row['Telefono']); ?></td> <!-- Agregado -->
                    <td><?php echo htmlspecialchars($row['Correo']); ?></td> <!-- Agregado -->
                    <td> <!-- Agregado -->
                        <a href="eliminarPersonal.php?id=<?php echo $row['Personal_ID']; ?>" onclick="return confirm('¿Estás seguro de que deseas eliminar este registro?');">Eliminar</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </table>
    <?php else: ?>
        <p>No se encontró personal en la sucursal seleccionada.</p>
    <?php endif; ?>
    <div class="footer">
        <a href="buscarPersonal.php">Volver a la búsqueda</a>
    </div>
</body>
</html>

<?php
// Liberar el resultado de la consulta
mysqli_free_result($result);

// Cerrar la conexión a la base de datos
mysqli_stmt_close($stmt);
mysqli_close($enlace);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administración Juegos</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            text-align: center; /* Centrar el contenido */
        }

        h1 {
            text-align: center;
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
            margin-top: 20px; /* Separación desde arriba */
        }

        .button:hover {
            background-color: #3e8e41;
        }

        .button:active {
            background-color: #3e8e41;
            box-shadow: 0 5px #666;
            transform: translateY(4px);
        }

        select {
            padding: 8px;
            font-size: 16px;
        }

        table {
            border-collapse: collapse;
            width: 100%;
            margin-top: 20px;
        }

        table, th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        .footer {
            text-align: center;
            margin-top: 20px;
        }

        .footer .button {
            background-color: #4CAF50;
            color: #fff;
            margin-right: 10px;
        }

        .footer .button:hover {
            background-color: #3e8e41;
        }

        .footer .button:active {
            background-color: #3e8e41;
            box-shadow: 0 5px #666;
            transform: translateY(4px);
        }
    </style>
    <script>
        function showGames(type) {
            document.getElementById('gameType').value = type;
            document.getElementById('gameForm').submit();
        }
    </script>
</head>
<body>

<div class="container">
    <h1>Administración Juegos</h1>

    <form id="sucursalForm" method="post">
        <label for="sucursal">Seleccione una sucursal:</label>
        <select name="sucursal" id="sucursal" onchange="document.getElementById('sucursalForm').submit();">
            <option value="">Seleccione una sucursal</option>
            <?php
            include('../conexion.php'); // Asegúrate de incluir tu archivo de conexión

            // Consulta para obtener todas las sucursales
            $sucursales_query = "SELECT Sucursal_ID, Ubicacion FROM Sucursal";
            $sucursales_result = mysqli_query($enlace, $sucursales_query);
            if (!$sucursales_result) {
                die("Error en la consulta de sucursales: " . mysqli_error($enlace));
            }

            while ($row = mysqli_fetch_assoc($sucursales_result)): ?>
                <option value="<?php echo $row['Sucursal_ID']; ?>" <?php if (isset($_POST['sucursal']) && $_POST['sucursal'] == $row['Sucursal_ID']) echo 'selected'; ?>>
                    <?php echo $row['Ubicacion']; ?>
                </option>
            <?php endwhile; ?>

            <?php mysqli_free_result($sucursales_result); ?>
        </select>
    </form>

    <?php if (isset($_POST['sucursal']) && $_POST['sucursal'] != ''): ?>
        <div style="text-align: center; margin-top: 20px;">
            <button class="button" onclick="showGames('mesa')">Juegos de Mesa</button>
            <button class="button" onclick="showGames('maquina')">Juegos de Máquina</button>
        </div>

        <form id="gameForm" method="post" class="hidden">
            <input type="hidden" name="sucursal" value="<?php echo $_POST['sucursal']; ?>">
            <input type="hidden" name="gameType" id="gameType">
        </form>

        <?php
        $sucursal_id = $_POST['sucursal'];

        if (isset($_POST['gameType'])) {
            if ($_POST['gameType'] == 'mesa') {
                // Consulta para obtener juegos de mesa y nombre del crupier
                $mesa_query = "
                    SELECT jm.Mesa_ID, jm.Numero_Mesa, jm.Nombre AS Juego, p.Nombre AS Crupier
                    FROM juego_mesa jm
                    LEFT JOIN Personal p ON jm.Personal_ID = p.Personal_ID
                    WHERE jm.Sucursal_ID = $sucursal_id";

                $mesa_result = mysqli_query($enlace, $mesa_query);
                if (!$mesa_result) {
                    die("Error en la consulta de juegos de mesa: " . mysqli_error($enlace));
                }
                ?>
                <h2>Juegos de Mesa</h2>
                <table>
                    <tr>
                        <th>Mesa ID</th>
                        <th>Número de Mesa</th>
                        <th>Juego</th>
                        <th>Crupier</th>
                    </tr>
                    <?php while ($row = mysqli_fetch_assoc($mesa_result)): ?>
                        <tr>
                            <td><?php echo $row['Mesa_ID']; ?></td>
                            <td><?php echo $row['Numero_Mesa']; ?></td>
                            <td><?php echo $row['Juego']; ?></td>
                            <td><?php echo $row['Crupier']; ?></td>
                        </tr>
                    <?php endwhile; ?>
                </table>
                <?php
                mysqli_free_result($mesa_result);
            } elseif ($_POST['gameType'] == 'maquina') {
                // Consulta para obtener juegos de máquina y nombre del cliente
                $maquina_query = "
                    SELECT jm.Maquina_ID, jm.Nombre AS Juego, c.Nombres AS Cliente_Nombre
                    FROM juego_maquina jm
                    LEFT JOIN Cliente c ON jm.Cliente_ID = c.Cliente_ID
                    WHERE jm.Sucursal_ID = $sucursal_id";

                $maquina_result = mysqli_query($enlace, $maquina_query);
                if (!$maquina_result) {
                    die("Error en la consulta de juegos de máquina: " . mysqli_error($enlace));
                }
                ?>
                <h2>Juegos de Máquina</h2>
                <table>
                    <tr>
                        <th>Maquina ID</th>
                        <th>Juego</th>
                        <th>Cliente</th>
                    </tr>
                    <?php while ($row = mysqli_fetch_assoc($maquina_result)): ?>
                        <tr>
                            <td><?php echo $row['Maquina_ID']; ?></td>
                            <td><?php echo $row['Juego']; ?></td>
                            <td><?php echo $row['Cliente_Nombre']; ?></td>
                        </tr>
                    <?php endwhile; ?>
                </table>
                <?php
                mysqli_free_result($maquina_result);
            }
        }
        ?>
    <?php endif; ?>

</div>

<div class="footer">
    <a href="index.php" class="button">Volver al inicio</a>
    <a href="agregar_juego.php" class="button">Agregar Juego</a>
</div>

</body>
</html>

<?php
mysqli_close($enlace);
?>

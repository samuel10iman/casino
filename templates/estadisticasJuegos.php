<?php
session_start();
include('../conexion.php'); // Ajusta la ruta según la ubicación de tu archivo conexion.php

// Obtener todas las sucursales
$sucursales_query = "SELECT Sucursal_ID, Ubicacion FROM Sucursal";
$sucursales_result = mysqli_query($enlace, $sucursales_query);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Estadísticas de Juegos</title>
    <style>
        body {
            font-family: Arial, sans-serif;
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
    </style>
    <script>
        function showGames(type) {
            document.getElementById('gameType').value = type;
            document.getElementById('gameForm').submit();
        }
    </script>
</head>
<body>

<h1>Estadísticas de Juegos</h1>

<a href="index.php" class="button">Volver a index.php</a>
<a href="agregar_juego.php" class="button">Agregar Juego</a>

<form id="sucursalForm" method="post">
    <label for="sucursal">Seleccione una sucursal:</label>
    <select name="sucursal" id="sucursal" onchange="document.getElementById('sucursalForm').submit();">
        <option value="">Seleccione una sucursal</option>
        <?php while ($row = mysqli_fetch_assoc($sucursales_result)): ?>
            <option value="<?php echo $row['Sucursal_ID']; ?>" <?php if (isset($_POST['sucursal']) && $_POST['sucursal'] == $row['Sucursal_ID']) echo 'selected'; ?>>
                <?php echo $row['Ubicacion']; ?>
            </option>
        <?php endwhile; ?>
    </select>
</form>

<?php if (isset($_POST['sucursal']) && $_POST['sucursal'] != ''): ?>
    <button class="button" onclick="showGames('maquina')">Juegos de Máquina</button>
    <button class="button" onclick="showGames('mesa')">Juegos de Mesa</button>

    <form id="gameForm" method="post" class="hidden">
        <input type="hidden" name="sucursal" value="<?php echo $_POST['sucursal']; ?>">
        <input type="hidden" name="gameType" id="gameType">
    </form>

    <?php if (isset($_POST['gameType']) && $_POST['gameType'] == 'maquina'): ?>
        <h2>Juegos de Máquina</h2>
        <?php
        $sucursal_id = $_POST['sucursal'];
        $maquina_query = "
            SELECT 
                jm.Maquina_ID,
                jm.Nombre AS Juego,
                c.Nombres AS Participante,
                c.Apellidos AS Participante_Apellidos
            FROM Juego_Maquina jm
            LEFT JOIN Cliente c ON jm.Cliente_ID = c.Cliente_ID AND jm.Sucursal_ID = c.Sucursal_ID
            WHERE jm.Sucursal_ID = $sucursal_id";
        $maquina_result = mysqli_query($enlace, $maquina_query);
        ?>
        <table>
            <tr>
                <th>Id de la Máquina</th>
                <th>Nombre del Juego</th>
                <th>Participante</th>
            </tr>
            <?php while ($row = mysqli_fetch_assoc($maquina_result)): ?>
                <tr>
                    <td><?php echo $row['Maquina_ID']; ?></td>
                    <td><?php echo $row['Juego']; ?></td>
                    <td><?php echo $row['Participante'] . ' ' . $row['Participante_Apellidos']; ?></td>
                </tr>
            <?php endwhile; ?>
        </table>
    <?php elseif (isset($_POST['gameType']) && $_POST['gameType'] == 'mesa'): ?>
        <h2>Juegos de Mesa</h2>
        <?php
        $sucursal_id = $_POST['sucursal'];
        $mesa_query = "
            SELECT 
                jm.Nombre AS Juego,
                cm.Mesa_ID,
                cm.Numero_Partida,
                cm.Hora_Entrada,
                cm.Hora_Salida,
                p.Nombre AS Crupier_Nombre
            FROM Juego_Mesa jm
            LEFT JOIN Cliente_Mesa cm ON jm.Mesa_ID = cm.Mesa_ID
            LEFT JOIN Crupier cr ON jm.Personal_ID = cr.Personal_ID
            LEFT JOIN Personal p ON cr.Personal_ID = p.Personal_ID
            WHERE jm.Sucursal_ID = $sucursal_id";
        $mesa_result = mysqli_query($enlace, $mesa_query);
        ?>
        <table>
            <tr>
                <th>Nombre del Juego</th>
                <th>Id de la Mesa</th>
                <th>Número de Partida</th>
                <th>Hora de Entrada</th>
                <th>Hora de Salida</th>
                <th>Crupier</th>
            </tr>
            <?php while ($row = mysqli_fetch_assoc($mesa_result)): ?>
                <tr>
                    <td><?php echo $row['Juego']; ?></td>
                    <td><?php echo $row['Mesa_ID']; ?></td>
                    <td><?php echo $row['Numero_Partida']; ?></td>
                    <td><?php echo $row['Hora_Entrada']; ?></td>
                    <td><?php echo $row['Hora_Salida']; ?></td>
                    <td><?php echo $row['Crupier_Nombre']; ?></td>
                </tr>
            <?php endwhile; ?>
        </table>
    <?php endif; ?>
<?php endif; ?>

</body>
</html>

<?php
mysqli_close($enlace);
?>

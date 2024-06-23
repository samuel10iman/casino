<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Cliente</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="../static/styles.css">
</head>
<body>
    <header>
        <h1>Casino Admin</h1>
        <nav>
            <ul>
                <li>"Nosotros ganamos tu plata, tú la experiencia"</li>
            </ul>
        </nav>
    </header>
    <main>
        <section class="form-container">
            <h2>Registrar Cliente</h2>
            <form action="../procesarCliente.php" method="POST">
                <div class="input-group">
                    <label for="nombres">Nombres:</label>
                    <input type="text" id="nombres" name="nombres" required>
                </div>
                <div class="input-group">
                    <label for="apellidos">Apellidos:</label>
                    <input type="text" id="apellidos" name="apellidos" required>
                </div>
                <div class="input-group">
                    <label for="direccion">Dirección:</label>
                    <textarea id="direccion" name="direccion" required></textarea>
                </div>
                <div class="input-group">
                    <label for="dni">DNI (solo números):</label>
                    <input type="number" id="dni" name="dni" required pattern="[0-9]+" title="Ingrese solo números">
                </div>
                <div class="input-group">
                    <label for="edad">Edad (min. 18 años):</label>
                    <input type="number" id="edad" name="edad" required min="18">
                </div>
                <div class="input-group">
                    <label for="saldo">Saldo (min. $1000):</label>
                    <input type="number" id="saldo" name="saldo" required min="1000">
                </div>
                <!-- Selección de Sucursal -->
                <div class="input-group">
                    <label for="sucursal">Seleccione Sucursal:</label>
                    <select id="sucursal" name="sucursal_id" required>
                        <!-- Aquí deberías cargar dinámicamente las opciones desde la base de datos -->
                        <?php
                        include('../conexion.php');

                        $sql_sucursales = "SELECT Sucursal_ID, Ubicacion FROM Sucursal";
                        $result_sucursales = mysqli_query($enlace, $sql_sucursales);
                        if ($result_sucursales) {
                            while ($row = mysqli_fetch_assoc($result_sucursales)) {
                                echo '<option value="' . $row['Sucursal_ID'] . '">' . $row['Ubicacion'] . '</option>';
                            }
                            mysqli_free_result($result_sucursales);
                        } else {
                            echo '<option value="">Error al cargar sucursales</option>';
                        }
                        mysqli_close($enlace);
                        ?>
                    </select>
                </div>
                <div class="input-group">
                    <label for="correos">Correos (separados por coma):</label>
                    <input type="text" id="correos" name="correos" placeholder="ejemplo@dominio.com, otro@dominio.com">
                </div>
                <div class="input-group">
                    <label for="telefonos">Teléfonos (separados por coma):</label>
                    <input type="text" id="telefonos" name="telefonos" placeholder="123456789, 987654321">
                </div>
                <button type="submit">Registrar Cliente</button>
            </form>
        </section>
    </main>
    <script src="script.js"></script>
</body>
</html>

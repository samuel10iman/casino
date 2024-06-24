<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Personal</title>
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
            <h2>Registrar Personal</h2>
            <form action="../procesarPersonal.php" method="POST">
                <div class="input-group">
                    <label for="nombre">Nombre:</label>
                    <input type="text" id="nombre" name="nombre" required>
                </div>
                <div class="input-group">
                    <label for="nacionalidad">Nacionalidad:</label>
                    <input type="text" id="nacionalidad" name="nacionalidad" required>
                </div>
                <div class="input-group">
                    <label for="fecha_contrato">Fecha de Contrato:</label>
                    <input type="date" id="fecha_contrato" name="fecha_contrato" required>
                </div>
                <div class="input-group">
                    <label for="fecha_fin_contrato">Fecha Fin de Contrato:</label>
                    <input type="date" id="fecha_fin_contrato" name="fecha_fin_contrato">
                </div>
                <div class="input-group">
                    <label for="horario">Horario:</label>
                    <input type="text" id="horario" name="horario">
                </div>
                <div class="input-group">
                    <label for="sueldo">Sueldo:</label>
                    <input type="number" id="sueldo" name="sueldo" min="0" required>
                </div>
                <div class="input-group">
                    <label for="tipo_contrato">Tipo de Contrato:</label>
                    <input type="text" id="tipo_contrato" name="tipo_contrato" required>
                </div>
                <div class="input-group">
                    <label for="telefono">Teléfono:</label>
                    <input type="text" id="telefono" name="telefono">
                </div>
                <div class="input-group">
                    <label for="correo">Correo:</label>
                    <input type="email" id="correo" name="correo">
                </div>

                <!-- Selección de Sucursal -->
                <div class="input-group">
                    <label for="sucursal">Sucursal:</label>
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
                    <label for="tipo_personal">Tipo de Personal:</label>
                    <select id="tipo_personal" name="tipo_personal" required>
                        <option value="auxiliar">Auxiliar</option>
                        <option value="crupier">Crupier</option>
                        <option value="tecnico">Técnico</option>
                    </select>
                </div>
                
                <button type="submit">Registrar Personal</button>
            </form>
        </section>
        <div class="footer">
        <a href="index.php">Volver a la página principal</a>
        </div>
    </main>
    <script src="script.js"></script>
</body>
</html>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Proveedor</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="../static/styles.css">
    <style>
        .error-message {
            color: red;
        }
    </style>
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
            <h2>Registrar Proveedor</h2>
            <?php
            if (isset($_GET['error']) && $_GET['error'] == 'Empresa ya registrada') {
                echo '<p class="error-message">¡Error! La empresa ya está registrada.</p>';
            }
            ?>
            <form action="procesarProveedor.php" method="POST">
                <div class="input-group">
                    <label for="ruc">RUC (solo números):</label>
                    <input type="number" id="ruc" name="ruc" required pattern="[0-9]+" title="Ingrese solo números">
                </div>
                <div class="input-group">
                    <label for="nombre">Nombre:</label>
                    <input type="text" id="nombre" name="nombre" required>
                </div>
                <div class="input-group">
                    <label for="ubicacion">Ubicación:</label>
                    <textarea id="ubicacion" name="ubicacion" required></textarea>
                </div>
                <div class="input-group">
                    <label for="telefonos">Teléfonos (máximo 6 caracteres por número, separados por comas):</label>
                    <input type="text" id="telefonos" name="telefonos" required pattern="(\d{1,6},?)+">
                </div>
                <div class="input-group">
                    <label for="tipo_empresa">Seleccione tipo de empresa:</label>
                    <select id="tipo_empresa" name="tipo_empresa" required>
                        <option value="Distribuidora de implementos de juego">Distribuidora de implementos de juego</option>
                        <option value="Concesionario de alimentos">Concesionario de alimentos</option>
                        <option value="Distribuidora de elementos de limpieza">Distribuidora de elementos de limpieza</option>
                        <option value="Distribuidora de armamento">Distribuidora de armamento</option>
                    </select>
                </div>
                <div class="input-group">
                    <label for="anio_fin">Fecha de Expiración de Contrato:</label>
                    <input type="date" id="anio_fin" name="anio_fin" required>
                </div>
                <button type="submit">Registrar Proveedor</button>
            </form>
        </section>
    </main>
    <script src="script.js"></script>
</body>
</html>

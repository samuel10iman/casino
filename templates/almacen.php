<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar y Buscar Productos</title>
    <link rel="stylesheet" href="../static/styles.css">
    <script>
        function mostrarFormulario() {
            document.getElementById('formulario').style.display = 'block';
            document.getElementById('buscarProductos').style.display = 'none';
        }

        function mostrarBuscar() {
            document.getElementById('formulario').style.display = 'none';
            document.getElementById('buscarProductos').style.display = 'block';
        }

        function eliminarProducto(id) {
            if (confirm('¿Estás seguro de que deseas eliminar este producto?')) {
                window.location.href = 'eliminarProducto.php?id=' + id;
            }
        }
    </script>
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
            <h2>Registrar y Buscar Productos en Almacén</h2>
            <div class="button-group">
                <button onclick="mostrarFormulario()">Añadir Producto</button>
                <button onclick="mostrarBuscar()">Buscar Productos</button>
            </div>

            <div id="formulario" style="display:none;">
                <form action="procesarAlmacen.php" method="POST">
                    <div class="input-group">
                        <label for="Nombre">Nombre del Producto:</label>
                        <input type="text" id="Nombre" name="Nombre" required>
                    </div>
                    <div class="input-group">
                        <label for="Precio">Precio:</label>
                        <input type="number" id="Precio" name="Precio" min="1" step="1" required>
                    </div>
                    <div class="input-group">
                        <label for="Tipo">Tipo:</label>
                        <input type="text" id="Tipo" name="Tipo" required>
                    </div>
                    <div class="input-group">
                        <label for="Cantidad_Disponible">Cantidad:</label>
                        <input type="number" id="Cantidad_Disponible" name="Cantidad_Disponible" required>
                    </div>
                    <div class="input-group">
                        <label for="sucursal">Seleccione Sucursal:</label>
                        <select id="sucursal" name="Sucursal_ID" required>
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
                    <button type="submit">Registrar Producto</button>
                </form>
            </div>

            <div id="buscarProductos" style="display:none;">
                <form method="GET" action="">
                    <div class="input-group">
                        <label for="filtroNombre">Nombre del Producto:</label>
                        <input type="text" id="filtroNombre" name="filtroNombre">
                    </div>
                    <div class="input-group">
                        <label for="filtroTipo">Tipo:</label>
                        <input type="text" id="filtroTipo" name="filtroTipo">
                    </div>
                    <div class="input-group">
                        <label for="filtroSucursal">Seleccione Sucursal:</label>
                        <select id="filtroSucursal" name="filtroSucursal">
                            <option value="">Todas</option>
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
                    <button type="submit">Buscar</button>
                </form>

                <?php
                include('../conexion.php');

                $filtroNombre = isset($_GET['filtroNombre']) ? $_GET['filtroNombre'] : '';
                $filtroTipo = isset($_GET['filtroTipo']) ? $_GET['filtroTipo'] : '';
                $filtroSucursal = isset($_GET['filtroSucursal']) ? $_GET['filtroSucursal'] : '';

                $sql_productos = "SELECT Producto_ID, Nombre, Precio, Tipo, Cantidad_Disponible, Sucursal_ID FROM Producto WHERE 1=1";
                if ($filtroNombre != '') {
                    $sql_productos .= " AND Nombre LIKE '%" . mysqli_real_escape_string($enlace, $filtroNombre) . "%'";
                }
                if ($filtroTipo != '') {
                    $sql_productos .= " AND Tipo LIKE '%" . mysqli_real_escape_string($enlace, $filtroTipo) . "%'";
                }
                if ($filtroSucursal != '') {
                    $sql_productos .= " AND Sucursal_ID = " . mysqli_real_escape_string($enlace, $filtroSucursal);
                }

                $result_productos = mysqli_query($enlace, $sql_productos);
                if ($result_productos) {
                    echo '<table>';
                    echo '<tr><th>ID</th><th>Nombre</th><th>Precio</th><th>Tipo</th><th>Cantidad Disponible</th><th>Sucursal</th><th>Acciones</th></tr>';
                    while ($row = mysqli_fetch_assoc($result_productos)) {
                        echo '<tr>';
                        echo '<td>' . $row['Producto_ID'] . '</td>';
                        echo '<td>' . $row['Nombre'] . '</td>';
                        echo '<td>' . $row['Precio'] . '</td>';
                        echo '<td>' . $row['Tipo'] . '</td>';
                        echo '<td>' . $row['Cantidad_Disponible'] . '</td>';
                        echo '<td>' . $row['Sucursal_ID'] . '</td>';
                        echo '<td><button onclick="eliminarProducto(' . $row['Producto_ID'] . ')">Eliminar</button></td>';
                        echo '</tr>';
                    }
                    echo '</table>';
                    mysqli_free_result($result_productos);
                } else {
                    echo 'Error al cargar los productos: ' . mysqli_error($enlace);
                }
                mysqli_close($enlace);
                ?>
            </div>
        </section>
    </main>
</body>
</html>

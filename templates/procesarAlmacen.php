<?php
include('../conexion.php'); // Ajusta la ruta de inclusión según tu estructura de directorios

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener datos del formulario para agregar producto
    if (isset($_POST['Nombre']) && isset($_POST['Precio']) && isset($_POST['Tipo']) && isset($_POST['Cantidad_Disponible']) && isset($_POST['Sucursal_ID'])) {
        $nombre = $_POST['Nombre'];
        $precio = (int) $_POST['Precio'];
        $tipo = $_POST['Tipo'];
        $cantidad_disponible = $_POST['Cantidad_Disponible'];
        $sucursal_id = $_POST['Sucursal_ID'];

        // Validar que el precio sea un entero positivo
        if ($precio <= 0) {
            die("El precio debe ser un valor entero positivo.");
        }

        // Verificar la conexión a la base de datos
        if (!$enlace) {
            die("Conexión fallida: " . mysqli_connect_error());
        }

        // Insertar datos en la tabla Producto
        $query_producto = "INSERT INTO Producto (Nombre, Precio, Tipo, Cantidad_Disponible, Sucursal_ID) 
                           VALUES (?, ?, ?, ?, ?)";
        $stmt_producto = mysqli_prepare($enlace, $query_producto);

        if ($stmt_producto) {
            mysqli_stmt_bind_param($stmt_producto, 'sdsii', $nombre, $precio, $tipo, $cantidad_disponible, $sucursal_id);

            // Ejecutar la consulta de inserción de Producto
            if (mysqli_stmt_execute($stmt_producto)) {
                echo "Producto registrado exitosamente";
            } else {
                echo "Error al registrar el producto: " . mysqli_stmt_error($stmt_producto);
            }

            mysqli_stmt_close($stmt_producto);
        } else {
            echo "Error en la preparación de la consulta: " . mysqli_error($enlace);
        }

        // Redireccionar después de registrar
        header('Location: almacen.php');
        exit();
    }

    // Obtener el ID del producto a eliminar
    if (isset($_POST['Producto_ID'])) {
        $producto_id = $_POST['Producto_ID'];

        // Verificar la conexión a la base de datos
        if (!$enlace) {
            die("Conexión fallida: " . mysqli_connect_error());
        }

        // Eliminar el producto de la tabla Producto
        $query_eliminar = "DELETE FROM Producto WHERE Producto_ID = ?";
        $stmt_eliminar = mysqli_prepare($enlace, $query_eliminar);

        if ($stmt_eliminar) {
            mysqli_stmt_bind_param($stmt_eliminar, 'i', $producto_id);

            // Ejecutar la consulta de eliminación de Producto
            if (mysqli_stmt_execute($stmt_eliminar)) {
                echo "Producto eliminado exitosamente";
            } else {
                echo "Error al eliminar el producto: " . mysqli_stmt_error($stmt_eliminar);
            }

            mysqli_stmt_close($stmt_eliminar);
        } else {
            echo "Error en la preparación de la consulta: " . mysqli_error($enlace);
        }

        // Redireccionar después de eliminar
        header('Location: almacen.php');
        exit();
    }
}

mysqli_close($enlace);
?>

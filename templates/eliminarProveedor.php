<?php
include('../conexion.php'); // Asegúrate de incluir tu archivo de conexión a la base de datos

// Verificar si se ha enviado un RUC de proveedor para eliminar
if (isset($_GET['ruc'])) {
    $proveedor_ruc = $_GET['ruc'];

    // Iniciar transacción
    mysqli_begin_transaction($enlace);

    // Eliminar registros de proveedor_telefono asociados al proveedor
    $query_delete_telefonos = "DELETE FROM proveedor_telefono WHERE RUC = ?";
    $stmt_telefonos = mysqli_prepare($enlace, $query_delete_telefonos);
    mysqli_stmt_bind_param($stmt_telefonos, 's', $proveedor_ruc);
    
    if (mysqli_stmt_execute($stmt_telefonos)) {
        // Después de eliminar teléfonos, eliminar el proveedor principal
        $query_delete_proveedor = "DELETE FROM proveedor WHERE RUC = ?";
        $stmt_proveedor = mysqli_prepare($enlace, $query_delete_proveedor);
        mysqli_stmt_bind_param($stmt_proveedor, 's', $proveedor_ruc);

        if (mysqli_stmt_execute($stmt_proveedor)) {
            // Commit de la transacción si todas las consultas son exitosas
            mysqli_commit($enlace);
            header('Location: buscarProveedor.php'); // Redirigir a la página principal
            exit;
        } else {
            // Rollback si hay algún error al eliminar el proveedor
            mysqli_rollback($enlace);
            echo "Error al eliminar el proveedor: " . mysqli_error($enlace);
        }

        // Cerrar la declaración preparada del proveedor
        mysqli_stmt_close($stmt_proveedor);
    } else {
        // Rollback si hay algún error al eliminar los teléfonos
        mysqli_rollback($enlace);
        echo "Error al eliminar teléfonos: " . mysqli_error($enlace);
    }

    // Cerrar la declaración preparada de teléfonos
    mysqli_stmt_close($stmt_telefonos);

} else {
    // No se proporcionó un RUC de proveedor válido
    echo "No se proporcionó un RUC de Proveedor válido para eliminar.";
}

// Cerrar la conexión a la base de datos
mysqli_close($enlace);
?>

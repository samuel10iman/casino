<?php
include('../conexion.php'); // Asegúrate de incluir tu archivo de conexión

// Verificar si se ha enviado un ID de cliente para eliminar
if (isset($_GET['id'])) {
    $cliente_id = $_GET['id'];

    // Eliminar registros de cliente_correo asociados al cliente
    $query_delete_correos = "DELETE FROM cliente_correo WHERE Cliente_ID = ?";
    $stmt_correos = mysqli_prepare($enlace, $query_delete_correos);
    mysqli_stmt_bind_param($stmt_correos, 'i', $cliente_id);
    
    if (mysqli_stmt_execute($stmt_correos)) {
        // Después de eliminar correos, eliminar registros de cliente_telefono
        $query_delete_telefonos = "DELETE FROM cliente_telefono WHERE Cliente_ID = ?";
        $stmt_telefonos = mysqli_prepare($enlace, $query_delete_telefonos);
        mysqli_stmt_bind_param($stmt_telefonos, 'i', $cliente_id);
        
        if (mysqli_stmt_execute($stmt_telefonos)) {
            // Después de eliminar telefonos, eliminar el cliente principal
            $query_delete_cliente = "DELETE FROM cliente WHERE Cliente_ID = ?";
            $stmt_cliente = mysqli_prepare($enlace, $query_delete_cliente);
            mysqli_stmt_bind_param($stmt_cliente, 'i', $cliente_id);

            if (mysqli_stmt_execute($stmt_cliente)) {
                // Cliente eliminado correctamente
                header('Location: index.php');
                exit;
            } else {
                // Error al eliminar el cliente
                echo "Error al eliminar el cliente: " . mysqli_error($enlace);
            }

            // Cerrar la declaración preparada del cliente
            mysqli_stmt_close($stmt_cliente);
        } else {
            // Error al eliminar telefonos
            echo "Error al eliminar telefonos: " . mysqli_error($enlace);
        }

        // Cerrar la declaración preparada de telefonos
        mysqli_stmt_close($stmt_telefonos);
    } else {
        // Error al eliminar correos
        echo "Error al eliminar correos: " . mysqli_error($enlace);
    }

    // Cerrar la declaración preparada de correos
    mysqli_stmt_close($stmt_correos);

} else {
    // No se proporcionó un ID de cliente válido
    echo "No se proporcionó un ID de cliente válido para eliminar.";
}

// Cerrar la conexión a la base de datos
mysqli_close($enlace);
?>

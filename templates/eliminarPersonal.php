<?php
include('../conexion.php'); // Asegúrate de incluir tu archivo de conexión

// Obtener el ID del personal a eliminar
$personal_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($personal_id > 0) {
    // Comenzar una transacción
    mysqli_begin_transaction($enlace);

    try {
        // Eliminar las filas relacionadas en la tabla `Telefono`
        $query_telefono = "DELETE FROM personal_telefono WHERE Personal_ID = ?";
        $stmt_telefono = mysqli_prepare($enlace, $query_telefono);
        mysqli_stmt_bind_param($stmt_telefono, 'i', $personal_id);
        if (!mysqli_stmt_execute($stmt_telefono)) {
            throw new Exception("Error eliminando teléfono: " . mysqli_stmt_error($stmt_telefono));
        }
        mysqli_stmt_close($stmt_telefono);

        // Eliminar las filas relacionadas en la tabla `Correo`
        $query_correo = "DELETE FROM personal_correo WHERE Personal_ID = ?";
        $stmt_correo = mysqli_prepare($enlace, $query_correo);
        mysqli_stmt_bind_param($stmt_correo, 'i', $personal_id);
        if (!mysqli_stmt_execute($stmt_correo)) {
            throw new Exception("Error eliminando correo: " . mysqli_stmt_error($stmt_correo));
        }
        mysqli_stmt_close($stmt_correo);

        // Eliminar las filas relacionadas en las tablas específicas de tipos de personal
        $query_tecnico = "DELETE FROM Tecnico WHERE Personal_ID = ?";
        $stmt_tecnico = mysqli_prepare($enlace, $query_tecnico);
        mysqli_stmt_bind_param($stmt_tecnico, 'i', $personal_id);
        if (!mysqli_stmt_execute($stmt_tecnico)) {
            throw new Exception("Error eliminando técnico: " . mysqli_stmt_error($stmt_tecnico));
        }
        mysqli_stmt_close($stmt_tecnico);

        $query_crupier = "DELETE FROM Crupier WHERE Personal_ID = ?";
        $stmt_crupier = mysqli_prepare($enlace, $query_crupier);
        mysqli_stmt_bind_param($stmt_crupier, 'i', $personal_id);
        if (!mysqli_stmt_execute($stmt_crupier)) {
            throw new Exception("Error eliminando crupier: " . mysqli_stmt_error($stmt_crupier));
        }
        mysqli_stmt_close($stmt_crupier);

        $query_auxiliar = "DELETE FROM Auxiliar WHERE Personal_ID = ?";
        $stmt_auxiliar = mysqli_prepare($enlace, $query_auxiliar);
        mysqli_stmt_bind_param($stmt_auxiliar, 'i', $personal_id);
        if (!mysqli_stmt_execute($stmt_auxiliar)) {
            throw new Exception("Error eliminando auxiliar: " . mysqli_stmt_error($stmt_auxiliar));
        }
        mysqli_stmt_close($stmt_auxiliar);

        // Eliminar el registro en la tabla `Personal`
        $query_personal = "DELETE FROM Personal WHERE Personal_ID = ?";
        $stmt_personal = mysqli_prepare($enlace, $query_personal);
        mysqli_stmt_bind_param($stmt_personal, 'i', $personal_id);
        if (!mysqli_stmt_execute($stmt_personal)) {
            throw new Exception("Error eliminando personal: " . mysqli_stmt_error($stmt_personal));
        }
        mysqli_stmt_close($stmt_personal);

        // Si todo va bien, confirmar la transacción
        mysqli_commit($enlace);

        echo "<script>alert('Registro eliminado exitosamente.'); window.location.href = 'buscarPersonal.php';</script>";
    } catch (Exception $e) {
        // Si ocurre un error, deshacer la transacción
        mysqli_rollback($enlace);
        echo "<script>alert('Error al eliminar el registro: " . $e->getMessage() . "'); window.location.href = 'buscarPersonal.php';</script>";
    }
} else {
    echo "<script>alert('ID de personal no válido.'); window.location.href = 'buscarPersonal.php';</script>";
}

// Cerrar la conexión a la base de datos
mysqli_close($enlace);
?>

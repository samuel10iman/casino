<?php
include('conexion.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Capturar los datos del formulario
    $nombre = $_POST['nombre'];
    $sucursal_id = $_POST['sucursal_id'];

    // Verificar si el registro ya existe en la base de datos
    $sql_verificar = "SELECT COUNT(*) as total FROM Personal WHERE Nombre = ? AND Sucursal_ID = ?";
    $stmt_verificar = mysqli_prepare($enlace, $sql_verificar);
    mysqli_stmt_bind_param($stmt_verificar, "si", $nombre, $sucursal_id);
    mysqli_stmt_execute($stmt_verificar);
    $resultado_verificar = mysqli_stmt_get_result($stmt_verificar);
    $row_verificar = mysqli_fetch_assoc($resultado_verificar);

    if ($row_verificar['total'] > 0) {
        echo "El registro ya existe en la base de datos.";
        exit;
    }

    // Si el registro no existe, proceder con la inserción
    $nacionalidad = $_POST['nacionalidad'];
    $fecha_contrato = $_POST['fecha_contrato'];
    $fecha_fin_contrato = $_POST['fecha_fin_contrato'];
    $horario = $_POST['horario'];
    $sueldo = $_POST['sueldo'];
    $tipo_contrato = $_POST['tipo_contrato'];
    $tipo_personal = $_POST['tipo_personal'];
    $telefono = $_POST['telefono'];
    $correo = $_POST['correo'];

    // Determinar la tabla correspondiente según el tipo de personal
    $tabla = '';
    switch ($tipo_personal) {
        case 'auxiliar':
            $tabla = 'auxiliar';
            break;
        case 'crupier':
            $tabla = 'crupier';
            break;
        case 'tecnico':
            $tabla = 'tecnico';
            break;
        default:
            echo "Tipo de personal no válido";
            exit;
    }

    // Consulta SQL para insertar el registro en la base de datos
    $sql_insert_personal = "INSERT INTO Personal (Nombre, Nacionalidad, Fecha_Contrato, Fecha_Fin_Contrato, Horario, Sueldo, Tipo_Contrato, Sucursal_ID) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

    // Preparar la consulta
    $stmt = mysqli_prepare($enlace, $sql_insert_personal);

    // Vincular parámetros y ejecutar la consulta
    mysqli_stmt_bind_param($stmt, "sssssiss", $nombre, $nacionalidad, $fecha_contrato, $fecha_fin_contrato, $horario, $sueldo, $tipo_contrato, $sucursal_id);
    $resultado = mysqli_stmt_execute($stmt);

    if ($resultado) {
        // Obtener el ID del personal recién insertado
        $personal_id = mysqli_insert_id($enlace);

        // Insertar el ID en la tabla correspondiente según el tipo de personal
        $sql_insert_personal_id = "INSERT INTO $tabla (Personal_ID) VALUES (?)";
        $stmt_personal_id = mysqli_prepare($enlace, $sql_insert_personal_id);
        mysqli_stmt_bind_param($stmt_personal_id, "i", $personal_id);
        $resultado_personal_id = mysqli_stmt_execute($stmt_personal_id);

        if ($resultado_personal_id) {
            $mensaje_exito = "Registro exitoso en la tabla Personal y en la tabla $tabla";

            // Insertar teléfono del personal
            $sql_insert_telefono = "INSERT INTO personal_telefono (Personal_ID, Telefono) VALUES (?, ?)";
            $stmt_telefono = mysqli_prepare($enlace, $sql_insert_telefono);
            mysqli_stmt_bind_param($stmt_telefono, "is", $personal_id, $telefono);
            $resultado_telefono = mysqli_stmt_execute($stmt_telefono);

            // Mostrar ventana emergente con JavaScript
            echo '<script>';
            echo 'alert("' . $mensaje_exito . '");';
            echo 'window.location.href = "templates/registroPersonal.php";'; // Redireccionar a la página de registro
            echo '</script>';

            if (!$resultado_telefono) {
                echo "Error al registrar el teléfono del personal";
            }

            // Insertar correo del personal
            $sql_insert_correo = "INSERT INTO personal_correo (Personal_ID, Correo) VALUES (?, ?)";
            $stmt_correo = mysqli_prepare($enlace, $sql_insert_correo);
            mysqli_stmt_bind_param($stmt_correo, "is", $personal_id, $correo);
            $resultado_correo = mysqli_stmt_execute($stmt_correo);

            if (!$resultado_correo) {
                echo "Error al registrar el correo del personal";
            }

            mysqli_stmt_close($stmt_personal_id);
            mysqli_stmt_close($stmt_telefono);
            mysqli_stmt_close($stmt_correo);
        } else {
            echo "Error al registrar en la tabla $tabla";
        }

    } else {
        echo "Error al registrar el personal";
    }

    mysqli_stmt_close($stmt);
    mysqli_close($enlace);
} else {
    echo "Acceso no autorizado";
}
?>

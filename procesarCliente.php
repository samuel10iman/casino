<?php
include('conexion.php'); // Asegúrate de incluir tu archivo de conexión

// Obtener datos del formulario
$nombres = $_POST['nombres'];
$apellidos = $_POST['apellidos'];
$direccion = $_POST['direccion'];
$dni = $_POST['dni'];
$edad = $_POST['edad'];
$saldo = $_POST['saldo'];
$sucursal_id = $_POST['sucursal_id'];
$correos = $_POST['correos']; // Correos separados por coma
$telefonos = $_POST['telefonos']; // Teléfonos separados por coma

// Valores iniciales para Tiempo_estadia, Ganancia y Perdida
$tiempo_estadia = 0;
$ganancia = 0;
$perdida = 0;

// Insertar datos en la tabla Cliente
$query_cliente = "INSERT INTO Cliente (Nombres, Apellidos, Direccion, DNI, Edad, Saldo, Sucursal_ID, Tiempo_estadia, Ganancia, Perdida) 
                  VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
$stmt_cliente = mysqli_prepare($enlace, $query_cliente);
mysqli_stmt_bind_param($stmt_cliente, 'ssssiiiiid', $nombres, $apellidos, $direccion, $dni, $edad, $saldo, $sucursal_id, $tiempo_estadia, $ganancia, $perdida);

// Ejecutar la consulta de inserción de Cliente
if (mysqli_stmt_execute($stmt_cliente)) {
    // Obtener el ID del cliente insertado
    $cliente_id = mysqli_insert_id($enlace);

    // Insertar correos del cliente en la tabla Cliente_Correo
    if (!empty($correos)) {
        $correos_array = explode(',', $correos);
        foreach ($correos_array as $correo) {
            $correo = trim($correo);
            $query_correo = "INSERT INTO Cliente_Correo (Cliente_ID, Correo) VALUES (?, ?)";
            $stmt_correo = mysqli_prepare($enlace, $query_correo);
            mysqli_stmt_bind_param($stmt_correo, 'is', $cliente_id, $correo);
            mysqli_stmt_execute($stmt_correo);
            mysqli_stmt_close($stmt_correo);
        }
    }

    // Insertar teléfonos del cliente en la tabla Cliente_Telefono
    if (!empty($telefonos)) {
        $telefonos_array = explode(',', $telefonos);
        foreach ($telefonos_array as $telefono) {
            $telefono = trim($telefono);
            $query_telefono = "INSERT INTO Cliente_Telefono (Cliente_ID, Telefono) VALUES (?, ?)";
            $stmt_telefono = mysqli_prepare($enlace, $query_telefono);
            mysqli_stmt_bind_param($stmt_telefono, 'is', $cliente_id, $telefono);
            mysqli_stmt_execute($stmt_telefono);
            mysqli_stmt_close($stmt_telefono);
        }
    }

    // Cerrar la declaración y la conexión
    mysqli_stmt_close($stmt_cliente);
    mysqli_close($enlace);

    // Redirigir a una página de éxito o a otra ubicación
    header('Location: templates/index.php');
    exit;
} else {
    // Manejo de error en caso de fallo en la inserción
    echo "Error al registrar el cliente: " . mysqli_error($enlace);
    mysqli_stmt_close($stmt_cliente);
    mysqli_close($enlace);
}
?>

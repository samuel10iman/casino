<?php
session_start();

// Incluir la conexión a la base de datos
include('conexion.php'); // Ajusta la ruta según la ubicación de tu archivo conexion.php

// Verificar si se envió el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos del formulario
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Consulta SQL para verificar las credenciales
    $sql = "SELECT Usuario FROM admin WHERE Usuario = ? AND Contrasena = ?";
    $stmt = mysqli_prepare($enlace, $sql);

    if ($stmt === false) {
        die('Error en la preparación de la consulta: ' . mysqli_error($enlace));
    }

    // Bind parameters
    mysqli_stmt_bind_param($stmt, "ss", $username, $password);

    // Ejecutar consulta
    mysqli_stmt_execute($stmt);

    // Obtener resultado
    mysqli_stmt_store_result($stmt);

    // Verificar si se encontró un usuario
    if (mysqli_stmt_num_rows($stmt) == 1) {
        // Usuario y contraseña correctos, guardar usuario en sesión
        $_SESSION['usuario'] = $username;

        // Redirigir a la página principal
        header("Location: templates/index.php");
        exit();
    } else {
        // Si no se encontró el usuario, almacenar mensaje de error y redirigir a inicio de sesión
        $_SESSION['error'] = "Usuario o contraseña incorrectos";
        header("Location: templates/InicioSesion.php");
        exit();
    }

    // Cerrar consulta
    mysqli_stmt_close($stmt);
}

// Cerrar conexión
mysqli_close($enlace);
?>

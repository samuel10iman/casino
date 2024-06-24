<?php
include('../conexion.php'); // Asegúrate de incluir tu archivo de conexión

// Obtener datos del formulario
$ruc = $_POST['ruc'];
$nombre = $_POST['nombre'];
$ubicacion = $_POST['ubicacion'];
$telefonos = $_POST['telefonos'];
$tipo_empresa = $_POST['tipo_empresa'];
$anio_fin = $_POST['anio_fin'];

// Verificar la conexión a la base de datos
if (!$enlace) {
    die("Conexión fallida: " . mysqli_connect_error());
}

// Verificar si ya existe un proveedor con el mismo nombre
$query_verificar = "SELECT COUNT(*) AS count FROM Proveedor WHERE Nombre = ?";
$stmt_verificar = mysqli_prepare($enlace, $query_verificar);

if ($stmt_verificar) {
    mysqli_stmt_bind_param($stmt_verificar, 's', $nombre);
    mysqli_stmt_execute($stmt_verificar);
    mysqli_stmt_bind_result($stmt_verificar, $count);
    mysqli_stmt_fetch($stmt_verificar);
    mysqli_stmt_close($stmt_verificar);

    if ($count > 0) {
        // Si ya existe un proveedor con el mismo nombre, mostrar mensaje de error
        header("Location: registro_proveedores.php?error=Empresa ya registrada");
        exit();
    } else {
        // Insertar datos en la tabla Proveedor
        $query_proveedor = "INSERT INTO Proveedor (RUC, Nombre, Tipo_Empresa, Ubicacion, Anio_Fin) 
                            VALUES (?, ?, ?, ?, ?)";
        $stmt_proveedor = mysqli_prepare($enlace, $query_proveedor);

        if ($stmt_proveedor) {
            mysqli_stmt_bind_param($stmt_proveedor, 'issss', $ruc, $nombre, $tipo_empresa, $ubicacion, $anio_fin);

            // Ejecutar la consulta de inserción de Proveedor
            if (mysqli_stmt_execute($stmt_proveedor)) {
                // Insertar teléfonos en la tabla Proveedor_Telefono
                $telefonos_array = explode(',', $telefonos);
                foreach ($telefonos_array as $telefono) {
                    $telefono = trim($telefono); // Eliminar espacios en blanco
                    $query_telefono = "INSERT INTO Proveedor_Telefono (RUC, Telefono) VALUES (?, ?)";
                    $stmt_telefono = mysqli_prepare($enlace, $query_telefono);
                    if ($stmt_telefono) {
                        mysqli_stmt_bind_param($stmt_telefono, 'is', $ruc, $telefono);
                        if (!mysqli_stmt_execute($stmt_telefono)) {
                            echo "Error al registrar el teléfono $telefono: " . mysqli_stmt_error($stmt_telefono);
                        }
                        mysqli_stmt_close($stmt_telefono);
                    } else {
                        echo "Error en la preparación de la consulta de teléfono: " . mysqli_error($enlace);
                    }
                }

                mysqli_stmt_close($stmt_proveedor);

                // Redirigir al usuario a index.php
                header("Location: index.php");
                exit();
            } else {
                echo "Error al registrar el proveedor: " . mysqli_stmt_error($stmt_proveedor);
            }
        } else {
            echo "Error en la preparación de la consulta: " . mysqli_error($enlace);
        }
    }
} else {
    echo "Error en la preparación de la consulta de verificación: " . mysqli_error($enlace);
}

mysqli_close($enlace);
?>

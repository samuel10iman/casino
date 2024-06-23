<?php
session_start();
include('../conexion.php'); // Ajusta la ruta según la ubicación de tu archivo conexion.php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtener los datos del formulario
    $tipoJuego = $_POST['tipoJuego'];
    $nombreJuego = $_POST['nombreJuego'];
    $sucursal = $_POST['sucursal'];

    if ($tipoJuego == 'maquina') {
        $cliente = $_POST['cliente'];

        // Verificar si el juego o el cliente ya existe en la sucursal
        $verificar_query = "SELECT * FROM juego_maquina WHERE nombre = '$nombreJuego' AND sucursal_id = '$sucursal'";
        $verificar_cliente_query = "SELECT * FROM juego_maquina WHERE cliente_id = '$cliente' AND sucursal_id = '$sucursal'";
        $verificar_result = mysqli_query($enlace, $verificar_query);
        $verificar_cliente_result = mysqli_query($enlace, $verificar_cliente_query);

        if (mysqli_num_rows($verificar_result) > 0 || mysqli_num_rows($verificar_cliente_result) > 0) {
            $_SESSION['mensaje_error'] = "El nombre del juego o el cliente ya están registrados.";
            header("Location: agregar_juego.php");
            exit();
        }

        // Procesamiento para juego de máquina
        $maquina_query = "INSERT INTO juego_maquina (sucursal_id, nombre, estado, cliente_id) 
                          VALUES ('$sucursal', '$nombreJuego', 'funcional', '$cliente')";
        $maquina_result = mysqli_query($enlace, $maquina_query);

        if ($maquina_result) {
            $_SESSION['mensaje_exito'] = "Juego de máquina agregado correctamente.";
            header("Location: estadisticasJuego.php");
            exit();
        } else {
            echo "Error al agregar juego de máquina: " . mysqli_error($enlace);
        }
    } elseif ($tipoJuego == 'mesa') {
        $numeroMesa = $_POST['numeroMesa'];
        $crupier = $_POST['crupier'];

        // Verificar si el juego o el crupier ya existen en la sucursal
        $verificar_query = "SELECT * FROM juego_mesa WHERE nombre = '$nombreJuego' AND sucursal_id = '$sucursal'";
        $verificar_crupier_query = "SELECT * FROM juego_mesa WHERE personal_id = '$crupier' AND sucursal_id = '$sucursal'";
        $verificar_result = mysqli_query($enlace, $verificar_query);
        $verificar_crupier_result = mysqli_query($enlace, $verificar_crupier_query);

        if (mysqli_num_rows($verificar_result) > 0 || mysqli_num_rows($verificar_crupier_result) > 0) {
            $_SESSION['mensaje_error'] = "El nombre del juego o el crupier ya están registrados.";
            header("Location: agregar_juego.php");
            exit();
        }

        // Procesamiento para juego de mesa
        $mesa_query = "INSERT INTO juego_mesa (sucursal_id, nombre, numero_mesa, personal_id) 
                       VALUES ('$sucursal', '$nombreJuego', '$numeroMesa', '$crupier')";
        $mesa_result = mysqli_query($enlace, $mesa_query);

        if ($mesa_result) {
            $_SESSION['mensaje_exito'] = "Juego de mesa agregado correctamente.";
            header("Location: estadisticasJuego.php");
            exit();
        } else {
            echo "Error al agregar juego de mesa: " . mysqli_error($enlace);
        }
    }
}

mysqli_close($enlace);
?>

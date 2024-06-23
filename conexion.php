<!DOCTYPE>
<html lang="es>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IF-edge">
    <meta name="viewport" content="width-device-width, initial-scale-1.0">
    <title>conexion mysql</title>
</head>
<body>
    <?php
    $enlace = mysqli_connect("localhost", "root", "", "casinolujan");

    if(!$enlace){
        die("no se conecto a la bd" . mysqli_error());
    }
    //echo "conexion exitosa";
    
    ?>
</body>

</html>
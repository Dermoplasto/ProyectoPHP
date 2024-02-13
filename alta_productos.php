<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("location:index.php");
    die();
}

include 'config.php';

try {
    $con = new PDO($dsn, $usuario, $contrasena);
} catch (PDOException $e) {
    die("Error de conexión: " . $e->getMessage());
}


if (isset($_POST['nombre'], $_POST['detalle'], $_POST['precio'], $_POST['fecalta'], $_POST['idcat'])) {
    $nombre = htmlspecialchars($_POST['nombre']);
    $detalle = htmlspecialchars($_POST['detalle']);
    $precio = (float) $_POST['precio'];
    $fecalta = $_POST['fecalta'];
    $idcat = (int) $_POST['idcat'];

    // Validaciones 
    $errores = [];

    if (empty($nombre)) {
        $errores['nombre'] = "No has puesto nombre";
    }

    if (empty($detalle)) {
        $errores['$detalle'] = "El detalle es obligatorio";
    }

    if ($precio <= 0) {
        $errores['precio'] = "El precio debe ser mayor que 0";
    }

    if (empty($fecalta)) {
        $errores['$fecalta'] = "La fecha de alta es requerida";
    }

    if ($idcat <= 0) {
        $errores['$idcat'] = "La categoría es requerida";
    }

    if (empty($errores)) {
        // Si no hay errores, insertará los datos en la base de datos
        $sql = "INSERT INTO productos (nombre, detalle, precio, fecalta, idcat) VALUES (:nombre, :detalle, :precio, :fecalta, :idcat)";
        $stmt = $con->prepare($sql);
        $params = [":nombre" => $nombre, ":detalle" => $detalle, ":precio" => $precio, ":fecalta" => $fecalta, ":idcat" => $idcat];

        if ($stmt->execute($params)) {
            echo "Producto añadido correctamente";
        } else {
            echo "No se ha podido añadir el producto";
            print_r($stmt->errorInfo()); // Imprime el error de la consulta SQL
        }
    } else {
        // Si hay errores, los imprime
        foreach ($errores as $error) {
            echo $error . "<br>";
        }
    }
} else {
    echo "Faltan datos";
}
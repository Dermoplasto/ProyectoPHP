<?php
session_start();
if (!isset($_SESSION['usuario'])) {
	header('Location: index.php');
	die();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>

<!-- Formulario para que el usuario pueda moverse más agil en la parte de back -->
<table style="background-color: #f2f2f2;">
        <tr>
        <tr><td><li class="active"><a href='indexAdmin.php'><span>Inicio</span></a></li></td>
				<td><li><a href='slides.php'><span>Formulario Slides</span></a></li></td>
				<td><li><a href='productos.php'><span>mantenimiento de productos</span></a></li></td>
        <td><li><a href='categorias.php'><span>Volver a las categorias</span></a></li></td>


      </table>

  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <style>
    body {
      background-image: url('images/fondoalta1.jpg');
     background-repeat: no-repeat;
     background-size: cover;
 
      font-family: Arial, sans-serif;
      margin: 20px;
    }

    form {
      width: 300px;
      margin-bottom: 20px;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
    }

    th, td {
      border: 1px solid #ddd;
      padding: 8px;
      text-align: left;
    }

    th {
      background-color: #f2f2f2;
    }

    button {
      padding: 8px;
      margin: 5px;
      cursor: pointer;
    }

    .btn-modificar {
      background-color: #4CAF50;
      color: white;
    }

    .btn-eliminar {
      background-color: #f44336;
      color: white;
    }

    
  </style>
  <title>Alta categoria</title>
</head>
<body>


<?php
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $imagen = $_FILES['imagen']['name'];

    $directorio = "imgcategorias/";
    $destino = $directorio . basename($_FILES["imagen"]["name"]);
    move_uploaded_file($_FILES["imagen"]["tmp_name"], $destino);

    try {
        $con = new PDO($dsn, $usuario, $contrasena);

        $sql = "INSERT INTO categorias (nombre, imagen) VALUES (:nombre, :imagen)";
        $stmt = $con->prepare($sql);
        $stmt->execute([':nombre' => $nombre, ':imagen' => $destino]);

        echo "Categoría añadida con éxito";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>

<form method="post" enctype="multipart/form-data">
    <table style="background-color: #f2f2f2;">>
        <tr>
            <td>Nombre de la categoría:</td>
            <td><input type="text" name="nombre" required></td>
        </tr>
        <tr>
            <td>Imagen de la categoría:</td>
            <td><input type="file" name="imagen" required></td>
        </tr>
        <tr>
            <td colspan="1"><input type="submit" value="Añadir categoría"></td>
        </tr>
    </table>
</form>
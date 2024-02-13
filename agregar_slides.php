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

if (isset($_POST['Enviar-Slides'])) {
    $nombre_slide = htmlspecialchars($_POST['Nombre']);

    if (!empty($_FILES['slide']['name'])) {
        $extension = pathinfo($_FILES['slide']['name'], PATHINFO_EXTENSION);
        if ($extension == "jpg" || $extension == "jpeg") {
            $nombre_fichero = "images/" . time() . "-" . str_replace(" ", "_", $_FILES['slide']['name']);

            try {
                $sql = "INSERT INTO slides(nombre,imagen) VALUES(:nombre,:imagen)";
                $stmt = $con->prepare($sql);
                if ($stmt->execute([":nombre" => $nombre_slide, ":imagen" => $nombre_fichero])) {
                    if (!move_uploaded_file($_FILES['slide']['tmp_name'], $nombre_fichero)) {
                        echo "No se ha subido la foto";
                    }
                } else {
                    echo "No se ha insertado el slide";
                }
            } catch (PDOException $e) {
                die("No se pudo insertar: " . $e->getMessage());
            }
        } else {
            echo "Extensión incorrecta";
        }
    } else {
        echo "No has selecionado la imagen";
    }
}
?>
<!DOCTYPE html>
<html>
<body>
<head>
<!-- Formulario para que el usuario pueda moverse más agil en la parte de back -->
        <table style="background-color: #f2f2f2;">
        <tr>
        <tr><td><li class="active"><a href='indexAdmin.php'><span>Inicio</span></a></li></td>
	    <td><li><a href='slides.php'><span>Volver al formulario de Slides</span></a></li></td>
		<td><li><a href='productos.php'><span>mantenimiento de productos</span></a></li></td>
        <td><li><a href='categorias.php'><span>mantenimiento de categorias</span></a></li></td>


      </table>




</head>

<h2>Agregar Slide</h2>

<?php
if (isset($errores)) {
    foreach ($errores as $error) {
        echo "<p style='color:red;'>{$error}</p>";
    }
}
?>

<form action="agregarslides.php" method="post" enctype="multipart/form-data">
    <label for="Nombre">Nombre:</label><br>
    <input type="text" id="Nombre" name="Nombre"><br>
    <label for="slide">Seleccionar imagen:</label><br>
    <input type="file" id="slide" name="slide" accept="image/jpeg"><br>
    <input type="submit" value="Enviar-Slides" name="Enviar-Slides">
</form>

</body>
</html>
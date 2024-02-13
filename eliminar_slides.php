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

if (isset($_POST['id_slide'])) {
    $id_slide = filter_input(INPUT_POST, 'id_slide', FILTER_VALIDATE_INT);
    if ($id_slide === false) {
        header("location:slides.php");
        die();
    }

    if (isset($_POST['aceptar'])) {
        try {
            $sql = "DELETE FROM slides WHERE id = :id";
            $stmt = $con->prepare($sql);
            if ($stmt->execute([":id" => $id_slide])) {
                if ($stmt->rowCount() != 1) {
                    $error = "No se pudo eliminar este slide";
                } else {
                    echo "Slide eliminado correctamente";
                }
            }
        } catch (PDOException $e) {
            die("Error al eliminar slide: " . $e->getMessage());
        }
    }
} else {
    header("location:slides.php");
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


<h2>Eliminar Slide</h2>

<form action="eliminareslides.php" method="post">
    <label for="id_slide">ID del Slide:</label><br>
    <input type="text" id="id_slide" name="id_slide"><br>
    <input type="submit" value="aceptar" name="aceptar">
</form>

</body>
</html>
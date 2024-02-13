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

if (isset($_POST['Eliminar-Slides'])) {
  $id_slide = htmlspecialchars($_POST['ID']);

  // Verificar si el ID del slide es un int
  if (!is_numeric($id_slide)) {
      echo "El ID del slide debe ser un número";
  } else {
      $id_slide = (int) $id_slide;

      $sql = "SELECT * FROM slides WHERE id=:id";
      $stmt = $con->prepare($sql);
      $stmt->execute([":id" => $id_slide]);
      $slide = $stmt->fetch();

      if ($slide) {
          // Si lo encuentra lo elimina
          $sql = "DELETE FROM slides WHERE id=:id";
          $stmt = $con->prepare($sql);
          if ($stmt->execute([":id" => $id_slide])) {
              echo "Slide eliminado correctamente";
          } else {
              echo "No se ha podido eliminar el slide";
              print_r($stmt->errorInfo()); // Imprime el error de la consulta SQL
          }
      } else {
          echo "No existe un slide con el ID proporcionado";
      }
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
        <td><li><a href='productos.php'><span>mantenimiento de productos</span></a></li></td>
        <td><li><a href='categorias.php'><span>mantenimiento de categorias</span></a></li></td>
      </table>
</head>

<h2>Agregar Slide</h2>

<form action="agregar_slides.php" method="post" enctype="multipart/form-data">
    <label for="Nombre">Nombre:</label><br>
    <input type="text" id="Nombre" name="Nombre"><br>
    <label for="slide">Seleccionar imagen:</label><br>
    <input type="file" id="slide" name="slide" accept="image/jpeg"><br>
    <input type="submit" value="Enviar-Slides" name="Enviar-Slides">
</form>

<h2>Eliminar Slide</h2>



<form action="slides.php" method="post">
    <label for="ID">ID del Slide a eliminar:</label><br>
    <input type="text" id="ID" name="ID"><br>
    <input type="submit" value="Eliminar-Slides" name="Eliminar-Slides">
</form>

</body>
</html>
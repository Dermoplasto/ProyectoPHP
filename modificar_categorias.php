<?php
session_start();
if (!isset($_SESSION['usuario'])) {
	header('Location: index.php');
	die();
}

if  (isset($_POST['idcat'])){
  $idcat=filter_input(INPUT_POST,'idcat',FILTER_VALIDATE_INT);
  if  ($idcat===false){
      header("location:categorias.php");
      die();
  }

  
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
  
</head>
<body>

<style>

    body {
      background-image: url('images/Hero.jpg');
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

<?php 
include 'config.php';

if  (isset($_POST['idcat'])){
    $idcat=filter_input(INPUT_POST,'idcat',FILTER_VALIDATE_INT);
    if  ($idcat===false){
        header("location:categorias.php");
        die();
    }

    try {
        $con = new PDO($dsn,$usuario,$contrasena);
    } catch(PDOException $e){
        die("Error de conexión");
    }

    if  (isset($_POST['aceptar'])){
        $nombre = $_POST['nombrecat'];
        $imagen = $_FILES['imagen']['name'];

        // Subir la imagen al servidor
        $directorio = "imgcategorias/";
        $destino = $directorio . basename($_FILES["imagen"]["name"]);
        move_uploaded_file($_FILES["imagen"]["tmp_name"], $destino);

        try {
            $sql="UPDATE categorias set nombre=:nom, imagen=:img where id=:x";
            $stmt=$con->prepare($sql);
            if  ($stmt->execute([":nom"=>$nombre, ":img"=>$destino, ":x"=>$idcat])){
                if  ($stmt->rowCount()!=1){
                    $error="Se ha producido un error al actualizar la categoría";
                } else {
                    echo "categoria actualizada";
                }
                
            }
        } catch (PDOException $e){
            die ("Error update".$e->getMessage());
        }
    }
} else {
    header("location:categorias.php");
}

try {
    $sql="SELECT * from categorias where id=:x";
    $stmt=$con->prepare($sql);
    if  ($stmt->execute([":x"=>$idcat])){
        if  ($fila=$stmt->fetch()){
?>
        <form method="post" enctype="multipart/form-data">
       
        <table style="background-color: #f2f2f2;">
        <tr>

           <tr><td>Nombre de categoría para modificar:</td>
            <td><input type="text" name="nombrecat" value="<?=$fila['nombre']?>"/><br/></td>
        </tr>  
         <tr><td>magen de la categoría: <input type="file" name="imagen" required><br/></td>
            <td><input type="hidden" name="idcat" value="<?=$idcat?>"/></td>
            <td><input type="submit"  name="aceptar" value="Aceptar"/></td>
        </tr>
        </table>
        </form>
            <?=isset($error) ? $error:""?>

<?php
        }
    }
} catch (PDOException $e){
    die ("error al conectar". $e->getMessage());
}
?>




</body>
</html>
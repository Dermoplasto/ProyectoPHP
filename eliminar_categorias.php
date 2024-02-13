<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    header("location:index.php");
    die();
}

?>

<!DOCTYPE html>
<html lang="es">
<head>

<!-- Formulario para moverse más agil en la parte de back -->
<table style="background-color: #f2f2f2;">
        <tr>
        <tr><td><li class="active"><a href='indexAdmin.php'><span>Inicio</span></a></li></td>
				<td><li><a href='slides.php'><span>Formulario Slides</span></a></li></td>
				<td><li><a href='categorias.php'><span>Volver al resto de mantenimiento de categorias</span></a></li></td>

  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
  <title>Eliminar categorias</title>
</head>
<body>

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
        die("EError de conexión");
    }


    if  (isset($_POST['aceptar'])){
        try {
            $sql="DELETE FROM categorias WHERE id=:x";
            $stmt=$con->prepare($sql);
            if  ($stmt->execute([":x"=>$idcat])){
                if  ($stmt->rowCount()!=1){
                    $error="No se pudo eliminar esta categoria";
                } else {
                    echo "Producto eliminado";
                }
                    
                
            }
        } catch (PDOException $e){
            die ("Error delete".$e->getMessage());
        }
    }
} else {
    header("location:categorias.php");
}
//Si llego aquí es porque todo está correcto

try {
   
    $sql="SELECT * from categorias where id=:x";
    $stmt=$con->prepare($sql);
    if  ($stmt->execute([":x"=>$idcat])){
        if  ($fila=$stmt->fetch()){
?>
      <form method="post" enctype="multipart/form-data">
    <table style="background-color: #f2f2f2;">
        <tr>  
            <td>Nombre de categoria para eliminar: <input type="text" name="nombrecat" value="<?=$fila['nombre']?>"/><br/></td>
            <input type="hidden" name="idcat" value="<?=$idcat?>"/>
            <input type="hidden" name="aceptar" value="1"/>
        </tr>
        <tr>
            <td colspan="1"><input type="submit" value="eliminar categoria"></td>
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
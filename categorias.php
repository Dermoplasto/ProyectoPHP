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
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  
 <!-- Formulario para que el usuario pueda moverse más agil en la parte de back -->
<table style="background-color: #f2f2f2;">
        <tr>
        <tr><td><li class="active"><a href='indexAdmin.php'><span>Inicio</span></a></li></td>
				<td><li><a href='slides.php'><span>Formulario Slides</span></a></li></td>
				<td><li><a href='productos.php'><span>mantenimiento de productos</span></a></li></td>
</table>
  
  
  <style>
    body {
      background-image: url('images/fondo.jpg');
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
    .categoria-imagen {
     width: 50px !important;
     height: auto !important;
     }

   .categoria-nombre {
   font-size: 50px !important;
   }
    
  </style>

  <!-- He creado dos estilos para que las fotos salgan bien en la tabla -->
  <title>Formulario de Artículos</title>
</head>
<body>

  <form id="articuloForm" action="alta_categoria.php">
    <input type="submit" name="alta" value="Dar de alta a una categoria">
  </form>

  <table>
    <tr>
      <th>Categoría</th>
       <th>Acciones</th>
      <th>Imagen</th>
    </tr>
    <?php 
    include 'config.php'; // traemos el include

    try {  // hacemos la conexión a la bd y antes de esto usamos el try catch para capturar errores
        $con = new PDO($dsn,$usuario,$contrasena);
        $sql="Select * from categorias";
        $stmt=$con->prepare($sql);
        if  ($stmt->execute()){
          while ($fila=$stmt->fetch()){ 
            ?>
        <tr> 
  <td class="categoria-nombre"><?=$fila['nombre']?></td>                
  <td><img class="categoria-imagen" src="<?=$fila['imagen']?>" alt="<?=$fila['nombre']?>"></td>                
  <td>
  <form action="modificar_categorias.php" method="post" style="display: inline;">
    <input type="hidden" name="idcat" value="<?=$fila['id']?>">
    <input type="submit" class="btn-modificar" value="Modificar">
  </form>
  <form action="eliminar_categorias.php" method="post" style="display: inline;">
    <input type="hidden" name="idcat" value="<?=$fila['id']?>">
    <input type="submit" class="btn-eliminar" value="Eliminar">
  </form>
</td>
</tr>
            <?php
          }

        }

    } catch (PDOException $e){ 
      echo $stmt->debugDumpParams();
      die("Error de conexión".$e->getMessage());
    }
    ?>
  </table>

  <header class="main-header">
			<div class="zerogrid">
				<div class="row">
					<div class="col-1-1">
						<a class="site-branding" href="index.php">
						
						</a><!-- .site-branding -->
					</div>
					<div class="col-2-3">
						<!-- Menu-main -->
						<div id='cssmenu' class="align-right">
							<ul>

        						

							</ul>
						</div>
					</div>
				</div>
			</div>
		</header>

    <form id="articuloForm" action="alta_categoria.php" method="post">


  </form>

</body>
</html>
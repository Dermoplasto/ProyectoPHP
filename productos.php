<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header('Location: index.php');
    die();
}
include 'config.php';

try {
    $con = new PDO($dsn, $usuario, $contrasena);
} catch (PDOException $e) {
    die("Error de conexión: " . $e->getMessage());
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
        <td><li><a href='categorias.php'><span>mantenimiento de categorias</span></a></li></td>
      </table>
</head>



<?php
// categorias
$sql = "SELECT * FROM categorias";
$stmt = $con->prepare($sql);
$stmt->execute();
$categorias = $stmt->fetchAll();

//  productos cada producto tiene una categoria (idcat)
$sql = "SELECT * FROM productos";
$stmt = $con->prepare($sql);
$stmt->execute();
$productos = $stmt->fetchAll();
?>

<!-- Formulario para añadir un nuevo producto -->
<form action="alta_productos.php" method="post">
    <label for="nombre">Nombre:</label><br>
    <input type="text" id="nombre" name="nombre"><br>
    <label for="detalle">Detalle:</label><br>
    <textarea id="detalle" name="detalle"></textarea><br>
    <label for="precio">Precio:</label><br>
    <input type="number" id="precio" name="precio" step="0.01"><br>
    <label for="fecalta">Fecha de alta:</label><br>
    <input type="date" id="fecalta" name="fecalta"><br>
    <label for="idcat">Categoría:</label><br>
    <select id="idcat" name="idcat">
        
    <?php foreach ($categorias as $categoria): ?>
            <option value="<?= $categoria['id'] ?>"><?= $categoria['nombre'] ?></option>
        <?php endforeach; ?>
    </select><br>
    <input type="submit" value="Añadir producto">
</form>

<!-- Lista de productos -->
<table>
    <tr>
        <th>Nombre</th>
        <th>Detalle</th>
        <th>Precio</th>
        <th>Fecha de alta</th>
        <th>Categoría</th>
        <th>Acciones</th>
    </tr>
    <?php foreach ($productos as $producto): ?>
        <tr>
            <td><?= $producto['nombre'] ?></td>
            <td><?= $producto['detalle'] ?></td>
            <td><?= $producto['precio'] ?></td>
            <td><?= $producto['fecalta'] ?></td>
            <td><?= $producto['idcat'] ?></td>
            <td>
            <form action="modificar_productos.php" method="post">
                    <input type="hidden" name="idpr" value="<?= $producto['id'] ?>">
                    <input type="submit" value="Modificar">
                </form>
                <form action="eliminar_productos.php" method="post">
                    <input type="hidden" name="idpr" value="<?= $producto['id'] ?>">
                    <input type="submit" value="Eliminar">
                </form>
            </td>
        </tr>
    <?php endforeach; ?>


    </body>
    </html>

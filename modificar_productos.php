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
    die("Error de conexión");
}

if (isset($_POST['idpr'])) {
    $idpr = filter_input(INPUT_POST, 'idpr', FILTER_VALIDATE_INT);
    if ($idpr === false) {
        header("location:productos.php");
        die();
    }

    if (isset($_POST['aceptar'])) {
        $nombreproducto = $_POST['nombreproducto'];
        $detalleproducto = $_POST['detalleproducto'];
        $precioproducto = $_POST['precioproducto'];
        $fechaproducto = $_POST['fechaproducto'];

        try {
            $sql = "UPDATE productos SET nombre = :nom, detalle = :det, precio = :pre, fecalta = :fec WHERE id = :x";
            $stmt = $con->prepare($sql);
            if ($stmt->execute([":nom" => $nombreproducto, ":det" => $detalleproducto, ":pre" => $precioproducto, ":fec" => $fechaproducto, ":x" => $idpr])) {
                if ($stmt->rowCount() != 1) {
                    $error = "No se pudo modificar el producto";
                } else {
                    echo "Producto modificado";
                }
            }
        } catch (PDOException $e) {
            die("Error update" . $e->getMessage());
        }
    }

    try {
        $sql = "SELECT * FROM productos WHERE id = :x";
        $stmt = $con->prepare($sql);
        if ($stmt->execute([":x" => $idpr])) {
            if ($fila = $stmt->fetch()) {
?>
               <form method="post" enctype="multipart/form-data">
           
           <table style="background-color: #f2f2f2;">
           <tr>

            <tr><td>Nombre del producto: <input type="text" name="nombreproducto" value="<?= $fila['nombre'] ?>" /><br /></td>
            <td>Detalle del producto: <input type="text" name="detalleproducto" value="<?= $fila['detalle'] ?>" /><br /></td>
            <td>Precio del producto: <input type="text" name="precioproducto" value="<?= $fila['precio'] ?>" /><br /></td>
            <td>Fecha de alta del producto: <input type="text" name="fechaproducto" value="<?= $fila['fecalta'] ?>" /><br /></td>

                    
                    <input type="hidden" name="idpr" value="<?= $idpr ?>" />
                    <input type="submit" name="aceptar" value="Aceptar" />
            </tr>
            </table>

                </form>
                <?= isset($error) ? $error : "" ?>
<?php
            }
        }
    } catch (PDOException $e) {
        die("error al conectar" . $e->getMessage());
    }
}
?>
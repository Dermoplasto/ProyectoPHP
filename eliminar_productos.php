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

    try {
        $sql = "DELETE FROM productos WHERE id = :x";
        $stmt = $con->prepare($sql);
        if ($stmt->execute([":x" => $idpr])) {
            if ($stmt->rowCount() != 1) {
                $error = "No se pudo eliminar el producto";
            } else {
                echo "Producto eliminado";
            }
        }
    } catch (PDOException $e) {
        die("Error al eliminar" . $e->getMessage());
    }
}
?>
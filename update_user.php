<?php
require_once 'Conexion.php';

$id = $_POST['id'];
$nombre = $_POST['nombre'];
$correo = $_POST['correo'];

try {
    $pdo = new Conexion();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $pdo->prepare("UPDATE usuarios SET nombre = :nombre, correo = :correo WHERE id = :id");
    $stmt->bindParam(':id', $id);
    $stmt->bindParam(':nombre', $nombre);
    $stmt->bindParam(':correo', $correo);
    $stmt->execute();

    echo json_encode(array('success' => true));
} catch(PDOException $e) {
    echo json_encode(array('error' => $e->getMessage()));
}
?>

<?php
require_once 'Conexion.php';

$id = $_POST['id'];

try {
    $pdo = new Conexion();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $pdo->prepare("DELETE FROM usuarios WHERE id = :id");
    $stmt->bindParam(':id', $id);
    $stmt->execute();

    echo json_encode(array('success' => true));
} catch(PDOException $e) {
    echo json_encode(array('error' => $e->getMessage()));
}
?>

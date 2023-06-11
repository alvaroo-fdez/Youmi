<?php
require_once 'Conexion.php';

$id = $_GET['id'];

try {
    $pdo = new Conexion();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE id = :id");
    $stmt->bindParam(':id', $id);
    $stmt->execute();

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    echo json_encode($user);
} catch(PDOException $e) {
    echo json_encode(array('error' => $e->getMessage()));
}
?>

<?php
require_once 'Conexion.php';

try {
    $pdo = new Conexion();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $pdo->query("SELECT * FROM usuarios WHERE rol != 0");
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($users);
} catch(PDOException $e) {
    echo json_encode(array('error' => $e->getMessage()));
}
?>

<?php
require_once 'Conexion.php';
$con = new Conexion();

$id_recibe_like = $_POST['id_usuario_recibe'];

// Check if the user has already disliked the profile
$query = "SELECT * FROM dislikes WHERE id_da_like = :id_da_like AND id_recibe_like = :id_recibe_like";
$stmt = $con->prepare($query);
$stmt->bindParam(':id_da_like', $_COOKIE['id']);
$stmt->bindParam(':id_recibe_like', $id_recibe_like);
$stmt->execute();

// If the user has already disliked the profile, do nothing
if ($stmt->rowCount() > 0) {
    echo json_encode(['status' => 'already_liked']);
    exit;
}

// Otherwise, add a new dislike to the database
$query = "INSERT INTO dislikes (id_da_like, id_recibe_like) VALUES (:id_da_like, :id_recibe_like)";
$stmt = $con->prepare($query);
$stmt->bindParam(':id_da_like', $_COOKIE['id']);
$stmt->bindParam(':id_recibe_like', $id_recibe_like);
$stmt->execute();

// Verificar si hay un match
$queryMatch = "SELECT * FROM dislikes WHERE id_da_like = :id_recibe_like AND id_recibe_like = :id_da_like";
$stmtMatch = $con->prepare($queryMatch);
$stmtMatch->bindParam(':id_da_like', $_COOKIE['id']);
$stmtMatch->bindParam(':id_recibe_like', $id_recibe_like);
$stmtMatch->execute();


echo json_encode(array('match' => false, 'mensaje' => $mensaje));

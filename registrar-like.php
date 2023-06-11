<?php
require_once 'Conexion.php';
$con = new Conexion();

$id_recibe_like = $_POST['id_usuario_recibe'];

// Check if the user has already liked the profile
$query = "SELECT * FROM likes WHERE id_da_like = :id_da_like AND id_recibe_like = :id_recibe_like";
$stmt = $con->prepare($query);
$stmt->bindParam(':id_da_like', $_COOKIE['id']);
$stmt->bindParam(':id_recibe_like', $id_recibe_like);
$stmt->execute();

// If the user has already liked the profile, do nothing
if ($stmt->rowCount() > 0) {
    echo json_encode(['status' => 'already_liked']);
    exit;
}

// Otherwise, add a new like to the database
$query = "INSERT INTO likes (id_da_like, id_recibe_like) VALUES (:id_da_like, :id_recibe_like)";
$stmt = $con->prepare($query);
$stmt->bindParam(':id_da_like', $_COOKIE['id']);
$stmt->bindParam(':id_recibe_like', $id_recibe_like);
$stmt->execute();

// Verificar si hay un match
$queryMatch = "SELECT * FROM likes WHERE id_da_like = :id_recibe_like AND id_recibe_like = :id_da_like";
$stmtMatch = $con->prepare($queryMatch);
$stmtMatch->bindParam(':id_da_like', $_COOKIE['id']);
$stmtMatch->bindParam(':id_recibe_like', $id_recibe_like);
$stmtMatch->execute();

// Si hay un match, mostrar notificación de match
if ($stmtMatch->rowCount() > 0) {
    $stmtNickname = $con->prepare("SELECT nickname FROM perfiles WHERE id_usuario = :id_usuario");
    $stmtNickname->bindParam(':id_usuario', $id_recibe_like);
    $stmtNickname->execute();
    $Nickname = $stmtNickname->fetch(PDO::FETCH_ASSOC)['nickname'];

    // Construir el mensaje de match como una cadena de texto
    $mensaje = 'Has hecho match con @' . $Nickname;
    $stmtFoto = $con->prepare("SELECT ruta FROM fotos WHERE id_usuario = :id_usuario ORDER BY id ASC");
    $stmtFoto->bindParam(':id_usuario', $id_recibe_like);
    $stmtFoto->execute();
    $rutaFoto = $stmtFoto->fetch(PDO::FETCH_ASSOC)['ruta']; 

    $queryNuevomatch = "INSERT INTO matches (user1_id, user2_id) VALUES (:id_da_like, :id_recibe_like)";
    $stmtNuevomatch = $con->prepare($queryNuevomatch);
    $stmtNuevomatch->bindParam(':id_da_like', $_COOKIE['id']);
    $stmtNuevomatch->bindParam(':id_recibe_like', $id_recibe_like);
    $stmtNuevomatch->execute();

    // Devolver la respuesta incluyendo el mensaje
    echo json_encode(array('match' => true, 'mensaje' => $mensaje, 'rutafoto' => $rutaFoto, 'respuestamatch' => $stmtNuevomatch));
} else {
    // Construir el mensaje de like como una cadena de texto
    $mensaje = 'Has dado like a este usuario.';
    // Devolver la respuesta incluyendo el mensaje
    echo json_encode(array('match' => false, 'mensaje' => $mensaje));
}

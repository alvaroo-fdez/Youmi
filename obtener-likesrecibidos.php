<?php
require_once 'Conexion.php';

function obtenerFoto($userId)
{
  // Conexión a la base de datos utilizando PDO
  $pdo = new Conexion();

  // Consulta para obtener la ruta de la foto del usuario
  $query = 'SELECT ruta FROM fotos WHERE id_usuario = :userId ORDER BY id ASC';
  $stmt = $pdo->prepare($query);
  $stmt->bindParam(':userId', $userId);
  $stmt->execute();

  // Obtener el resultado de la consulta
  $imagen = $stmt->fetch(PDO::FETCH_ASSOC);

  // Cerrar la conexión a la base de datos
  $pdo = null;

  return $imagen;
}

$con = new Conexion();

// Obtener el ID del usuario logueado desde $_COOKIE['id']
$userId = $_COOKIE['id'];

// Consulta para obtener los matches del usuario logueado
$stmt = $con->prepare("SELECT perfiles.*
FROM perfiles
JOIN likes ON perfiles.id_usuario = likes.id_da_like
LEFT JOIN matches ON (perfiles.id_usuario = matches.user1_id AND likes.id_recibe_like = matches.user2_id) OR (perfiles.id_usuario = matches.user2_id AND likes.id_recibe_like = matches.user1_id)
WHERE likes.id_recibe_like = :userId
  AND matches.id IS NULL;
");
$stmt->bindParam(':userId', $userId);
$stmt->execute();

// Obtener los resultados como un array asociativo
$likes_recibidos = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Consulta para obtener la foto de cada match del usuario logueado
$stmt2 = $con->prepare("SELECT ruta FROM fotos WHERE id_usuario = :userId ORDER BY id ASC");
$stmt2->bindParam(':userId', $userId);
$stmt2->execute();

foreach ($likes_recibidos as &$cada_like) {
  $ruta = obtenerFoto($cada_like['id_usuario']);
  $cada_like['ruta'] = $ruta['ruta'];
}

// Cerrar la conexión PDO
$con = null;

// Enviar los resultados como respuesta en formato JSON
header('Content-Type: application/json');
echo json_encode($likes_recibidos);

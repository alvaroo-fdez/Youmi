<?php
require_once 'Conexion.php';

try {
    // Conectar a la base de datos
    $conn = new Conexion();

    // Habilitar el modo de excepciones para errores de PDO
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Obtener los datos del formulario
    $latitud = $_POST["latitud"];
    $longitud = $_POST["longitud"];
    $id = $_POST["id"];

    // Verificar si la ubicación ya existe en la tabla de ubicaciones
    $sql = "SELECT * FROM ubicaciones WHERE usuario_id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        // La ubicación ya existe, actualizarla
        $sql = "UPDATE ubicaciones SET latitud = :latitud, longitud = :longitud WHERE usuario_id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':latitud', $latitud);
        $stmt->bindParam(':longitud', $longitud);
        $stmt->bindParam(':id', $id);
        if ($stmt->execute()) {
            echo "La ubicación se ha actualizado correctamente.";
        } else {
            echo "Error al actualizar la ubicación: " . $stmt->errorInfo()[2];
        }
    } else {
        // La ubicación no existe, insertarla
        $sql = "INSERT INTO ubicaciones (usuario_id, latitud, longitud) VALUES (:id, :latitud, :longitud)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':latitud', $latitud);
        $stmt->bindParam(':longitud', $longitud);
        if ($stmt->execute()) {
            echo "La ubicación se ha insertado correctamente.";
        } else {
            echo "Error al insertar la ubicación: " . $stmt->errorInfo()[2];
        }
    }
} catch(PDOException $e) {
    // Manejar errores de la conexión PDO
    echo "Error de conexión a la base de datos: " . $e->getMessage();
}
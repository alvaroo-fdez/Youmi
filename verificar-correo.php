<?php
// Verificar si se ha enviado un código de verificación
if (isset($_GET['codigo'])) {
    $codigoVerificacion = $_GET['codigo'];

    // Buscar el usuario correspondiente al código de verificación
    $sql = "SELECT * FROM usuarios WHERE codigo_verificacion = :codigo_verificacion";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':codigo_verificacion', $codigoVerificacion);
    $stmt->execute();
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    // Si se encuentra un usuario con el código de verificación proporcionado
    if ($usuario) {
        // Actualizar el registro del usuario para indicar que su dirección de correo electrónico ha sido verificada
        $sql = "UPDATE usuarios SET correo_verificado = 1 WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $usuario['id']);
        $stmt->execute();

        echo "¡Tu dirección de correo electrónico ha sido verificada exitosamente!";
    } else {
        echo "El código de verificación es inválido o ya ha sido utilizado.";
    }
} else {
    echo "No se proporcionó un código de verificación.";
}

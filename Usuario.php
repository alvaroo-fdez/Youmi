<?php

require_once 'PHPMailer\src\PHPMailer.php';
require_once 'PhpMailer\src\Exception.php';
require_once 'PhpMailer\src\SMTP.php';
require_once 'Conexion.php';

class Usuario{
    private $nombre;
    private $correo;
    private $password;

    function __construct($nombre, $correo, $password) {
        $this->nombre = $nombre;
        $this->correo = $correo;
        $this->password = $password;
    }


    function insertaUsuario(){
        $con = new Conexion();
        $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $con->prepare("SELECT * FROM usuarios WHERE correo = :correo");
        $stmt->bindParam(':correo', $this->correo);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $resultado = 4;
        } else {
            try {
                $stmt = $con->prepare('INSERT INTO `usuarios` (`nombre`, `correo`, `contraseña`, `codigo_verificacion`) VALUES (?, ?, ?, ?)');
                
                $passencr = password_hash($this->password, PASSWORD_DEFAULT);
                $verificationCode = uniqid();
    
                $stmt->bindParam(1, $this->nombre);
                $stmt->bindParam(2, $this->correo);
                $stmt->bindParam(3, $passencr);
                $stmt->bindParam(4, $verificationCode);


                if($stmt->execute()){
                    $resultado = 2;
                }else{
                    $resultado = 3;
                }
            
            } catch(PDOException $e) {
                echo "Error al insertar usuario: " . $e->getMessage();
            }
        }
        
        return $resultado;
    }
}
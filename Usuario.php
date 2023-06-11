<?php

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
                $stmt = $con->prepare('INSERT INTO `usuarios` (`nombre`, `correo`, `contraseña`, `codigo_verificacion`, `rol`) VALUES (?, ?, ?, ?, 1)');
                
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

    static function compruebaLogin($correo, $password){
        $con = new Conexion();
        $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $con->prepare("SELECT `contraseña` FROM `usuarios` WHERE `correo` = :correo");
        $stmt->bindParam(':correo', $correo);
        $stmt->execute();
        
        $contra = $stmt->fetch(PDO::FETCH_ASSOC)['contraseña'];
        
        if(password_verify($password, $contra)){

            $stmt2 = $con->prepare("SELECT `id` FROM `usuarios` WHERE `correo` = :correo");
            $stmt2->bindParam(':correo', $correo);
            $stmt2->execute();

            $id = $stmt2->fetch(PDO::FETCH_ASSOC)['id'];

            $stmt4 = $con->prepare("SELECT `rol` FROM `usuarios` WHERE `id` = :id_user");
            $stmt4->bindParam(':id_user', $id);
            $stmt4->execute();

            if($stmt4->fetch(PDO::FETCH_ASSOC)["rol"] == 0){
                setcookie('correo', $correo, time()+3600*24*365*100);
                setcookie('id', $id, time()+3600*24*365*100);
                header("Location: admin.php");
            }else{
                $stmt3 = $con->prepare("SELECT `id_usuario` FROM `perfiles` WHERE `id_usuario` = :id");
                $stmt3->bindParam(':id', $id);
                $stmt3->execute();
    
                $creado = $stmt3->fetch(PDO::FETCH_ASSOC);
    
                if($creado){
                    $stmt4 = $con->prepare("SELECT `nombre` FROM `usuarios` WHERE `id` = :id");
                    $stmt4->bindParam(':id', $id);
                    $stmt4->execute();
    
                    $nombre = $stmt4->fetch(PDO::FETCH_ASSOC)['nombre'];
    
                    session_start();
    
                    $_SESSION['correo'] = $correo;
                    $_SESSION['nombre'] = $nombre;
    
                    setcookie('correo', $correo, time()+3600*24*365*100);
                    setcookie('id', $id, time()+3600*24*365*100);
                    setcookie('nombre', $nombre, time()+3600*24*365*100);
        
                    header("Location: inicio.php");
                }else{
                    $_SESSION['correo'] = $correo;
                    setcookie('correo', $correo, time()+3600*24*365*100);
                    setcookie('id', $id, time()+3600*24*365*100);
    
                    $stmt4 = $con->prepare("SELECT `nombre` FROM `usuarios` WHERE `id` = :id");
                    $stmt4->bindParam(':id', $id);
                    $stmt4->execute();
    
                    $nombre = $stmt4->fetch(PDO::FETCH_ASSOC)['nombre'];
    
                    setcookie('nombre', $nombre, time()+3600*24*365*100);
    
                    header("Location: creacion.php");
                }
            } 
        }else{
            header('location: login.php?mensajelogin=error');
        }
    }
}
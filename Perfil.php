<?php 

require_once 'Conexion.php';

class Perfil{
    private $id_usuario;
    private $nickname;
    private $edad;
    private $genero;
    private $generoamostrar;
    private $fechanacimiento;
    private $mostrargenero;
    //private $imagenes;

    function __construct($id_usuario, $nickname, $edad, $genero, $generoamostrar, $mostrargenero, $fechanacimiento/*, $imagenes*/) {
        $this->id_usuario = $id_usuario;
        $this->nickname = $nickname;
        $this->edad = $edad;
        $this->genero = $genero;
        $this->generoamostrar = $generoamostrar;
        $this->mostrargenero = $mostrargenero;
        $this->fechanacimiento = $fechanacimiento;
       // $this->imagenes = $imagenes;
    }

    function creaPerfil(){
        $con = new Conexion();
        $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $con->prepare('INSERT INTO `perfiles` (`id_usuario`, `nickname`, `edad`, `género`, `generoamostrar`, `mostrar_genero`, `fecha_nacimiento`) VALUES (?, ?, ?, ?, ?, ?, ?)');
        
        $stmt->bindParam(1, $this->id_usuario);
        $stmt->bindParam(2, $this->nickname);
        $stmt->bindParam(3, $this->edad);
        $stmt->bindParam(4, $this->genero);
        $stmt->bindParam(5, $this->generoamostrar);
        $stmt->bindParam(6, $this->mostrargenero);
        $stmt->bindParam(7, $this->fechanacimiento);

        if($stmt->execute()){
            $resultado = true;
            $id = $_COOKIE['id'];

            $stmt2 = $con->prepare("SELECT `id_usuario` FROM `perfiles` WHERE `id_usuario` = :id_usuario");
            $stmt2->bindParam(':id_usuario', $id);
            $stmt2->execute();

            $id_usuario = $stmt2->fetch(PDO::FETCH_ASSOC);

            if($id_usuario){
                header("Location: inicio.php");
            }
        }else{
            $resultado = false;
        }

        return $resultado;
    }

    function insertajuegos($juegos){
        $con = new Conexion();
        $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        foreach ($juegos as $juego) {
            foreach($juego as $nombre => $nada){
                $sql = "INSERT INTO usuarios_juegos (id_usuario, juego) VALUES ($this->id_usuario, '" . $nombre . "')";

                $stmt = $con->prepare($sql);

                $stmt->execute();
            }
        }

    }

    function actualizaPerfil(){
        $con = new Conexion();
        $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $con->prepare('UPDATE `perfiles` SET `nickname`=:nickname,`edad`=:edad,`género`=:genero,`generoamostrar`=:generoamostrar,`mostrar_genero`=:mostrar_genero,`fecha_nacimiento`=:fecha_nacimiento WHERE id_usuario = :id');

        $stmt->bindParam(':nickname', $this->nickname);
        $stmt->bindParam(':edad', $this->edad);
        $stmt->bindParam(':genero', $this->genero);
        $stmt->bindParam(':generoamostrar', $this->generoamostrar);
        $stmt->bindParam(':mostrar_genero', $this->mostrargenero);
        $stmt->bindParam(':fecha_nacimiento', $this->fechanacimiento);
        $stmt->bindParam(':id', $_COOKIE['id']);

        if($stmt->execute()){
            $resultado = true;
            header("Location: editar_perfil.php");
        }else{
            $resultado = false;
        }

        return $resultado;
    }

    function actualizajuegos($juegos){
        $con = new Conexion();
        $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $con->prepare("DELETE FROM `usuarios_juegos` WHERE `id_usuario`=:id_usuario");
        $stmt->bindParam(':id_usuario', $_COOKIE['id']);
        $stmt->execute();
        
        foreach ($juegos as $juego) {
            foreach($juego as $nombre => $nada){
                $sql = "INSERT INTO usuarios_juegos (id_usuario, juego) VALUES ($this->id_usuario, '" . $nombre . "')";

                $stmt2 = $con->prepare($sql);

                $stmt2->execute();
            }
        }

    }

    
}
?>
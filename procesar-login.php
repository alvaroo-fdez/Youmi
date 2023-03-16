<?php
require_once 'Usuario.php';

if(isset($_POST['btlogin'])){
    $emailLogin = htmlspecialchars($_POST['emaillogin']);
    $passwordLogin = htmlspecialchars($_POST['passlogin']);

    $usuario = new Usuario($nombre, $email, $password);

    $insercion = $usuario->insertaUsuario();

    //echo $insercion;

        if($insercion == 2){
            header('location: login.php?mensaje=exito');
            
        }else if($insercion == 3){
            header('location: login.php?mensaje=error');
        }
    
}
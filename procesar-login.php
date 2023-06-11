<?php
require_once 'Usuario.php';

if(isset($_POST['btlogin'])){
    $emailLogin = htmlspecialchars($_POST['emaillogin']);
    $passwordLogin = htmlspecialchars($_POST['passlogin']);

    Usuario::compruebaLogin($emailLogin, $passwordLogin);
        
}
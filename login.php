<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./assets/css/formulario.css">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.17/dist/sweetalert2.min.css">
    <link href="assets/img/recursos/logotipos/favicon.png" rel="icon">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.17/dist/sweetalert2.all.min.js"></script>
    <title>Youmi</title>
</head>
<?php
	require_once 'Conexion.php';
	require_once 'Usuario.php';

    if(isset($_COOKIE['id'])){
        $id = $_COOKIE['id'];
        $con = new Conexion();
        $stmt = $con->prepare("SELECT * FROM `perfiles` WHERE `id` = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $existe = $stmt->fetch(PDO::FETCH_ASSOC);
    
        if($existe){
            header("Location: inicio.php");
        }else{
            $stmt2 = $con->prepare("SELECT rol FROM `usuarios` WHERE `id` = :id");
            $stmt2->bindParam(':id', $id);
            $stmt2->execute();
            $admin = $stmt2->fetch(PDO::FETCH_ASSOC)["rol"];
            if($admin == 0){
                header("Location: admin.php");
            }else{
                header("Location: creacion.php");
            }
        }
    }
?>

<body>
    <?php if(isset($_GET['mensaje'])){
    if($_GET['mensaje'] == 'exito'){
		?>
    <script>
    $("#overlay").css("display", "block");

    // Mostrar mensaje emergente utilizando SweetAlert
    Swal.fire({
        title: 'Registro exitoso',
        text: '¡Te has registrado satisfactoriamente!',
        icon: 'success',
        confirmButtonText: 'OK'
    }).then((result) => {
        if (result.isConfirmed) {
            // Redireccionar al index
            window.location.href = 'login.php';
        }

        // Ocultar capa de superposición
        $("#overlay").css("display", "none");
    });

    $("body").removeClass("swal2-height-auto");
    </script>
    <?php
        
    }else if($_GET['mensaje'] == 'error'){
		?>
    <script>
    $("#overlay").css("display", "block");

    // Mostrar mensaje emergente utilizando SweetAlert
    Swal.fire({
        title: 'Error',
        text: 'Ha habido algún error con el registro',
        icon: 'error',
        confirmButtonText: 'OK'
    }).then((result) => {
        if (result.isConfirmed) {
            // Redireccionar al index
            window.location.href = 'login.php';
        }

        // Ocultar capa de superposición
        $("#overlay").css("display", "none");
    });

    $("body").removeClass("swal2-height-auto");
    </script>
    <?php
	}

}

if(isset($_GET['mensajelogin'])){
	if($_GET['mensajelogin'] == 'error'){
		?>
    <script>
    $("#overlay").css("display", "block");

    // Mostrar mensaje emergente utilizando SweetAlert
    Swal.fire({
        title: 'Contraseña incorrecta',
        text: 'La contraseña no coincide con la que tenemos en nuestro sistema',
        icon: 'error',
        confirmButtonText: 'OK'
    }).then((result) => {
        if (result.isConfirmed) {
            // Redireccionar al index
            window.location.href = 'login.php';
        }

        // Ocultar capa de superposición
        $("#overlay").css("display", "none");
    });

    $("body").removeClass("swal2-height-auto");
    </script>
    <?php
	}
}
?>
    <div class="container" id="container">
        <div class="form-container sign-up-container">
            <form action="procesar-registro.php" method="POST" id="formulario-registro">
                <h1 class="titulocrear">Crear cuenta</h1>
                <div class="group">
                    <input type="text" required="" name="nombreregistro" id="nombreregistro" class="input" />
                    <span class="bar"></span>
                    <label>Nombre</label>

                </div>
                <div class="input-error-message" id="nombreregistro-error"></div>

                <div class="group">
                    <input type="text" required="" name="emailregistro" id="emailregistro" class="input" />
                    <span class="bar"></span>
                    <label>Correo electrónico</label>

                </div>
                <div class="input-error-message" id="emailregistro-error"></div>

                <div class="group">
                    <input type="password" required="" name="passregistro" id="passregistro" class="input" />
                    <span class="bar"></span>
                    <label>Contraseña</label>

                </div>
                <div class="input-error-message" id="passregistro-error"></div>

                <button type="submit" name="btregistro" id="btregistro">Registrarse</button>
            </form>

        </div>
        <div class="form-container sign-in-container">
            <form action="procesar-login.php" method="POST">
                <h1 class="titulocrear">Iniciar sesión</h1>
                <div class="group">
                    <input type="text" required="" name="emaillogin" id="emaillogin" class="input" />
                    <span class="bar"></span>
                    <label>Correo electrónico</label>
                </div>
                <div class="input-error-message" id="emaillogin-error"></div>

                <div class="group">
                    <input type="password" required="" name="passlogin" id="passlogin" class="input" />
                    <span class="bar"></span>
                    <label>Contraseña</label>
                </div>
                <div class="input-error-message" id="passlogin-error"></div>

                <a href="#" class="olvidaste">¿Has olvidado tu contraseña?</a>
                <button type="submit" name="btlogin">Iniciar sesión</button>
            </form>
        </div>
        <div class="overlay-container">
            <div class="overlay">
                <div class="overlay-panel overlay-left">
                    <h1>¡Bienvenido de vuelta!</h1>
                    <p>Para conectarte con nosotros, inicia sesión con tus credenciales</p>
                    <button class="ghost" id="signIn">Iniciar sesión</button>
                </div>
                <div class="overlay-panel overlay-right">
                    <h1>¡Hola amig@!</h1>
                    <p>Entra con tus datos y empieza una nueva aventura con nosotros</p>
                    <button class="ghost" id="signUp">Registrarse</button>
                </div>
            </div>
        </div>
    </div>
    <script src="./assets/js/formulario.js"></script>   
</body>

</html>
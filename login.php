<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/formulario.css">
	<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.17/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.17/dist/sweetalert2.all.min.js"></script>
    <title>Youmi</title>
</head>
<?php
	require_once 'Conexion.php';
	require_once 'Usuario.php';


?>
<body>
<?php if(isset($_GET['mensaje'])){
    if($_GET['mensaje'] == 'exito'){
		?>
	<script>
		

		 $("#overlay").css("display","block");

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
	$("#overlay").css("display","none");
});

$("body").removeClass("swal2-height-auto");
	</script>
		<?php
        
    }else if($_GET['mensaje'] == 'error'){
		?>
	<script>
		

		 $("#overlay").css("display","block");

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
	$("#overlay").css("display","none");
});

$("body").removeClass("swal2-height-auto");
	</script>
		<?php
	}

} ?>
<div class="container" id="container">
	<div class="form-container sign-up-container">
	<form action="procesar-registro.php" method="POST" id="formulario-registro">
  <h1>Crear una cuenta</h1>
  <input type="text" placeholder="Nombre" name="nombreregistro" id="nombreregistro"/>
  <div class="input-error-message" id="nombreregistro-error"></div>
  <input type="email" placeholder="Email" name="emailregistro" id="emailregistro"/>
  <div class="input-error-message" id="emailregistro-error"></div>
  <input type="password" placeholder="Contraseña" name="passregistro" id="passregistro"/>
  <div class="input-error-message" id="passregistro-error"></div>
  <button type="submit" name="btregistro" id="btregistro">Registrarse</button>
</form>

	</div>
	<div class="form-container sign-in-container">
		<form action="comprobar-login.php" method="POST">
			<h1>Iniciar sesión</h1>
			<input type="email" placeholder="Email" name="emaillogin" id="emaillogin"/>
			<div class="input-error-message" id="emaillogin-error"></div>
			<input type="password" placeholder="Contraseña" name="passlogin" id="passlogin"/>
			<div class="input-error-message" id="passlogin-error"></div>
			<a href="#">¿Has olvidado tu contraseña?</a>
			<button type="submit" name="btlogin">Iniciar sesión</button>
		</form>
	</div>
	<div class="overlay-container">
		<div class="overlay">
			<div class="overlay-panel overlay-left">
				<h1>¡Bienvenido de vuelta!</h1>
				<p>To keep connected with us please login with your personal info</p>
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
            <script src="./js/formulario.js"></script>
</body>
</html>
$(document).ready(function () {
    let cambioregistro = $("#signUp");
    let cambiologin = $("#signIn");
    let contenedor = $("#container");
    let btregistro = $("#btregistro");

    var validaNombreRegisto = false;
    var validaCorreoRegistro = false;
    var validaPassRegistro = false;

    cambioregistro.on("click", function () {
        contenedor.addClass("right-panel-active");
    });

    cambiologin.on("click", function () {
        contenedor.removeClass("right-panel-active");
    });

    btregistro.on("click", validarRegistro);

    $('#nombreregistro').on('keyup', function () {
        let nombre = $(this).val().trim();
        let patronNombre = /^[a-zA-ZñÑ]{4,16}$/;

        if (nombre.length < 4 || nombre.length > 16) {
            $(this).addClass('input-error');
            $('#nombreregistro-error').text('El nombre de usuario debe tener entre 4 y 16 caracteres.');
        } else {
            if (!patronNombre.test(nombre)) {
                $(this).addClass('input-error');
                $('#nombreregistro-error').text('Solo se aceptan caracteres alfabéticos');
            } else {
                $(this).removeClass('input-error');
                $('#nombreregistro-error').text('');
                validaNombreRegisto = true;
            }
        }
    });

    // Validar correo electrónico
    $('#emailregistro').on('keyup', function () {
        let email = $(this).val().trim();
        let patronMail = /^[-\w.%+]{1,64}@(?:[A-Z0-9-]{1,63}\.){1,125}[A-Z]{2,63}$/i;

        if (!patronMail.test(email)) {
            $(this).addClass('input-error');
            $('#emailregistro-error').text('Por favor ingrese un correo electrónico válido.');
        } else {
            $(this).removeClass('input-error');
            $('#emailregistro-error').text('');
            validaCorreoRegistro = true;
        }
    });

    // Validar contraseña
    $('#passregistro').on('keyup', function () {
        let password = $(this).val().trim();
        let patronPassword = /^(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#$&*])(?=.{8,})/;

        if (password.length < 8) {
            $(this).addClass('input-error');
            $('#passregistro-error').text('La contraseña debe tener al menos 8 caracteres.');
        } else {
            if (!patronPassword.test(password)) {
                $(this).addClass('input-error');
                $('#passregistro-error').text('La contraseña debe tener al menos una letra mayúscula. un número y un carácter especial');
            } else {
                $(this).removeClass('input-error');
                $('#passregistro-error').text('');
                validaPassRegistro = true;
            }
        }
    });

    // Validar correo electrónico
    $('#emaillogin').on('keyup', function () {
        let email = $(this).val().trim();
        let patronMail = /^[-\w.%+]{1,64}@(?:[A-Z0-9-]{1,63}\.){1,125}[A-Z]{2,63}$/i;

        if (!patronMail.test(email)) {
            $(this).addClass('input-error');
            $('#emaillogin-error').text('Por favor ingrese un correo electrónico válido.');
        } else {
            $(this).removeClass('input-error');
            $('#emaillogin-error').text('');
        }
    });

    // Validar contraseña
    $('#passlogin').on('keyup', function () {
        let passwordLogin = $(this).val().trim();
        let patronPasswordLogin = /^(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#$&*])(?=.{8,})/;

        if (passwordLogin.length < 8) {
            $(this).addClass('input-error');
            $('#passlogin-error').text('La contraseña debe tener al menos 8 caracteres.');
        } else {
            if (!patronPasswordLogin.test(passwordLogin)) {
                $(this).addClass('input-error');
                $('#passlogin-error').text('La contraseña debe tener al menos una letra mayúscula. un número y un carácter especial');
            } else {
                $(this).removeClass('input-error');
                $('#passlogin-error').text('');
            }
        }
    });

    // Obtener referencia al campo de correo electrónico y al elemento de error correspondiente
let emailregistro = $('#emailregistro');
let emailerror = $('#emailregistro-error');

// Cuando el campo de correo electrónico pierde el foco, enviar una solicitud AJAX al servidor
emailregistro.on('blur', function() {
  let email = emailregistro.val();

  $.ajax({
    url: 'comprobar-email.php',
    data: { email: email },
    dataType: 'json',
    success: function(data) {
      if (data.existe) {
        emailerror.text('Este correo electrónico ya está en uso');
        emailerror.addClass('active');
        validaCorreoRegistro = false;
      } else {
        if(validaCorreoRegistro){
            emailerror.text('');
            validaCorreoRegistro = true;
        }
        emailerror.removeClass('active');
      }
    },
    error: function() {
      console.log('Error al comprobar el correo electrónico');
    }
  });
});

function validarRegistro(e){
    console.log("nombre = " + validaNombreRegisto);
    console.log("correo = " + validaCorreoRegistro);
    console.log("password = " + validaPassRegistro);

    if(!validaNombreRegisto || !validaCorreoRegistro || !validaPassRegistro){
        e.preventDefault();

        if($("#nombreregistro").val().trim() == 0){
            $('#nombreregistro-error').text('Por favor, indique un nombre');
        }
        
        if($("#emailregistro").val().trim() == ""){
            $('#emailregistro-error').text('Por favor, indique un correo');
        }

        if($("#passregistro").val().trim() == ""){
            $('#passregistro-error').text('Por favor, indique una contraseña');
        }

        
       
        return false;
    }
}

    var validaCorreoLogin = false;

    // Obtener referencia al campo de correo electrónico y al elemento de error correspondiente
    let emaillogin = $('#emaillogin');
    let emailerrorlogin = $('#emaillogin-error');
    
    // Cuando el campo de correo electrónico pierde el foco, enviar una solicitud AJAX al servidor
    emaillogin.on('blur', function() {
      let email = emaillogin.val();
    
      $.ajax({
        url: 'comprobar-email.php',
        data: { email: email },
        dataType: 'json',
        success: function(data) {
          if (!data.existe) {
            emailerrorlogin.text('No existe ninguna cuenta con este correo asociado');
            emailerrorlogin.addClass('active');
            validaCorreoLogin = true;
          } else {
            if(validaCorreoLogin){
                emailerrorlogin.text('');
                validaCorreoLogin = true;
            }
            emailerrorlogin.removeClass('active');
          }
        },
        error: function() {
          console.log('Error al comprobar el correo electrónico');
        }
      });
    });


});





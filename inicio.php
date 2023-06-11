<?php

function calcularDistancia($lat1, $lon1, $lat2, $lon2)
{
  $radioTierra = 6371;

  $latitud1 = deg2rad($lat1);
  $longitud1 = deg2rad($lon1);
  $latitud2 = deg2rad($lat2);
  $longitud2 = deg2rad($lon2);

  $dlat = $latitud2 - $latitud1;
  $dlon = $longitud2 - $longitud1;

  $a = sin($dlat / 2) * sin($dlat / 2) + cos($latitud1) * cos($latitud2) * sin($dlon / 2) * sin($dlon / 2);
  $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
  $distancia = $radioTierra * $c;

  $distancia = round($distancia);

  return $distancia;
}

require_once 'Conexion.php';

if (isset($_COOKIE['id'])) {
  $id = $_COOKIE['id'];
  $con = new Conexion();
  $stmt = $con->prepare("SELECT * FROM `perfiles` WHERE `id_usuario` = :id");
  $stmt->bindParam(':id', $id);
  $stmt->execute();
  $existe = $stmt->fetch(PDO::FETCH_ASSOC);

  if (!$existe) {
    $stmt2 = $con->prepare("SELECT rol FROM `usuarios` WHERE `id` = :id");
    $stmt2->bindParam(':id', $id);
    $stmt2->execute();
    $admin = $stmt2->fetch(PDO::FETCH_ASSOC)["rol"];
    if ($admin == 0) {
      header("Location: admin.php");
    } else {
      header("Location: creacion.php");
    }
  }
} else {
  header("Location: login.php");
}

$con = new Conexion();
$con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$stmt = $con->prepare("SELECT ruta FROM `fotos` WHERE id_usuario = :id_usuario ORDER BY id ASC");
$stmt->bindParam(':id_usuario', $_COOKIE['id']);
$stmt->execute();
$ruta = $stmt->fetch(PDO::FETCH_ASSOC)['ruta'];

$ubication = $con->prepare("SELECT latitud, longitud FROM `ubicaciones` WHERE usuario_id = :id_usuario ORDER BY id ASC");
$ubication->bindParam(':id_usuario', $_COOKIE['id']);
$ubication->execute();
$ubilocal = $ubication->fetchAll(PDO::FETCH_ASSOC);

if ($ubilocal) {
  $longitudlocal = $ubilocal[0]["longitud"];
  $latitudlocal = $ubilocal[0]["latitud"];
}


if (isset($_POST['cerrarsesion'])) {
  setcookie('correo', '', time() - 3600 * 24 * 365 * 100);
  setcookie('id', '', time() - 3600 * 24 * 365 * 100);
  setcookie('nombre', '', time() - 3600 * 24 * 365 * 100);

  header('Location: ./login.php');
}

function generoamostrar($userId)
{
  $conn = new Conexion();

  $query = "SELECT generoamostrar FROM perfiles WHERE id_usuario = :user_id";

  $stmt = $conn->prepare($query);

  $stmt->bindParam(':user_id', $userId);

  $stmt->execute();

  $generoamostrar = $stmt->fetch(PDO::FETCH_ASSOC);

  $conn = null;

  return $generoamostrar;
}

$genero_muestra = generoamostrar($_COOKIE['id'])['generoamostrar'];

function obtenerMatches($userId)
{

  try {
    $conn = new Conexion();

    $query = "SELECT * FROM matches WHERE (user1_id = :userId OR user2_id = :userId)";

    $stmt = $conn->prepare($query);

    $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);

    $stmt->execute();

    $matches = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $conn = null;

    return $matches;
  } catch (PDOException $e) {
    // Manejo de errores
    echo "Error al obtener los matches: " . $e->getMessage();
    return null;
  }
}

function obtenerPerfil($userId)
{
  $pdo = new Conexion();

  $query = 'SELECT * FROM perfiles WHERE id_usuario = :userId';
  $stmt = $pdo->prepare($query);
  $stmt->bindParam(':userId', $userId);
  $stmt->execute();

  $perfil = $stmt->fetch(PDO::FETCH_ASSOC);

  $pdo = null;

  return $perfil;
}

function obtenerFoto($userId)
{
  $pdo = new Conexion();

  $query = 'SELECT ruta FROM fotos WHERE id_usuario = :userId ORDER BY id ASC';
  $stmt = $pdo->prepare($query);
  $stmt->bindParam(':userId', $userId);
  $stmt->execute();

  $imagen = $stmt->fetch(PDO::FETCH_ASSOC);

  $pdo = null;

  return $imagen;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="assets/img/recursos/logotipos/favicon.png" rel="icon">
  <link rel="stylesheet" href="./assets/css/inicio.css">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css" />
  <title>Youmi</title>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="assets/js/mostrarventana.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.17/dist/sweetalert2.all.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js"></script>
</head>

<body>
  <div id="loader">
    <span id="loader-text"><img src="./assets/img/recursos/logotipos/logotipoblanco.png" class="palpitar"></span>
  </div>
  <aside>
    <div id="top-aside">
      <a href="editar_perfil.php" id="enlace-editar-perfil">
        <div id="top-aside-fotoynombre">
          <img src="./<?php echo $ruta ?>" alt="" id="foto-perfil-aside">
          <span id="nombre-perfil-aside"><?php echo $_COOKIE['nombre'] ?></span>
        </div>
      </a>
      <div id="top-aside-cerrarsesion">
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
          <button id="cerrarsesion" name="cerrarsesion">Cerrar sesión</button>
        </form>
      </div>
    </div>
    <div id="bottom-aside">
      <div id="header-aside">
        <ul id="lista-aside">
          <li data-ventana="matches" class="active"><a href="#">Matches</a></li>
          <li data-ventana="mensajes"><a href="#">Likes recibidos</a></li>
        </ul>
      </div>
      <div id="ventanas">
        <!-- Ventana de matches -->
        <div class="ventana visible" id="ventana-matches">
          <h2 style="padding: 20px 0 20px 25px; border-bottom: 1px solid #e9e9e9;margin:0">Mis matches</h2>
          <p style="padding-left: 20px;">Aquí te saldran los matches que tengas.</p>
        </div>
        <!-- Ventana de mensajes -->
        <div class="ventana" id="ventana-mensajes">
          <h2 style="padding: 20px 0 20px 25px; border-bottom: 1px solid #e9e9e9;margin:0">Mis mensajes</h2>
          <p style="padding-left: 20px;">Aquí te saldran los likes que has recibido.</p>
        </div>
      </div>
    </div>
  </aside>

  <div id="perfiles">
    <!-- HTML de la interfaz del chat -->
    <div id="chat-container">
      <div id="chat-messages"></div>
      <form id="chat-form" data-user-id="">
        <input type="text" id="message-input" placeholder="Escribe un mensaje..." />
        <button type="submit">Enviar</button>
      </form>
    </div>
    <?php
    try {
      $conexion = new Conexion();
      $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
      die("Error de conexión a la base de datos: " . $e->getMessage());
    }
    $mostrar_perfil = true;
    // Obtener todos los perfiles de la base de datos
    $sql = 'SELECT * FROM perfiles WHERE id_usuario != ' . $_COOKIE['id'] . ' AND id_usuario NOT IN (SELECT id_recibe_like FROM likes WHERE id_da_like = ' . $_COOKIE['id'] . ') AND id_usuario NOT IN (SELECT id_recibe_like FROM dislikes WHERE id_da_like = ' . $_COOKIE['id'] . ')';
    $resultado = $conexion->query($sql);

    $numPerfiles = $resultado->rowCount();

    /* var_dump($resultado->fetchAll()); */

    // Mostrar cada perfil en la página
    while ($perfil = $resultado->fetch(PDO::FETCH_ASSOC)) {
      $id = $perfil["id"];
      $id_usuario = $perfil["id_usuario"];
      $nickname = $perfil["nickname"];
      $edad = $perfil["edad"];
      $genero = $perfil["género"];
      $mostrar_genero = $perfil["mostrar_genero"];

      $stmt2 = $conexion->prepare("SELECT ruta FROM `fotos` WHERE id_usuario = :id_usuario ORDER BY id ASC");
      $stmt2->bindParam(':id_usuario', $id_usuario);
      $stmt2->execute();
      $ruta2 = $stmt2->fetch(PDO::FETCH_ASSOC)['ruta'];

      $stmt3 = $conexion->prepare("SELECT latitud, longitud FROM `ubicaciones` WHERE usuario_id = :id_usuario ORDER BY id ASC");
      $stmt3->bindParam(':id_usuario', $id_usuario);
      $stmt3->execute();
      $ubi = $stmt3->fetchAll(PDO::FETCH_ASSOC);

      //var_dump($ubi);
      if ($ubi) {
        $longitudperfil = $ubi[0]["longitud"];
        $latitudperfil = $ubi[0]["latitud"];
      }



      if ($genero_muestra == "mujeres" && $genero == "hombre") {
        $mostrar_perfil = false;
      }
      if ($genero_muestra == "hombres" && $genero == "mujer") {
        $mostrar_perfil = false;
      }

      if ($mostrar_perfil) {
    ?>

        <div class="perfil" id="<?php echo $id; ?>" data-user-id="<?php echo $id_usuario ?>">
          <span class="respuesta-like" style="opacity: 0">ME GUSTA</span>
          <span class="respuesta-dislike" style="opacity: 0;">NOPE</span>
          <div class="slider">
            <?php
            $stmt2 = $conexion->prepare("SELECT ruta FROM `fotos` WHERE id_usuario = :id_usuario ORDER BY id ASC");
            $stmt2->bindParam(':id_usuario', $id_usuario);
            $stmt2->execute();
            $fotos = $stmt2->fetchAll(PDO::FETCH_ASSOC);

            if ($fotos) {
              foreach ($fotos as $foto) {
                $ruta = $foto['ruta'];
                echo '<div class="slide" style="background-image: url(\'' . $ruta . '\')"></div>';
              }
            }
            ?>
          </div>

          <div class="info-card-bottom">
            <div class="texto-info-card">
              <p class="nickname-card">@<?php echo $nickname ?> <span class="edad-card"><?php echo $edad ?></span></p>
              <?php
              if (isset($latitudlocal) && isset($longitudlocal) && isset($latitudperfil) && isset($longitudperfil)) {
              ?>
                <p style="font-size: 13px;"><i class="bi bi-geo-alt"></i> A <?php echo calcularDistancia($latitudlocal, $longitudlocal, $latitudperfil, $longitudperfil) ?> kilómetros de distancia</p>
              <?php
              }
              if ($mostrar_genero) {
                echo '<p style="font-size: 13px;">Género:  <span style="text-transform: capitalize">' . $genero . '</span></p>';
              }

              $stmt4 = $con->prepare("SELECT `juego` FROM `usuarios_juegos` WHERE `id_usuario` = :id");
              $stmt4->bindParam(':id', $id_usuario);
              $stmt4->execute();
              $juegos = $stmt4->fetchAll(PDO::FETCH_ASSOC);

              ?>
              <div id="juegos-seleccionados">
                <?php
                foreach ($juegos as $juego) {
                ?>
                  <div class="elemento-seleccionado"><?php echo $juego["juego"] ?></div>
                <?php
                }
                ?>
              </div>
            </div>

            <div id="botones-like-no-like">
              <button class="no-like" id="<?php echo $id_usuario ?>"><i class="bi bi-x-lg"></i></button>
              <button class="like" id="<?php echo $id_usuario ?>"><i class="bi bi-heart-fill"></i></button>
            </div>
          </div>

        </div>
    <?php
      }
    }

    if (!$mostrar_perfil) {
      $numPerfiles--;
    }

    if ($numPerfiles == 0) {
      echo '<div id="mensaje-final">No hay más perfiles para mostrar.</div>';
    }
    echo '<div id="mensaje-final" style="display:none">No hay más perfiles para mostrar.</div>';

    $conexion = null;
    ?>
  </div>

</body>


<script>
  var ubicacionEnviada = false;

  function obtenerUbicacion() {
    if (navigator.geolocation) {
      navigator.geolocation.getCurrentPosition(actualizarUbicacion, mostrarError);
    } else {
      alert("La geolocalización no está soportada por este navegador.");
    }
  }

  function actualizarUbicacion(posicion) {
    var latitud = posicion.coords.latitude;
    var longitud = posicion.coords.longitude;
    var id = <?php echo $_COOKIE["id"] ?>;

    if (!ubicacionEnviada) {
      fetch("guardar-ubicacion.php", {
          method: "POST",
          headers: {
            "Content-Type": "application/x-www-form-urlencoded"
          },
          body: "latitud=" + latitud + "&longitud=" + longitud + "&id=" + id
        })
        .then(response => {
          console.log(response.text());
          ubicacionEnviada = true; 
        })
        .catch(error => {
          console.error(error);
        });
    }
  }

  function mostrarError(error) {
    console.error("Error al obtener la ubicación: " + error.message);
  }

  window.addEventListener("load", function() {
    obtenerUbicacion();
  });
</script>

<script>
  var perfiles = document.querySelectorAll('.perfil');
  var perfil_actual = 0;

  if (typeof perfiles[perfil_actual] !== 'undefined') {
    perfiles[perfil_actual].style.display = 'flex';
    perfiles[perfil_actual].style.flexDirection = 'column';
    perfiles[perfil_actual].style.justifyContent = 'flex-end';
  }


  function siguientePerfil() {
    perfiles[perfil_actual].style.animation = 'slideOutRight 1.25s forwards';

    var respuestadiseno = perfiles[perfil_actual].children[0];

    respuestadiseno.className += " respuesta-visible";

    perfiles[perfil_actual].addEventListener('animationend', function() {
      perfiles[perfil_actual].style.display = 'none';
      perfiles[perfil_actual].style.animation = '';
      perfiles[perfil_actual].style.transform = '';

      perfil_actual++;
      if (perfil_actual >= perfiles.length) {
        document.getElementById('mensaje-final').style.display = 'block';
        return;
      }

      perfiles[perfil_actual].style.display = 'flex';
      perfiles[perfil_actual].style.flexDirection = 'column';
      perfiles[perfil_actual].style.justifyContent = 'flex-end';
    });
  }

  function siguientePerfilDislike() {
    perfiles[perfil_actual].style.animation = 'slideOutLeft 1.25s forwards';

    var respuestadiseno1 = perfiles[perfil_actual].children[1];
    respuestadiseno1.className += " respuesta-visible";

    perfiles[perfil_actual].addEventListener('animationend', function() {
      perfiles[perfil_actual].style.display = 'none';
      perfiles[perfil_actual].style.animation = '';
      perfiles[perfil_actual].style.transform = '';

      perfil_actual++;
      if (perfil_actual >= perfiles.length) {
        document.getElementById('mensaje-final').style.display = 'block';
        return;
      }

      perfiles[perfil_actual].style.display = 'flex';
      perfiles[perfil_actual].style.flexDirection = 'column';
      perfiles[perfil_actual].style.justifyContent = 'flex-end';
    });
  }

  $(document).ready(function() {
    $('.like').on('click', siguientePerfil);
    $('.no-like').on('click', siguientePerfilDislike);
  });

  $('.like').on('click', function() {
    let id_usuario = $(this).attr('id');

    console.log(id_usuario);

    // Insertar un registro en la tabla de likes
    $.ajax({
      url: 'registrar-like.php',
      type: 'POST',
      data: {
        id_usuario_recibe: id_usuario
      },
      success: function(response) {
        try {
          /* console.log(response); */
          var data = JSON.parse(response);
          var mensaje = data.mensaje;
          var match = data.match;
          var rutafoto = data.rutafoto;

          if (match) {
            Swal.fire({
              title: "¡Match!",
              html: `<div class="custom-content">
                        <img class="custom-image" src="${rutafoto}" alt="Foto de perfil">
                        <div class="custom-text">${mensaje}</div>
                      </div>`,
              showCloseButton: true,
              showConfirmButton: false,
              customClass: {
                content: 'custom-swal-content'
              }

            });
          }

          $.getJSON('obtener-matches.php', function(responsematch) {
            console.log(responsematch);

            if (responsematch.length > 0) {
              $('#ventana-matches').empty();

              $('#ventana-matches').append('<h2 style="padding-left: 20px; ">Mis matches</h2>');
              for (var i = 0; i < responsematch.length; i++) {
                var match = responsematch[i];
                console.log(match.id);
                matchHTML += '<li class="li-match-profile-list">';
                matchHTML += '<span href="#" class="match-profile-list" id="' + match.id + '">';
                matchHTML += '<div class="match-profile-list-container">';
                matchHTML += '<img src="./' + match.ruta + '" alt="" id="foto-perfil-aside">';
                matchHTML += '<p>@' + match.nickname + '</p>';
                matchHTML += '</div>';
                matchHTML += '</span>';
                matchHTML += '</li>';
                $('#ventana-matches').append(matchHTML);
              }
            }
          });
        } catch (error) {
          console.log("Error al analizar la respuesta:", error);
        }
      }

    });
  });

  $('.no-like').on('click', function() {
    // Obtener el id del perfil
    let id_usuario = $(this).attr('id');

    console.log(id_usuario);

    // Insertar un registro en la tabla de dislikes
    $.ajax({
      url: 'registrar-dislike.php',
      type: 'POST',
      data: {
        id_usuario_recibe: id_usuario
      },
      success: function(response) {
        /* console.log(response); */
      }
    });
  });
</script>
<script>
  function obtenerActualizacionesMatches() {
    $.getJSON('obtener-matches.php', function(responsematch) {
      console.log(responsematch);

      if (responsematch.length > 0) {
        $('#ventana-matches').empty();

        $('#ventana-matches').append('<h2 style="padding: 20px 0 20px 25px; border-bottom: 1px solid #e9e9e9;margin:0">Mis matches</h2>');

        // Mostrar los matches en el aside
        for (var i = 0; i < responsematch.length; i++) {
          var match = responsematch[i];
          console.log(match.id);
          var rutaFotoPerfil = match.ruta;
          precargarImagenPerfil(rutaFotoPerfil);

          var matchHTML = '<li class="li-match-profile-list">';
          matchHTML += '<span href="#" class="match-profile-list" id="' + match.id + '">';
          matchHTML += '<div class="match-profile-list-container">';
          matchHTML += '<img src="./' + match.ruta + '" alt="" id="foto-perfil-aside">';
          matchHTML += '<p>@' + match.nickname + '</p>';
          matchHTML += '</div>';
          matchHTML += '</span>';
          matchHTML += '</li>';
          $('#ventana-matches').append(matchHTML);
        }
      }
    });
  }

  function precargarImagenPerfil(rutaFoto) {
    var img = new Image();
    img.src = rutaFoto;
  }

  obtenerActualizacionesMatches();

  setInterval(obtenerActualizacionesMatches, 1000);
</script>

<script>
  function obtenerActualizacionesLikesRecibidos() {
    $.getJSON('obtener-likesrecibidos.php', function(responsematch) {
      //console.log(responsematch);

      if (responsematch.length > 0) {
        $('#ventana-mensajes').empty();

        $('#ventana-mensajes').append('<h2 style="padding: 20px 0 20px 25px; border-bottom: 1px solid #e9e9e9;margin:0">Likes recibidos</h2>');

        // Mostrar los matches en el aside
        for (var i = 0; i < responsematch.length; i++) {
          var match = responsematch[i];
          //console.log(match.id);
          var rutaFotoPerfil = match.ruta;

          // Precargar la imagen de perfil
          precargarImagenPerfil(rutaFotoPerfil);

          var matchHTML = '<li class="li-match-profile-list">';
          matchHTML += '<span href="#" class="match-profile-list" id="' + match.id + '">';
          matchHTML += '<div class="match-profile-list-container">';
          matchHTML += '<img src="./' + match.ruta + '" alt="" id="foto-perfil-aside">';
          matchHTML += '<p>@' + match.nickname + '</p>';
          matchHTML += '</div>';
          matchHTML += '</span>';
          matchHTML += '</li>';
          $('#ventana-mensajes').append(matchHTML);
        }
      }
    });
  }

  setInterval(obtenerActualizacionesLikesRecibidos, 1000);
</script>
<script src="./assets/js/loader.js"></script>
<script src="./assets/js/slider.js"></script>
  
</script>

</html>
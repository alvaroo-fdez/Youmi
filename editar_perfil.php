<?php
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

$conn = new Conexion();
$stmt3 = $con->prepare("SELECT * FROM `perfiles` WHERE `id_usuario` = :id");
$stmt3->bindParam(':id', $id);
$stmt3->execute();
$perfil = $stmt3->fetch(PDO::FETCH_ASSOC);
// var_dump($perfil);

// Obtener juegos favoritos del usuario actual
$con = new Conexion();
$con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$stmt = $con->prepare("SELECT juego FROM usuarios_juegos WHERE id_usuario = :userId");
$stmt->bindValue(':userId', $id);
$stmt->execute();

$juegosSeleccionados = $stmt->fetchAll(PDO::FETCH_COLUMN);


?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="assets/img/recursos/logotipos/favicon.png" rel="icon">
  <title>Youmi</title>
  <link rel="stylesheet" href="./assets/css/creacion.css">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
</head>

<body>
  <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
  <div id="loader">
    <span id="loader-text"><img src="./assets/img/recursos/logotipos/logotipoblanco.png" class="palpitar"></span>
  </div>
  <?php session_start(); ?>
  <div class="container">

  <a href="./inicio.php" style="text-decoration:none;color:#000"><i class="bi bi-arrow-90deg-left"></i> Volver</a>

    <h1>Editar mi perfil</h1>
    <form action="procesar-edicion.php" method="POST" id="formulario-perfil" enctype="multipart/form-data">
      <div id="todo-sin-boton">
        <div>
          <div class="group">
            <input type="text" name="nombre" id="nickname" value="<?php echo $perfil["nickname"] ?>" required>
            <span class="bar"></span>
            <label>Nickname</label>
          </div>
          <div id="errorNickname" class="error"></div>

          <div class="group">
            <input type="text" value="<?php echo $_COOKIE['correo'] ?>" readonly>
            <span class="bar"></span>
          </div>

          <h3>Fecha de nacimiento</h3>
          <div class="group">
            <input type="date" name="fechanacimiento" id="fecha" value="<?php echo $perfil["fecha_nacimiento"] ?>">
            <span class="bar"></span>
          </div>
          <div id="errorDate" class="error"></div>

          <h3>Género</h3>
          <div class="radio-buttons">
            <label>
              <input type="radio" name="genero" value="hombre" <?php if ($perfil["género"] == "hombre") { ?> checked <?php } ?>>
              <span>Hombre</span>
            </label>
            <label>
              <input type="radio" name="genero" value="mujer" <?php if ($perfil["género"] == "mujer") { ?> checked <?php } ?>>
              <span>Mujer</span>
            </label>
          </div>
          <div id="errorGenero" class="error"></div>

          <div class="checkbox-container">
            <input type="checkbox" id="show-gender" name="mostrar-genero" value="yes" <?php if ($perfil["mostrar_genero"]) { ?> checked <?php } ?>>
            <label for="show-gender" id="show-gender-label">Mostrar mi género en el perfil</label>
          </div>

          <h3 id="genero-2">Muéstrame</h3>
          <div class="radio-buttons">
            <label>
              <input type="radio" name="muestrame-genero" value="hombres" <?php if ($perfil["generoamostrar"] == "hombres") { ?> checked <?php } ?>>
              <span>Hombres</span>
            </label>
            <label>
              <input type="radio" name="muestrame-genero" value="mujeres" <?php if ($perfil["generoamostrar"] == "mujeres") { ?> checked <?php } ?>>
              <span>Mujeres</span>
            </label>
            <label>
              <input type="radio" name="muestrame-genero" value="todos" <?php if ($perfil["generoamostrar"] == "todos") { ?> checked <?php } ?>>
              <span>Todos</span>
            </label>
          </div>
          <div id="errorMuestraGenero" class="error"></div>

          <div class="separacion"></div>

          <span id="add-favorite-games"><i class="bi bi-pencil-square"></i> &nbsp; Editar juegos favoritos</span>

          <div id="modal" class="modal">
            <div class="modal-content">
              <span class="close">&times;</span>
              <h2>Selecciona tus juegos favoritos</h2>
              <ul id="game-list">
                <?php
                $con = new Conexion();
                $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


                $stmt = $con->prepare("SELECT * FROM `videojuegos`");
                $stmt->execute();

                while ($videojuegos = $stmt->fetch()) {
                  $isChecked = in_array($videojuegos['nombre'], $juegosSeleccionados);
                  if ($isChecked) {
                    $juegosSeleccionadosDefault[] = $videojuegos['nombre'];
                  }
                ?>
                  <li>
                    <label>
                      <input type="checkbox" value="<?php echo $videojuegos['nombre']; ?>" <?php if ($isChecked) echo 'checked'; ?>>
                      <span><?php echo $videojuegos['nombre']; ?></span>
                    </label>
                  </li>
                <?php
                }


                ?>
              </ul>
              <span id="save-favorite-games">Guardar</span>
            </div>
          </div>
          <div class="separacion-media"></div>
          <div id="juegos-seleccionados"></div>

          <div id="juegos-seleccionados-inputs" style="display:none">
          </div>
          <div id="errorVideojuegos" class="error"></div>
        </div>

        <div class="imagenes">
          <h3>Foto de perfil</h3>
          <div class="distribucion-imagenes">
            <div class="imagen">
              <div class="contenedor-imagen">
                <img id="imagen1-preview" class="imagen-preview hidden" src="" alt="Previsualización de la imagen 1">
                <div class="subir-imagen">
                  <label for="imagen1" class="boton-subir">
                    <i class="bi bi-plus"></i>
                  </label>
                  <input type="file" id="imagen1" name="imagen1" accept=".jpg, .jpeg, .png" onchange="previsualizarImagen(event, 'imagen1-preview')">
                </div>
              </div>
            </div>

            <div class="imagen">
              <div class="contenedor-imagen">
                <img id="imagen2-preview" class="imagen-preview hidden" src="" alt="Previsualización de la imagen 2">
                <div class="subir-imagen">
                  <label for="imagen2" class="boton-subir">
                    <i class="bi bi-plus"></i>
                  </label>
                  <input type="file" id="imagen2" name="imagen2" accept=".jpg, .jpeg, .png" onchange="previsualizarImagen(event, 'imagen2-preview')">
                </div>
              </div>
            </div>

            <div class="imagen">
              <div class="contenedor-imagen">
                <img id="imagen3-preview" class="imagen-preview hidden" src="" alt="Previsualización de la imagen 3">
                <div class="subir-imagen">
                  <label for="imagen3" class="boton-subir">
                    <i class="bi bi-plus"></i>
                  </label>
                  <input type="file" id="imagen3" name="imagen3" accept=".jpg, .jpeg, .png" onchange="previsualizarImagen(event, 'imagen3-preview')">
                </div>
              </div>
            </div>

            <div class="imagen">
              <div class="contenedor-imagen">
                <img id="imagen4-preview" class="imagen-preview hidden" src="" alt="Previsualización de la imagen 4">
                <div class="subir-imagen">
                  <label for="imagen4" class="boton-subir">
                    <i class="bi bi-plus"></i>
                  </label>
                  <input type="file" id="imagen4" name="imagen4" accept=".jpg, .jpeg, .png" onchange="previsualizarImagen(event, 'imagen4-preview')">
                </div>
              </div>
            </div>

            <div class="imagen">
              <div class="contenedor-imagen">
                <img id="imagen5-preview" class="imagen-preview hidden" src="" alt="Previsualización de la imagen 5">
                <div class="subir-imagen">
                  <label for="imagen5" class="boton-subir">
                    <i class="bi bi-plus"></i>
                  </label>
                  <input type="file" id="imagen5" name="imagen5" accept=".jpg, .jpeg, .png" onchange="previsualizarImagen(event, 'imagen5-preview')">
                </div>
              </div>
            </div>

            <div class="imagen">
              <div class="contenedor-imagen">
                <img id="imagen6-preview" class="imagen-preview hidden" src="" alt="Previsualización de la imagen 6">
                <div class="subir-imagen">
                  <label for="imagen6" class="boton-subir">
                    <i class="bi bi-plus"></i>
                  </label>
                  <input type="file" id="imagen6" name="imagen6" accept=".jpg, .jpeg, .png" onchange="previsualizarImagen(event, 'imagen6-preview')">
                </div>
              </div>
            </div>
          </div>
          <p style="text-align:center"><strong>Añade al menos 2 fotos para continuar</strong></p>
          <p class="error" id="errorImagenes" style="text-align: center"></p>
        </div>

      </div>
      <button type="submit" value="Enviar" id="enviar">Actualizar</button>
    </form>
  </div>

  <script src="./assets/js/edicion.js"></script>

  <script>
    function previsualizarImagen(event, idPreview) {
      const input = event.target;
      const preview = document.getElementById(idPreview);
      const reader = new FileReader();

      reader.onload = function() {
        preview.src = reader.result;
        preview.classList.remove("hidden");
      };

      if (input.files && input.files[0]) {
        reader.readAsDataURL(input.files[0]);
      } else {
        preview.src = '';
        preview.classList.add("hidden");
      }

      /* Nueva comprobación para ocultar el botón si no hay imagen seleccionada */
      const contenedor = input.closest('.contenedor-imagen');
      const botonSubir = contenedor.querySelector('.boton-subir');
      if (!input.value) {
        //botonSubir.style.display = 'none';
      } else {
        botonSubir.style.display = 'flex';
      }
    }
  </script>
  <script>
    let selectedGames2 = [];
    <?php
    $con = new Conexion();
    $stmt4 = $con->prepare("SELECT `juego` FROM `usuarios_juegos` WHERE `id_usuario` = :id");
    $stmt4->bindParam(':id', $id);
    $stmt4->execute();
    $perfil = $stmt4->fetchAll(PDO::FETCH_ASSOC);
    //var_dump($perfil);
    foreach ($perfil as $juego) {
    ?>
      selectedGames2.push("<?php echo $juego["juego"]; ?>");
    <?php
    }
    ?>

    let cadenadelarray = "";
    let cadenadelarray2 = "";

    selectedGames2.forEach(function(valor, i) {
      cadenadelarray += '<div class="elemento-seleccionado">' + valor + '</div>';

      cadenadelarray2 += '<input type="text" name="juegos[][' + valor + ']">';
    });

    inputsjuegosseleccionados.innerHTML = cadenadelarray2;

    juegosseleccionados.innerHTML = cadenadelarray;
  </script>
  <?php
  // Obtener las fotos del usuario desde la base de datos
  $con = new Conexion();
  $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  $stmt = $con->prepare("SELECT * FROM fotos WHERE id_usuario = :id_usuario");
  $stmt->bindParam(':id_usuario', $id);
  $stmt->execute();

  // Iterar sobre las fotos y asignar las rutas a los elementos <img>
  $i = 1;
  while ($foto = $stmt->fetch()) {
    $rutaFoto = $foto['ruta'];
    echo '<script>document.getElementById("imagen' . $i . '").setAttribute("data-default-value", "' . $rutaFoto . '");</script>';
    echo '<script>document.getElementById("imagen' . $i . '-preview").src = "' . $rutaFoto . '";</script>';
    echo '<script>document.getElementById("imagen' . $i . '-preview").classList.remove("hidden");</script>';
    $i++;
  }
  ?>
  <script src="./assets/js/loader.js"></script>
</body>

</html>
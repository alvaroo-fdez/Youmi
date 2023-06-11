<?php 
    require_once 'Conexion.php';

    if(!isset($_COOKIE['id'])){
        header("Location: login.php");
    }else{
        $con = new Conexion();
        $id = $_COOKIE['id'];
        $stmt = $con->prepare("SELECT `rol` FROM `usuarios` WHERE `id` = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $admin = $stmt->fetch(PDO::FETCH_ASSOC)["rol"];
    
        if($admin != 0){
            header("Location: login.php");
        }
    }

    if(isset($_POST['logout'])){
        setcookie('correo', '', time() - 3600 * 24 * 365 * 100);
        setcookie('id', '', time() - 3600 * 24 * 365 * 100);
        setcookie('nombre', '', time() - 3600 * 24 * 365 * 100);

        header('Location: ./login.php');
    }
    
?>
<!DOCTYPE html>
<html>
<head>
    <title>Panel de administración</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="assets/img/recursos/logotipos/favicon.png" rel="icon">
</head>
<body>
<div class="container">
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" style="margin-top: 70px; margin-bottom: 25px;">
        <button class="btn btn-secondary" style="margin-top: 10px;" name="logout">
            <i class="bi bi-box-arrow-left"></i> Cerrar Sesión
        </button>
    </form>
    <h2>Panel de administración</h2>
    <div class="form-group">
        <input type="text" class="form-control" id="search-input" placeholder="Buscar usuarios">
    </div>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Email</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody id="user-list">
            
        </tbody>
    </table>
</div>


<div class="modal fade" id="confirmModal" tabindex="-1" role="dialog" aria-labelledby="confirmModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="confirmModalLabel">Confirmar eliminación</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>¿Estás seguro de que deseas eliminar este perfil?</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-danger" id="confirmButton">Eliminar</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editModalLabel">Editar Usuario</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <input type="hidden" id="editUserId">
        <div class="form-group">
          <label for="editUserName">Nombre</label>
          <input type="text" class="form-control" id="editUserName">
        </div>
        <div class="form-group">
          <label for="editUserEmail">Email</label>
          <input type="email" class="form-control" id="editUserEmail">
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary" id="saveChangesButton">Guardar cambios</button>
      </div>
    </div>
  </div>
</div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <script src="./assets/js/admin.js"></script>
</body>

</html>

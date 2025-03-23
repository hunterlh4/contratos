<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>
    <?php echo $data['title']; ?>
  </title>
  <script src="<?php echo BASE_URL; ?>/assets/js/modulos/iconos.js" crossorigin="anonymus"></script>
  <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/loginstyle.css" />
  <link rel="icon" type="png" href="<?php echo BASE_URL; ?>/assets/img/icono_diresa.png">

  
</head>

<div class="container">
  <div class="forms-container">
    <div class="signin-signup">
      <form role="form" class="sign-in-form" id="formulario" autocomplete="off">
          <img class="d-block w-100" src="<?php echo BASE_URL; ?>/assets/img/logo.png" alt=""><br>
          <br>  
          <!-- <h2 class="title">Sistema de Control de Asistencia </h2>  -->
          
          <div class="input-field">
            <i class="fas fa-user"></i>
            <input type="text" id="username" name="username" placeholder="Usuario" />
          </div>
          <div class="input-field">
            <i class="fas fa-lock"></i>
            
            <input type="password" id="password" name="password" placeholder="Contraseña" />
          </div>
         <br>
          <div class="text-center">
            <button type="submit" class="btn bg-gradient-primary w-100 my-4 mb-2">Ingresar</button>
            <a href="<?php echo BASE_URL; ?>Registro" class=""><button type="button" class="btn bg-gradient-primary w-100 my-4 mb-2">Registro</button></a>
          </div>
      </form>
      <form action="login.php" method="POST" class="sign-up-form">
        <!--  -->
        <a href=<?php echo BASE_URL."Uploads/Manual/Manual_Usuario.pdf" ?> target="_blank" class=""><h2 class="title">Manual de Usuario</h2></a>

        <!--  -->
        <div class="manual-container" style="overflow-y: auto; max-height: 700px;">
        <!-- Contenido del manual aquí -->
          <p> Ver 1.0</p>

        <!-- Agrega más contenido según sea necesario -->
        </div>
        <!--  -->
      </form>
    </div>
  </div>

  <div class="panels-container">
    <div class="panel left-panel">
      <div class="content">
        <h3>Manual de Usuario</h3>
        <p>
          Necesitas informacion sobre como usar el sistema. Aprende todo aqui!
        </p>
        <button class="btn transparent" id="sign-up-btn">
          Descarga Manual
        </button>
      </div>
      <img src="<?php echo BASE_URL; ?>/assets/img/login_time.svg" class="image" alt="" />
    </div>
    <div class="panel right-panel">
      <div class="content">
        <h3>Ingresa al sistema</h3>
        <p>
          <!-- Ingresa tu correo afiliado donde te llegará un mensaje de sislega, dale click al enlace y listo! -->
        </p>
        <button class="btn transparent" id="sign-in-btn">
          Ingresar
        </button>
      </div>
      <img src="<?php echo BASE_URL; ?>/assets/img/email.svg" class="image" alt="" />
    </div>
  </div>
</div>




</script>
<!-- Control Center for Material Dashboard: parallax effects, scripts for the example pages etc -->

<script>
  const base_url = '<?php echo BASE_URL; ?>';
  
</script>
<script src="<?php echo BASE_URL; ?>assets/js/sweetalert2.all.min.js"></script>
<script src="<?php echo BASE_URL; ?>assets/js/app.min.js"></script>
<script src="<?php echo BASE_URL; ?>assets/js/modulos/login.js"></script>
<script src="<?php echo BASE_URL; ?>assets/js/modulos/script.js"></script>
</body>

</html>
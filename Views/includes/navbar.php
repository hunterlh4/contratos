<div class="navbar-bg"></div>
<nav class="navbar navbar-expand-lg main-navbar sticky">
  <div class="form-inline mr-auto">
    <ul class="navbar-nav mr-3">
      <li>
        <!--data-toggle="sidebar"-->
        <a href="#" class="nav-link nav-link-lg collapse-btn" id="sidebar_click"><i
            data-feather="align-justify"></i></a>
      </li>
      <li>
        <a href="#" class="nav-link nav-link-lg fullscreen-btn"><i data-feather="maximize"></i></a>
      </li>
    </ul>
  </div>
  <ul class="navbar-nav navbar-right">
    <!-- prueba -->
    <!-- <li class="dropdown dropdown-list-toggle"><a href="#" data-toggle="dropdown" class="nav-link nav-link-lg message-toggle"><i data-feather="mail"></i>
        <span class="badge headerBadge1"></span> </a>
      <div class="dropdown-menu dropdown-list dropdown-menu-right pullDown">
        <div class="dropdown-header">
          prueba

        </div>
        <div class="dropdown-list-content dropdown-list-message" >
        <figure class="avatar mr-2 avatar-xl" data-initial="UM"></figure>
                    <figure class="avatar mr-2 avatar-lg bg-danger text-white" data-initial="UM"></figure>
                    <figure class="avatar mr-2 bg-warning text-white" data-initial="UM"></figure>
                    <figure class="avatar mr-2 avatar-sm bg-success text-white" data-initial="UM"></figure>
                    <figure class="avatar mr-2 avatar-xs bg-info text-white" data-initial="UM"></figure>

        <a href="#" class="dropdown-item"> <span class="dropdown-item-avatar text-white">
        <figure class="avatar mr-2 bg-danger text-white" data-initial="UM"></figure>
            </span> <span class="dropdown-item-desc"> <span class="message-user">Sarah
                Smith</span> <span class="time messege-text">Client Requirements</span>
              <span class="time">2 Days Ago</span>
            </span>
          </a>
        </div>
        
      </div>

      
    </li> -->
    <!-- prueba -->
    <?php
    if ($_SESSION['nivel'] == 1 || $_SESSION['nivel'] == 100) {
      echo '<li class="dropdown dropdown-list-toggle"><a href="#" data-toggle="dropdown" class="nav-link nav-link-lg message-toggle"><i data-feather="mail"></i>';
    } else {
      echo ' <li class="dropdown dropdown-list-toggle d-none"><a href="#" data-toggle="dropdown" class="nav-link nav-link-lg message-toggle"><i data-feather="mail"></i>';
    }
    ?>

    <span class="badge headerBadge1" id="totalNotificaciones"></span> </a>
    <div class="dropdown-menu dropdown-list dropdown-menu-right pullDown">
      <div class="dropdown-header">
        Notificationes

      </div>

      <div class="dropdown-list-content dropdown-list-message" id="listaNotificaciones">
        <!-- <figure class="avatar mr-2 avatar-xl" data-initial="UM"></figure>
                    <figure class="avatar mr-2 avatar-lg bg-danger text-white" data-initial="UM"></figure>
                    <figure class="avatar mr-2 bg-warning text-white" data-initial="UM"></figure>
                    <figure class="avatar mr-2 avatar-sm bg-success text-white" data-initial="UM"></figure>
                    <figure class="avatar mr-2 avatar-xs bg-info text-white" data-initial="UM"></figure> -->


      </div>
      <div class="dropdown-footer text-center">
        <a href="usuario">Ver todo <i class="fas fa-chevron-right"></i></a>
      </div>

    </div>
    </li>
    <li class="dropdown">
      <a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
        <img alt="image" src="<?php echo BASE_URL; ?>assets/img/icono_diresa.png"
          class="user-img-radious-style"> <span class="d-sm-none d-lg-inline-block"></span></a>
      <div class="dropdown-menu dropdown-menu-right pullDown">
        <div class="dropdown-title">
          <?php echo  $_SESSION['username']  //$_SESSION['nombre'] . ' ' . $_SESSION['apellido']; 
          ?>
        </div>

        <a href="<?php echo BASE_URL . 'admin/perfil'; ?>" class="dropdown-item has-icon"><i
            class="far fa-user"></i> Perfil</a>
        <!-- <a href="<?php echo BASE_URL . 'admin/mensajes'; ?>" class="dropdown-item has-icon"> <i class="fas fa-bolt"></i> Actividades </a> -->
        <div class="dropdown-divider"></div>
        <a href="<?php echo BASE_URL . 'admin/salir'; ?>" class="dropdown-item has-icon text-danger"> <i
            class="fas fa-sign-out-alt"></i>
          Salir
        </a>
      </div>
    </li>
  </ul>
</nav>


<script>
  const base_url_1 = '<?php echo BASE_URL; ?>';
</script>
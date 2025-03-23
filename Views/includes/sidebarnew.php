''''''<div class="main-sidebar sidebar-style-2">
  <aside id="sidebar-wrapper">
    <div class="sidebar-brand">
      <a href="<?php echo BASE_URL; ?>"> <img alt="image" src="<?php echo BASE_URL; ?>assets/img/icono_diresa.png"
          class="header-logo" /> <span class="logo-name">DIRESA TACNA</span>
      </a>
    </div>
    <ul class="sidebar-menu">
      <?php
      if ($_SESSION['nivel'] !== 5) {
        echo ' <li class="menu-header">General</li>';
      }
      // 1 admin            alextm
      // 2 jefe oficina     alextm1
      // 3 Visualizador     alextm2
      // 4 portero          alextm3
      // 100 mio

      // MANTENIMIENTO
      if ($_SESSION['nivel'] == 1 || $_SESSION['nivel'] == 100) {
        echo '<li class="dropdown">
        <a href="#" class="menu-toggle nav-link has-dropdown"><i data-feather="folder-minus"></i><span>Mantenimiento</span></a>
        <ul class="dropdown-menu">';
        echo '<li class="dropdown"><a href="' . BASE_URL . 'Usuario" class="nav-link"><i data-feather="users"></i><span>Usuarios</span></a></li>';
        echo '<li class="dropdown"><a href="' . BASE_URL . 'Personal" class="nav-link"><i data-feather="credit-card"></i><span>Personal</span></a></li>';
        echo '<li class="dropdown"><a href="' . BASE_URL . 'Persona" class="nav-link"><i data-feather="user"></i><span>Persona</span></a></li>';



        echo '</ul>
      </li>';
      }
      // CONTRATOS
      if ($_SESSION['nivel'] == 1 || $_SESSION['nivel'] == 100) {
        echo '<li class="dropdown">
        <a href="#" class="menu-toggle nav-link has-dropdown"><i data-feather="folder-minus"></i><span>Contratos</span></a>
        <ul class="dropdown-menu">';
        echo '<li class="dropdown"><a href="' . BASE_URL . 'Contrato" class="nav-link"><i data-feather="paperclip"></i><span>Solicitudes</span></a></li>';
        echo '<li class="dropdown"><a href="' . BASE_URL . 'Contrato/Arrendamiento" class="nav-link"><i data-feather="file-text"></i><span>Arrendamiento</span></a></li>';
        echo '<li class="dropdown"><a href="' . BASE_URL . 'Contrato/LocacionServicio" class="nav-link"><i data-feather="file-text"></i><span>Locacion de Servicios</span></a></li>';
        echo '<li class="dropdown"><a href="' . BASE_URL . 'Contrato/mandato" class="nav-link"><i data-feather="file-text"></i><span>Mandato</span></a></li>';
        echo '<li class="dropdown"><a href="' . BASE_URL . 'Contrato/mutuodinero" class="nav-link"><i data-feather="file-text"></i><span>Mutuo de Dinero</span></a></li>';
        echo '</ul>
      </li>';
      }
      // ADENDAS
      if ($_SESSION['nivel'] == 1 || $_SESSION['nivel'] == 100) {
        echo '<li class="dropdown">
        <a href="#" class="menu-toggle nav-link has-dropdown"><i data-feather="folder-minus"></i><span>Adendas</span></a>
        <ul class="dropdown-menu">';
        echo '<li class="dropdown"><a href="' . BASE_URL . 'Adenda" class="nav-link"><i data-feather="paperclip"></i><span>Solicitudes</span></a></li>';
        echo '<li class="dropdown"><a href="' . BASE_URL . 'Adenda/arrendamiento" class="nav-link"><i data-feather="file-text"></i><span>Arrendamiento</span></a></li>';
        echo '<li class="dropdown"><a href="' . BASE_URL . 'Adenda/locacioServicio" class="nav-link"><i data-feather="file-text"></i><span>Locacion de Servicios</span></a></li>';
        echo '<li class="dropdown"><a href="' . BASE_URL . 'Adenda/mandato" class="nav-link"><i data-feather="file-text"></i><span>Mandato</span></a></li>';
        echo '<li class="dropdown"><a href="' . BASE_URL . 'Adenda/mutuodinero" class="nav-link"><i data-feather="file-text"></i><span>Mutuo de Dinero</span></a></li>';
        echo '</ul>
      </li>';
      }
      // CONFIGURACION
      if ($_SESSION['nivel'] == 1 || $_SESSION['nivel'] == 100) {
        echo '<li class="dropdown">
        <a href="#" class="menu-toggle nav-link has-dropdown"><i data-feather="folder-minus"></i><span>Configuracion</span></a>
        <ul class="dropdown-menu">';
        echo '<li class="dropdown"><a href="' . BASE_URL . 'Formato" class="nav-link"><i data-feather="server"></i><span>Formato para contratos</span></a></li>';
        echo '<li class="dropdown"><a href="' . BASE_URL . 'Area" class="nav-link"><i data-feather="package"></i><span>Area</span></a></li>';
        echo '<li class="dropdown"><a href="' . BASE_URL . 'Cargo" class="nav-link"><i data-feather="codepen"></i><span>Cargo</span></a></li>';
        echo '<li class="dropdown"><a href="' . BASE_URL . 'Banco" class="nav-link"><i data-feather="archive"></i><span>Banco</span></a></li>';
        // echo '<li class="dropdown"><a href="' . BASE_URL . 'Asistencia" class="nav-link"><i data-feather="clipboard"></i><span>Hoja de Asistencia</span></a></li>';
        // echo '<li class="dropdown"><a href="' . BASE_URL . 'Asistencia/ver" class="nav-link"><i data-feather="clipboard"></i><span>Mis Asistencias</span></a></li>';
        // echo '<li class="dropdown"><a href="' . BASE_URL . 'Festividades/ver" class="nav-link"><i data-feather="calendar"></i><span>Calendario</span></a></li>';
        // echo '<li class="dropdown"><a href="' . BASE_URL . 'HoraExtra" class="nav-link"><i data-feather="clock"></i><span>Horas Extra</span></a></li>';
        echo '</ul>
      </li>';
      }
      // MANUAL DE USUARIO
      if ($_SESSION['nivel'] == 1 || $_SESSION['nivel'] == 100) {
        echo '<li class="dropdown"><a href="' . BASE_URL . 'Manual" class="nav-link"><i data-feather="settings"></i><span>Manual de Usuario</span></a></li>';
      }


      // <!-- Administrables -->
      if ($_SESSION['nivel'] == 1 || $_SESSION['nivel'] == 100) {
        echo '<li class="dropdown">
                <a href="#" class="menu-toggle nav-link has-dropdown"><i data-feather="monitor"></i><span>Administrables</span></a>
                <ul class="dropdown-menu">';
        echo '<li><a class="nav-link" href="' . BASE_URL . 'Trabajador">Trabajador</a></li>';
        echo '<li><a class="nav-link" href="' . BASE_URL . 'Direccion">Dirección</a></li>';
        echo '<li><a class="nav-link" href="' . BASE_URL . 'Equipo">Equipo</a></li>';
        echo '<li><a class="nav-link" href="' . BASE_URL . 'Horario">Horario</a></li>';
        echo '<li><a class="nav-link" href="' . BASE_URL . 'Cargo">Cargo</a></li>';
        echo '<li><a class="nav-link" href="' . BASE_URL . 'Regimen">Régimen</a></li>';
        echo '<li><a class="nav-link" href="' . BASE_URL . 'Usuario">Usuarios</a></li>';
        echo '</ul>
              </li>';
      }
      //  <!-- Asistencia -->
      if ($_SESSION['nivel'] == 1 || $_SESSION['nivel'] == 100) {
        echo '<li class="dropdown">
        <a href="#" class="menu-toggle nav-link has-dropdown"><i data-feather="monitor"></i><span>Asistencia</span></a>
        <ul class="dropdown-menu">';
        echo '<li class="dropdown"><a href="' . BASE_URL . 'Importar" class="nav-link"><i data-feather="upload"></i><span>Importar</span></a></li>';
        echo '<li class="dropdown"><a href="' . BASE_URL . 'Asistencia" class="nav-link"><i data-feather="clipboard"></i><span>Hoja de Asistencia</span></a></li>';
        echo '<li class="dropdown"><a href="' . BASE_URL . 'Asistencia/ver" class="nav-link"><i data-feather="clipboard"></i><span>Mis Asistencias</span></a></li>';
        echo '<li class="dropdown"><a href="' . BASE_URL . 'Festividades/ver" class="nav-link"><i data-feather="calendar"></i><span>Calendario</span></a></li>';
        echo '<li class="dropdown"><a href="' . BASE_URL . 'HoraExtra" class="nav-link"><i data-feather="clock"></i><span>Horas Extra</span></a></li>';
        echo '</ul>
      </li>';
      }
      // <!-- Jefe de Oficina -->
      if ($_SESSION['nivel'] == 2) {
        echo '<li class="dropdown"><a href="' . BASE_URL . 'Boleta/RevisarBoletas" class="nav-link"><i data-feather="monitor"></i><span>Revisar Boletas</span></a></li>';
      }
      // <!-- Visualizador -->
      if ($_SESSION['nivel'] == 3) {
        echo '<li class="dropdown"><a href="' . BASE_URL . 'Asistencia/ver" class="nav-link"><i data-feather="monitor"></i><span>Asistencia</span></a></li>';
        echo '<li class="dropdown"><a href="' . BASE_URL . 'Festividades/ver" class="nav-link"><i data-feather="calendar"></i><span>Calendario</span></a></li>';
        echo '<li class="dropdown"><a href="' . BASE_URL . 'Boleta/MisBoletas" class="nav-link"><i data-feather="file"></i><span>Boleta</span></a></li>';
      }
      // <!-- Portero -->
      if ($_SESSION['nivel'] == 4) {
        echo '<li class="dropdown"><a href="' . BASE_URL . 'Boleta/Porteria" class="nav-link"><i data-feather="monitor"></i><span>Boletas</span></a></li>';
      }
      // <!-- Portero -->
      if ($_SESSION['nivel'] == 1 || $_SESSION['nivel'] == 100) {
        echo '<li class="dropdown">
                <a href="#" class="menu-toggle nav-link has-dropdown"><i data-feather="monitor"></i><span>Boletas</span></a>
                <ul class="dropdown-menu">';
        echo '<li class="dropdown"> <a href="' . BASE_URL . 'Boleta" class="nav-link"><i data-feather="file-text"></i><span>Boletas</span></a> </li> ';
        echo '<li class="dropdown"> <a href="' . BASE_URL . 'Boleta/RevisarBoletas" class="nav-link"><i data-feather="file-text"></i><span>Revisar Boletas</span></a> </li> ';
        echo '<li class="dropdown"> <a href="' . BASE_URL . 'Boleta/Porteria" class="nav-link"><i data-feather="file-text"></i><span>Portería</span></a> </li> ';
        echo '<li class="dropdown"> <a href="' . BASE_URL . 'Boleta/MisBoletas" class="nav-link"><i data-feather="file-text"></i><span>Mis Boletas</span></a> ';
        echo '</ul>
        </li> ';
      }
      // <!-- Reportes -->
      if ($_SESSION['nivel'] == 1 || $_SESSION['nivel'] == 100) {
        echo '<li class="dropdown">
                <a href="#" class="menu-toggle nav-link has-dropdown"><i data-feather="monitor"></i><span>Reportes</span></a>
                <ul class="dropdown-menu">';
        echo '<li class="dropdown"><a href="' . BASE_URL . 'Reporte/Mensual" class="nav-link"><i data-feather="file-text"></i><span>Mensual</span></a></li>';
        echo '<li class="dropdown"><a href="' . BASE_URL . 'Reporte/Fechas" class="nav-link"><i data-feather="file-text"></i><span>Entre Fechas</span></a></li>';
        echo '<li class="dropdown"><a href="' . BASE_URL . 'Reporte/Kardex" class="nav-link"><i data-feather="file-text"></i><span>Kardex</span></a></li>';
        echo '</ul>
        </li>';
      }
      // <!-- Configuración y Soporte -->
      if ($_SESSION['nivel'] == 1 || $_SESSION['nivel'] == 100) {
        echo '<li class="dropdown"><a href="' . BASE_URL . 'Configuracion/" class="nav-link"><i data-feather="settings"></i><span>Configuración</span></a></li>';
        echo '<li class="dropdown"><a href="' . BASE_URL . 'Log/" class="nav-link"><i data-feather="archive"></i><span>Log</span></a></li>';
        echo '<li class="dropdown"><a href="' . BASE_URL . 'Soporte/" class="nav-link"><i data-feather="info"></i><span>Soporte</span></a></li>';
      }
      ?>
    </ul>
  </aside>
</div>
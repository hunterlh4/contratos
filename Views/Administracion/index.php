<?php include_once './Views/includes/header.php'; ?>

<body>
  <div class="loader"></div>
  <div id="app">
    <div class="main-wrapper main-wrapper-1">
      <?php
      include './Views/includes/navbar.php';
      include './Views/includes/sidebarnew.php';
      ?>
      <!-- Main Content -->
      <div class="main-content">
        <section class="section">
          <div class="section-body">
            <div class="row">
              <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                  <div class="card-statistic-4 p-4 shadow-lg p-3 rounded">
                    <div class="row align-items-center">
                      <div class="col-md-4">
                        <div class="banner-img">
                          <img src="<?php echo BASE_URL; ?>/assets/img/Scenes05-removebg-preview.png" alt="imagen de un calendario" width="100%" height="auto">
                        </div>
                      </div>
                      <div class="col-md-8">
                        <div class="card-content">
                          <h3 class="card-title text-danger text-center font-weight-bold">¡BIENVENIDO AL SISTEMA DE CONTROL DE ASISTENCIA DE LA DIRESA TACNA! </h3>
                          <?php
                       
                          ?>

                          <h4 class="font-weight-bold text-center"> <?php echo  $data['nombre'] . ' ' .  $data['apellido'];  ?></h4>

                          <?php
                          // admin
                          if ($data['nivel'] == 1 || $data['nivel'] == 100) {
                            echo ' 
                            <p style="text-align: justify;">Como Administrador del Sistema de Control de Asistencia usted podra visualizar el ingreso y salida que marcan los relojes, así como evaluar y generar los reportes.</p>
                             <p style="text-align: justify;">Para iniciar a REVISAR los horarios de los trabajadores de clic al siguiente botón.</p>
                            <a type="button" class="btn btn-primary btn-lg text-center" href="' . BASE_URL . 'Asistencia"><i class="far fa-hand-point-right"></i> INICIAR</a>';
                           
                          }
                          // jefe de area
                          if ($data['nivel'] == 2){
                            echo ' 
                            <p style="text-align: justify;">Como Jefe de área del Sistema de Control de Asistencia usted podra Evaluar las Boletas, revisar sus boletas y sus asistencias.</p>
                             <p style="text-align: justify;">Para iniciar a REVISAR los horarios de los trabajadores de clic al siguiente botón.</p>
                            <a type="button" class="btn btn-primary btn-lg text-center" href="' . BASE_URL . 'Ver"><i class="far fa-hand-point-right"></i> INICIAR</a>';
                          }
                          
                          // vizualizador
                          if ($data['nivel'] == 3){
                            echo ' 
                            <p style="text-align: justify;">Como Vizualizador del Sistema de Control de Asistencia usted revisar sus boletas y sus asistencias.</p>
                             <p style="text-align: justify;">Para iniciar a REVISAR las boletas de los trabajadores de clic al siguiente botón.</p>
                            <a type="button" class="btn btn-primary btn-lg text-center" href="' . BASE_URL . 'Asistencia/Ver"><i class="far fa-hand-point-right"></i> INICIAR</a>';
                          }
                          // porteria
                          if ($data['nivel'] == 4){
                            echo ' 
                            <p style="text-align: justify;">Como Portero del área del Sistema de Control de Asistencia usted podra Evaluar las Boletas, revisar sus boletas y sus asistencias.</p>
                             <p style="text-align: justify;">Para iniciar a REVISAR los horarios de los trabajadores de clic al siguiente botón.</p>
                            <a type="button" class="btn btn-primary btn-lg text-center" href="' . BASE_URL . 'Boleta/Porteria"><i class="far fa-hand-point-right"></i> INICIAR</a>';
                          }
                          // sin permiso
                          if ($data['nivel'] == 5) {
                            echo ' <p style="text-align: center;">Usted no cuenta con los privilegios suficientes. </p>
                             <p style="text-align: center;">Espere que un Administrador del Sistema le otorgue los permisos suficientes.</p>';
                          }
                          ?>



                        </div>
                      </div>
                    </div>
                  </div>
                </div>

              </div>
            </div>
            <!-- CALCULO DE ASISTENCIA -->
            <div class="row">
              <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-xs-12">
                <div class="card">
                  <div class="card-statistic-4">
                    <div class="align-items-center justify-content-between">
                      <div class="row ">
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pr-0 pt-3 center">
                          <div class="card-content">
                            <h5 class="font-15">Puntuales</h5>
                            <h2 class="mb-3 font-18">231</h2>
                            <!-- <p class="mb-0"><span class="col-green">10%</span> Incremento</p> -->
                            <!-- <a type="button" class="btn btn-primary text-center mt-3" href=""><i class="fa fa-stopwatch"></i> Visualizar</a> -->
                          </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pl-0">
                          <div class="banner-img">
                            <img src="<?php echo BASE_URL; ?>assets/img/banner/1.png" alt="">
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-xs-12">
                <div class="card">
                  <div class="card-statistic-4">
                    <div class="align-items-center justify-content-between">
                      <div class="row ">
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pr-0 pt-3">
                          <div class="card-content">
                            <h5 class="font-15">Tardanzas</h5>
                            <h2 class="mb-2 font-18 center" id="num_tardanzas"> 70 </h2>
                            <!-- <a type="button" class="btn btn-primary text-center mt-3" href=""><i class="fa fa-stopwatch"></i> Visualizar</a> -->
                          </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pl-0">
                          <div class="banner-img">
                            <img src="<?php echo BASE_URL; ?>assets/img/banner/3.png" alt="tardanzas">
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-xs-12">
                <div class="card">
                  <div class="card-statistic-4">
                    <div class="align-items-center justify-content-between">
                      <div class="row ">
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pr-0 pt-3">
                          <div class="card-content">
                            <h5 class="font-15">Sin Registro</h5>
                            <h2 class="mb-3 font-18 center">85</h2>
                            <!-- <p class="mb-0"><span class="col-green">128,589</span> -->
                            <!-- 128,589</p> -->
                          </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pl-0">
                          <div class="banner-img">
                            <img src="<?php echo BASE_URL; ?>assets/img/banner/2.png" alt="">
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-xs-12">
                <div class="card">
                  <div class="card-statistic-4">
                    <div class="align-items-center justify-content-between">
                      <div class="row ">
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pr-0 pt-3">
                          <div class="card-content">
                            <h5 class="font-15">Total</h5>
                            <h2 class="mb-3 font-18 center">386</h2>
                            <!-- <p class="mb-0"><span class="col-green">42%</span> Incremento</p> -->
                          </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pl-0">
                          <div class="banner-img">
                            <img src="<?php echo BASE_URL; ?>assets/img/banner/4.png" alt="">
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- GRAFICOS -->
            <div class="row">
              <div class="col-xl-6 col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                  <div class="card-body">
                    <div class="row">
                      <div class="col-12">
                        <div class="d-flex justify-content-between align-items-center">
                          <div style="width: 100%; text-align: center;">
                            <h5 class="font-15">Puntuales</h5>
                          </div>
                          <a type="button" class="btn btn-primary text-center" href=""><i class="fa fa-eye"></i> </a>
                        </div>
                      </div>
                      <div class="col-12 mt-3">
                        <div class="banner-img d-flex justify-content-center">
                          <img src="<?php echo BASE_URL; ?>assets/img/banner/1.png" alt="">
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-xl-6 col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                  <div class="card-body">
                    <div class="row">
                      <div class="col-12">
                        <div class="d-flex justify-content-between align-items-center">
                          <div style="width: 100%; text-align: center;">
                            <h5 class="font-15">Tardanzas</h5>
                          </div>
                          <a type="button" class="btn btn-primary text-center" href=""><i class="fa fa-eye"></i> </a>
                        </div>
                      </div>
                      <div class="col-12 mt-3">
                        <div class="banner-img d-flex justify-content-center">
                          <img src="<?php echo BASE_URL; ?>assets/img/banner/3.png" alt="tardanzas">
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-xl-6 col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                  <div class="card-body">
                    <div class="row">
                      <div class="col-12">
                        <div class="d-flex justify-content-between align-items-center">
                          <div style="width: 100%; text-align: center;">
                            <h5 class="font-15">Sin Registro</h5>
                          </div>
                          <a type="button" class="btn btn-primary text-center" href=""><i class="fa fa-eye"></i> </a>
                        </div>
                      </div>
                      <div class="col-12 mt-3">
                        <div class="banner-img d-flex justify-content-center">
                          <img src="<?php echo BASE_URL; ?>assets/img/banner/2.png" alt="">
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-xl-6 col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                  <div class="card-body">
                    <div class="row">
                      <div class="col-12">
                        <div class="d-flex justify-content-between align-items-center">
                          <div style="width: 100%; text-align: center;">
                            <h5 class="font-15">Total</h5>
                          </div>
                          <a type="button" class="btn btn-primary text-center" href=""><i class="fa fa-eye"></i> </a>
                        </div>
                      </div>
                      <div class="col-12 mt-3">
                        <div class="banner-img d-flex justify-content-center">
                          <img src="<?php echo BASE_URL; ?>assets/img/banner/4.png" alt="">
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

            </div>
          </div>
        </section>
        <!--<section class="section">-->

        <!--</section>-->
        <?php // include './Views/includes/sidebar-config.html'; 
        ?>
      </div>
      <?php include './Views/includes/footer.php'; ?>
    </div>
  </div>

  <?php include './Views/includes/script_new.php' ?>
  <script src="<?php echo BASE_URL; ?>/assets/js/modulos/home.js"></script>

</body>

</html>


<style>


</style>
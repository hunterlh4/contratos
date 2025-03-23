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


              <div class="col-md-12">
                <div class="card">
                  <div
                    class="card-header d-flex justify-content-between align-items-center mb-0 mt-3">
                    <h3 class="font-weight-bolder"><i class="fa fa-users"></i> Administrar Usuarios
                    </h3>

                    <div class="m-0">
                      <button class="btn btn-icon icon-left btn-primary rounded-0" type="button"
                        id="nuevo_registro"><i class="fas fa-plus"></i>
                        Nuevo
                      </button>

                      <button class="btn btn-icon icon-left btn-warning rounded-0" type="button"
                        id="nuevo_registro"><i class="fas fa-exclamation-triangle"></i>
                        Permisos
                      </button>
                    </div>
                  </div>

                  <div class="card-body">

                    <div class="table-responsive">
                      <table class="table table-striped table-hover" style="width:100%;"
                        id="table-alex">
                        <thead>
                          <tr>
                            <th class="text-center">#</th>
                            <th>Usuario</th>
                            <th>Nombre</th>
                            <th>Apellido</th>
                            <th>DNI</th>
                            <th>SISTEMA</th>
                            <th>AREA</th>
                            <th>CARGO</th>
                            <th>ROL</th>
                            <th>ESTADO</th>
                            <th>ACCION</th>
                          </tr>
                        </thead>
                        <tbody>
                        </tbody>
                      </table>
                    </div>


                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>

        <?php //include 'includes/sidebar-config.html'; 
        ?>
      </div>
      <?php include './Views/includes/footer.php'; ?>
    </div>
  </div>

  <!-- MODAL -->
  <div id="nuevoModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <!-- <h5 class="modal-title" id="formModal">Usuario</h5> -->
          <h5 class="modal-title" id="titleModal"></h5>
          <div class="form-group">

          </div>
          <button type="button" onclick=cerrarModal() class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>

        <form form id="formUsuarios" class="needs-validation" novalidate="" method="POST" autocomplete="off">
          <div class="modal-body">
            <input type="hidden" id="id" name="id">

            <!-- personal -->
            <div class="form-group col-xl-12 col-lg-12 col-md-12 col-sm-12">
              <label>Personal</label>
              <div class="input-group">
                <!-- <div class="input-group-prepend">
                    <div class="input-group-text"><i class="fas fa-toolbox"></i></div>
                  </div> -->
                <select class="form-control" id='selectTrabajadores' name="personal" required>
                  <option value="" selected>Selecciona un Personal</option>
                </select>
                <div class="invalid-feedback">
                  Por favor, ingresa un Personal válido.
                </div>
                <div class="valid-feedback">
                  Correcto.
                </div>
              </div>
            </div>
            <!-- rol -->

            <div class="form-group col-xl-12 col-lg-12 col-md-12 col-sm-12">
              <label for="direccion" class="custom-label">Rol</label>
              <div class="input-group">
                <select class="form-control select " id="selectRoles" name="rol" required>
                  <option value="" selected>Selecciona un Rol</option>
                  <!-- Opciones para la dirección -->
                </select>
                <div class="invalid-feedback">
                  Debes seleccionar una Rol.
                </div>
                <div class="valid-feedback">
                  Correcto.
                </div>
              </div>
            </div>

            <!-- usuario -->
            <div class="form-group col-xl-12 col-lg-12 col-md-12 col-sm-12">
              <label>Usuario</label>
              <div class="input-group">
                <div class="input-group-prepend">
                  <div class="input-group-text"><i class="fas fa-user"></i></div>
                </div>
                <input type="text" class="form-control" placeholder="Usuario" name="username"
                  id="username" minlength="5" maxlength="16" required>
              </div>
            </div>

            <!-- password -->
            <div class="form-group col-xl-12 col-lg-12 col-md-12 col-sm-12">
              <label>Password</label>
              <div class="input-group">
                <div class="input-group-prepend">
                  <div class="input-group-text">
                    <i class="fas fa-lock"></i>
                  </div>
                </div>
                <input type="password" class="form-control" placeholder="Password" name="password"
                  id="password" autocomplete="new-password" minlength="6" maxlength="20">
              </div>
            </div>

            <!-- sistema -->
            <div class="form-group col-xl-12 col-lg-12 col-md-12 col-sm-12">
              <label>Sistema</label>
              <div class="input-group">
                <div class="input-group-prepend">
                  <div class="input-group-text">
                    <i class="fas fa-list-alt"></i>
                  </div>
                </div>
                <!-- <input type="text" class="form-control" placeholder="Nivel" name="nivel" id="nivel"> -->

                <select class="form-control" id="sistema" name="sistema" required>
                  <option value="" selected>Selecciona un Nivel</option>
                  <option value="intranet">Intranet</option>
                  <option value="extranet">Extranet</option>
                  <option value="intranet+extranet">Intranet + Extranet</option>

                </select>

              </div>
            </div>
            <!-- fin form -->


            <!--  estado-->
            <div class="form-group col-xl-3 col-lg-4 col-md-6 col-sm-12" id="estado-grupo">
              <label>Estado</label>
              <div class="input-group">


                <div class="col-sm-9 d-flex align-items-center">
                  <div class="custom-control custom-radio mr-3">
                    <input type="radio" id="radio-true" value=1 name="estado"
                      class="custom-control-input" checked>
                    <label class="custom-control-label" for="radio-true">Activo</label>
                  </div>
                  <div class="custom-control custom-radio">
                    <input type="radio" id="radio-false" value=0 name="estado"
                      class="custom-control-input">
                    <label class="custom-control-label" for="radio-false">Inactivo</label>
                  </div>
                </div>
              </div>
            </div>


            <!--  -->

            <!--  -->
            <div class="modal-footer bg-white">

              <button class="btn btn-primary" type="submit" id="btnAccion">Registrar</button>
              <!-- <button class="btn btn-danger" type="button" onclick=cerrar() data-dismiss="modal" aria-label="Close">Cancelar</button> -->
              <button class="btn btn-danger" onclick=cerrarModal() class="close" data-dismiss="modal"
                aria-label="Close">Cancelar</button>
            </div>
        </form>
      </div>
    </div>
  </div>
  </div>


  <!--MODAL - NUEVO USARIO-->

  <!-- MODAL FIN -->
  <?php include './Views/includes/script_new.php' ?>

  </html>
  <script src="<?php echo BASE_URL; ?>/assets/js/modulos/usuario.js"></script>

  <script>
    // $(document).ready(function(){
    //   $(".collapse-btn").click();
    // });
    const base_url = '<?php echo BASE_URL; ?>';
  </script>

  <style>
    .swal2-popup {
      position: center;

    }

    /* Estilo general para todos los botones */
    .dt-buttons .btn {
      /* font-size: 14px;  */
      /* padding: 8px 16px;  */
      color: #fff;
      border: none;
      border-radius: 4px;
      margin: 5px;
      display: inline-flex;
      align-items: center;
      width: 60px;
      height: 34px;
      justify-content: center;
      text-align: center;
    }
  </style>
</body>

</html>
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
                  <div class="card-header d-flex justify-content-between align-items-center mb-0 mt-3">
                    <h3 class="font-weight-bolder" id='seguimiento'><i class="fa fa-briefcase"></i> Seguimiento</h3>
                    <div class="ml-auto">
                      <button class="btn btn-lg btn-outline-primary rounded-0" type="button" onclick=goBack()>Volver</button>
                      <button class="btn btn-lg btn-outline-primary rounded-0" type="button" id="nuevo_registro">Nuevo</button>
                    </div>
                  </div>

                  <div class="card-body">
                    <div class="table-responsive">
                      <table class="table table-striped table-hover align-center" style="width:100%;" id="table-alex">
                        <thead>
                          <tr>
                            <th class="text-center">#</th>
                            <th>Régimen</th>
                            <th>Dirección</th>
                            <th>Cargo</th>
                            <th>Documento</th>
                            <th>Sueldo</th>
                            <th style="width: 80px;">Inicio</th>
                            <th style="width: 80px;">Fin</th>
                            <!-- <th>Estado</th> -->
                            <th>Acción</th>
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

      </div>
      <?php include './Views/includes/footer.php'; ?>
    </div>
  </div>

  <!-- MODAL -->
  <div id="nuevoModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">

          <h5 class="modal-title" id="titleModal"></h5>
          <button type="button" onclick=cerrarModal() class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>

        <form form id="formulario" class="needs-validation" novalidate="" method="POST" autocomplete="off" enctype="multipart/form-data">
          <div class="modal-body">
            <input type="hidden" id="id" name="id">
            <!-- AQUI EMPIEZA -->


            <!-- aqui termina -->
            <!-- <p><b>Datos Personales</b></p> 
              <hr>  -->

            <div class="row">



              <div class="col-md-12">
                <div class="form-group">
                  <label for="direccion">Direccion</label>
                  <div class="input-group">
                    <!-- <div class="input-group-prepend">
                      <div class="input-group-text">
                        <i class="fas fa-address-card"></i>
                      </div>
                    </div> -->
                    <select class="form-control" id="direccion" name="direccion" required>
                      <option value="" selected>Selecciona una Direccion</option>
                      <!-- Opciones para la dirección -->
                    </select>
                  </div>

                </div>
              </div>

              <div class="col-md-6 col-sm-6">
                <div class="form-group">
                  <label>Regimen</label>
                  <div class="input-group">

                    <select class="form-control" id="regimen" name="regimen" required>
                      <option value="" selected>Selecciona un Regimen</option>
                      <!-- Opciones para la dirección -->
                    </select>
                  </div>
                </div>
              </div>
              <div class="col-md-6 col-sm-6">
                <div class="form-group">
                  <label>Cargo</label>
                  <div class="input-group">

                    <select class="form-control" id="cargo" name="cargo" required>
                      <option value="" selected>Selecciona un Cargo</option>
                      <!-- Opciones para la dirección -->
                    </select>
                  </div>
                </div>
              </div>

              <div class="col-md-6 col-sm-6">
                <div class="form-group">
                  <label>Inicio</label>
                  <div class="input-group">
                    <!-- <div class="input-group-prepend">
                    <div class="input-group-text">
                      <i class="fas fa-calendar"></i>
                    </div>
                  </div> -->
                    <input type="Date" class="form-control" placeholder="YYYY/MM/DD" name="fecha_inicio" id="fecha_inicio" required>
                  </div>
                </div>
              </div>
              <div class="col-md-6 col-sm-6">
                <div class="form-group">
                  <label>Fin</label>
                  <div class="input-group">
                    <!-- <div class="input-group-prepend">
                    <div class="input-group-text">
                      <i class="fas fa-calendar"></i>
                    </div>
                  </div> -->
                    <input type="Date" class="form-control" placeholder="YYYY/MM/DD" name="fecha_fin" id="fecha_fin" required>
                  </div>
                </div>
              </div>

              <div class="col-md-4 col-sm-6">
                <div class="form-group">
                  <label for="dni">Sueldo</label>
                  <!-- <button type="button" onclick=consultar()>Consultar</button> -->
                  <!-- <input type="text" class="form-control" id="dni" name="dni" required> -->
                  <div class="input-group">
                    <!-- <div class="input-group-prepend">
                      <div class="input-group-text">
                        <i class="fas fa-address-card"></i>
                      </div>
                    </div> -->
                    <input type="number" class="form-control" placeholder="Sueldo" name="sueldo" id="sueldo" maxlength="10" required>
                  </div>
                </div>
              </div>
              <div class="col-md-8 col-sm-6">
                <div class="form-group">
                  <label>Documento</label>
                  <div class="input-group">
                    <!-- <div class="input-group-prepend">
                      <div class="input-group-text">
                        <i class="fas fa-address-card"></i>
                      </div>
                    </div> -->
                    <!-- <input type="file" class="form-control" name="documento" id="documento"> -->
                    <!-- Opciones para la dirección -->
                      <div class="custom-file">
                        <input type="hidden" id="nombreArchivoActual" name="nombreArchivoActual">
                        <input type="file" class="custom-file-input" id="archivo" name="archivo" accept=".pdf">
                        <label class="custom-file-label" id="nombreArchivo" for="archivo"></label>
                      </div>
                    </select>
                  </div>
                </div>
              </div>

              <div class="col-md-6">

                <div class="form-group" id="estado-grupo">
                  <label>Estado</label>
                  <div class="input-group">
                    <div class="col-sm-9 d-flex align-items-center mt-1">
                      <div class="custom-control custom-radio mr-3">
                        <input type="radio" id="radio-true" value='Activo' name="estado" class="custom-control-input" checked>
                        <label class="custom-control-label" for="radio-true">Activo</label>
                      </div>
                      <div class="custom-control custom-radio">
                        <input type="radio" id="radio-false" value='Inactivo' name="estado" class="custom-control-input">
                        <label class="custom-control-label" for="radio-false">Inactivo</label>
                      </div>
                    </div>
                  </div>
                </div>

              </div>
            </div>

            <!-- FIN DEL ROW -->
          </div>

          <div class="modal-footer bg-white">
            <button class="btn btn-primary" type="submit" id="btnAccion">Registrar</button>
            <button class="btn btn-danger" onclick=cerrarModal() class="close" data-dismiss="modal" aria-label="Close">Cancelar</button>
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
  <script src="<?php echo BASE_URL; ?>/assets/js/modulos/seguimiento.js"></script>

  <script>
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
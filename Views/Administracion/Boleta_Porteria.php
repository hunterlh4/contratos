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

                    <h3 class="font-weight-bolder"><i class="fa fa-briefcase"></i> Boletas</h3>
                    <!-- <button class="btn btn-lg btn-outline-primary rounded-0 " type="button" id="nuevo_registro">Nuevo</button> -->
                  </div>

                  <div class="card-body">
                    <div class="table-responsive">
                      <table class="table table-striped table-hover text-center" style="width:100%;" id="table-horas-alex">
                        <thead>
                          <tr>
                            <th style="width: 15px;">#</th>
                            <th style="width: 30px;">Número</th>
                            <th style="width: 250px;">Aprobador</th>
                            <th style="width: 50px;">Fecha</th>
                            <th style="width: 50px;">Salida</th>
                            <th style="width: 50px;">Entrada</th>
                            <th style="width: 50px;">Trámite</th>
                            <!-- <th>Estado</th> -->
                            <th style="width: 50px;">Acción</th>
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

        <form form id="formulario" class="needs-validation" novalidate="" method="POST" autocomplete="off">
          <div class="modal-body">
            <input type="hidden" id="id" name="id">
            <div class="row">
              <div class="col-md-6 col-sm-12">
                <div class="form-group">
                  <label for="solicitante">Solicitante</label>
                  <select class="form-control" id="solicitante" name="solicitante" required>
                    <option value="">Seleccione un Solicitante</option>

                    <!-- Opciones del select -->
                  </select>
                </div>
              </div>
              <div class="col-md-6 col-sm-12">
                <div class="form-group">
                  <label for="aprobador">Aprobador</label>
                  <select class="form-control" id="aprobador" name="aprobador" required>
                    <option value="">Seleccione un aprobador</option>
                    <!-- Opciones del select -->
                  </select>
                </div>
              </div>
              <div class="col-md-12 col-sm-12">
                <div class="form-group">
                  <label for="fecha_inicio">Fecha</label>
                  <input type="date" class="form-control" id="fecha" name="fecha" required>
                </div>
              </div>


              <div class="col-md-6 col-sm-6">
                <div class="form-group">
                  <label for="hora_salida">Hora de Salida</label>
                  <div class="d-flex align-items-start">
                    <input type="time" class="form-control mr-3" id="hora_salida" name="hora_salida" required>
                    <button class="btn btn-success " id="btn_salida" type="button" onclick="salida()">Ahora</button>
                  </div>
                </div>
              </div>
              <div class="col-md-6 col-sm-6">
                <div class="form-group">
                  <label for="hora_entrada">Hora de Retorno</label>
                  <div class="d-flex align-items-start">
                    <input type="time" class="form-control mr-3" id="hora_entrada" name="hora_entrada" required>
                    <button class="btn btn-success " id="btn_retorno" type="button" onclick="retorno()">Ahora</button>
                  </div>
                </div>
              </div>


              <div class="col-md-6 col-sm-6">
                <div class="form-group">
                  <label for="razon">Razón</label>
                  <select class="form-control" id="razon" name="razon" required>
                    <option value="">Seleccione una Razon</option>
                    <option value="CS">Comisión de Servicio</option>
                    <option value="DHE">Devolucion de Horas</option>
                    <option value="AP">Asuntos Particulares</option>
                    <option value="ESS">ESSALUD</option>
                    <option value="CAP">Capacitacion</option>
                    <option value="LM/LP">Licencia por Maternidad/Paternidad</option>
                    <option value="C.ESP">Casos Especiales</option>
                    <option value="OTR">Otro</option>
                    <!-- Opciones del select -->
                  </select>
                </div>
              </div>
              <div class="col-md-6 col-sm-6">

                <div class="form-group">
                  <label for="otra_razon">Otra Razón</label>
                  <input type="text" class="form-control" id="otra_razon" name="otra_razon">
                </div>
              </div>
              <div id="resultado" class="col-md-12 col-sm-12">

              </div>



              <!--  -->
              <div class="modal-footer bg-white col-md-12 col-sm-12">
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
  <script src="<?php echo BASE_URL; ?>assets/js/modulos/boleta_porteria.js"></script>

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
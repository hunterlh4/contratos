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
                    <button class="btn btn-lg btn-outline-primary rounded-0 " type="button" value=1 id="nuevo_registro">Nuevo</button>
                  </div>
                  <div class="card-body">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                      <li class="nav-item">
                        <a class="nav-link active" id="hora-tab" data-toggle="tab" href="#hora" role="tab" aria-controls="hora" aria-selected="true">Boleta por Horas</a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link" id="dia-tab" data-toggle="tab" href="#dia" role="tab" aria-controls="dia" aria-selected="false">Boleta por Días</a>
                      </li>

                    </ul>
                    <div class="tab-content" id="myTabContent">
                      <div class="tab-pane fade show active" id="hora" role="tabpanel" aria-labelledby="hora-tab">
                        <div class="table-responsive">
                          <table class="table table-striped table-hover text-center" style="width:100%;" id="table-horas-alex">
                            <thead>
                              <tr>
                                <th style="width: 15px;"># </th>
                                <th style="width: 30px;">Número</th>
                                <th style="width: 160px;">Solicitante</th>
                                <th style="width: 50px;">Razón</th>
                                <th style="width: 50px;">Fecha</th>


                                <th style="width: 50px;">Salida</th>
                                <th style="width: 50px;">Entrada</th>
                                <th style="width: 50px;">Trámite</th>
                                <!-- <th>estado</th> -->
                                <th style="width: 50px;">Acción</th>
                              </tr>
                            </thead>
                            <tbody>
                            </tbody>
                          </table>
                        </div>
                      </div>
                      <div class="tab-pane fade" id="dia" role="tabpanel" aria-labelledby="dia-tab">
                        <div class="table-responsive">
                          <table class="table table-striped table-hover text-center " style="width:100%;" id="table-dias-alex">
                            <thead>
                              <tr>
                                <th style="width: 15px;"># </th>
                                <th style="width: 30px;">Número</th>
                                <th style="width: 200px;">Solicitante</th>
                                <th style="width: 50px;">Razón</th>
                                <th style="width: 50px;">Desde</th>
                                <th style="width: 50px;">Hasta</th>
                                <!-- <th>Fin</th> -->


                                <th style="width: 50px;">Trámite</th>
                                <!-- <th>estado</th> -->
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
            <input type="hidden" id="tipo" name="tipo" value=0>
            <div class="row">
              <div class="col-md-6 col-sm-6">
                <div class="form-group">
                  <label for="solicitante">Solicitante</label>
                  <select class="form-control" id="solicitante" name="solicitante" required>
                    <option value="">Seleccione un Solicitante</option>

                    <!-- Opciones del select -->
                  </select>
                </div>
              </div>
              <div class="col-md-6 col-sm-6">
                <div class="form-group">
                  <label for="aprobador">Aprobador</label>
                  <select class="form-control" id="aprobador" name="aprobador" required>
                    <option value="">Seleccionar un aprobador</option>
                    <!-- Opciones del select -->
                  </select>
                </div>
              </div>
              <div class="col-md-6 col-sm-6 fechas">

                <div class="form-group">
                  <label for="fecha_inicio">Fecha de Inicio</label>
                  <input type="date" class="form-control" id="fecha_inicio" name="fecha_inicio" required>
                </div>
              </div>
              <div class="col-md-6 col-sm-6 fechas">

                <div class="form-group">
                  <label for="fecha_fin">Fecha de Fin</label>
                  <input type="date" class="form-control" id="fecha_fin" name="fecha_fin" required>
                </div>
              </div>

              <div class="col-md-6 col-sm-6 horas">

                <div class="form-group">
                  <label for="hora_salida">Hora de Salida</label>
                  <input type="time" class="form-control" id="hora_salida" name="hora_salida" required>

                </div>
              </div>
              <div class="col-md-6 col-sm-6 horas">
                <div class="form-group">
                  <label for="hora_entrada">Hora de Entrada</label>
                  <input type="time" class="form-control" id="hora_entrada" name="hora_entrada" required>
                </div>
              </div>
              <!-- </div> -->


              <div class="col-md-6 col-sm-6">
                <div class="form-group">
                  <label for="razon">Razón</label>
                  <select class="form-control" id="razon" name="razon" required>

                    <!-- Opciones del select -->
                  </select>
                </div>
              </div>
              <div class="col-md-6 col-sm-6">

                <div class="form-group">
                  <label for="otra_razon">Motivo</label>
                  <input type="text" class="form-control" id="otra_razon" name="otra_razon" placeholder="Gore, Procuraduria, Fiscalia, ..." required>
                </div>
              </div>
              <div id="resultado" class="col-md-12 col-sm-12">

              </div>
            </div>


            <!--  -->
            <div class="modal-footer bg-white col-md-12 col-sm-12" id="botones">
              <!-- <button class="btn btn-success" id="Aprobado" type="button" onclick="revisar('Aprobado')">Aprobar</button>
              <button class="btn btn-info" id="Rechazado" type="button" onclick="revisar('Rechazado')">Rechazar</button>
              <button class="btn btn-light" id="Anulado" type="button" onclick="revisar('Anulado')">Anular</button> -->
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


  <script src="<?php echo BASE_URL; ?>assets/js/modulos/boleta.js"></script>

  <script>
    const base_url = '<?php echo BASE_URL; ?>';
  </script>
  <style>
    td .d-flex {
      display: initial !important;
    }

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
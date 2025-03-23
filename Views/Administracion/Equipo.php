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
                    
                    <h3 class="font-weight-bolder"><i class="fa fa-briefcase"></i> Equipo</h3>
                    <button class="btn btn-lg btn-outline-primary rounded-0 " type="button" id="nuevo_registro">Nuevo</button>
                  </div>

                  <div class="card-body">
                    <div class="table-responsive">
                      <table class="table table-striped table-hover" style="width:100%;" id="table-alex">
                        <thead>
                          <tr>
                            <th class="text-center"># </th>
                            <th>Nombre</th>
                            <th>Estrategia</th>
                            <th>Estado</th>
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
  <div class="modal-dialog" role="document">
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

       
            <div class="form-group">
              <label>Nombre</label>
              <div class="input-group">
                <div class="input-group-prepend">
                  <div class="input-group-text">
                    <i class="fas fa-address-card"></i>
                  </div>
                </div>
                <input type="text" class="form-control" placeholder="Nombre" name="nombre" id="nombre" minlength="3"
  maxlength="50" required>
              </div>
            </div>
            <div class="form-group">
              <label>estrategia</label>
              <div class="input-group">
                <div class="input-group-prepend">
                  <div class="input-group-text">
                    <i class="fas fa-address-card"></i>
                  </div>
                </div>
                <input type="Text"  class="form-control" placeholder="estrategia" name="estrategia" id="estrategia" minlength="1"
  maxlength="50"  required>
               
              </div>
            </div>
            

            <!--  -->
            <div class="form-group" id="estado-grupo">
              <label>Estado</label>
              <div class="input-group">
                <div class="col-sm-9 d-flex align-items-center">
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
            <!--  -->

            <!--  -->
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
  <script src="<?php echo BASE_URL; ?>/assets/js/modulos/equipo.js"></script>

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
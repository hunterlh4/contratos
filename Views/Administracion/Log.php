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

                                        <h3 class="font-weight-bolder"><i class="fa fa-briefcase"></i> Log</h3>

                                    </div>

                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-striped table-hover" style="width:100%;" id="table-alex">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center"># </th>
                                                        <th>Usuario</th>
                                                        <th>Accion</th>
                                                        <th>Tabla</th>
                                                        <th>Fecha</th>
                                                        <th>accion</th>
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


                <div class="modal-body">
                    <input type="hidden" id="id" name="id">
                    <div class="row">
                        <div class="col-md-12 col-sm-12">
                            <div class="form-group ">

                                <div class="input-group">

                                    <textarea class="codeeditor col-md-12 col-sm-12" id="log" readonly></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!--MODAL - NUEVO USARIO-->

    <!-- MODAL FIN -->
    <?php include './Views/includes/script_new.php' ?>

    </html>
    <script src="<?php echo BASE_URL; ?>assets/js/modulos/log.js"></script>

    <script>
        const base_url = '<?php echo BASE_URL; ?>';
    </script>

    <style>
        .modal-body {
      max-height: 80vh; /* Ajusta según tu necesidad */
      overflow-y: auto;
    }
    .codeeditor {
      width: 100%;
      height: 400px; /* Ajusta esta altura según tus necesidades */
      box-sizing: border-box; /* Incluye el padding y el borde en el tamaño total */
      padding: 10px;
      border: 1px solid #ccc;
      border-radius: 5px;
      resize: none; /* Evita el redimensionamiento manual */
      overflow: auto; /* Permite el scroll si el contenido es demasiado grande */
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
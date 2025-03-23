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

                                        <h3 class="font-weight-bolder"><i class="fa fa-briefcase"></i> Configuracion</h3>
                                        
                                    </div>

                                    <div class="card-body">
                                        <form form id="formulario" class="needs-validation" novalidate="" method="POST" autocomplete="off">
                                        <input type="hidden" name="id" id="id">
                                            <div class="form-group">
                                                <label>API KEY</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text">
                                                            <i class="fas fa-address-card"></i>
                                                        </div>
                                                    </div>
                                                    <input type="text" class="form-control" placeholder="Ingrese el API KEY" name="api_1" id="api_1" minlength="10" maxlength="60" required>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label>API KEY 2</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text">
                                                            <i class="fas fa-address-card"></i>
                                                        </div>
                                                    </div>
                                                    <input type="text" class="form-control" placeholder="Ingrese el API KEY" name="api_2" id="api_2" minlength="10" maxlength="60" >
                                                </div>


                                                
                                            </div>

                                            
                                            <div class="form-group">
                                            <button class="btn btn-primary" type="submit" onclick=guardar() id="btnAccion">Registrar</button>

                                                
                                            </div>
                                        </form>
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
                            <label>Nivel</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <i class="fas fa-address-card"></i>
                                    </div>
                                </div>
                                <input type="number" step="1" class="form-control" placeholder="nivel" name="nivel" id="nivel" required>
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
    <script src="<?php echo BASE_URL; ?>assets/js/modulos/configuracion.js"></script>

    <script>
        const base_url = '<?php echo BASE_URL; ?>';
    </script>
</body>

</html>
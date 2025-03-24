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
                                        <h3 class="font-weight-bolder"><i class="fa fa-briefcase"></i> Contrato</h3>
                                        <!-- <div class="ml-auto">
                                            
                                            <button class="btn btn-lg btn-outline-primary rounded-0" type="button"
                                                id="nuevo_registro">Nuevo</button>
                                        </div> -->

                                        <div class="dropdown d-inline mr-2">
                                            <button class="btn btn-primary rounded-0 dropdown-toggle" type="button" id="dropdownMenuButton"
                                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                Nuevo Contrato
                                            </button>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item" href="<?php echo BASE_URL . 'Contrato/Nuevo_Arrendamiento'; ?>">Arrendamiento</a>
                                                <a class="dropdown-item" href="<?php echo BASE_URL . 'Contrato/Nuevo_LocacionServicio'; ?>">Locacion de Servicio</a>
                                                <a class="dropdown-item" href="<?php echo BASE_URL . 'Contrato/Nuevo_Mandato'; ?>">Mandato</a>
                                                <a class="dropdown-item" href="<?php echo BASE_URL . 'Contrato/Nuevo_MutuoDinero'; ?>">Mutuo Dinero</a>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-striped table-hover align-center"
                                                style="width:100%;" id="table-alex">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center"># </th>
                                                        <th>CODIGO</th>
                                                        <th>TIPO DE CONTRATO</th>
                                                        <!-- <th>TIPO DE DOCUMENTO</th> -->
                                                        <th>ABOGADO</th>
                                                        <th>SOLICITANTE</th>
                                                        <!-- <th>TELEFONO</th> -->
                                                        <th>ESTADO</th>
                                                        <!-- <th>CORREO</th> -->

                                                        <!-- <th>Particular</th> -->
                                                        <th>FECHA SOLICITADA</th>
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

            </div>
            <?php include './Views/includes/footer.php'; ?>
        </div>
    </div>

    <!-- MODAL -->
    <div id="nuevoModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title"
        aria-hidden="true">
        <!--  sm md lg xl -->
        <div class="modal-dialog  modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">

                    <h5 class="modal-title" id="titleModal"></h5>
                    <button type="button" onclick=cerrarModal() class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form form id="formulario" class="needs-validation" novalidate="" method="POST" autocomplete="off">
                    <div class="modal-body">

                        <!-- ID -->
                        <input type="hidden" id="id" name="id">
                        <!-- AQUI EMPIEZA -->


                        <!-- aqui termina -->
                        <!-- <p><b>Datos Personales</b></p> -->
                        <hr>
                        <div class="row">

                            <div class="form-group col-xl-6 col-lg-6 col-md-12 col-sm-12">
                                <label for="rol">Tipo de Persona</label>
                                <div class="input-group">
                                    <!-- <div class="input-group-prepend">
                    <div class="input-group-text">
                      <i class="fas fa-address-card"></i>
                    </div>
                  </div> -->
                                    <select class="form-control" id="tipo_persona" name="tipo_persona" required>
                                        <option value="" selected>Selecciona un Tipo de Persona</option>
                                        <option value=1>Persona Natural</option>
                                        <option value=2>Persona Juridica</option>
                                        <!-- Opciones para la dirección -->
                                    </select>
                                </div>

                            </div>


                            <!-- dni -->
                            <div class="form-group col-xl-6 col-lg-6 col-md-12 col-sm-12">
                                <label for="dni">DNI</label>
                                <!-- <button type="button" onclick=consultar()>Consultar</button> -->
                                <!-- <input type="text" class="form-control" id="dni" name="dni" required> -->
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <i class="fas fa-address-card"></i>
                                        </div>
                                    </div>
                                    <input type="text" class="form-control" placeholder="DNI" name="dni" id="dni"
                                        minlength="8" maxlength="8">


                                    <div class="input-group-append">
                                        <button class="btn btn-primary" type="button" onclick="consultar(1)"> <i
                                                class="fas fa-search"></i></button>
                                    </div>
                                </div>
                            </div>
                            <!-- ruc -->
                            <div class="form-group col-xl-6 col-lg-6 col-md-12 col-sm-12 ">
                                <label for="ruc">RUC</label>
                                <!-- <button type="button" onclick=consultar()>Consultar</button> -->
                                <!-- <input type="text" class="form-control" id="dni" name="dni" required> -->
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <i class="fas fa-address-card"></i>
                                        </div>
                                    </div>
                                    <input type="text" class="form-control" placeholder="RUC" name="ruc" id="ruc"
                                        minlength="11" maxlength="11">


                                    <div class="input-group-append">
                                        <button class="btn btn-primary" type="button" onclick="consultar(2)"> <i
                                                class="fas fa-search"></i></button>
                                    </div>
                                </div>
                            </div>

                            <!-- nombre -->
                            <div class="form-group col-xl-6 col-lg-6 col-md-12 col-sm-12">
                                <label for="nombre">Nombre</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <i class="fas fa-address-card"></i>
                                        </div>
                                    </div>
                                    <input type="text" class="form-control" placeholder="Nombre" name="nombre"
                                        id="nombre" minlength="5" maxlength="30" required>
                                </div>

                            </div>

                            <div class="form-group col-xl-6 col-lg-12 col-md-12 col-sm-12">
                                <label for="Direccion">Direccion</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <i class="fas fa-address-card"></i>
                                        </div>
                                    </div>
                                    <input type="text" class="form-control" placeholder="Direccion" name="direccion"
                                        id="direccion" minlength="5" maxlength="30" required>
                                </div>

                            </div>
                            <!-- ruc -->
                            <div class="form-group col-xl-4 col-lg-4 col-md-12 col-sm-12">
                                <label for="rol">Departamento</label>
                                <div class="input-group">
                                    <!-- <div class="input-group-prepend">
                    <div class="input-group-text">
                      <i class="fas fa-address-card"></i>
                    </div>
                  </div> -->
                                    <select class="form-control" id="departamento" name="departamento" required>
                                        <option value="" selected>Selecciona un departamento</option>
                                        <!-- Opciones para la dirección -->
                                    </select>
                                </div>

                            </div>
                            <!-- provincia -->
                            <div class="form-group col-xl-4 col-lg-4 col-md-12 col-sm-12">
                                <label>provincia</label>
                                <div class="input-group">

                                    <select class="form-control" id="provincia" name="provincia" required>
                                        <option value="" selected>Selecciona un provincia</option>
                                        <!-- Opciones para la dirección -->
                                    </select>
                                </div>
                            </div>
                            <!-- distrito -->
                            <div class="form-group col-xl-4 col-lg-4 col-md-12 col-sm-12">
                                <label>distrito</label>
                                <div class="input-group">

                                    <select class="form-control" id="distrito" name="distrito" required>
                                        <option value="" selected>Selecciona un distrito</option>
                                        <!-- Opciones para la dirección -->
                                    </select>
                                </div>
                            </div>


                            <!-- NOMBRE -->


                            <!-- CELULAR -->
                            <div class="form-group col-xl-6 col-lg-6 col-md-12 col-sm-12">
                                <label>celular</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <i class="fas fa-mobile-alt"></i>
                                        </div>
                                    </div>
                                    <input type="text" class="form-control" placeholder="Celular" name="celular"
                                        id="celular" maxlength="11">
                                </div>
                            </div>

                            <!-- correo -->
                            <div class="form-group col-xl-6 col-lg-6 col-md-12 col-sm-12">
                                <label>Correo</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <!-- <i class="fas fa-email"></i> -->
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round"
                                                class="feather feather-mail">
                                                <path
                                                    d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z">
                                                </path>
                                                <polyline points="22,6 12,13 2,6"></polyline>
                                            </svg>
                                        </div>
                                    </div>
                                    <input type="email" class="form-control" placeholder="Correo" name="email"
                                        id="email" minlength="5" maxlength="40" required>
                                </div>
                            </div>




                        </div>

                        <!-- <p><b>Datos de Trabajo</b></p>
                        <hr> -->
                        <div class="row">
                            <!-- rol -->



                            <!-- estado -->
                            <div class="form-group col-xl-3 col-lg-4 col-md-6 col-sm-12" id="estado-grupo">
                                <label>Estado</label>
                                <div class="input-group">
                                    <div class="col-sm-9 d-flex align-items-center mt-1">
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


                        </div>

                        <!-- FIN DEL ROW -->
                    </div>

                    <div class="modal-footer bg-white">
                        <button class="btn btn-primary" type="submit" id="btnAccion">Registrar</button>
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
    <script src="<?php echo BASE_URL; ?>/assets/js/modulos/contrato/solicitudes.js"></script>

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
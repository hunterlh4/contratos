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
                <h4 class="font-weight-bolder text-center pb-4 pt-0 mt-0">
                    <i class="fa fa-briefcase"></i> Nueva Solicitud - Arrendamiento
                </h4>


                <section class="section">

                    <div class="section-body">




                        <div class="row">

                            <!-- <div class="col-12 col-md-12 col-lg-3">

                                <div class="card">
                                   
                                    <div class="card-body">



                                    </div>
                                </div>
                            </div> -->

                            <div class="col-12 col-md-12 col-lg-9">
                                <div class="card">

                                    <!-- <hr> -->
                                    <div class="card-body">

                                        <form form id="formulario" class="needs-validation" novalidate="" method="POST" autocomplete="off">

                                            <h5>Datos Generales</h5>

                                            <div class="card-body pb-0">
                                                <div class="row">
                                                    <div class="form-group col-md-12 col-4 col-xl-4 col-lg-4">
                                                        <label>Abogado</label>
                                                        <div class="d-flex align-items-center">
                                                            <select class="form-control  " id="abogado_id" name="abogado_id" required>
                                                                <option value="" selected>Selecciona un Abogado</option>

                                                            </select>
                                                        </div>

                                                    </div>
                                                    <!-- </div>
                                                <div class="row"> -->
                                                    <div class="form-group col-md-12 col-4 col-xl-4 col-lg-4">
                                                        <label>Arrendador</label>
                                                        <div class="d-flex align-items-center">
                                                            <select class="form-control " id="emisor_id" name="emisor_id" required>
                                                                <option value="" selected>Selecciona un Arrendador</option>

                                                            </select>
                                                        </div>

                                                    </div>
                                                    <!-- </div>
                                                <div class="row"> -->
                                                    <div class="form-group col-md-12 col-4 col-xl-4 col-lg-4">
                                                        <label>Arrendatario</label>
                                                        <div class="d-flex align-items-center">
                                                            <select class="form-control  " id="receptor_id" name="receptor_id" required>
                                                                <option value="" selected>Selecciona un Arrendatario</option>

                                                            </select>
                                                        </div>

                                                    </div>


                                                </div>




                                            </div>





                                            <h5>Inmueble</h5>

                                            <div class="card-body pb-0">
                                                <div class="row">
                                                    <div class="form-group col-xl-4 col-lg-4 col-md-12 col-sm-12">
                                                        <label for="rol">Departamento</label>
                                                        <div class="input-group">

                                                            <select class="form-control" id="departamento" name="departamento" required>
                                                                <option value="" selected>Selecciona un departamento</option>
                                                                <!-- Opciones para la dirección -->
                                                            </select>
                                                        </div>

                                                    </div>
                                                    <!-- </div>
                                                <div class="row"> -->
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
                                                    <!-- </div>
                                               
                                                <div class="row"> -->
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

                                                    <div class="form-group col-xl-4 col-lg-4 col-md-12 col-sm-12">
                                                        <label for="aprobador">Direccion</label>
                                                        <input type="text" class="form-control" id="direccion" name="direccion" placeholder="Ingrese su direccion" required>
                                                    </div>

                                                    <div class="form-group col-xl-8 col-lg-4 col-md-12 col-sm-12">
                                                        <label for="aprobador">Observaciones</label>
                                                        <textarea class="form-control" id="observacion" name="observacion"></textarea>
                                                    </div>



                                                </div>


                                            </div>
                                            <!-- plazos -->
                                            <h5>Plazo</h5>

                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="form-group col-xl-4 col-lg-4 col-md-12 col-sm-12">
                                                        <label for="fecha_inicio">Inicio de Contrato</label>
                                                        <div class="input-group">


                                                            <input type="date" class="form-control" id="fecha_inicio" name="fecha_inicio" required>
                                                        </div>

                                                    </div>
                                                    <!-- </div>
                                                <div class="row"> -->
                                                    <!-- provincia -->
                                                    <div class="form-group col-xl-4 col-lg-4 col-md-12 col-sm-12">
                                                        <label for="fecha_fin">Fin de Contrato</label>
                                                        <div class="input-group">

                                                            <input type="date" class="form-control" id="fecha_fin" name="fecha_fin" required>

                                                        </div>
                                                    </div>
                                                    <!-- </div>
                                               
                                                <div class="row"> -->
                                                    <!-- distrito -->
                                                    <div class="form-group col-xl-4 col-lg-4 col-md-12 col-sm-12">
                                                        <label for="fecha_suscrita">Suscripcion de Contrato</label>
                                                        <div class="input-group">

                                                            <input type="date" class="form-control" id="fecha_suscripcion" name="fecha_suscripcion" required>

                                                        </div>
                                                    </div>
                                                </div>

                                            </div>



                                            <h5>Renta</h5>

                                            <div class="card-body pb-0">
                                                <div class="row">
                                                    <div class="form-group col-xl-3 col-lg-4 col-md-12 col-sm-12">
                                                        <label for="rol">Moneda</label>
                                                        <div class="input-group">

                                                            <select class="form-control" id="moneda_id" name="moneda_id" required>
                                                                <option value="" selected>Selecciona una Moneda</option>
                                                                <!-- Opciones para la dirección -->
                                                            </select>
                                                        </div>

                                                    </div>
                                                    <div class="form-group col-xl-3 col-lg-4 col-md-12 col-sm-12">
                                                        <label for="aprobador">Monto</label>
                                                        <input type="number" class="form-control" value=0 id="monto" name="monto" placeholder="Ingrese el Monto" required>
                                                    </div>
                                                    <!-- </div>
                                                <div class="row"> -->
                                                    <!-- provincia -->
                                                    <div class="form-group col-xl-3 col-lg-4 col-md-12 col-sm-12">
                                                        <label>Banco</label>
                                                        <div class="input-group">

                                                            <select class="form-control" id="banco_id" name="banco_id" required>
                                                                <option value="" selected>Selecciona un Banco</option>
                                                                <!-- Opciones para la dirección -->
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <!-- </div>
                                               
                                                <div class="row"> -->
                                                    <!-- distrito -->


                                                    <div class="form-group col-xl-3 col-lg-4 col-md-12 col-sm-12">
                                                        <label for="aprobador">N° de cuenta</label>
                                                        <input type="text" class="form-control" id="cuenta_bancaria" name="cuenta_bancaria" placeholder="Ingrese su la cuenta bancaria" required>
                                                    </div>





                                                </div>


                                            </div>


                                            <div class="card-footer text-right">
                                                <button class="btn btn-primary" type="submit" id="btnAccion">Enviar</button>
                                            </div>
                                        </form>

                                    </div>


                                </div>
                            </div>

                            <div class="col-12 col-md-12 col-lg-3">

                                <div class="row">
                                    <div class="card col-12">
                                        <div class="card-header d-flex justify-content-center align-items-center text-center mb-0 mt-3">
                                            <h4>Arrendador</h4>
                                        </div>
                                        <div class="card-body">
                                            <div class="py-0">
                                                <p class="clearfix">
                                                    <span class="float-left">Nombre</span>
                                                    <span class="float-right text-muted" id="arrendador_nombre"></span>
                                                </p>
                                                <p class="clearfix">
                                                    <span class="float-left">DNI</span>
                                                    <span class="float-right text-muted" id="arrendador_dni"></span>
                                                </p>
                                                <p class="clearfix">
                                                    <span class="float-left">RUC</span>
                                                    <span class="float-right text-muted" id="arrendador_ruc"></span>
                                                </p>
                                                <p class="clearfix">
                                                    <span class="float-left">Dirección</span>
                                                    <span class="float-right text-muted" id="arrendador_direccion"></span>
                                                </p>
                                                <p class="clearfix">
                                                    <span class="float-left">Teléfono</span>
                                                    <span class="float-right text-muted" id="arrendador_telefono"></span>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="card col-12">
                                        <div class="card-header d-flex justify-content-center align-items-center text-center mb-0 mt-3">
                                            <h4>Arrendatario</h4>
                                        </div>
                                        <div class="card-body">
                                            <div class="py-0">
                                                <p class="clearfix">
                                                    <span class="float-left">Nombre</span>
                                                    <span class="float-right text-muted" id="arrendatario_nombre"></span>
                                                </p>
                                                <p class="clearfix">
                                                    <span class="float-left">DNI</span>
                                                    <span class="float-right text-muted" id="arrendatario_dni"></span>
                                                </p>
                                                <p class="clearfix">
                                                    <span class="float-left">RUC</span>
                                                    <span class="float-right text-muted" id="arrendatario_ruc"></span>
                                                </p>
                                                <p class="clearfix">
                                                    <span class="float-left">Dirección</span>
                                                    <span class="float-right text-muted" id="arrendatario_direccion"></span>
                                                </p>
                                                <p class="clearfix">
                                                    <span class="float-left">Teléfono</span>
                                                    <span class="float-right text-muted" id="arrendatario_telefono"></span>
                                                </p>
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
    <div id="nuevoModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title"
        aria-hidden="true">
        <!--  sm  lg xl -->
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
                        <!-- AQUI EMPIEZA -->


                        <!-- aqui termina -->
                        <!-- <p><b>Datos Personales</b></p> -->
                        <hr>
                        <div class="row">


                            <!-- dni -->
                            <div class="form-group col-xl-4 col-lg-4 col-md-12 col-sm-12">
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
                                        minlength="8" maxlength="8" required>


                                    <div class="input-group-append">
                                        <button class="btn btn-primary" type="button" onclick=consultar()> <i
                                                class="fas fa-search"></i></button>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-xl-4 col-lg-6 col-md-12 col-sm-12">
                                <label for="rol">Cargo</label>
                                <div class="input-group">
                                    <!-- <div class="input-group-prepend">
                    <div class="input-group-text">
                      <i class="fas fa-address-card"></i>
                    </div>
                  </div> -->
                                    <select class="form-control" id="cargo" name="cargo" required>
                                        <option value="" selected>Selecciona un cargo</option>
                                        <!-- Opciones para la dirección -->
                                    </select>
                                </div>

                            </div>
                            <!-- area -->
                            <div class="form-group col-xl-4 col-lg-6 col-md-12 col-sm-12">
                                <label>Area</label>
                                <div class="input-group">

                                    <select class="form-control" id="area" name="area" required>
                                        <option value="" selected>Selecciona un area</option>
                                        <!-- Opciones para la dirección -->
                                    </select>
                                </div>
                            </div>

                            <!-- NOMBRE -->
                            <!-- nombre -->
                            <div class="form-group col-xl-4 col-lg-4 col-md-12 col-sm-12">
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
                            <!-- apellido -->
                            <div class="form-group col-xl-4 col-lg-4 col-md-12 col-sm-12">
                                <label for="apellido">Apellido Paterno</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <i class="fas fa-address-card"></i>
                                        </div>
                                    </div>
                                    <input type="text" class="form-control" placeholder="Apellido Paterno"
                                        name="apellido_paterno" id="apellido_paterno" minlength="3" maxlength="30"
                                        required>
                                </div>

                            </div>

                            <!-- APELLIDO MATERNO -->

                            <div class="form-group col-xl-4 col-lg-4 col-md-12 col-sm-12">
                                <label>Apellido Materno</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <i class="fas fa-phone"></i>
                                        </div>
                                    </div>
                                    <input type="text" class="form-control" placeholder="Apellido Materno"
                                        name="apellido_materno" id="apellido_materno" maxlength="11">
                                </div>
                            </div>




                            <!-- telefono -->
                            <div class="form-group col-xl-4 col-lg-4 col-md-6 col-sm-12">
                                <label>Teléfono</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <i class="fas fa-phone"></i>
                                        </div>
                                    </div>
                                    <input type="text" class="form-control" placeholder="Telefono" name="telefono"
                                        id="telefono" maxlength="11">
                                </div>
                            </div>
                            <!-- CELULAR -->
                            <div class="form-group col-xl-4 col-lg-4 col-md-6 col-sm-12">
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
                            <div class="form-group col-xl-4 col-lg-4 col-md-6 col-sm-12">
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
    <script src="<?php echo BASE_URL; ?>/assets/js/modulos/contrato/arrendamiento.js"></script>

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
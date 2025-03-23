<?php include_once './Views/includes/header.php'; ?>
<body>
  <!-- <div class="loader"></div> -->
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
                                    <div class="card-header justify-content-center pt-5">
                                
                                        <h3 class="font-weight-bolder"><i class="fa fa-user-edit"></i> Configuración de
                                            Perfil</h3>
                                    </div>
                                    <div class="card-body">
                                        <form id="formPerfil_actualizar" method="POST">
                                            <input type="hidden" id="id_usuario" name="id_usuario" value="<?php // echo  $data['id'] ?>">
                                            <input type="hidden" id="bandera" name="bandera">
                                            <div class="row form-group justify-content-center">
                                                <div class="col-md-6 d-flex justify-content-end">
                                                    <label class="custom-switch">
                                                        <input type="checkbox" id="switch_editar" name="switch_editar" class="custom-switch-input">
                                                        <span class="custom-switch-indicator"></span>
                                                        <span class="custom-switch-description">¿Editar?</span>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="row form-group justify-content-center">
                                                <div class="col-md-6 justify-content-center">
                                                    <label for="nombres">Nombre(s):</label>
                                                    <input id="nombres" name="nombres" type="text" class="form-control" value="<?php echo $data['nombre'] ?>" disabled>
                                                </div>
                                            </div>
                                            <div class="row form-group justify-content-center">
                                                <div class="col-md-6 justify-content-center">
                                                    <label for="apellidos">Apellidos:</label>
                                                    <input id="apellidos" name="apellidos" type="text" class="form-control" value="<?php echo $data["apellido"] ?>" readonly>
                                                </div>
                                            </div>
                                            <div class="row form-group justify-content-center">
                                                <div class="col-md-6 justify-content-center">
                                                    <label for="usuario">Usuario:</label>
                                                    <input id="usuario" name="usuario" type="text" class="form-control" value="<?php echo $data["username"] ?>" disabled>
                                                    <div id="valid_user" class="invalid-feedback" type="hidden"> El
                                                        usuario no puede estar vacio. </div>
                                                </div>
                                            </div>
                                            <div class="row form-group justify-content-center">
                                                <div class="col-md-6 justify-content-center">
                                                    <label for="new_pass_1">Contraseña:</label>
                                                    <input id="new_pass_1" name="new_pass_1" type="password" class="form-control" placeholder="Sin Cambios" disabled>
                                                </div>
                                            </div>
                                            <div class="row form-group justify-content-center">
                                                <div class="col-md-6 justify-content-center">
                                                    <label for="new_pass_2">Repetir Contraseña:</label>
                                                    <input id="new_pass_2" name="new_pass_2" type="password" class="form-control" placeholder="Sin Cambios" disabled>
                                                    <div id="valid_contraseña" class="invalid-feedback" type="hidden">
                                                        Las contraseñas no coinciden. </div>
                                                </div>
                                            </div>
                                            <div class="row form-group justify-content-center">
                                                <div class="col-md-6 d-flex justify-content-center">
                                                    <button type="reset" id="btn_cancelar" class="btn btn-danger m-2" disabled>Cancelar</button>
                                                    <button type="submit" id="btn_guardar" class="btn btn-primary m-2" disabled>Guardar</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <?php //include 'includes/sidebar-config.html'; ?>
            </div>
            <?php include './Views/includes/footer.php'; ?>
    </div>
  </div>

  <?php include './Views/includes/script_new.php' ?>
  <script src="<?php echo BASE_URL; ?>/assets/js/modulos/perfil.js"></script>
    
  <script>
    // $(document).ready(function(){
    //   $(".collapse-btn").click();
    // });
    const base_url = '<?php echo BASE_URL; ?>';
  </script>
</body>

</html>
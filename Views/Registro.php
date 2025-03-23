<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>
    <?php echo $data['title']; ?>
  </title>
  <!-- General CSS Files -->
  <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/app.min.css">
  <!-- <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/bundles/jquery-selectric/selectric.css"> -->
  <!-- Template CSS -->
  <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/style.css">
  <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/bundles/select2/dist/css/select2.min.css">
  <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/components.css">
  <!-- Custom style CSS -->
  <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/custom.css">
  <link rel="icon" type="png" href="<?php echo BASE_URL; ?>assets/img/icono_diresa.png">

</head>

<body>
  <div class="loader"></div>

  <div id="app">

    <section class="section">
      <div class="container mt-5">
        <div class="row justify-content-center">
          <div class="col-12 col-sm-10 col-md-8 col-lg-6 col-xl-6">
            <div class="card card-primary">
              <div class="card-header">
                <h4>Registro</h4>
              </div>
              <div class="card-body">
                <form id="formulario" method="POST" class="needs-validation" novalidate autocomplete="off">

                  <div class="row">

                    <div class="form-group col-12 col-md-12">
                      <label for="direccion" class="custom-label">Dirección</label>
                      <div class="input-group">
                        <select class="form-control select select2" id="direccion" name="direccion" required>
                          <option value="" selected>Selecciona una Dirección</option>
                          <!-- Opciones para la dirección -->
                        </select>
                        <div class="invalid-feedback">
                          Debes seleccionar una dirección.
                        </div>
                        <div class="valid-feedback">
                          Correcto.
                        </div>
                      </div>
                    </div>

                    <div class="form-group col-xl-6 col-md-6">
                      <label for="dni">DNI</label>
                      <div class="input-group">
                        <input id="dni" type="text" class="form-control" name="dni" pattern="\d{8}" maxlength="8" title="Debe tener exactamente 8 dígitos" autofocus required>
                        <div class="input-group-append">
                          <button class="btn btn-icon btn-primary" onclick="buscar()" type="button"><i class="fas fa-search"></i></button>
                        </div>
                        <div class="invalid-feedback">
                          Por favor, ingresa un DNI válido.
                        </div>
                        <div class="valid-feedback">
                          Correcto.
                        </div>
                      </div>
                    </div>

                    <div class="form-group col-xl-6 col-md-6">
                      <label for="fecha_nacimiento">Fecha de Nacimiento</label>
                      <input id="fecha_nacimiento" type="date" class="form-control" name="fecha_nacimiento" required>
                      <div class="invalid-feedback">
                        Por favor, ingresa una fecha válida.
                      </div>
                      <div class="valid-feedback">
                        Correcto.
                      </div>
                    </div>

                    <div class="form-group col-xl-6 col-md-6">
                      <label for="apellido">Apellido</label>
                      <input id="apellido" type="text" class="form-control" pattern="[A-ZÑ\s]{5,30}" minlength="5" maxlength="30" name="apellido" required>
                      <div class="invalid-feedback">
                        Por favor, ingresa tu apellido.
                      </div>
                      <div class="valid-feedback">
                        Correcto.
                      </div>
                    </div>

                    <div class="form-group col-xl-6 col-md-6">
                      <label for="nombre">Nombre</label>
                      <input id="nombre" type="text" class="form-control" pattern="[A-ZÑ\s]{3,30}" minlength="3" maxlength="30" name="nombre" required>
                      <div class="invalid-feedback">
                        Por favor, ingresa tu nombre.
                      </div>
                      <div class="valid-feedback">
                        Correcto.
                      </div>
                    </div>

                    <div class="form-group col-12 col-md-12">
                      <div>
                        <label for="usuario" class="custom-label">Usuario</label>
                        <small id="username-error" class="custom-small d-none"> (El nombre de usuario ya se encuentra en uso.) </small>
                      </div>
                      <input id="usuario" name="usuario" type="text" class="form-control" pattern="[a-zA-Z0-9]{5,16}" minlength="5" maxlength="16" required>
                      <div class="invalid-feedback">
                        El nombre de usuario debe tener entre 5 y 16 caracteres.
                      </div>
                      <div class="valid-feedback">
                        Correcto.
                      </div>
                    </div>

                    <div class="form-group col-xl-6 col-md-6">
                      <label for="password" class="d-block">Nueva Contraseña</label>
                      <div class="input-group">
                        <input id="password" type="password" class="form-control pwstrength" pattern=".{6,20}" minlength="6" maxlength="20" data-indicator="pwindicator" name="password" required>
                        <div class="input-group-append">
                          <button class="btn btn-icon btn-primary" onclick="ver1()" type="button"><i class="fas fa-eye"></i></button>
                        </div>
                        <div class="invalid-feedback">
                          La clave debe tener entre 6 y 20 caracteres.
                        </div>
                        <div class="valid-feedback">
                          Correcto.
                        </div>
                      </div>
                      <div id="pwindicator" class="pwindicator">
                        <div class="bar"></div>
                        <div class="label"></div>
                      </div>
                    </div>

                    <div class="form-group col-xl-6 col-md-6">
                      <label for="password2" class="d-block">Confirma tu Contraseña</label>
                      <div class="input-group">
                        <input id="password2" type="password" class="form-control pwstrength2" pattern=".{6,20}" minlength="6" maxlength="20" data-indicator="pwindicator2" name="password-confirm" required>
                        <div class="input-group-append">
                          <button class="btn btn-icon btn-primary" onclick="ver2()" type="button"><i class="fas fa-eye"></i></button>
                        </div>
                        <div class="invalid-feedback">
                          La clave debe tener entre 6 y 20 caracteres.
                        </div>
                        <div class="valid-feedback">
                          Correcto.
                        </div>
                      </div>
                      <div id="pwindicator2" class="pwindicator">
                        <div class="bar"></div>
                        <div class="label"></div>
                      </div>
                    </div>

                    <div class="form-group col-xl-12 col-md-12">
                      <button type="submit" class="btn btn-primary btn-lg btn-block">
                        Registrar
                      </button>
                    </div>
                  </div>
                </form>
              </div>
              <div class="mb-4 text-muted text-center">
                ¿Ya se encuentra registrado? <a href="<?php echo BASE_URL; ?>Login">Iniciar sesión</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
  <!-- General JS Scripts -->

  <style>
    .custom-label {
      font-weight: 600;
      color: #34395e;
      font-size: 12px;
      letter-spacing: 0.5px;
    }

    .custom-small {


      margin-top: .25rem;
      font-size: 80%;
      color: #dc3545;
    }
  </style>

  <script>
    const base_url = '<?php echo BASE_URL; ?>';
  </script>
  <script src="<?php echo BASE_URL; ?>assets/js/app.min.js"></script>
  <!-- Template JS File -->
  <script src="<?php echo BASE_URL; ?>assets/js/scripts2.js"></script>
  <!-- Custom JS File -->
  <script src="<?php echo BASE_URL; ?>assets/js/custom.js"></script>

  <!-- JS Libraies -->
  <script src="<?php echo BASE_URL; ?>assets/bundles/select2/dist/js/select2.full.min.js"></script>
  <script src="<?php echo BASE_URL; ?>assets/bundles/jquery-pwstrength/jquery.pwstrength.min.js"></script>
  <!-- <script src="<?php echo BASE_URL; ?>assets/bundles/jquery-selectric/jquery.selectric.min.js"></script> -->
  <script src="<?php echo BASE_URL; ?>assets/js/modulos/registro.js"></script>
  <script src="<?php echo BASE_URL; ?>assets/js/sweetalert2.all.min.js"></script>


</body>

</html>
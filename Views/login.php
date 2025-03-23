<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?php echo $data['title']; ?>
    </title>
    <link rel="stylesheet" href="assets/css/login/reset.css">
    <link rel="stylesheet" href="assets/css/login/main.css">
    <link rel='stylesheet' href='assets/css/login/iconos.css'>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="assets/css/fonts/font-family.css" rel="stylesheet">
    <link rel="icon" type="png" href="<?php echo BASE_URL; ?>/assets/img/icono_diresa.png">
</head>

<body>
    <main>

        <div class="page-container">

            <div class="grid-container">
                <div class="left-side">
                    <div class="img-and-text">
                        <!-- <img class="cart-illustration" src="assets/img/login/cart-illustration.png" alt=""> -->
                        <img class="cart-illustration" src="assets/img/logo.png" alt="">
                        <!-- <img class="cart-illustration" src="assets/img/icono_diresa.png" alt="" > -->
                        <!-- <h1>Recursos <br> Humanos</h1> -->
                        <!-- <hr> -->
                        <!-- <h1>Sistema Integrador</h1> -->
                        <!-- <h1>Inicio de Sesion.</h1> -->
                    </div>
                </div>

                <div class="right-side">
                    <div class="wrapper">
                        <h2>Inicio de Sesión.</h2>
                        <p>¿No tienes una cuenta? <a href="<?php echo BASE_URL; ?>Registro">Regístrate</a></p>
                        <!-- <div class="sign-up-buttons">
              <button id="sign-up"><img src="assets/img/login/google-icon.png"> Sign up with Google</button>
              <button id="sign-up-facebook"><img src="assets/img/login/facebook-icon.svg" width="16px"> Sign up with facebook</button>
            </div> -->
                        <p class="socials-divider"><span>o</span></p>

                        <form role="form" id="formulario" autocomplete="off">
                            <!-- <label for="username">Usuario</label> -->
                            <div class="email-input-container">
                                <!-- <i class="fi fi-rr-envelope icon-email"></i> -->
                                <!-- <i class="fi fi-rr-circle-user icon-email"></i> -->
                                <i class="fi fi-rr-user icon-email"></i>
                                <input type="text" name="username" placeholder="Ingrese su usuario" id="username" focus>
                            </div>
                            <!-- <label for="password">Contraseña</label> -->

                            <div class="password-input-container">
                                <i class="fi fi-rr-lock icon-password"></i>
                                <input type="password" name="password" placeholder="Ingrese su contraseña"
                                    id="password">
                            </div>

                        </form>

                        <div class="agreement-check">
                            <input type="checkbox" id="recuerdame" name="recuerdame">
                            <label for="recuerdame" class="terms-of-use-text">Recuérdame</label>
                            <!-- <span class="terms-of-use-text">Recuerdame -->

                            <!-- <a href="#">Terms of Service</a> and -->
                            <!-- <a href="#">Privacy Policy</a> -->
                            <!-- </span> -->


                        </div>


                        <button id="register-button" type="button">Iniciar Sesion</button>
                        <!-- <p class="credits">Made with ❤️ by <a href="https://github.com/hunterlh4" target="_blank">aluizamendes</a></p> -->
                        <p class="credits">Descarga el <a
                                href="<?php echo BASE_URL . 'Uploads/Manual/Manual_Usuario.pdf'; ?>"
                                target="_blank">Manual de Usuario 🕗</a></p>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <script>
    const base_url = '<?php echo BASE_URL; ?>';
    </script>

    <script src="<?php echo BASE_URL; ?>assets/js/sweetalert2.all.min.js"></script>
    <script src="<?php echo BASE_URL; ?>assets/js/app.min.js"></script>
    <script src="<?php echo BASE_URL; ?>assets/js/modulos/login.js"></script>

</body>

<style>
/* .swal2-popup {
    font-size: 1.6rem !important;
  } */


/* Estilos del texto */
</style>

</html>
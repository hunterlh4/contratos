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

                                        <h3 class="font-weight-bolder"><i class="fa fa-laptop"></i> Soporte</h3>

                                    </div>
                                    <div class="row ">
                                        <div class="col-md-6 align-center">
                                            <div class="card-body">
                                                <ul class="list-group list-group-flush">
                                                    <li class="list-group-item">
                                                        <div class="media-body">
                                                            <h5 class="mr-3">Correo </h5>
                                                            <p class="text-center">alexticoma4@gmail.com</p>
                                                        </div>
                                                    </li>
                                                    <li class="list-group-item">
                                                        <div class="media-body">
                                                            <h5 class="mr-3">Número </h5>
                                                            <p class="text-center">933054810</p>
                                                            <a href="https://wa.link/8hpd4c" target="_blank" rel="noopener noreferrer" class="btn btn-social-icon ml-2 " style="background-color: #ffffff; border-radius: 50%;" >
                                                                <i class="fab fa-whatsapp" style="color: #25D366; font-size: 32px;"></i>
                                                            </a>
                                                        </div>
                                                    </li>
                                                </ul>
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




    <!--MODAL - NUEVO USARIO-->

    <!-- MODAL FIN -->
    <?php include './Views/includes/script_new.php' ?>

    </html>
    <script src="<?php echo BASE_URL; ?>assets/js/modulos/soporte.js"></script>

    <script>
        const base_url = '<?php echo BASE_URL; ?>';
    </script>
    <style>
        .list-group-item {
            display: flex;
            align-items: center;
        }

        .media-body {
            display: flex;
            align-items: center;
        }

        .media-body h5 {
            margin: 0;
            margin-right: 5px;
            /* Ajusta el espacio entre "Correo :" y el valor */
        }

        .media-body p {
            margin: 0;
            margin-left: auto;
            /* Alinea el párrafo a la derecha */
        }
    </style>
</body>

</html>
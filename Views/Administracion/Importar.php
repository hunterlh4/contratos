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
        <div class="card-header mb-0 mt-3  d-flex justify-content-between align-items-center">
            <div class="col-md-12">
                <h2 class="card-title"><i class="fa fa-file-csv"></i> Importar</h2>
            </div>
        </div>
        
        <div class="card-body">
            <form form id="formulario" class="needs-validation" novalidate="" method="POST" autocomplete="off" enctype="multipart/form-data">
                <div class="col-md-12 mb-3 ">
                    <div class="custom-file">
                        <input type="hidden" id="nombreArchivoActual" name="nombreArchivoActual">
                        <input type="file" class="custom-file-input" id="archivo" name="archivo" accept=".csv,.xlsx" required>
                        <label class="custom-file-label" id="nombreArchivo" for="archivo">Seleccione un Archivo</label>
                    </div>
                </div>
                <div class="col-md-12 mb-2 mt-2 text-center"  id="loadingMessage"  style="display: none;" >
                <span class="text-danger font-weight-bolder ">*Este proceso puede tardar unos segundos*</span>
                </div>
                <div id="status"></div>

              

                <div class="col-md-12 mb-2 mt-2 text-center">
                <button type="submit" id="Importar" class="btn btn-secondary btn-block btn-lg"  >Cargar Datos </button>
                </div>
               
            </form>
            <!-- <div id="progress-container" style="display: none;">
                <div id="progress-bar" style="width: 0%; background: green; height: 20px;"></div>
            </div> -->
            <div class="progress mb-3" style="height: 25px;" id="progress-container" style="display: none;">
                <div class="progress-bar bg-info" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;">
                <span id="progress-text">0%</span>
                </div>
            </div>

            
        </div>
        <div class="card-body">
        <div class="col-md-12 mb-3">
            <div class="d-flex align-items-center">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="nav1-tab" data-toggle="tab" href="#nav1" role="tab" aria-controls="nav1" aria-selected="true">Asistencia</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="nav2-tab" data-toggle="tab" href="#nav2" role="tab" aria-controls="nav2" aria-selected="false">SAMU 1</a>
                    </li>
                    <!-- <li class="nav-item">
                        <a class="nav-link" id="nav3-tab" data-toggle="tab" href="#nav3" role="tab" aria-controls="nav3" aria-selected="false">SAMU 2</a>
                    </li> -->
                    <li class="nav-item">
                        <a class="nav-link" id="nav4-tab" data-toggle="tab" href="#nav4" role="tab" aria-controls="nav4" aria-selected="false">Frontera 1</a>
                    </li>
                    <!-- <li class="nav-item">
                        <a class="nav-link" id="nav5-tab" data-toggle="tab" href="#nav5" role="tab" aria-controls="nav5" aria-selected="false">Frontera 2</a>
                    </li> -->
                    <li class="nav-item">
                        <a class="nav-link" id="nav6-tab" data-toggle="tab" href="#nav6" role="tab" aria-controls="nav6" aria-selected="false">Trabajador</a>
                    </li>
                </ul>
                     
            </div>
            <div class="tab-content" id="myTabContent">
                      <div class="tab-pane fade show active" id="nav1" role="tabpanel" aria-labelledby="nav1-tab">
                        <div class="table-responsive">
                        <table class="table table-xl table-lg table-sm">
                            <thead>
                                <tr>
                                    <th scope="col">Fecha</th>
                                    <th scope="col">ID</th>
                                    <th scope="col">Nombre Usuario</th>
                                    <th scope="col">Departamento</th>
                                    <th scope="col">Entrada - Salida 1</th>
                                    <th scope="col">Entrada - Salida 2</th>
                                    <th scope="col">Entrada - Salida 3</th>
                                    <th scope="col">Entrada - Salida 4</th>
                                    <th scope="col">Entrada - Salida 5</th>
                                    <th scope="col">Entrada - Salida 6</th>
                                    <th scope="col">Entrada - Salida 7</th>
                                    <th scope="col">Entrada - Salida 8</th>
                                    <th scope="col">Descanso</th>
                                    <th scope="col">Tiempo Trabajado</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1/05/2024</td>
                                    <td>12345678</td>
                                    <td>John Doe jdoe</td>
                                    <td>DIRESA/NOMBRADO</td>
                                    <td>07:30</td>
                                    <td>07:31</td>
                                    <td>15:35</td>
                                    <td>00:00</td>
                                    <td>00:00</td>
                                    <td>00:00</td>
                                    <td>00:00</td>
                                    <td>00:00</td>
                                    <td>00:00</td>
                                    <td>00:00</td>
                                </tr>
                                <tr>
                                    <td>1/05/2024</td>
                                    <td>87654321</td>
                                    <td>Jane Smith jsmith</td>
                                    <td>DIRESA/NOMBRADO</td>
                                    <td>07:25</td>
                                    <td>07:26</td>
                                    <td>15:31</td>
                                    <td>00:00</td>
                                    <td>00:00</td>
                                    <td>00:00</td>
                                    <td>00:00</td>
                                    <td>00:00</td>
                                    <td>00:00</td>
                                    <td>00:00</td>
                                </tr>
                                <!-- Puedes agregar más filas según sea necesario -->
                            </tbody>
                        </table>
                        </div>
               
                        <!-- <div class="form-group">
                        <div class="selectgroup-pills">
                        <div class="scrollable">
                            <label class="selectgroup-item">Fecha</label>
                            <label class="selectgroup-item">ID</label>
                            <label class="selectgroup-item">Nombre</label>
                            <label class="selectgroup-item">Usuario</label>
                            <label class="selectgroup-item">Departamento</label>
                            <label class="selectgroup-item">Entrada - Salida 1</label>
                            <label class="selectgroup-item">Entrada - Salida 2</label>
                            <label class="selectgroup-item">Entrada - Salida 3</label>
                            <label class="selectgroup-item">Entrada - Salida 4</label>
                            <label class="selectgroup-item">Entrada - Salida 5</label>
                            <label class="selectgroup-item">Entrada - Salida 6</label>
                            <label class="selectgroup-item">Entrada - Salida 7</label>
                            <label class="selectgroup-item">Entrada - Salida 8</label>
                            <label class="selectgroup-item">Descanso</label>
                            <label class="selectgroup-item">Tiempo Trabajado</label>
                        </div>
                        </div>

                        </div> -->
                      </div>
                      <div class="tab-pane fade" id="nav2" role="tabpanel" aria-labelledby="nav2-tab">
                        <!-- <div class="form-group">
                        <div class="selectgroup-pills">
                        <div class="scrollable">
                            <label class="selectgroup-item">Dpto.</label>
                            <label class="selectgroup-item">Nombre</label>
                            <label class="selectgroup-item">No.</label>
                            <label class="selectgroup-item">Fecha/Hora</label>
                            <label class="selectgroup-item">Locación ID</label>
                            <label class="selectgroup-item">ID Número</label>
                            <label class="selectgroup-item">VerificaCod</label>
                            <label class="selectgroup-item">No.tarjeta</label>
                        </div>
                        </div>              
                        </div> -->
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th scope="col">Dpto.</th>
                                        <th scope="col">Nombre</th>
                                        <th scope="col">No.</th>
                                        <th scope="col">Fecha/Hora</th>
                                        <th scope="col">Locación ID</th>
                                        <th scope="col">ID Número</th>
                                        <th scope="col">VerificaCod</th>
                                        <th scope="col">No.tarjeta</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>SAMU2023</td>
                                        <td>John Doe</td>
                                        <td>12345678</td>
                                        <td>11-may-24 7:32:11 AM</td>
                                        <td>1</td>
                                        <td></td>
                                        <td>FP</td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>SAMU2023</td>
                                        <td>John Doe</td>
                                        <td>12345678</td>
                                        <td>11-may-24 7:31:16 PM</td>
                                        <td>1</td>
                                        <td></td>
                                        <td>FP</td>
                                        <td></td>
                                    </tr>
                                    
                                  
                                   
                                    <!-- Puedes agregar más filas según sea necesario -->
                                </tbody>
                            </table>
                        </div>
                      </div>
                      <div class="tab-pane fade" id="nav3" role="tabpanel" aria-labelledby="nav3-tab">
                        <!-- <div class="form-group">
                        <div class="selectgroup-pills">
                        <div class="scrollable">
                            <label class="selectgroup-item">AC No.</label>
                            <label class="selectgroup-item">Nombre</label>
                            <label class="selectgroup-item">Dpto.</label>
                            <label class="selectgroup-item">Fecha</label>
                            <label class="selectgroup-item">Hora</label>
                        </div>
                        </div>
                        </div> -->
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th scope="col">AC No.</th>
                                        <th scope="col">Nombre</th>
                                        <th scope="col">Dpto.</th>
                                        <th scope="col">Fecha</th>
                                        <th scope="col">Hora</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>12345678</td>
                                        <td>John Doe</td>
                                        <td>SAMU2023</td>
                                        <td>01-may-24</td>
                                        <td>08:00</td>
                                    </tr>
                                    <tr>
                                        <td>12345678</td>
                                        <td>Jane Smith</td>
                                        <td>SAMU2023</td>
                                        <td>01-may-24</td>
                                        <td>07:35 07:35 07:35 19:48</td>
                                    </tr>
                                    <!-- Puedes agregar más filas según sea necesario -->
                                </tbody>
                            </table>
                        </div>
                      </div>
                      <div class="tab-pane fade" id="nav4" role="tabpanel" aria-labelledby="nav4-tab">
                        <!-- <div class="form-group">
                        <div class="selectgroup-pills">
                        <div class="scrollable">
                            <label class="selectgroup-item">Dpto.</label>
                            <label class="selectgroup-item">Nombre</label>
                            <label class="selectgroup-item">No.</label>
                            <label class="selectgroup-item">Fecha/Hora</label>
                            <label class="selectgroup-item">Locación ID</label>
                            <label class="selectgroup-item">ID Número</label>
                            <label class="selectgroup-item">VerificaCod</label>
                            <label class="selectgroup-item">No.tarjeta</label>
                        </div>
                        </div>              
                        </div> -->
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th scope="col">Dpto.</th>
                                        <th scope="col">Nombre</th>
                                        <th scope="col">No.</th>
                                        <th scope="col">Fecha/Hora</th>
                                        <th scope="col">Locación ID</th>
                                        <th scope="col">ID Número</th>
                                        <th scope="col">VerificaCod</th>
                                        <th scope="col">No.tarjeta</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>FRONTERA</td>
                                        <td>Jane Smith</td>
                                        <td>87654321</td>
                                        <td>6/05/2024 08:16:34</td>
                                        <td>1</td>
                                        <td></td>
                                        <td>FP</td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>FRONTERA</td>
                                        <td>Jane Smith</td>
                                        <td>87654321</td>
                                        <td>6/05/2024 17:30:10</td>
                                        <td>1</td>
                                        <td></td>
                                        <td>FP</td>
                                        <td></td>
                                    </tr>
                                    <!-- Puedes agregar más filas según sea necesario -->
                                </tbody>
                            </table>
                        </div>
                      </div>
                      <div class="tab-pane fade" id="nav5" role="tabpanel" aria-labelledby="nav5-tab">
                        <!-- <div class="form-group">
                        <div class="selectgroup-pills">
                        <div class="scrollable">
                            <label class="selectgroup-item">AC No.</label>
                            <label class="selectgroup-item">Nombre</label>
                            <label class="selectgroup-item">Dpto.</label>
                            <label class="selectgroup-item">Fecha</label>
                            <label class="selectgroup-item">Hora</label>
                        </div>
                        </div>
                        </div> -->
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th scope="col">AC No.</th>
                                        <th scope="col">Nombre</th>
                                        <th scope="col">Dpto.</th>
                                        <th scope="col">Fecha</th>
                                        <th scope="col">Hora</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>001</td>
                                        <td>John Doe</td>
                                        <td>IT</td>
                                        <td>2024-07-01</td>
                                        <td>08:00</td>
                                    </tr>
                                    <tr>
                                        <td>002</td>
                                        <td>Jane Smith</td>
                                        <td>HR</td>
                                        <td>2024-07-02</td>
                                        <td>09:00</td>
                                    </tr>
                                    <!-- Puedes agregar más filas según sea necesario -->
                                </tbody>
                            </table>
                        </div>
                      </div>
                      <div class="tab-pane fade" id="nav6" role="tabpanel" aria-labelledby="nav6-tab">
                        <!-- <div class="form-group">
                        <div class="selectgroup-pills">
                        <div class="scrollable">
                            <label class="selectgroup-item">ID Usuario</label>
                            <label class="selectgroup-item">Nombre</label>
                            <label class="selectgroup-item">Departamento</label>
                            <label class="selectgroup-item">Correo</label>
                            <label class="selectgroup-item">Teléfono</label>
                            <label class="selectgroup-item">Fecha Inicio</label>
                            <label class="selectgroup-item">Fecha Vencimiento</label>
                            <label class="selectgroup-item">Nivel Admin</label>
                            <label class="selectgroup-item">Modo Autenticación</label>
                            <label class="selectgroup-item">Número de Template</label>
                            <label class="selectgroup-item">Grupo de Acceso1</label>
                            <label class="selectgroup-item">Grupo de Acceso2</label>
                            <label class="selectgroup-item">Grupo de Acceso3</label>
                            <label class="selectgroup-item">Grupo de Acceso4</label>
                            <label class="selectgroup-item">Número Tarjeta</label>
                            <label class="selectgroup-item">Bypass</label>
                            <label class="selectgroup-item">Title</label>
                            <label class="selectgroup-item">Mobile</label>
                            <label class="selectgroup-item">Gender</label>
                            <label class="selectgroup-item">Date of Birth</label>
                            </div>
                        </div>
                        
                        </div> -->
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th scope="col">ID Usuario</th>
                                        <th scope="col">Nombre</th>
                                        <th scope="col">Departamento</th>
                                        <th scope="col">Correo</th>
                                        <th scope="col">Teléfono</th>
                                        <th scope="col">Fecha Inicio</th>
                                        <th scope="col">Fecha Vencimiento</th>
                                        <th scope="col">Nivel Admin</th>
                                        <th scope="col">Modo Autenticación</th>
                                        <th scope="col">Número de Template</th>
                                        <th scope="col">Grupo de Acceso1</th>
                                        <th scope="col">Grupo de Acceso2</th>
                                        <th scope="col">Grupo de Acceso3</th>
                                        <th scope="col">Grupo de Acceso4</th>
                                        <th scope="col">Número Tarjeta</th>
                                        <th scope="col">Bypass</th>
                                        <th scope="col">Title</th>
                                        <th scope="col">Mobile</th>
                                        <th scope="col">Gender</th>
                                        <th scope="col">Date of Birth</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>12345678</td>
                                        <td>John Doe</td>
                                        <td>DIRESA/NOMBRADO</td>
                                        <td></td>
                                        <td></td>
                                        <td>2010-01-01 00:00:00</td>
                                        <td>2030-09-01 01:00:00</td>
                                        <td>Usuario Normal</td>
                                        <td>Dispositivo Predeterminado</td>
                                        <td>3</td>
                                        <td>Acceso Total</td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td>5000000-99</td>
                                        <td>Y</td>
                                        <td>Guest</td>
                                        <td></td>
                                        <td>Male</td>
                                        <td>26/03/2024</td>
                                    </tr>
                                    <tr>
                                        <td>87654321</td>
                                        <td>Jane Smith</td>
                                        <td>DIRESA/NOMBRADO</td>
                                        <td></td>
                                        <td></td>
                                        <td>2010-01-01 00:00:00</td>
                                        <td>2030-09-01 01:00:00</td>
                                        <td>Usuario Normal</td>
                                        <td>Dispositivo Predeterminado</td>
                                        <td>3</td>
                                        <td>Acceso Total</td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td>5000000-99</td>
                                        <td>Y</td>
                                        <td>Guest</td>
                                        <td></td>
                                        <td>Female</td>
                                        <td>26/03/2024</td>
                                    </tr>
                                    <!-- Puedes agregar más filas según sea necesario -->
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
</div>
</section>
</div>
            

        
        <?php include './Views/includes/footer.php'; ?>
    </div>
    </div>

  
</div>

<style>
.tab-pane {
    overflow-x: auto; /* Aplica scroll horizontal solo dentro del tab-pane */
    white-space: nowrap; /* Evita saltos de línea */
    max-width: 100%; /* Ajusta el ancho máximo para evitar desbordamientos */
}

.selectgroup-pills {
    display: inline-block; /* Asegura que los elementos se alineen en línea */
    vertical-align: top; /* Alinea los elementos al principio del contenedor */
}

.scrollable {
    padding-bottom: 10px; /* Espacio inferior para evitar solapamientos */
}

</style>

    <!--MODAL - NUEVO USARIO-->

    <!-- MODAL FIN -->
    <?php include './Views/includes/script_new.php' ?>

    </html>
    <script src="<?php echo BASE_URL; ?>assets/js/modulos/importar.js"></script>
  

    <script>
        const base_url = '<?php echo BASE_URL; ?>';
    </script>
</body>

</html>
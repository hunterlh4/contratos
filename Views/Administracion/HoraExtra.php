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
<h3 class="font-weight-bolder"><i data-feather="clock" class="mb-1 ml-1"></i> Horas Extra</h3>
<div class="d-flex align-items-center pl-3 mb-1 col-md-8">
                    <select class="form-control select2" id="trabajador" required>
                      <option value="" selected>Selecciona un trabajador</option>

                    </select>
                    </div>
                    <h5 id="total_duracion">Tiempo: 00:00 </h5>
</div>
<div class="card-body">
<div id="Calendario">
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

    <div id="eventContextMenu" class="context-menu" style="display:none; position:absolute; z-index:1000;">
        <ul class="list-group">
            <li class="list-group-item"><button type="button" class="btn btn-icon icon-left btn-info btn-sm" id="editEvent"><i class="far fa-edit"></i>Editar</button></li>
            <li class="list-group-item"><button type="button" class="btn btn-icon icon-left btn-danger btn-sm" id="deleteEvent"><i class="far fa-trash-alt"></i>Eliminar</button></li>
        </ul>
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
                        <!-- fecha -->
                        <div class="form-group">
                            <label>Fecha Desde</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <i class="fas fa-address-card"></i>
                                    </div>
                                </div>
                                <input type="Date" class="form-control" placeholder="MM/DD/YYYY" name="fecha_inicio" id="fecha_inicio" required>
                            </div>
                        </div>
                        <!-- desde -->
                        <div class="form-group">
                            <label>Hora Desde</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <i class="fas fa-address-card"></i>
                                    </div>
                                </div>
                                <input type="Time" class="form-control"  name="hora_desde" id="hora_desde" required>
                            </div>
                        </div>
                        <!-- hasta -->
                        <div class="form-group">
                            <label>Hora Hasta</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <i class="fas fa-address-card"></i>
                                    </div>
                                </div>
                                <input type="Time" class="form-control"  name="hora_hasta" id="hora_hasta" required>
                            </div>
                        </div>
                        <!-- tipo -->
                        <div class="form-group">
                            <label>Tipo de Hora</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <i class="fas fa-address-card"></i>
                                    </div>
                                </div>
                                <select class="form-control" id="tipo" name="tipo" required>
                                    <option value="">Seleccione una opcion</option>
                                    <option value="aumentar">Incrementar Horas Extra Realizadas</option>
                                    <option value="restar">Usar Horas Extra</option>
                                </select>
                            </div>
                        </div>
                        <!--Estado  -->
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

    <div id="borrar" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="my-modal-delete-title">Eliminar Evento</h5>
                    <button type="button" class="close" onclick=cerrarModalBorrar() data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    ¿Estás seguro de que deseas eliminar este evento?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" onclick=cerrarModalBorrar()>Cancelar</button>
                    <button type="button" class="btn btn-danger" id="deleteEventBtn">Eliminar</button>
                </div>
            </div>
        </div>
    </div>


    <!--MODAL - NUEVO USARIO-->

    <!-- MODAL FIN -->
    <?php include './Views/includes/script_new.php' ?>

    </html>
    
    <script src="<?php echo BASE_URL; ?>assets/js/modulos/horaExtra.js"></script>
    <!-- <script src="<?php echo BASE_URL; ?>assets/js/calendario2.js"></script> -->

    <script>
        const base_url = '<?php echo BASE_URL; ?>';
    </script>

    <style>
       

  #calendario {
    max-width: 1100px;
    margin: 0 auto;
  }

  .fc-center {
            font-size: 2em;
            /* Tamaño de fuente h2 */
            margin-top: 4px;
            font-weight: 0;
            line-height: 1.2;

            /* h1: 2em
h2: 1.5em
h3: 1.17em
h4: 1em
h5: 0.83em */
        }

       


        .fc-day-grid-event {
            font-weight: normal;
            font-style: normal;
            font-size: 1.0em;
            font-family: "Nunito", "Segoe UI", arial;
            /* color: #6c757d; */
            /* color: #414141; */
            /* display: block; */
            /* white-space: nowrap; */
        }

        .fc-event-container .fc-content span.fc-title {
            display: block;
            /* Cambiar a bloque para permitir múltiples líneas */
            width: 100%;
            /* Establecer el ancho al 100% para que se expanda horizontalmente */
            white-space: normal;
            /* Permitir que el texto se divida en múltiples líneas */
            word-wrap: break-word;
            /* Permitir que las palabras largas se dividan en varias líneas */
        }

        .close-button {
    font-size: 18px; /* Tamaño del botón de cierre */
   
    cursor: pointer; /* Cambia el cursor al pasar sobre el botón */
    color: #fff; /* Color del texto */
  
}

.fc-content {
    display: flex;
    justify-content: space-between;
    align-items: center;
    /* width: 100%; */
}



.buttons-column {
    display: flex;
    flex-direction: column;
    margin-left: auto;
}

.buttons-column button {
    border: none;
    background: none;
    margin: 0;
    padding: 0;
}

.buttons-column button i {
    display: block;
    padding: 8px;
}

.fc-day-grid-event .fc-content {
    padding: 0;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.fc-title {
    flex-grow: 1;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.context-menu {
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.15);
    padding: 0;
    margin: 0;
    width: auto;
    background-color: transparent; /* Fondo transparente */
}

.context-menu ul {
    margin: 0;
    padding: 0;
    list-style: none;
}

.context-menu ul li {
    padding: 0;
    margin: 0;
    display: flex;
    justify-content: flex-start;
    width: 100%;
}

.context-menu ul li button {
    width: 100%;
    text-align: left;
    border: none;
    padding: 8px 12px;
    cursor: pointer;
    
    outline: none;
    border-radius: 0;
}

.context-menu ul li button:hover {
    background-color: #f0f0f0; /* Color de fondo al pasar el ratón por encima */
}
.list-group-item {
    border: none;
    border-radius: 0%;
}

.oculto{
    display: none;
}
    </style>
</body>

</html>
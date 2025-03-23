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
<h3 class="font-weight-bolder"><i class="fa fa-laptop"></i> Reporte</h3>
<button class="btn btn-lg btn-outline-primary rounded-0 " onclick=generar() type="button" id="btngenerar">Generar Informe</button>

</div>
<!-- <hr> -->
<div class="card-body">
<form form id="formulario" class="needs-validation" novalidate="" method="POST" autocomplete="off">
<div class="row ">

    



   
    <!-- <div class="col-md-4 div_fecha_desde">
        <div class="form-group">
            <label>Desde</label>
            <input type="date" class="form-control" id="fecha_desde">
        </div>
    </div>
    <div class="col-md-4 div_fecha_hasta">
        <div class="form-group">
            <label>Hasta</label>
            <input type="date" class="form-control" id="fecha_hasta">
        </div>
    </div> -->

    <!-- <div class="col-md-2">
            <div class="form-group">
                <label for="Tipo">Tipo</label>
                <div class="input-group">
                <select class="form-control"  id="tipo" name="tipo" required>
                <option value="detallado">Trabajador</option>
                <option value="general">General</option>
                <option value="tardanza">Tardanza</option>
                    
                </select>
                </div>
            </div>

    </div> -->
    <div class="col-md-10" id ="contenedor_trabajadores">
        <div class="form-group">
            <label for="direccion">Trabajadores</label>
            <div class="input-group">
              
                <select class="form-control select2"  multiple="" id="trabajador" name="trabajador" required>
                </select>
            </div>
        </div>
    
    </div>
    <div class="col-md-2 div_anio">
            <div class="form-group">
                <label for="direccion">Año</label>
                <div class="input-group">
                <select class="form-control"  id="anio" name="anio" required>
                </select>
                </div>
            </div>

    </div>

    <!-- <div class="col-md-12"> -->

    
    <!-- </div> -->

</div>
</form>   
    
</div>


</div>

<div class="card">
<div class="card-header d-flex justify-content-between align-items-center mb-0 mt-3 pb-0">
<h5 class="font-weight-bolder"><i class="fa fa-print"></i> Tipo de Reporte</h5>
</div>
<!-- <hr> -->
<div class="card-body">

<div class="row ">

    <div class="col-md-12">
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
<?php include './Views/includes/script_new.php' ?>
</html>
<script src="<?php echo BASE_URL; ?>assets/js/modulos/reporte_kardex.js"></script>
<script>
const base_url = '<?php echo BASE_URL; ?>';
</script>
<!-- <script src="https://cdn.plyr.io/3.7.8/plyr.js"></script> -->
<style>

</style>
</body>
</html>
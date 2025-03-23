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
</div>
<div class="row ">
    <div class="col-md-6 align-center">
        <div class="card-body">
            
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
<script src="<?php echo BASE_URL; ?>assets/js/modulos/reporte.js"></script>
<script>
const base_url = '<?php echo BASE_URL; ?>';
</script>
</body>
</html>
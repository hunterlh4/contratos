<!DOCTYPE html>
<html lang="es">

<head>
<!-- <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" /> -->
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>
    <?php echo $data['title']; ?>
  </title>



<link rel="icon" type="png" href="<?php echo BASE_URL; ?>assets/img/icono_diresa.png">
<!-- General CSS Files -->
<link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/app.min.css">
<link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/bundles/datatables/datatables.min.css">
<link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/bundles/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css">
<!-- <link rel="stylesheet" href="https://cdn.datatables.net/rowgroup/1.2.0/css/rowGroup.dataTables.min.css"> -->
<!-- <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/datatables.min.css"> -->

<!-- General CSS Files FORMULARIOS-->
<link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/bundles/bootstrap-daterangepicker/daterangepicker.css">
<!-- <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/bundles/bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css"> -->
<link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/bundles/select2/dist/css/select2.min.css">
<link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/bundles/jquery-selectric/selectric.css">
<link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/bundles/bootstrap-tagsinput/dist/bootstrap-tagsinput.css">
<link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/bundles/bootstrap-timepicker/css/bootstrap-timepicker.min.css">

<link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/bundles/pretty-checkbox/pretty-checkbox.min.css">
<!-- icon -->
<link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/bundles/bootstrap-social/bootstrap-social.css">

<!-- CSS  FullCalendar -->

<link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/bundles/fullcalendar/fullcalendar.min.css">
<!-- <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/bundles/fullcalendar/main.css"> -->

<!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css" integrity="sha512-mSYUmp1HYZDFaVKK//63EcZq4iFWFjxSL+Z3T/aCt4IO9Cejm03q3NKKYN6pFQzY0SBOr8h+eCIAZHPXcpZaNw==" crossorigin="anonymous" referrerpolicy="no-referrer" /> -->
<link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/datapicker calendar.min.css"  crossorigin="anonymous" referrerpolicy="no-referrer" />

<!-- excel -->
<script src="<?php echo BASE_URL; ?>assets/js/csv.min.js"></script>
<script src="<?php echo BASE_URL; ?>assets/js/xlsx.full.min.js"></script>
<!-- CSS  TableExport -->
<link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/bundles/tableexport/tableexport.css">

<!-- CSS  ALERTY -->
<!-- <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/alertify.min.css"/> -->
<!-- Default theme -->
<!-- <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/default.min.css"/> -->
<!-- Semantic UI theme -->
<!-- <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/semantic.min.css"/> -->
<!-- Bootstrap theme -->
<!-- <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/bootstrap.min.css"/> -->

<!-- <link rel="stylesheet" type="text/css" href="<?php echo BASE_URL; ?>assets/plantilla/chosen.css"> -->
<link rel="stylesheet" type="text/css" href="<?php echo BASE_URL; ?>assets/css/jquery.fancybox.css">
<!-- Mobiscroll -->
<link href="<?php echo BASE_URL; ?>assets/bundles/mobiscroll/css/mobiscroll.jquery.min.css" rel="stylesheet" />

<!-- Template CSS -->
<link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/style.css">
<link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/components.css">
<!-- Custom style CSS -->
<link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/custom.css">


<style>
    .disabled {
        pointer-events: none;
        background-color: #e9ecef;
        opacity: 1;
    }
    
    .rayar{
        max-width: max-content;
        padding: 5px;
    }
    .rayar:hover { 
        /*max-width: max-content;*/
        color: #5864bd;
        padding: 2px;
        border-bottom: 2px solid #5864bd;
        
        transition-property: all;
        transition-duration: 0.5s;
        transition-timing-function: linear;
    }
 
</style>


</head>
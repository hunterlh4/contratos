const frm = document.querySelector("#formulario");
const titleModal = document.querySelector("#titleModal");
const btnAprobar = document.querySelector("#btnAprobar");
const btnRechazar = document.querySelector("#btnRechazar");
const myModal = new bootstrap.Modal(document.getElementById("nuevoModal"));
var flag = true;
let accion = "";
let boton = 1;

// INPUTS

const idElement = document.querySelector("#id");
const solicitanteElement = document.querySelector("#solicitante");
let tipo_boleta = document.querySelector("#tipo");
let fechaInicioElement = document.querySelector("#fecha_inicio");
let fechaFinElement = document.querySelector("#fecha_fin");
const horaSalidaElement = document.querySelector("#hora_salida");
const horaEntradaElement = document.querySelector("#hora_entrada");
const razonElement = document.querySelector("#razon");
const otra_razonElement = document.querySelector("#otra_razon");
const observacionElement = document.querySelector("#observacion");
//
const tbl_boleta_dias = document.getElementById("table-dias-alex");
var tabla_dias, tabla_horas;
const tbl_boleta_horas = document.getElementById("table-horas-alex");
const aprobado = document.querySelector("#Aprobado");
const rechazado = document.querySelector("#Rechazado");
const anulado = document.querySelector("#Anulado");

let mytable; // = document.querySelector("#table-1");
let tblUsuario;
var data9;
var datos;

// Ajustar el tamaño del modal
// Establece el ancho máximo del modal

document.addEventListener("DOMContentLoaded", function () {
  // vertabla();
  llenarSelectSolicitante();

  llenartablaHoras();
  llenarTablaDias();
});
var cantidad = 0;
function revisar(accion) {
  if (flag) {
    flag = false;
    const envio = accion;
    const data = new FormData(frm);

    const url = base_url + "Boleta/revisar";
    data.append("accion", envio);

    $.ajax({
      url: url,
      method: "POST",
      data: data,
      processData: false,
      contentType: false,
      beforeSend: function () {
        // console.log('Enviando solicitud...');
      },
      success: function (response) {
        // console.log(response);
        const res = JSON.parse(response);
        if (res.icono == "success") {
          boton == 1 ? tabla_horas.ajax.reload() : tabla_dias.ajax.reload();
          frm.reset(); // Limpia el formulario
          cerrarModal(); // Oculta el modal y el fondo oscuro
        }
        Swal.fire("Aviso", res.msg.toUpperCase(), res.icono);
        flag = true; // Marcar que la acción ha terminado
      },
      error: function (xhr, status, error) {
        console.error("Error en la solicitud:", error);
        flag = true; // Marcar que la acción ha terminado incluso si hay un error
      },
    });
  }
}

function llenartablaHoras() {
  tipo = "1";
  tabla_horas = $("#table-horas-alex").DataTable({
    ajax: {
      url: base_url + "Boleta/listarRevisionBoletas",
      type: "POST", // Especifica el método HTTP como POST
      dataSrc: "",
      data: function (data) {
        // Agrega los parámetros que deseas enviar
        data.parametro = "1";

        // Agrega más parámetros si es necesario
        return data;
      },
    },
    columns: [
      // Define tus columnas aquí según la estructura de tus datos
      { data: "posicion" },

      { data: "numero" },
      { data: "nombre_trabajador" },
      { data: "razon"},
      { data: "fecha_nueva" },
      // { data: "fecha_fin_formateada" },
      { data: "hora_salida" },
      { data: "hora_entrada" },
      { data: "estado_tramite" },
      // { data: "estado" },
      { data: "accion" },
    ],
    dom: "Bfrtip",
    columnDefs: [
      //   { width: "15px", targets: 0 }, // Ancho de la primera columna
      //   { width: "30px", targets: 1 }, // Ancho de la segunda columna
      //   { width: "250px", targets: 2 }, // Ancho de la segunda columna
      // Agrega más columnDefs según sea necesario
    ],
    language: 
    {
      "sProcessing": "Procesando...",
      "sLengthMenu": "Mostrar _MENU_ registros",
      "sZeroRecords": "No se encontraron resultados",
      "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
      "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
      "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
      "sInfoPostFix": "",
      "sSearch": "Buscar:",
      "sUrl": "",
      "sInfoThousands": ",",
      "sLoadingRecords": "Cargando...",
      "oPaginate": {
        "sFirst": "Primero",
        "sLast": "Último",
        "sNext": "Siguiente",
        "sPrevious": "Anterior"
      },
      "buttons": {
        "copy": "Copiar",
        "colvis": "Visibilidad",
        "collection": "Colección",
        "colvisRestore": "Restaurar visibilidad",
        "copyKeys": "Presione ctrl o u2318 + C para copiar los datos de la tabla al portapapeles del sistema. <br \/> <br \/> Para cancelar, haga clic en este mensaje o presione escape.",
        "copySuccess": {
            "1": "Copiada 1 fila al portapapeles",
            "_": "Copiadas %ds fila al portapapeles"
        },
        "copyTitle": "Copiar al portapapeles",
        "csv": "CSV",
        "excel": "Excel",
        "pageLength": {
            "-1": "Mostrar todas las filas",
            "_": "Mostrar %d filas"
        },
        "pdf": "PDF",
        "print": "Imprimir",
        "renameState": "Cambiar nombre",
        "updateState": "Actualizar",
        "createState": "Crear Estado",
        "removeAllStates": "Remover Estados",
        "removeState": "Remover",
        "savedStates": "Estados Guardados",
        "stateRestore": "Estado %d"
    },
      "oAria": {
        "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
        "sSortDescending": ": Activar para ordenar la columna de manera descendente"
      }
    },

    buttons: [
      {
        extend: "copy",
        exportOptions: {
          columns: [0, 1, 2, 3, 4, 5, 6], // Especifica las columnas que deseas copiar
        },
      },
      {
        extend: "csv",
        exportOptions: {
          columns: [0, 1, 2, 3, 4, 5, 6], // Especifica las columnas que deseas exportar a CSV
        },
      },
      {
        extend: "excel",
        exportOptions: {
          columns: [0, 1, 2, 3, 4, 5, 6], // Especifica las columnas que deseas exportar a Excel
        },
      },
      {
        extend: "pdf",
        exportOptions: {
          columns: [0, 1, 2, 3, 4, 5, 6], // Especifica las columnas que deseas exportar a PDF
        },
      },
      {
        extend: "print",
        exportOptions: {
          columns: [0, 1, 2, 3, 4, 5, 6], // Especifica las columnas que deseas imprimir
        },
      },
    ],
  });
}

function llenarTablaDias() {
  // dias 2
  tipo = "2";

  tabla_dias = $("#table-dias-alex").DataTable({
    ajax: {
      url: base_url + "Boleta/listarRevisionBoletas",
      type: "POST", // Especifica el método HTTP como POST
      dataSrc: "",
      data: function (data) {
        // Agrega los parámetros que deseas enviar
        data.parametro = "2";

        // Agrega más parámetros si es necesario
        return data;
      },
    },

    columns: [
      // Define tus columnas aquí según la estructura de tus datos
      { data: "posicion" },

      { data: "numero" },
      { data: "nombre_trabajador" },
      { data: "razon"},
      { data: "fecha_inicio_formateada" },
      { data: "fecha_fin_formateada" },
      // { data: "hora_salida" },
      // { data: "hora_entrada" },
      { data: "estado_tramite" },
      // { data: "estado" },
      { data: "accion" },
    ],
    // columnDefs: [
    //     { width: "15px", targets: 0 }, // Ancho de la primera columna
    //     { width: "30px", targets: 1 }, // Ancho de la segunda columna
    //     { width: "250px", targets: 2 }, // Ancho de la segunda columna
    //   // Agrega más columnDefs según sea necesario
    // ],
    dom: "Bfrtip",
    language: 
    {
      "sProcessing": "Procesando...",
      "sLengthMenu": "Mostrar _MENU_ registros",
      "sZeroRecords": "No se encontraron resultados",
      "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
      "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
      "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
      "sInfoPostFix": "",
      "sSearch": "Buscar:",
      "sUrl": "",
      "sInfoThousands": ",",
      "sLoadingRecords": "Cargando...",
      "oPaginate": {
        "sFirst": "Primero",
        "sLast": "Último",
        "sNext": "Siguiente",
        "sPrevious": "Anterior"
      },
      "buttons": {
        "copy": "Copiar",
        "colvis": "Visibilidad",
        "collection": "Colección",
        "colvisRestore": "Restaurar visibilidad",
        "copyKeys": "Presione ctrl o u2318 + C para copiar los datos de la tabla al portapapeles del sistema. <br \/> <br \/> Para cancelar, haga clic en este mensaje o presione escape.",
        "copySuccess": {
            "1": "Copiada 1 fila al portapapeles",
            "_": "Copiadas %ds fila al portapapeles"
        },
        "copyTitle": "Copiar al portapapeles",
        "csv": "CSV",
        "excel": "Excel",
        "pageLength": {
            "-1": "Mostrar todas las filas",
            "_": "Mostrar %d filas"
        },
        "pdf": "PDF",
        "print": "Imprimir",
        "renameState": "Cambiar nombre",
        "updateState": "Actualizar",
        "createState": "Crear Estado",
        "removeAllStates": "Remover Estados",
        "removeState": "Remover",
        "savedStates": "Estados Guardados",
        "stateRestore": "Estado %d"
    },
      "oAria": {
        "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
        "sSortDescending": ": Activar para ordenar la columna de manera descendente"
      }
    },

    buttons: [
      {
        extend: "copy",
        exportOptions: {
          columns: [0, 1, 2, 3, 4, 5, 6], // Especifica las columnas que deseas copiar
        },
      },
      {
        extend: "csv",
        exportOptions: {
          columns: [0, 1, 2, 3, 4, 5, 6], // Especifica las columnas que deseas exportar a CSV
        },
      },
      {
        extend: "excel",
        exportOptions: {
          columns: [0, 1, 2, 3, 4, 5, 6], // Especifica las columnas que deseas exportar a Excel
        },
      },
      {
        extend: "pdf",
        exportOptions: {
          columns: [0, 1, 2, 3, 4, 5, 6], // Especifica las columnas que deseas exportar a PDF
        },
      },
      {
        extend: "print",
        exportOptions: {
          columns: [0, 1, 2, 3, 4, 5, 6], // Especifica las columnas que deseas imprimir
        },
      },
    ],
  });

  // Puedes agregar más opciones de configuración de DataTables según sea necesario
}
$('a[data-toggle="tab"]').on("shown.bs.tab", function (e) {
  var target = $(e.target).attr("href"); // Get the target pane ID

  if (target === "#hora") {
    boton = 1; // Set value to 1 for Hora
  } else if (target === "#dia") {
    boton = 2; // Set value to 2 for Día
    var thElements = document.querySelectorAll("#table-dias-alex th");

    // Define los anchos personalizados para cada <th>
    var customWidths = [
      "15px",
      "30px",
      "250px",
      "50px",
      "50px",
      "50px",
      "50px",
    ];

    // Asigna los anchos personalizados a cada <th>
    for (var i = 0; i < thElements.length; i++) {
      thElements[i].style.width = customWidths[i];
    }
  }
});

function view(id) {
  flag = true;

  $.ajax({
    url: base_url + "Boleta/edit/" + id,
    type: "GET",

    success: function (response) {
      frm.reset();
      resetRequiredFields();
      cambiarPage(boton);

      const res = JSON.parse(response);
      console.log(res.estado_tramite);
      idElement.value = res.id;
      solicitanteElement.value = res.trabajador_id;

      fechaInicioElement.value = res.fecha_inicio;
      fechaFinElement.value = res.fecha_fin;
      horaSalidaElement.value = res.hora_salida;
      horaEntradaElement.value = res.hora_entrada;
      observacionElement.value = res.observaciones;
      razonElement.value = res.razon;
      otra_razonElement.value = res.razon_especifica;
      cambiarEstadoInputs();
      titleModal.textContent = "Vizualizar";

      if (res.estado_tramite == "Anulado") {
        aprobado.style.display = "none";
        rechazado.style.display = "none";
        anulado.style.display = "none";
      }
      if (
        res.estado_tramite == "Aprobado" ||
        res.estado_tramite == "Rechazado"
      ) {
        aprobado.style.display = "none";
        rechazado.style.display = "none";
        anulado.style.display = "block";
      }
      if (res.estado_tramite == "Pendiente") {
        aprobado.style.display = "block";
        rechazado.style.display = "block";
        anulado.style.display = "none";
      }

      myModal.show();
    },
    error: function (xhr, status, error) {
      console.error(error);
    },
  });
}

function cambiarPage(boton) {
  const fechas = document.querySelectorAll(".fechas");
  const horas = document.querySelectorAll(".horas");

  var todayDate = new Date().toISOString().slice(0, 10);
  fechaInicioElement.value = todayDate;
  fechaFinElement.value = todayDate;

  // 1 horas
  if (boton == 1) {
    tipo_boleta.value = boton;

    fechas.forEach((element) => {
      element.style.display = "none";
    });
    horas.forEach((element) => {
      element.style.display = "block";
    });
    razon.innerHTML = "";

    const opcionInicial = document.createElement("option");
    opcionInicial.value = "";
    opcionInicial.textContent = "Seleccione una Razon";
    razon.appendChild(opcionInicial);
    const razones = [
      { descripcion: "Comisión de Servicio", abreviacion: "CS" },
      { descripcion: "Devolucion de Horas", abreviacion: "DHE" },
      { descripcion: "Asuntos Particulares", abreviacion: "AP" },
      // { descripcion: "Licencia por Enfermedad", abreviacion: "ENF" },
      { descripcion: "ESSALUD", abreviacion: "ESS" },
      { descripcion: "Capacitacion", abreviacion: "CAP" },
      {
        descripcion: "Licencia por Maternidad/Paternidad",
        abreviacion: "LM/LP",
      },
      { descripcion: "Casos Especiales", abreviacion: "C.ESP" },
      { descripcion: "Otro", abreviacion: "OTR" },
    ];

    razones.forEach((razon_t) => {
      const opcion = document.createElement("option");
      opcion.value = razon_t.abreviacion;
      opcion.textContent = razon_t.descripcion;
      razon.appendChild(opcion);
    });
  }
  // 2 dias
  if (boton == 2) {
    tipo_boleta.value = boton;

    fechas.forEach((element) => {
      element.style.display = "block";
    });
    horas.forEach((element) => {
      element.style.display = "none";
    });
    razon.innerHTML = "";
    const opcionInicial = document.createElement("option");
    opcionInicial.value = "";
    opcionInicial.textContent = "Seleccione una Razon";
    razon.appendChild(opcionInicial);
    const razones = [
      { descripcion: "Asuntos Particulares", abreviacion: "AP" },
      { descripcion: "Comision de Servicios", abreviacion: "CS" },

      { descripcion: "Dev. Horas Extra", abreviacion: "DHE" },
      { descripcion: "Onomastico", abreviacion: "O" },
      { descripcion: "Capacitacion", abreviacion: "CAP" },
      { descripcion: "Duelo", abreviacion: "D" },
      {
        descripcion: "A cuenta de Vacaciones por Asuntos Personales",
        abreviacion: "AV",
      },
      { descripcion: "Vacaciones", abreviacion: "V" },
      { descripcion: "Lic. por Enfermedad", abreviacion: "LE" },
      { descripcion: "Lic. por Maternidad-Paternidad", abreviacion: "LM/LP" },
      { descripcion: "Lic Por Familiar Grave", abreviacion: "LIC. F.G." },
      { descripcion: "Lic. Gestacion", abreviacion: "LIC. GEST." },
      { descripcion: "Casos Especiales", abreviacion: "C.ESP" },
      { descripcion: "Otro", abreviacion: "OTR" },
    ];

    razones.forEach((razon_t) => {
      const opcion = document.createElement("option");
      opcion.value = razon_t.abreviacion;
      opcion.textContent = razon_t.descripcion;
      razon.appendChild(opcion);
    });
  }
}

function llenarSelectSolicitante() {
  $.ajax({
    url: base_url + "Api/listartrabajadores",
    type: "GET",

    success: function (response) {
      console.log(response);
      datos = JSON.parse(response);
      datos.forEach((opcion) => {
        // Crear un elemento de opción
        let option = document.createElement("option");
        // Establecer el valor y el texto de la opción

        if (opcion.estado === "Inactivo") {
          // Aplicar estilo al campo seleccionado
          option.style.color = "red"; // Cambiar a tu color deseado
        }

        option.value = opcion.id;

        if (opcion.dni == null) {
          option.text = opcion.apellido_nombre;
        } else {
          option.text = opcion.apellido_nombre + " - " + opcion.dni;
        }

        // Agregar la opción al select
        solicitante.appendChild(option);
      });
    },
    error: function (xhr, status, error) {
      console.error(error);
    },
  });
}

// reiniciar validaciones
function resetRequiredFields() {
  // Obtener todos los elementos de entrada requeridos
  $("#formulario").removeClass("was-validated");
}

// Llamar a la función cuando se abre el modal
function abrirModal() {
  myModal.show();
}

// Función para cerrar el modal
function cerrarModal() {
  myModal.hide();
}

function cambiarEstadoInputs() {
  idElement.disabled = false;
  solicitanteElement.disabled = true;

  fechaInicioElement.disabled = true;
  fechaFinElement.disabled = true;
  horaSalidaElement.disabled = true;
  horaEntradaElement.disabled = true;
  razonElement.disabled = true;
  otra_razonElement.disabled = true;
}

const nuevo = document.querySelector("#nuevo_registro");
const frm = document.querySelector("#formulario");
const titleModal = document.querySelector("#titleModal");
const btnAccion = document.querySelector("#btnAccion");
const myModal = new bootstrap.Modal(document.getElementById("nuevoModal"));
// NOMBRE DE MIS INPUTS
const inputId = document.querySelector("#id");
const inputRegimen = document.querySelector("#regimen");
const inputHiddenFile = document.querySelector("#nombreArchivoActual") ;
const labelFile = document.querySelector("#nombreArchivo");


let mytable; // = document.querySelector("#table-1");
let tblUsuario;
var data9;
var datos;

//  INPUTS


// Ajustar el tamaño del modal
// Establece el ancho máximo del modal

document.addEventListener("DOMContentLoaded", function () {
  llenarTabla();
  llenarselectDireccion();
  llenarselectRegimen();
  // llenarselectHorario();
  llenarselectCargo();



  //levantar modal
  nuevo.addEventListener("click", function () {
    frm.reset();
    resetRequiredFields();
    btnAccion.textContent = "Registrar";
    titleModal.textContent = "Nuevo Seguimiento";
    document.getElementById('archivo').setAttribute('required', 'required');
 

    inputId.value = "";
    inputHiddenFile.value = '';
    labelFile.innerHTML = 'Seleccione un Archivo';

    document.querySelectorAll("#estado-grupo").forEach((element) => {
      element.style.display = "none";
    });
    
    myModal.show();
  });

  //submit usuarios
  frm.addEventListener("submit", function (e) {
    e.preventDefault();

  
    let data = new FormData(this);
    const url = base_url + "Seguimiento/registrar";
    const http = new XMLHttpRequest();
    http.open("POST", url, true);
    http.send(data);
    http.onreadystatechange = function () {
      if (this.readyState == 4 && this.status == 200) {
        console.log(this.responseText);
        const res = JSON.parse(this.responseText);
        if (res.icono == "success") {
          tblUsuario.ajax.reload();
          frm.reset(); // Limpia el formulario
          cerrarModal(); // Oculta el modal y el fondo oscuro
        }
        Swal.fire("Aviso", res.msg.toUpperCase(), res.icono);
      }
    };
  });

 
});

function llenarTabla() {
  tblUsuario = $("#table-alex").DataTable({
    ajax: {
      url: base_url + "Seguimiento/listar",
      dataSrc: "",
    },
    columns: [
        { data: "id" },
        { data: "regimen" },
        { data: "direccion" },
        { data: "cargo" },
        { data: "documento_descarga" },
        { data: "sueldo" },
        { data: "fecha_inicio_2" },
        { data: "fecha_fin_2" },
        // { data: "estado" },
        { data: "accion" },
    ],
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
          columns: [0, 1, 2, 3, 4, 5, 6,7,8], // Especifica las columnas que deseas copiar
        },
      },
      {
        extend: "csv",
        exportOptions: {
          columns: [0, 1, 2, 3, 4, 5, 6,7,8], // Especifica las columnas que deseas exportar a CSV
        },
      },
      {
        extend: "excel",
        exportOptions: {
          columns: [0, 1, 2, 3, 4, 5, 6,7,8], // Especifica las columnas que deseas exportar a Excel
        },
      },
      {
        extend: "pdf",
        exportOptions: {
          columns: [0, 1, 2, 3, 4, 5, 6,7,8], // Especifica las columnas que deseas exportar a PDF
        },
      },
      {
        extend: "print",
        exportOptions: {
          columns: [0, 1, 2, 3, 4, 5, 6,7,8], // Especifica las columnas que deseas imprimir
        },
      },
    ],
  });
}

function actualizartabla() {
  mytable = $("#table-alex").DataTable();
  // var datosSeleccionados = tabla.rows('.selected').data();
  tabla.ajax.reload();
}

function edit(id) {
  const url = base_url + "Seguimiento/edit/" + id;
  const http = new XMLHttpRequest();
  http.open("GET", url, true);
  http.send();
  http.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      frm.reset();
      resetRequiredFields();
      // console.log(this.responseText);
      const res = JSON.parse(this.responseText);

      inputId.value = res.id;
      inputRegimen.value = res.regimen;
      document.querySelector("#direccion").value = res.direccion;
      document.querySelector("#cargo").value = res.cargo;
      labelFile.innerHTML = res.documento;
      inputHiddenFile.value = res.documento;
      document.getElementById('archivo').removeAttribute('required');
      document.querySelector("#sueldo").value = res.sueldo;
      document.querySelector("#fecha_inicio").value = res.fecha_inicio;
      document.querySelector("#fecha_fin").value = res.fecha_fin;
      
      if (res.estado == "Activo") {
        document.querySelector("#radio-true").checked = true;
        document.querySelector("#radio-false").checked = false;
      } else {
        document.querySelector("#radio-false").checked = true;
        document.querySelector("#radio-true").checked = false;
      }
      document.querySelectorAll("#estado-grupo").forEach((element) => {
        element.style.display = "block";
      });
      // document.querySelector('#password').setAttribute('readonly', 'readonly');
      btnAccion.textContent = "Actualizar";
      titleModal.textContent = "Actualizar Seguimiento";
      myModal.show();

      //$('#nuevoModal').modal('show');
    }
  };
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

function goBack() {
  window.location.href = base_url + "Trabajador";
  // console.log('hola');
}

document.getElementById("archivo").addEventListener("change", function(event) {
  // Obtener el nombre del nuevo archivo seleccionado por el usuario
  var nuevoNombreArchivo = event.target.files[0].name;

  // Actualizar el valor del campo oculto si el nombre del archivo ha cambiado
  if (inputHiddenFile !== nuevoNombreArchivo) {
    inputHiddenFile.value = nuevoNombreArchivo;
    labelFile.innerHTML = nuevoNombreArchivo;
  }
});

// telefono.addEventListener("input", (e) => {
//   let value = e.target.value.replace(/\D/g, ""); 
//   let formattedValue = "";


//   for (let i = 0; i < value.length; i++) {
//     if (i > 0 && i % 3 === 0) {
//       formattedValue += " ";
//     }
//     formattedValue += value[i];
//   }

//   e.target.value = formattedValue;
// });

// function consultar() {
//     var dniNumber = document.getElementById("dni").value;


//     if(dniNumber.length === 0){
//       Swal.fire("Aviso", 'campo vacio'.toUpperCase(), 'error');
//     }
//     if((dniNumber.length > 0) && (dniNumber.length < 8) ){
//       Swal.fire("Aviso", 'El DNI debe de tener 8 Digitos'.toUpperCase(), 'warning');
//     }
    

//     if(dniNumber.length === 8) {
//       const url = base_url + "Trabajador/obtenerDatosPorDNI/" + dniNumber;
//       const http = new XMLHttpRequest();
//       http.open("GET", url, true);
//       http.send();
//       http.onreadystatechange = function () {
//           if (this.readyState == 4 && this.status == 200) {
//               const res = JSON.parse(this.responseText);
//               console.log(this.responseText);

//               if(res.apellidoPaterno === undefined || res.apellidoPaterno.length < 1){
//                 Swal.fire("Aviso", 'no existe el numero de Dni'.toUpperCase(), 'error');
//               }else{
//                 document.querySelector("#nombre").value =res.apellidoPaterno +' '+res.apellidoMaterno+' '+ res.nombres;
//               }
//               res.apellidoPaterno +' '+res.apellidoMaterno+' '+ res.nombres;

//           } else {
//           console.log("Error al consultar y editar el DNI.");
//           }
//       };
//     }
  
// }

function verHistorial(id) {
  //  window.location.href =  base_url + 'HorarioDetalle?id=' + encodeURIComponent(id);
 
  const url = base_url + "Trabajador/verHistorial/" + id;
  const http = new XMLHttpRequest();

  http.open('GET', url, true);
  http.onload = function() {
      if (http.status >= 200 && http.status < 300) {
          console.log('Llamada al controlador realizada correctamente.');
          window.location.href = base_url + "Seguimiento";
      } else {
          console.error('Error al llamar al controlador:', http.statusText);
      }
  };

  http.onerror = function() {
      console.error('Error de red al intentar llamar al controlador.');
  };

  http.send();
}


function llenarselectDireccion() {
  $.ajax({
    url: base_url + "Trabajador/listarDireccion",
    type: "GET",

    success: function (response) {
      datos = JSON.parse(response);

      datos.forEach((opcion) => {
        // Crear un elemento de opción
        let option = document.createElement("option");
        // Establecer el valor y el texto de la opción
        // option.value = opcion.did;

        if (opcion.destado === "Inactivo" || opcion.eestado === "Inactivo") {
          // Aplicar estilo al campo seleccionado
          option.style.color = "red"; // Cambiar a tu color deseado
        } else {
          // Restablecer el color de fondo si el valor no es "Inactivo"
          option.style.backgroundColor = ""; // Restablecer el color a su valor por defecto
        }
        if(opcion.enombre==null){
          option.text = opcion.dnombre;
          option.value = opcion.dnombre;
        }else{
          
          option.text = opcion.dnombre + " " + opcion.enombre;
          option.value = opcion.dnombre + " " + opcion.enombre;
         
        }
        // Agregar la opción al select
        direccion.appendChild(option);
      });
    },
    error: function (xhr, status, error) {
      console.error(error);
    },
  });
}

function llenarselectRegimen() {
  $.ajax({
    url: base_url + "Trabajador/listarRegimen",
    type: "GET",

    success: function (response) {
      datos = JSON.parse(response);

      datos.forEach((opcion) => {
        // Crear un elemento de opción
        let option = document.createElement("option");
        // Establecer el valor y el texto de la opción
        option.value = opcion.nombre;

        if (opcion.estado === "Inactivo") {
          // Aplicar estilo al campo seleccionado
          option.style.color = "red"; // Cambiar a tu color deseado
        } else {
          // Restablecer el color de fondo si el valor no es "Inactivo"
          option.style.backgroundColor = ""; // Restablecer el color a su valor por defecto
        }

        option.text = opcion.nombre;
        // Agregar la opción al select
        regimen.appendChild(option);
      });
    },
    error: function (xhr, status, error) {
      console.error(error);
    },
  });
}

// function llenarselectHorario() {
//   $.ajax({
//     url: base_url + "Trabajador/listarHorario",
//     type: "GET",

//     success: function (response) {
//       datos = JSON.parse(response);

//       datos.forEach((opcion) => {
//         // Crear un elemento de opción
//         let option = document.createElement("option");
//         // Establecer el valor y el texto de la opción
//         option.value = opcion.id;

//         if (opcion.estado === "Inactivo") {
//           // Aplicar estilo al campo seleccionado
//           option.style.color = "red"; // Cambiar a tu color deseado
//         } else {
//           // Restablecer el color de fondo si el valor no es "Inactivo"
//           option.style.backgroundColor = ""; // Restablecer el color a su valor por defecto
//         }

//         option.text = opcion.nombre;
//         // Agregar la opción al select
//         horario.appendChild(option);
//       });
//     },
//     error: function (xhr, status, error) {
//       console.error(error);
//     },
//   });
// }

function llenarselectCargo() {
  $.ajax({
    url: base_url + "Trabajador/listarCargo",
    type: "GET",

    success: function (response) {
      datos = JSON.parse(response);

      datos.forEach((opcion) => {
        // Crear un elemento de opción
        let option = document.createElement("option");
        // Establecer el valor y el texto de la opción
        option.value = opcion.nombre;

        if (opcion.estado === "Inactivo") {
          // Aplicar estilo al campo seleccionado
          option.style.color = "red"; // Cambiar a tu color deseado
        } else {
          // Restablecer el color de fondo si el valor no es "Inactivo"
          option.style.backgroundColor = ""; // Restablecer el color a su valor por defecto
        }

        option.text = opcion.nombre;
        // Agregar la opción al select
        cargo.appendChild(option);
      });
    },
    error: function (xhr, status, error) {
      console.error(error);
    },
  });
}

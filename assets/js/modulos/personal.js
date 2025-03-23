

const titleModal = document.querySelector("#titleModal");
const btnAccion = document.querySelector("#btnAccion");
const myModal = new bootstrap.Modal(document.getElementById("nuevoModal"));
const telefono = document.getElementById("telefono");
let numberCredit = document.getElementById("tarjeta");

let mytable; // = document.querySelector("#table-1");
let tblUsuario;
var data9;
var datos;

// Ajustar el tamaño del modal
// Establece el ancho máximo del modal

let frm,
  selectArea,
  selectCargo,
  nuevo,
  input_id,
  input_dni,
  // input_nacimiento,
  input_nombre,
  input_apellido_materno,
  input_apellido_paterno;

function inicializarVariables() {
  frm = document.querySelector("#formulario");
  nuevo = document.querySelector("#nuevo_registro");
  selectCargo =  document.getElementById("cargo");
  selectArea =  document.getElementById("area");
  input_id = document.querySelector("#id");
  input_dni = document.querySelector("#dni");
  // input_nacimiento = document.getElementById("nacimiento");
  input_nombre = document.querySelector("#nombre");
  input_apellido_paterno = document.querySelector("#apellido_paterno");
  input_apellido_materno = document.querySelector("#apellido_materno");

  llenarTabla();
  llenarselectCargo();
  llenarselectArea();
  // llenarselectHorario();
  // llenarselectCargo();

  nuevo.addEventListener("click", function () {
    frm.reset();
    resetRequiredFields();
    // llenarselect(trabajadores);
    btnAccion.textContent = "Registrar";
    titleModal.textContent = "Nuevo Personal";
    // document.getElementById("password").setAttribute("required", "true");
    document.querySelector("#radio-true").checked = true;
    document.querySelector("#id").value = "";
    document.querySelectorAll("#estado-grupo").forEach((element) => {
      element.style.display = "none";
    });
    myModal.show();
  });
}

document.addEventListener("DOMContentLoaded", function () {
  inicializarVariables()
 
  //submit usuarios
  frm.addEventListener("submit", function (e) {
    e.preventDefault();

    let data = new FormData(this);
    const url = base_url + "Personal/registrar";
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





// function prueba() {
//   $.ajax({
//     url: base_url + "Personal/listar",
//     type: "GET",

//     success: function (response) {
//       datos = JSON.parse(response);
//       console.log(datos,'personal')

//         // Agregar la opción al selec
//     },
//     error: function (xhr, status, error) {
//       console.error(error);
//     },
//   });
// }


function llenarTabla() {
  
  tblUsuario = $("#table-alex").DataTable({
    ajax: {
      url: base_url + "Personal/listar",
      dataSrc: "",
    },
    columns: [
      { data: "contador" },
      { data: "personal_nombre" },
      { data: "personal_apellido" },
     
      { data: "personal_dni" },
      { data: "personal_correo" },
      { data: "area_nombre" },
      { data: "cargo_nombre" },

      {
        data: "personal_estado",
        render: function (data, type, row) {
            // let checked = data == 1 ? "checked" : "";
            // return `<div class="card-body">
            // <div class="pretty p-switch p-fill">
            // <input type="checkbox" ${checked} />
            //         <div class="state p-success">
            //             <label></label>
            //         </div>
            //         </div>
            //         </div>
            // `;
            if (data == 1) {
              return `<span class='badge badge-info'>Activo</span>`;
          } else {
              return `<span class='badge badge-danger'>Inactivo</span>`;
          }
        }
    },
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

function actualizartabla() {
  mytable = $("#table-alex").DataTable();
  // var datosSeleccionados = tabla.rows('.selected').data();
  tabla.ajax.reload();
}

function edit(id) {
  const url = base_url + "Personal/edit/" + id;
  const http = new XMLHttpRequest();
  http.open("GET", url, true);
  http.send();
  http.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      frm.reset();
      resetRequiredFields();
      console.log(this.responseText);
      const res = JSON.parse(this.responseText);
      document.querySelector("#id").value = res.id;
      document.querySelector("#dni").value = res.dni;
      document.querySelector("#telefono").value = res.telefono;
      document.querySelector("#tarjeta").value = res.tarjeta;
      document.querySelector("#nombre").value = res.nombre;
      document.querySelector("#apellido").value = res.apellido;
      document.querySelector("#email").value = res.email;
      document.querySelector("#nacimiento").value = res.fecha_nacimiento;
      document.querySelector("#Cargo").value = res.Cargo_id;
      document.querySelector("#Area").value = res.Area_id;
      document.querySelector("#cargo").value = res.cargo_id;
      document.querySelector("#horario").value = res.horariodetalle_id;
      document.querySelector("#modalidad").value = res.modalidad_trabajo;
      console.log( res.horariodetalle_id);
      if (res.sexo == "F") {
        document.querySelector("#radio-mujer").checked = true;
        document.querySelector("#radio-hombre").checked = false;
      } else {
        document.querySelector("#radio-hombre").checked = true;
        document.querySelector("#radio-mujer").checked = false;
      }
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
      titleModal.textContent = "Modificar Personal";
      myModal.show();

      // $('#nuevoModal').modal('show');
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

telefono.addEventListener("input", (e) => {
  let value = e.target.value.replace(/\D/g, ""); // Remueve todos los caracteres que no sean dígitos
  let formattedValue = "";

  // Formatea el número añadiendo un espacio después de cada grupo de tres dígitos
  for (let i = 0; i < value.length; i++) {
    if (i > 0 && i % 3 === 0) {
      formattedValue += " ";
    }
    formattedValue += value[i];
  }

  e.target.value = formattedValue;
});

function consultar() {
    var dniNumber = document.getElementById("dni").value;


    if(dniNumber.length === 0){
      Swal.fire("Aviso", 'campo vacio'.toUpperCase(), 'error');
    }
    if((dniNumber.length > 0) && (dniNumber.length < 8) ){
      Swal.fire("Aviso", 'El DNI debe de tener 8 Digitos'.toUpperCase(), 'warning');
    }
    

    if(dniNumber.length === 8) {
      const url = base_url + "Personal/obtenerDatosPorDNI/" + dniNumber;
      const http = new XMLHttpRequest();
      http.open("GET", url, true);
      http.send();
      http.onreadystatechange = function () {
          if (this.readyState == 4 && this.status == 200) {
              const res = JSON.parse(this.responseText);
              if (!res.apellidoPaterno || res.apellidoPaterno.length < 1) {
                Swal.fire("Aviso", "No se encontró el apellido paterno", "error");
              } else {
                // let apellidoCompleto = res.apellidoPaterno.trim(); // Inicializar con apellido paterno
      
                // if (res.apellidoMaterno && res.apellidoMaterno.length > 0) {
                //   apellidoCompleto += " " + res.apellidoMaterno.trim(); // Agregar apellido materno si existe
                // }
      
                input_apellido_paterno.value = res.apellidoPaterno
                input_apellido_materno.value = res.apellidoMaterno
      
                // Asignar el nombre completo al campo correspondiente
                input_nombre.value = res.nombres.trim();
      
                // Asumiendo que esto es para mostrar un mensaje de éxito o esconder el mensaje de error
              }

          } else {
          console.log("Error al consultar y editar el DNI.");
          }
      };
    }
  
}

function verHistorial(id) {
  //  window.location.href =  base_url + 'HorarioDetalle?id=' + encodeURIComponent(id);
 
  const url = base_url + "Personal/verHistorial/" + id;
  const http = new XMLHttpRequest();

  http.open('GET', url, true);
  http.onload = function() {
      if (http.status >= 200 && http.status < 300) {
          console.log('Llamada al contCargoador realizada correctamente.');
          window.location.href = base_url + "Seguimiento";
      } else {
          console.error('Error al llamar al contCargoador:', http.statusText);
      }
  };

  http.onerror = function() {
      console.error('Error de red al intentar llamar al contCargoador.');
  };

  http.send();
}


function llenarselectCargo() {
  $.ajax({
    url: base_url + "Cargo/listarActivo",
    type: "GET",

    success: function (response) {
      datos = JSON.parse(response);

      datos.forEach((opcion) => {
        // Crear un elemento de opción
        let option = document.createElement("option");
        // Establecer el valor y el texto de la opción
        option.value = opcion.did;
        option.text = opcion.nombre;
        
        // if (opcion.destado === "Inactivo" || opcion.eestado === "Inactivo") {
        //   // Aplicar estilo al campo seleccionado
        //   option.style.color = "red"; // Cambiar a tu color deseado
        // } else {
        //   // Restablecer el color de fondo si el valor no es "Inactivo"
        //   option.style.backgroundColor = ""; // Restablecer el color a su valor por defecto
        // }
        // if(opcion.enombre==null){
        //   option.text = opcion.dnombre
        // }else{
        //   option.text = opcion.dnombre + " " + opcion.enombre;
         
        // }
       
        // Agregar la opción al select
        selectCargo.appendChild(option);
      });
    },
    error: function (xhr, status, error) {
      console.error(error);
    },
  });
}

function llenarselectArea() {
  $.ajax({
    url: base_url + "Area/listarActivo",
    type: "GET",

    success: function (response) {
      datos = JSON.parse(response);

      datos.forEach((opcion) => {
        // Crear un elemento de opción
        let option = document.createElement("option");
        // Establecer el valor y el texto de la opción
        option.value = opcion.id;

        // if (opcion.estado === "Inactivo") {
        //   // Aplicar estilo al campo seleccionado
        //   option.style.color = "red"; // Cambiar a tu color deseado
        // } else {
        //   // Restablecer el color de fondo si el valor no es "Inactivo"
        //   option.style.backgroundColor = ""; // Restablecer el color a su valor por defecto
        // }

        option.text = opcion.nombre;
        // Agregar la opción al select
        selectArea.appendChild(option);
      });
    },
    error: function (xhr, status, error) {
      console.error(error);
    },
  });
}

// function llenarselectHorario() {
//   $.ajax({
//     url: base_url + "Personal/listarHorarioDetalle",
//     type: "GET",

//     success: function (response) {
//       datos = JSON.parse(response);

//       datos.forEach((opcion) => {
//         // Crear un elemento de opción
//         let option = document.createElement("option");
//         // Establecer el valor y el texto de la opción

//         option.value = opcion.hdid;

//         if (opcion.estado === "Inactivo") {
//           // Aplicar estilo al campo seleccionado
//           option.style.color = "red"; // Cambiar a tu color deseado
//         } else {
//           // Restablecer el color de fondo si el valor no es "Inactivo"
//           option.style.backgroundColor = ""; // Restablecer el color a su valor por defecto
//         }
        
//         option.text = opcion.hnombre +'  ('+opcion.hora_entrada_sin_segundos +' - '+opcion.hora_salida_sin_segundos +')';
//         // Agregar la opción al select
//         horario.appendChild(option);
//       });
//     },
//     error: function (xhr, status, error) {
//       console.error(error);
//     },
//   });
// }

// function llenarselectCargo() {
//   $.ajax({
//     url: base_url + "Personal/listarCargo",
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
//         cargo.appendChild(option);
//       });
//     },
//     error: function (xhr, status, error) {
//       console.error(error);
//     },
//   });
// }

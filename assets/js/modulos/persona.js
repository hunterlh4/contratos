const titleModal = document.querySelector("#titleModal");
const btnAccion = document.querySelector("#btnAccion");
const myModal = new bootstrap.Modal(document.getElementById("nuevoModal"));
const telefono = document.getElementById("telefono");
// const celular = document.getElementById("celular");
// let numberCredit = document.getElementById("tarjeta");

let mytable; // = document.querySelector("#table-1");
let tblUsuario;
var data9;
var datos;

// Ajustar el tamaño del modal
// Establece el ancho máximo del modal

let frm,
  // selectArea,
  // selectCargo,
  nuevo,
  input_id,
  input_dni,
  input_ruc,
  input_tipo_documento,
  ubigeo,
  // input_nacimiento,
  selectDepartamento,
  selectProvincia,
  selectDistrito,
  selectTipo_persona,
  input_nombre,
  input_direccion,
  input_ubigeo = "",
  input_celular,
  input_representante_legal,
  input_partida_registral,
  input_contacto_nombre,
  input_correo;

function inicializarVariables() {
  frm = document.querySelector("#formulario");
  nuevo = document.querySelector("#nuevo_registro");
  selectDepartamento = document.getElementById("departamento");
  selectProvincia = document.getElementById("provincia");
  selectDistrito = document.getElementById("distrito");
  selectTipo_persona = document.getElementById("tipo_persona");

  input_id = document.querySelector("#id");
  input_dni = document.querySelector("#dni");
  input_ruc = document.querySelector("#dni");
  input_tipo_documento = document.querySelector("#dni");
  input_email = document.querySelector("#email");
  input_nombre = document.querySelector("#nombre");
  input_direccion = document.querySelector("#direccion");
  input_celular = document.querySelector("#celular");

  const divDNI = document.getElementById("dni").closest(".form-group");
  const divRUC = document.getElementById("ruc").closest(".form-group");

  function actualizarCampos() {
    let tipoPersona = selectTipo_persona.value;

    if (tipoPersona === "1") {
      // Persona Natural
      divDNI.style.display = "block";
      divRUC.style.display = "none";

      input_dni.required = true;
      input_dni.focus();
      input_ruc.required = false;
      input_ruc.value = "";
    } else if (tipoPersona === "2") {
      // Persona Jurídica
      divDNI.style.display = "none";
      divRUC.style.display = "block";

      input_ruc.required = true;
      input_ruc.focus();
      input_dni.required = false;
      input_dni.value = "";
    } else {
      // Opción por defecto
      divDNI.style.display = "block";
      divRUC.style.display = "none";
    }
  }

  // Detecta cambios en el select
  selectTipo_persona.addEventListener("change", actualizarCampos);

  // Ejecutar al cargar la página
  actualizarCampos();
  // input_email = document.querySelector("#email");

  // input_nacimiento = document.getElementById("nacimiento");

  llenarTabla();
  llenarselectDepartamento();

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
  inicializarVariables();

  //submit usuarios
  frm.addEventListener("submit", function (e) {
    e.preventDefault();
    validarformulario();
  });

  // selectDepartamento.addEventListener("change", function () {
  //   let departamento_id = this.value;
  //   let ubigeo_departamento = this.options[this.selectedIndex].dataset.ubigeo;
  //   ubigeo = ubigeo_departamento; // Asignar el ubigeo del departamento

  //   if (departamento_id) {
  //     $.ajax({
  //       url: base_url + "Api/listarProvincia",
  //       type: "POST",
  //       data: { departamento_id: departamento_id },
  //       success: function (response) {
  //         let datos = JSON.parse(response);
  //         selectProvincia.innerHTML =
  //           '<option value="" selected>Selecciona una provincia</option>';
  //         selectDistrito.innerHTML =
  //           '<option value="" selected>Selecciona un distrito</option>'; // Reset distritos

  //         datos.forEach((opcion) => {
  //           let option = document.createElement("option");
  //           option.value = opcion.id;
  //           option.dataset.ubigeo = opcion.ubigeo;
  //           option.text = opcion.nombre;
  //           selectProvincia.appendChild(option);
  //         });
  //       },
  //       error: function (xhr, status, error) {
  //         console.error(error);
  //       }
  //     });
  //   }
  // });

  // // Cargar Distritos al seleccionar una Provincia
  // selectProvincia.addEventListener("change", function () {
  //   let provincia_id = this.value;
  //   let ubigeo_provincia = this.options[this.selectedIndex].dataset.ubigeo;
  //   ubigeo = ubigeo.substring(0, 2) + ubigeo_provincia; // Concatenar ubigeo del departamento + provincia

  //   if (provincia_id) {
  //     $.ajax({
  //       url: base_url + "Api/listarDistrito",
  //       type: "POST",
  //       data: { provincia_id: provincia_id },
  //       success: function (response) {
  //         let datos = JSON.parse(response);
  //         selectDistrito.innerHTML =
  //           '<option value="" selected>Selecciona un distrito</option>';

  //         datos.forEach((opcion) => {
  //           let option = document.createElement("option");
  //           option.value = opcion.id;
  //           option.dataset.ubigeo = opcion.ubigeo;
  //           option.text = opcion.nombre;
  //           selectDistrito.appendChild(option);
  //         });
  //       },
  //       error: function (xhr, status, error) {
  //         console.error(error);
  //       }
  //     });
  //   }
  // });

  // // Actualizar Ubigeo al seleccionar un Distrito
  // selectDistrito.addEventListener("change", function () {
  //   let ubigeo_distrito = this.options[this.selectedIndex].dataset.ubigeo;
  //   ubigeo = ubigeo.substring(0, 4) + ubigeo_distrito; // Concatenar ubigeo completo
  //   console.log("Ubigeo seleccionado:", ubigeo);
  // });

  // Evento para seleccionar la provincia según el departamento
  selectDepartamento.addEventListener("change", function () {
    let departamento_id = this.value;
    let ubigeo_departamento = this.options[this.selectedIndex].dataset.ubigeo;
    ubigeo = ubigeo_departamento; // Asignar el ubigeo del departamento

    console.log("Ubigeo después de seleccionar Departamento:", ubigeo); // 👀 MOSTRAR EN CONSOLA

    if (departamento_id) {
      $.ajax({
        url: base_url + "Api/listarProvincia",
        type: "POST",
        data: { departamento_id: departamento_id },
        success: function (response) {
          let datos = JSON.parse(response);
          selectProvincia.innerHTML =
            '<option value="" selected>Selecciona una provincia</option>';
          selectDistrito.innerHTML =
            '<option value="" selected>Selecciona un distrito</option>'; // Reset distritos

          datos.forEach((opcion) => {
            let option = document.createElement("option");
            option.value = opcion.id;
            option.dataset.ubigeo = opcion.ubigeo;
            option.text = opcion.nombre;
            selectProvincia.appendChild(option);
          });

          // Si ya hay un ubigeo cargado, seleccionar provincia automáticamente
          if (input_ubigeo) {
            seleccionarProvincia(input_ubigeo.substring(0, 4));
          }
        }
      });
    }
  });

  // Evento para seleccionar el distrito según la provincia
  selectProvincia.addEventListener("change", function () {
    let provincia_id = this.value;
    let ubigeo_provincia = this.options[this.selectedIndex].dataset.ubigeo;
    ubigeo = ubigeo.substring(0, 2) + ubigeo_provincia; // Concatenar ubigeo del departamento + provincia

    console.log("Ubigeo después de seleccionar Provincia:", ubigeo); // 👀 MOSTRAR EN CONSOLA

    if (provincia_id) {
      $.ajax({
        url: base_url + "Api/listarDistrito",
        type: "POST",
        data: { provincia_id: provincia_id },
        success: function (response) {
          let datos = JSON.parse(response);
          selectDistrito.innerHTML =
            '<option value="" selected>Selecciona un distrito</option>';

          datos.forEach((opcion) => {
            let option = document.createElement("option");
            option.value = opcion.id;
            option.dataset.ubigeo = opcion.ubigeo;
            option.text = opcion.nombre;
            selectDistrito.appendChild(option);
          });

          // Si ya hay un ubigeo cargado, seleccionar distrito automáticamente
          if (input_ubigeo) {
            seleccionarDistrito(input_ubigeo);
          }
        }
      });
    }
  });

  selectDistrito.addEventListener("change", function () {
    let ubigeo_distrito = this.options[this.selectedIndex].dataset.ubigeo;
    ubigeo = ubigeo.substring(0, 4) + ubigeo_distrito; // Concatenar ubigeo completo

    console.log("Ubigeo seleccionado (final):", ubigeo); // 👀 MOSTRAR EN CONSOLA
  });

  // Función para seleccionar automáticamente el Departamento, Provincia y Distrito
  // function seleccionarUbigeo(ubigeo) {
  //   let departamentoCodigo = ubigeo.substring(0, 2);
  //   let provinciaCodigo = ubigeo.substring(0, 4);

  //   // Seleccionar departamento
  //   selectDepartamento.value =
  //     [...selectDepartamento.options].find(
  //       (opt) => opt.dataset.ubigeo === departamentoCodigo
  //     )?.value || "";
  //   selectDepartamento.dispatchEvent(new Event("change"));

  //   // Esperar carga de provincias y luego seleccionar
  //   setTimeout(() => seleccionarProvincia(provinciaCodigo), 500);
  // }

  // function seleccionarProvincia(provinciaCodigo) {
  //   selectProvincia.value =
  //     [...selectProvincia.options].find(
  //       (opt) => opt.dataset.ubigeo === provinciaCodigo
  //     )?.value || "";
  //   selectProvincia.dispatchEvent(new Event("change"));

  //   // Esperar carga de distritos y luego seleccionar
  //   setTimeout(() => seleccionarDistrito(input_ubigeo), 500);
  // }

  // function seleccionarDistrito(ubigeo) {
  //   selectDistrito.value =
  //     [...selectDistrito.options].find((opt) => opt.dataset.ubigeo === ubigeo)
  //       ?.value || "";
  // }
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

function validarformulario() {
  let errores = "";

  // if (input_dni.value === "" || input_dni.value.length !== 8) {
  //   errores += "El <b>DNI</b> debe tener exactamente 8 dígitos numéricos.<br>";
  // }

  // Validar Cargo y Área (Seleccionar opción válida)
  if (selectDepartamento === "") {
    errores += "Selecciona un <b>Departamento</b>.<br>";
  }
  if (selectDistrito === "") {
    errores += "Selecciona un <b>Distrito</b>.<br>";
  }
  if (selectProvincia === "") {
    errores += "Selecciona un <b>Provincia</b>.<br>";
  }

  // Validar Nombre y Apellidos
  if (
    input_nombre.value.trim() === "" ||
    input_nombre.value.length < 5 ||
    input_nombre.value.length > 30
  ) {
    errores += "El campo <b>Nombre</b> debe tener entre 5 y 30 caracteres.<br>";
  }

  // Validación de Apellido Paterno (entre 3 y 30 caracteres)

  // Validar Teléfono y Celular (Opcionales, pero si se llenan deben ser numéricos y de 9 dígitos)
  // if (input_telefono !== "" && (input_telefono.length !== 9 || isNaN(input_telefono))) {
  //   errores += "El <b>Teléfono</b> debe tener exactamente 9 dígitos numéricos.<br>";
  // }
  // if (input_celular !== "" && (input_celular.length !== 9 || isNaN(input_celular))) {
  //   errores += "El <b>Celular</b> debe tener exactamente 9 dígitos numéricos.<br>";
  // }

  // Validar Email (Opcional, pero si se llena debe ser válido)
  if (input_email.value !== "" && !/^\S+@\S+\.\S+$/.test(input_email.value)) {
    errores += "El <b>Correo</b> no tiene un formato válido.<br>";
  }
  // Mostrar errores si existen
  if (errores !== "") {
    alerta("Aviso", errores, "error");
    return;
  }

  registrar();
}

function registrar() {
  var formData = new FormData(frm);
  const url = base_url + "Persona/registrar";

  if (selectDepartamento && selectProvincia && selectDistrito) {
    let formulario_ubigeo = ubigeo;
    formData.append("ubigeo", formulario_ubigeo); // Agregar ubigeo al FormData
  }

  $.ajax({
    type: "POST",
    url: url,
    data: formData,
    processData: false,
    contentType: false,
    success: function (response) {
      console.log(response);

      const res = JSON.parse(response);
      // if(res.icono=="success"){
      if (res.icono == "success") {
        tblUsuario.ajax.reload();
        frm.reset(); // Limpia el formulario
        resetRequiredFields();
        cerrarModal(); // Oculta el modal y el fondo oscuro
      }
      alerta("Aviso", res.msg, res.icono);
    },
    error: function (xhr, status, error) {
      console.error("Error al enviar la solicitud: " + error);
    }
  });
}

function alerta(titulo, msg, icono) {
  Swal.fire(titulo, msg.toUpperCase(), icono);
}

function llenarTabla() {
  tblUsuario = $("#table-alex").DataTable({
    ajax: {
      url: base_url + "Persona/listar",
      dataSrc: ""
    },
    columns: [
      { data: "contador" },
      { data: "nombre" },
      {
        data: "tipo_persona",
        render: function (data, type, row) {
          if (data == 1) {
            return `Persona Natural`;
          }
          if (data == 2) {
            return `Persona Juridica`;
          }
        }
      },
      {
        // data: "tipo_documento_identidad",
        // render: function (data, type, row) {
        //   if (data == 1) {
        //     return `DNI`;
        //   }
        //   if (data == 2) {
        //     return `RUC`;
        //   }
        // }
        data: "numero_documento"
      },
      { data: "numero_ruc" },
      { data: "contacto_telefono" },

      {
        data: "estado",
        render: function (data, type, row) {
          if (data == 1) {
            return `<span class='badge badge-info'>Activo</span>`;
          } else {
            return `<span class='badge badge-danger'>Inactivo</span>`;
          }
        }
      },
      { data: "accion" }
    ],
    dom: "Bfrtip",
    language: {
      sProcessing: "Procesando...",
      sLengthMenu: "Mostrar _MENU_ registros",
      sZeroRecords: "No se encontraron resultados",
      sInfo:
        "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
      sInfoEmpty: "Mostrando registros del 0 al 0 de un total de 0 registros",
      sInfoFiltered: "(filtrado de un total de _MAX_ registros)",
      sInfoPostFix: "",
      sSearch: "Buscar:",
      sUrl: "",
      sInfoThousands: ",",
      sLoadingRecords: "Cargando...",
      oPaginate: {
        sFirst: "Primero",
        sLast: "Último",
        sNext: "Siguiente",
        sPrevious: "Anterior"
      },
      buttons: {
        copy: "Copiar",
        colvis: "Visibilidad",
        collection: "Colección",
        colvisRestore: "Restaurar visibilidad",
        copyKeys:
          "Presione ctrl o u2318 + C para copiar los datos de la tabla al portapapeles del sistema. <br /> <br /> Para cancelar, haga clic en este mensaje o presione escape.",
        copySuccess: {
          1: "Copiada 1 fila al portapapeles",
          _: "Copiadas %ds fila al portapapeles"
        },
        copyTitle: "Copiar al portapapeles",
        csv: "CSV",
        excel: "Excel",
        pageLength: {
          "-1": "Mostrar todas las filas",
          _: "Mostrar %d filas"
        },
        pdf: "PDF",
        print: "Imprimir",
        renameState: "Cambiar nombre",
        updateState: "Actualizar",
        createState: "Crear Estado",
        removeAllStates: "Remover Estados",
        removeState: "Remover",
        savedStates: "Estados Guardados",
        stateRestore: "Estado %d"
      },
      oAria: {
        sSortAscending:
          ": Activar para ordenar la columna de manera ascendente",
        sSortDescending:
          ": Activar para ordenar la columna de manera descendente"
      }
    },

    buttons: [
      {
        extend: "copy",
        exportOptions: {
          columns: [0, 1, 2, 3, 4, 5, 6] // Especifica las columnas que deseas copiar
        }
      },
      {
        extend: "csv",
        exportOptions: {
          columns: [0, 1, 2, 3, 4, 5, 6] // Especifica las columnas que deseas exportar a CSV
        }
      },
      {
        extend: "excel",
        exportOptions: {
          columns: [0, 1, 2, 3, 4, 5, 6] // Especifica las columnas que deseas exportar a Excel
        }
      },
      {
        extend: "pdf",
        exportOptions: {
          columns: [0, 1, 2, 3, 4, 5, 6] // Especifica las columnas que deseas exportar a PDF
        }
      },
      {
        extend: "print",
        exportOptions: {
          columns: [0, 1, 2, 3, 4, 5, 6] // Especifica las columnas que deseas imprimir
        }
      }
    ]
  });
}

function actualizartabla() {
  mytable = $("#table-alex").DataTable();
  // var datosSeleccionados = tabla.rows('.selected').data();
  tabla.ajax.reload();
}

function edit(id) {
  const url = base_url + "Persona/edit/" + id;

  $.ajax({
    url: url,
    type: "GET",
    success: function (response) {
      frm.reset();
      resetRequiredFields();
      console.log(response);
      const res = JSON.parse(response);
      input_id.value = res.id;

      selectTipo_persona.value = res.tipo_persona;
      if (res.tipo_persona == 1) {
        input_dni.value = res.numero_documento;
      }
      if (res.tipo_persona == 2) {
        input_ruc.value = res.numero_ruc;
      }
      input_nombre.value = res.nombre;
      input_direccion.value = res.direccion;
      if (res.ubigeo.length === 6) {
        seleccionarUbigeo(res.ubigeo);
      }

      input_celular.value = res.contacto_telefono;
      input_email.value = res.contacto_email;

      if (res.estado == 1) {
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
    },
    error: function (xhr, status, error) {
      console.error("Error en la petición AJAX:", error);
      alert("Hubo un problema al obtener los datos.");
    }
  });
}

function seleccionarUbigeo(ubigeoCompleto) {
  if (!ubigeoCompleto || ubigeoCompleto.length !== 6) return;

  let ubigeo_departamento = ubigeoCompleto.substring(0, 2);
  let ubigeo_provincia = ubigeoCompleto.substring(2, 4);
  let ubigeo_distrito = ubigeoCompleto.substring(4, 6);

  // 1. Seleccionar el Departamento
  let optionDep = [...selectDepartamento.options].find(
    (opt) => opt.dataset.ubigeo === ubigeo_departamento
  );
  if (optionDep) {
    selectDepartamento.value = optionDep.value;

    // 2. Cargar Provincias
    $.ajax({
      url: base_url + "Api/listarProvincia",
      type: "POST",
      data: { departamento_id: optionDep.value },
      success: function (response) {
        let datos = JSON.parse(response);
        selectProvincia.innerHTML =
          '<option value="" selected>Selecciona una provincia</option>';

        datos.forEach((opcion) => {
          let option = document.createElement("option");
          option.value = opcion.id;
          option.dataset.ubigeo = opcion.ubigeo;
          option.text = opcion.nombre;
          selectProvincia.appendChild(option);
        });

        // 3. Seleccionar la Provincia después de cargarla
        let optionProv = [...selectProvincia.options].find(
          (opt) => opt.dataset.ubigeo === ubigeo_provincia
        );
        if (optionProv) {
          selectProvincia.value = optionProv.value;

          // 4. Cargar Distritos
          $.ajax({
            url: base_url + "Api/listarDistrito",
            type: "POST",
            data: { provincia_id: optionProv.value },
            success: function (response) {
              let datos = JSON.parse(response);
              selectDistrito.innerHTML =
                '<option value="" selected>Selecciona un distrito</option>';

              datos.forEach((opcion) => {
                let option = document.createElement("option");
                option.value = opcion.id;
                option.dataset.ubigeo = opcion.ubigeo;
                option.text = opcion.nombre;
                selectDistrito.appendChild(option);
              });

              // 5. Seleccionar el Distrito después de cargarlo
              let optionDist = [...selectDistrito.options].find(
                (opt) => opt.dataset.ubigeo === ubigeo_distrito
              );
              if (optionDist) {
                selectDistrito.value = optionDist.value;
              }
            }
          });
        }
      }
    });
  }
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

celular.addEventListener("input", (e) => {
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

document.getElementById("dni").addEventListener("input", (e) => {
  let value = e.target.value.replace(/\D/g, ""); // Remueve caracteres no numéricos
  e.target.value = value.slice(0, 8); // Limita a 8 caracteres
});

document.getElementById("ruc").addEventListener("input", (e) => {
  let value = e.target.value.replace(/\D/g, ""); // Remueve caracteres no numéricos
  e.target.value = value.slice(0, 11); // Limita a 11 caracteres
});

function llenarselectDepartamento() {
  $.ajax({
    url: base_url + "Api/listarDepartamento",
    type: "GET",
    success: function (response) {
      let datos = JSON.parse(response);
      selectDepartamento.innerHTML =
        '<option value="" selected>Selecciona un departamento</option>';

      datos.forEach((opcion) => {
        let option = document.createElement("option");
        option.value = opcion.id;
        option.dataset.ubigeo = opcion.ubigeo; // Guardar el ubigeo en el dataset
        option.text = opcion.nombre;
        selectDepartamento.appendChild(option);
      });
    },
    error: function (xhr, status, error) {
      console.error(error);
    }
  });
}

function consultar(tipo_consulta) {
  let url = "";
  if (tipo_consulta == 1) {
    let dniNumber = document.getElementById("dni").value;
    if (dniNumber.length === 0) {
      Swal.fire("Aviso", "DNI vacio".toUpperCase(), "error");
      return;
    }
    if (dniNumber.length > 0 && dniNumber.length < 8) {
      Swal.fire(
        "Aviso",
        "El DNI debe de tener 8 Digitos".toUpperCase(),
        "warning"
      );
      return;
    }
    url = base_url + "Persona/obtenerDatosPorDNI/" + dniNumber;
  }
  if (tipo_consulta == 2) {
    let rucNumber = document.getElementById("ruc").value;
    if (rucNumber.length === 0) {
      Swal.fire("Aviso", "RUC vacio".toUpperCase(), "error");
      return;
    }
    if (rucNumber.length > 0 && rucNumber.length < 8) {
      Swal.fire(
        "Aviso",
        "El RUC debe de tener 11 Digitos".toUpperCase(),
        "warning"
      );
      return;
    }
    url = base_url + "Persona/obtenerDatosPorRUC/" + rucNumber;
  }

  const http = new XMLHttpRequest();
  http.open("GET", url, true);
  http.send();
  http.onreadystatechange = function () {
    console.log(url, "URL", this.responseText);
    if (this.readyState == 4 && this.status == 200) {
      const res = JSON.parse(this.responseText);

      if (tipo_consulta == 1) {
        input_nombre.value = res.nombreCompleto;
      }

      if (tipo_consulta == 2) {
        input_nombre.value = res.razonSocial;
        input_direccion.value = res.direccion;
      }
    } else {
      console.log("Error al consultar y editar .");
    }
  };
}

// function verHistorial(id) {
//   //  window.location.href =  base_url + 'HorarioDetalle?id=' + encodeURIComponent(id);

//   const url = base_url + "Personal/verHistorial/" + id;
//   const http = new XMLHttpRequest();

//   http.open('GET', url, true);
//   http.onload = function() {
//       if (http.status >= 200 && http.status < 300) {
//           console.log('Llamada al contCargoador realizada correctamente.');
//           window.location.href = base_url + "Seguimiento";
//       } else {
//           console.error('Error al llamar al contCargoador:', http.statusText);
//       }
//   };

//   http.onerror = function() {
//       console.error('Error de red al intentar llamar al contCargoador.');
//   };

//   http.send();
// }

// function llenarselectDepartamento() {
//   $.ajax({
//     url: base_url + "Api/listarDepartamento",
//     type: "GET",

//     success: function (response) {
//       datos = JSON.parse(response);

//       datos.forEach((opcion) => {
//         // Crear un elemento de opción
//         let option = document.createElement("option");
//         // Establecer el valor y el texto de la opción
//         option.value = opcion.id;
//         option.dataset.ubigeo = opcion.ubigeo;
//         option.text = opcion.nombre;
//         // Agregar la opción al select
//         selectDepartamento.appendChild(option);
//       });
//     },
//     error: function (xhr, status, error) {
//       console.error(error);
//     }
//   });
// }

// function llenarselectProvincia() {
//   $.ajax({
//     url: base_url + "Api/listarProvincia",
//     type: "POST",

//     success: function (response) {
//       datos = JSON.parse(response);

//       datos.forEach((opcion) => {
//         // Crear un elemento de opción
//         let option = document.createElement("option");
//         // Establecer el valor y el texto de la opción
//         option.value = opcion.id;
//         option.text = opcion.nombre;
//         // Agregar la opción al select
//         selectProvincia.appendChild(option);
//       });
//     },
//     error: function (xhr, status, error) {
//       console.error(error);
//     }
//   });
// }

// function llenarselectDistrito() {
//   $.ajax({
//     url: base_url + "Api/listarDistrito",
//     type: "POST",

//     success: function (response) {
//       datos = JSON.parse(response);

//       datos.forEach((opcion) => {
//         // Crear un elemento de opción
//         let option = document.createElement("option");
//         // Establecer el valor y el texto de la opción
//         option.value = opcion.id;

//         // if (opcion.estado === "Inactivo") {
//         //   // Aplicar estilo al campo seleccionado
//         //   option.style.color = "red"; // Cambiar a tu color deseado
//         // } else {
//         //   // Restablecer el color de fondo si el valor no es "Inactivo"
//         //   option.style.backgroundColor = ""; // Restablecer el color a su valor por defecto
//         // }

//         option.text = opcion.nombre;
//         // Agregar la opción al select
//         selectDistrito.appendChild(option);
//       });
//     },
//     error: function (xhr, status, error) {
//       console.error(error);
//     }
//   });
// }

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

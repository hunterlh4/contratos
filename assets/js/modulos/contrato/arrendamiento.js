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
let emisor_lista = [];
let receptor_lista = [];
let frm,
  // selectArea,
  // selectCargo,
  nuevo,
  input_id,
  //   input_dni,
  //   input_ruc,
  input_tipo_documento,
  ubigeo,
  // input_nacimiento,
  selectDepartamento,
  selectProvincia,
  selectDistrito,
  //   personas
  selectAbogado,
  selectEmisor,
  selectReceptor,
  contrato_tipo,
  input_direccion,
  input_ubigeo = "",
  input_observacion,
  input_fecha_inicio,
  input_fecha_fin,
  input_fecha_suscripcion,
  input_moneda,
  input_monto,
  input_banco,
  input_numero_cuenta,
  input_representante_legal,
  input_partida_registral,
  input_contacto_nombre,
  input_correo;

function inicializarVariables() {
  frm = document.querySelector("#formulario");
  //   nuevo = document.querySelector("#nuevo_registro");

  selectAbogado = document.getElementById("abogado_id");
  selectEmisor = document.getElementById("emisor_id");
  selectReceptor = document.getElementById("receptor_id");

  selectDepartamento = document.getElementById("departamento");
  selectProvincia = document.getElementById("provincia");
  selectDistrito = document.getElementById("distrito");

  input_direccion = document.querySelector("#direccion");
  input_observacion = document.getElementById("observacion");

  input_fecha_inicio = document.getElementById("fecha_inicio");
  input_fecha_fin = document.getElementById("fecha_fin");
  input_fecha_suscripcion = document.getElementById("fecha_suscripcion");

  selectMoneda = document.getElementById("moneda_id");
  input_monto = document.getElementById("monto");
  selectBanco = document.getElementById("banco_id");
  input_numero_cuenta = document.getElementById("numero_cuenta");

  //   contrato_tipo = document.getElementById("tipo_persona");

  input_id = document.querySelector("#id");

  input_celular = document.querySelector("#celular");

  //   const divDNI = document.getElementById("dni").closest(".form-group");
  //   const divRUC = document.getElementById("ruc").closest(".form-group");

  // Detecta cambios en el select
  //   contrato_tipo.addEventListener("change", actualizarCampos);

  // Ejecutar al cargar la página

  // input_email = document.querySelector("#email");

  // input_nacimiento = document.getElementById("nacimiento");

  llenarselectDepartamento();
  llenarSelectAbogado();
  llenarSelectEmisor();
  llenarSelectBanco();
  llenarSelectMoneda();
  // llenarselectHorario();
  // llenarselectCargo();
}

document.addEventListener("DOMContentLoaded", function () {
  inicializarVariables();

  //submit usuarios
  frm.addEventListener("submit", function (e) {
    e.preventDefault();
    validarformulario();
  });

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
        },
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
        },
      });
    }
  });

  selectDistrito.addEventListener("change", function () {
    let ubigeo_distrito = this.options[this.selectedIndex].dataset.ubigeo;
    ubigeo = ubigeo.substring(0, 4) + ubigeo_distrito; // Concatenar ubigeo completo

    console.log("Ubigeo seleccionado (final):", ubigeo); // 👀 MOSTRAR EN CONSOLA
  });
});

$(document).ready(function () {
  $("#emisor_id").on("change", function () {
    let emisor_id = $(this).val();

    if (emisor_id) {
      let emisor = emisor_lista.find((a) => a.id == emisor_id); // Buscar en la lista
      if (emisor) {
        llenarDatosArrendador(emisor);
      }

      $.ajax({
        url: base_url + "Persona/listarReceptor",
        type: "POST",
        data: { emisor_id: emisor_id },
        success: function (response) {
          let datos = JSON.parse(response);
          receptor_lista = datos;
          console.log(datos); // Verificar qué datos se están recibiendo

          let selectReceptor = $("#receptor_id");
          selectReceptor
            .empty()
            .append(
              '<option value="" selected>Selecciona un Arrendatario</option>'
            );

          datos.forEach((opcion) => {
            selectReceptor.append(new Option(opcion.nombre, opcion.id));
          });

          // Si usas Select2, refrescar opciones
          selectReceptor.trigger("change");
        },
        error: function (xhr, status, error) {
          console.error("Error en la petición AJAX: ", error);
        },
      });
    } else {
      limpiarDatosArrendador();
      limpiarDatosArrendatario();
    }
  });
});

$("#receptor_id").on("change", function () {
  let receptor_id = $(this).val();
  let receptor = receptor_lista.find((a) => a.id == receptor_id);
  if (receptor) {
    llenarDatosArrendatario(receptor);
  } else {
    limpiarDatosArrendatario();
  }
});

function llenarDatosArrendador(data) {
  $("#arrendador_nombre").text(data.nombre);
  $("#arrendador_dni").text(data.numero_documento);
  $("#arrendador_ruc").text(data.numero_ruc);
  $("#arrendador_direccion").text(data.direccion);
  $("#arrendador_telefono").text(data.contacto_telefono);
}

// Función para llenar los datos del Arrendatario
function llenarDatosArrendatario(data) {
  $("#arrendatario_nombre").text(data.nombre);
  $("#arrendatario_dni").text(data.numero_documento);
  $("#arrendatario_ruc").text(data.numero_ruc);
  $("#arrendatario_direccion").text(data.direccion);
  $("#arrendatario_telefono").text(data.contacto_telefono);
}

function limpiarDatosArrendador() {
  $(
    "#arrendador_nombre, #arrendador_dni, #arrendador_ruc, #arrendador_direccion, #arrendador_telefono"
  ).text("");
}

function limpiarDatosArrendatario() {
  $(
    "#arrendatario_nombre, #arrendatario_dni, #arrendatario_ruc, #arrendatario_direccion, #arrendatario_telefono"
  ).text("");
}

function validarformulario() {
  let errores = "";

  // Validación de SELECTS
  const selects = [
    { element: selectAbogado, label: "Abogado" },
    { element: selectEmisor, label: "Arrendador" },
    { element: selectReceptor, label: "Arrendatario" },
    { element: selectDepartamento, label: "Departamento" },
    { element: selectProvincia, label: "Provincia" },
    { element: selectDistrito, label: "Distrito" },
    { element: selectMoneda, label: "Moneda" },
    { element: selectBanco, label: "Banco" },
  ];

  selects.forEach(({ element, label }) => {
    if (!element || element.value.trim() === "") {
      errores += `Selecciona un valor para <b>${label}</b>.<br>`;
    }
  });

  // Validación de INPUTS tipo texto
  const inputsText = [
    { element: input_direccion, label: "Dirección" },
    { element: input_numero_cuenta, label: "N° de Cuenta" },
  ];

  inputsText.forEach(({ element, label }) => {
    if (!element || element.value.trim() === "") {
      errores += `El campo <b>${label}</b> es obligatorio.<br>`;
    }
  });

  // Validar Monto (Debe ser un número mayor a 0)
  if (
    !input_monto ||
    input_monto.value.trim() === "" ||
    isNaN(input_monto.value) ||
    parseFloat(input_monto.value) <= 0
  ) {
    errores += "El campo <b>Monto</b> debe ser un número mayor a 0.<br>";
  }

  // Validar N° de Cuenta (Debe ser numérico y al menos 6 caracteres)
  if (input_numero_cuenta) {
    let cuentaValor = input_numero_cuenta.value.trim();
    if (!/^\d{6,}$/.test(cuentaValor)) {
      errores +=
        "El <b>N° de cuenta</b> debe ser numérico y tener al menos 6 dígitos.<br>";
    }
  }

  // Validación de Fechas
  if (
    !input_fecha_inicio.value.trim() ||
    !input_fecha_fin.value.trim() ||
    !input_fecha_suscripcion.value.trim()
  ) {
    errores += "Todos los campos de <b>Fechas</b> son obligatorios.<br>";
  } else {
    if (new Date(input_fecha_fin.value) <= new Date(input_fecha_inicio.value)) {
      errores +=
        "La <b>Fecha de Fin</b> debe ser mayor a la <b>Fecha de Inicio</b>.<br>";
    }
  }

  // Mostrar errores si hay
  if (errores !== "") {
    alerta("Aviso", errores, "error"); // Utiliza SweetAlert
    return false;
  }

  registrar(); // Llamar a la función de registro si no hay errores
}

function registrar() {
  var formData = new FormData(frm);
  const url = base_url + "Contrato/registrar";

  const tipo_contrato = 1;
  formData.append("tipo_contrato", tipo_contrato);
  if (selectDepartamento && selectProvincia && selectDistrito) {
    if (typeof ubigeo !== "undefined") {
      formData.append("ubigeo", ubigeo); // Agregar ubigeo al FormData
    }
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
      console.log(res);
      // if(res.icono=="success"){
      if (res.icono == "success") {
        // tblUsuario.ajax.reload();
        // frm.reset(); // Limpia el formulario
        resetRequiredFields();
        cerrarModal(); // Oculta el modal y el fondo oscuro
      }
      alerta("Aviso", res.msg, res.icono);
    },
    error: function (xhr, status, error) {
      console.error("Error al enviar la solicitud: " + error);
    },
  });
}

function alerta(titulo, msg, icono) {
  Swal.fire(titulo, msg.toUpperCase(), icono);
}

// function edit(id) {
//   const url = base_url + "Persona/edit/" + id;

//   $.ajax({
//     url: url,
//     type: "GET",
//     success: function (response) {
//       frm.reset();
//       resetRequiredFields();
//       console.log(response);
//       const res = JSON.parse(response);
//       input_id.value = res.id;

//       contrato_tipo.value = res.tipo_persona;
//       if (res.tipo_persona == 1) {
//         input_dni.value = res.numero_documento;
//       }
//       if (res.tipo_persona == 2) {
//         input_ruc.value = res.numero_ruc;
//       }
//       input_nombre.value = res.nombre;
//       input_direccion.value = res.direccion;
//       if (res.ubigeo.length === 6) {
//         seleccionarUbigeo(res.ubigeo);
//       }

//       input_celular.value = res.contacto_telefono;
//       input_email.value = res.contacto_email;

//       if (res.estado == 1) {
//         document.querySelector("#radio-true").checked = true;
//         document.querySelector("#radio-false").checked = false;
//       } else {
//         document.querySelector("#radio-false").checked = true;
//         document.querySelector("#radio-true").checked = false;
//       }
//       document.querySelectorAll("#estado-grupo").forEach((element) => {
//         element.style.display = "block";
//       });
//       // document.querySelector('#password').setAttribute('readonly', 'readonly');
//       btnAccion.textContent = "Actualizar";
//       titleModal.textContent = "Modificar Personal";
//       myModal.show();
//     },
//     error: function (xhr, status, error) {
//       console.error("Error en la petición AJAX:", error);
//       alert("Hubo un problema al obtener los datos.");
//     },
//   });
// }

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
            },
          });
        }
      },
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

// document.getElementById("ruc").addEventListener("input", (e) => {
//   let value = e.target.value.replace(/\D/g, ""); // Remueve caracteres no numéricos
//   e.target.value = value.slice(0, 11); // Limita a 11 caracteres
// });

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
    },
  });
}

// function listarAbogados() {
//   $.ajax({
//     url: base_url + "Personal/listarAbogados",
//     type: "GET",

//     success: function (response) {
//       datos = JSON.parse(response);
//       datos.forEach((opcion) => {
//         // Crear un elemento de opción
//         let option = document.createElement("option");
//         // Establecer el valor y el texto de la opción

//         // if (opcion.estado === "Inactivo") {
//         //   // Aplicar estilo al campo seleccionado
//         //   option.style.color = "red"; // Cambiar a tu color deseado
//         // }
//         // option.value = opcion.id;
//         // if (opcion.dni == null) {
//         //   option.text = opcion.apellido_nombre;
//         // } else {
//         //   option.text = opcion.apellido_nombre + " - " + opcion.dni;
//         // }
//         // Agregar la opción al select
//         select1.appendChild(option);
//       });
//     },
//     error: function (xhr, status, error) {
//       console.error(error);
//     },
//   });
// }

function llenarSelectAbogado() {
  $.ajax({
    url: base_url + "Personal/listarAbogado",
    type: "GET",
    success: function (response) {
      let datos = JSON.parse(response);
      selectAbogado.innerHTML =
        '<option value="" selected>Selecciona un Abogado</option>';

      datos.forEach((opcion) => {
        let option = document.createElement("option");
        option.value = opcion.id;
        option.text = opcion.nombre;
        selectAbogado.appendChild(option);
      });
    },
    error: function (xhr, status, error) {
      console.error(error);
    },
  });
}

function llenarSelectEmisor() {
  $.ajax({
    url: base_url + "Persona/listar",
    type: "GET",
    success: function (response) {
      let datos = JSON.parse(response);
      selectEmisor.innerHTML =
        '<option value="" selected>Selecciona un Arrendedor</option>';
      emisor_lista = datos;

      datos.forEach((opcion) => {
        let option = document.createElement("option");
        option.value = opcion.id;
        option.text = opcion.nombre;
        selectEmisor.appendChild(option);
      });
    },
    error: function (xhr, status, error) {
      console.error(error);
    },
  });
}

function llenarSelectBanco() {
  $.ajax({
    url: base_url + "Banco/listar",
    type: "GET",
    success: function (response) {
      let datos = JSON.parse(response);
      selectBanco.innerHTML =
        '<option value="" selected>Selecciona un banco</option>';

      datos.forEach((opcion) => {
        let option = document.createElement("option");
        option.value = opcion.id;
        option.text = opcion.nombre;
        selectBanco.appendChild(option);
      });
    },
    error: function (xhr, status, error) {
      console.error(error);
    },
  });
}
function llenarSelectMoneda() {
  $.ajax({
    url: base_url + "Moneda/listar",
    type: "GET",
    success: function (response) {
      let datos = JSON.parse(response);
      selectMoneda.innerHTML =
        '<option value="" selected>Selecciona una moneda</option>';

      datos.forEach((opcion) => {
        let option = document.createElement("option");
        option.value = opcion.id;
        // option.text = opcion.nombre + " - " + opcion.simbolo;
        option.text = `${opcion.nombre} - ${opcion.simbolo}`;
        selectMoneda.appendChild(option);
      });
    },
    error: function (xhr, status, error) {
      console.error(error);
    },
  });
}

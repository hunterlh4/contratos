let frm,
  input_dni,
  input_nacimiento,
  input_nombre,
  input_apellido,
  input_usuario,
  input_password,
  input_password2,
  eyeIcon1,
  eyeIcon2;
let invalidFeedback, validFeedback;

$(".pwstrength").pwstrength();
$(".pwstrength2").pwstrength();

function inicializarVariables() {
  frm = document.querySelector("#formulario");
  input_dni = document.getElementById("dni");
  input_nacimiento = document.getElementById("fecha_nacimiento");
  input_nombre = document.getElementById("nombre");
  input_apellido = document.getElementById("apellido");
  input_usuario = document.getElementById("usuario");
  input_direccion = document.getElementById("direccion");
  input_password = document.getElementById("password");
  input_password2 = document.getElementById("password2");
  invalidFeedback = document.querySelector(".dni-invalid");
  validFeedback = document.querySelector(".dni-valid");

  eyeIcon1 = document.querySelector("#password + .input-group-append button i");
  eyeIcon2 = document.querySelector(
    "#password2 + .input-group-append button i"
  );

  validarInputs();
  listarDireccion();

  frm.addEventListener("submit", function (e) {
    e.preventDefault();
    validarformulario();
  });
}

function validarInputs() {
  input_dni.addEventListener("input", function (e) {
    // Eliminar todos los caracteres que no sean números
    this.value = this.value.replace(/[^0-9]/g, "");

    // Limitar la longitud a 8 caracteres
    if (this.value.length > 8) {
      this.value = this.value.slice(0, 8);
    }
  });

  input_nombre.addEventListener("input", function (e) {
    // Eliminar todos los caracteres que no sean letras
    this.value = this.value.replace(/[^a-zA-Z\sñÑ]/g, "");

    // Convertir a mayúsculas
    this.value = this.value.toUpperCase();

    // Limitar la longitud a 40 caracteres
    if (this.value.length > 30) {
      this.value = this.value.slice(0, 30);
    }
  });

  input_apellido.addEventListener("input", function (e) {
    // Eliminar todos los caracteres que no sean letras
    this.value = this.value.replace(/[^a-zA-Z\sñÑ]/g, "");

    // Convertir a mayúsculas
    this.value = this.value.toUpperCase();

    // Limitar la longitud a 40 caracteres
    if (this.value.length > 30) {
      this.value = this.value.slice(0, 30);
    }
  });

  input_usuario.addEventListener("input", function (e) {
    // Convertir todo a minúsculas
    this.value = this.value.toLowerCase();

    // Permitir solo letras minúsculas y limitar a 16 caracteres
    this.value = this.value.replace(/[^a-z0-9ñ]/g, "").slice(0, 16);
  });

  input_usuario.addEventListener("keydown", function (e) {
    if (e.key === "Backspace") {
      return;
    }
    if (e.key === "Enter") {
      return;
    }
  });

  const fechaActual = new Date();
  const fechaMinima = new Date();
  fechaMinima.setFullYear(fechaActual.getFullYear() - 85);
  const fechaMaxima = new Date();
  fechaMaxima.setFullYear(fechaActual.getFullYear() - 17);

  const fechaMinimaFormateada = fechaMinima.toISOString().slice(0, 10);
  const fechaMaximaFormateada = fechaMaxima.toISOString().slice(0, 10);

  input_nacimiento.setAttribute("min", fechaMinimaFormateada);
  input_nacimiento.setAttribute("max", fechaMaximaFormateada);
}

function validarformulario() {
  let errores = "";
  if (input_dni.value === "") {
    errores += "Completa el campo <b>DNI</b>.<br>";
  }
  if (input_nacimiento.value === "") {
    errores += "Selecciona una <b>fecha</b>.<br>";
  }
  if (input_nombre.value === "") {
    errores += "Completa el campo <b>Nombre</b>.<br>";
  }
  if (input_apellido.value === "") {
    errores += "Completa el campo <b>Apellido</b>.<br>";
  }
  if (input_usuario.value === "") {
    errores += "Completa el campo <b>Usuario</b>.<br>";
  }
  if (input_password.value === "") {
    errores += "Completa el campo <b>Password</b>.<br>";
  }
  if (input_password2.value === "") {
    errores += "Completa el campo <b>Password Confirmation</b>.<br>";
  }
  if (input_password.value !== input_password2.value) {
    errores += "Las contraseñas no coinciden.<br>";
  }

  if (errores !== "") {
    alertas(errores, "error");
    return;
  }
  registrar(); // Llama a la función que maneja la lógica cuando el DNI es válido
}

function buscar() {
  // Validar si el DNI está vacío

  if (input_dni.value === "") {
    mostrarMensajeError(1);
    return;
  }

  // Validar si el DNI tiene exactamente 8 dígitos
  if (input_dni.value.length !== 8 || !/^\d{8}$/.test(input_dni.value)) {
    mostrarMensajeError(1);
    return;
  }

  // Si pasa las validaciones, llamar a la función AJAX
  buscardni();
}

function mostrarMensajeError(tipo) {
  if (tipo == 1) {
    alertas("Ingrese un DNI valido", "error");
  }
  if (tipo == 2) {
    alertas("DNI válido. Simulación de AJAX completada.", "success");
  }
}

function ver1() {
  
  if (input_password.type === "password") {
    input_password.type = "text";
    eyeIcon1.classList.remove("fa-eye");
    eyeIcon1.classList.add("fa-eye-slash");
  } else {
    input_password.type = "password";
    eyeIcon1.classList.remove("fa-eye-slash");
    eyeIcon1.classList.add("fa-eye");
  }
}

// Función para mostrar o ocultar contraseña 2
function ver2() {
  if (input_password2.type === "password") {
    input_password2.type = "text";
    eyeIcon2.classList.remove("fa-eye");
    eyeIcon2.classList.add("fa-eye-slash");
  } else {
    input_password2.type = "password";
    eyeIcon2.classList.remove("fa-eye-slash");
    eyeIcon2.classList.add("fa-eye");
  }
}

function listarDireccion() {
  $.ajax({
    url: base_url + "Registro/listarDireccion",
    type: "GET",

    success: function (response) {
      datos = JSON.parse(response);

      datos.forEach((opcion) => {
        // Crear un elemento de opción
        let option = document.createElement("option");
        // Establecer el valor y el texto de la opción
        option.value = opcion.did;

        if (opcion.enombre == null) {
          option.text = opcion.dnombre;
        } else {
          option.text = opcion.dnombre + " " + opcion.enombre;
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

function buscardni() {
  if (input_dni.value.length === 8) {
    const url = base_url + "Registro/obtenerDatosPorDNI/" + input_dni.value;

    $.ajax({
      url: url,
      type: "POST",
      // dataType: "json",
      success: function (response) {
        const res = JSON.parse(response);
        console.log(res);

        if (!res.apellidoPaterno || res.apellidoPaterno.length < 1) {
          Swal.fire("Aviso", "No se encontró el DNI", "error");
          input_apellido.value = "";
          input_nombre.value="";
        } else {
          let apellidoCompleto = res.apellidoPaterno.trim(); // Inicializar con apellido paterno

          if (res.apellidoMaterno && res.apellidoMaterno.length > 0) {
            apellidoCompleto += " " + res.apellidoMaterno.trim(); // Agregar apellido materno si existe
          }

          input_apellido.value = apellidoCompleto.trim();

          // Asignar el nombre completo al campo correspondiente
          input_nombre.value = res.nombres.trim();

          // Asumiendo que esto es para mostrar un mensaje de éxito o esconder el mensaje de error
        }
      },
      error: function (xhr, status, error) {
        console.log("Error al consultar y editar el DNI: ", error);
        Swal.fire(
          "Error",
          "Hubo un problema con la solicitud. Inténtalo de nuevo más tarde.",
          "error"
        );
      },
    });
  }
}

function registrar() {
  var formData = new FormData(frm);
  const url = base_url + "Registro/registrar/";
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
        frm.reset();
        resetRequiredFields();
      }
      alertas(res.message, res.icono);
      // }
      // if(res.icono=="error"){
      //   alerta(res.message,res.errors,res.icono);
      // }
      // alertas(res.message,res.icono);
    },
    error: function (xhr, status, error) {
      console.error("Error al enviar la solicitud: " + error);
    },
  });
}
function alertas(msg, icono) {
  Swal.fire("Aviso", msg, icono);
}
function alerta(titulo, msg, icono) {
  Swal.fire(titulo, msg, icono);
}

function resetRequiredFields() {
  // Obtener todos los elementos de entrada requeridos
  $("#formulario").removeClass("was-validated");
  var direccionSelect = $('#direccion');
  direccionSelect.val("").trigger('change');

  $('#pwindicator .label').text("");
  $('#pwindicator2 .label').text("");
  var pwindicator = document.getElementById("pwindicator");
  var pwindicator2 = document.getElementById("pwindicator2");

  // Eliminar todas las clases adicionales
  if (pwindicator) {
    pwindicator.className = "pwindicator"; // Asignar solo la clase base
  }
  if (pwindicator2) {
    pwindicator2.className = "pwindicator"; // Asignar solo la clase base
  }
}

document.addEventListener("DOMContentLoaded", function () {
  inicializarVariables();
});

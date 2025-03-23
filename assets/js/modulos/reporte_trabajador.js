// Variables globales
const currentYear = new Date().getFullYear();
let trabajadores = [];
let meses = [];
// Elementos del DOM
// const periodo = document.getElementById("periodo");
// const mensualElements = document.querySelectorAll(".div_mes");
// const anioElements = document.querySelectorAll(".div_anio");
// const fechasDesdeElements = document.querySelectorAll(".div_fecha_desde");
// const fechasHastaElements = document.querySelectorAll(".div_fecha_hasta");
const mesInput = document.getElementById("mes");
const anio = document.getElementById("anio");
const fechaDesdeInput = document.getElementById("fecha_desde");
const fechaHastaInput = document.getElementById("fecha_hasta");
const contenedorTrabajadores = document.querySelector(
  "#contenedor_trabajadores"
);
const tipo = document.querySelector("#tipo");
const trabajador = document.querySelector("#trabajador");

function updateVisibility() {
  // Limpiar campos antes de mostrar u ocultar elementos

  if (periodo.value === "mensual") {
    mensualElements.forEach((element) => {
      element.style.display = "block";
    });
    anioElements.forEach((element) => {
      element.style.display = "block";
    });
    fechasDesdeElements.forEach((element) => {
      element.style.display = "none";
    });
    fechasHastaElements.forEach((element) => {
      element.style.display = "none";
    });
  }
  if (periodo.value === "fechas") {
    mensualElements.forEach((element) => {
      element.style.display = "none";
    });
    anioElements.forEach((element) => {
      element.style.display = "none";
    });
    fechasDesdeElements.forEach((element) => {
      element.style.display = "block";
    });
    fechasHastaElements.forEach((element) => {
      element.style.display = "block";
    });

    // aqui ponle la fecha
    const currentDate = getCurrentDate();
    fechaDesdeInput.value = currentDate;
    fechaHastaInput.value = currentDate;
  }
}

function llenarSelectAnio() {
  anio.innerHTML = "";
  // Generate the options for current year, previous year, and year before that
  for (let i = 0; i < 4; i++) {
    const option = document.createElement("option");
    option.value = currentYear - i;
    option.textContent = currentYear - i;
    anio.appendChild(option);
  }
}
function llenarSelectMes() {
  mesInput.innerHTML = "";

  const monthNames = [
    "Enero",
    "Febrero",
    "Marzo",
    "Abril",
    "Mayo",
    "Junio",
    "Julio",
    "Agosto",
    "Septiembre",
    "Octubre",
    "Noviembre",
    "Diciembre"
  ];
  // Generate the options for current year, previous year, and year before that
  for (let i = 0; i < 12; i++) {
    const option = document.createElement("option");
    option.value = i + 1;
    option.textContent = monthNames[i];
    mesInput.appendChild(option);
  }
}
function llenarSelectTrabajador() {
  $.ajax({
    url: base_url + "Trabajador/listarActivo",
    type: "POST",

    success: function (response) {
      datos = JSON.parse(response);
      // console.log(response);
      // Limpiar el select aprobadorElement
      trabajador.innerHTML = "";
      datos.map(function (item) {
        var option = document.createElement("option");
        if (item.estado === "Inactivo") {
          option.style.color = "red";
        }
        option.value = item.id;
        if (item.tdni == null) {
          option.text = item.apellido_nombre;
        } else {
          option.text = item.apellido_nombre + " - " + item.dni;
        }
        trabajador.appendChild(option);
      });
    },
    error: function (xhr, status, error) {
      console.error(error);
    }
  });
}

function toggleTrabajadores() {
  contenedorTrabajadores.classList.add("col-md-12");
  if (tipo.value !== "detallado") {
    contenedorTrabajadores.classList.add("d-none");
    contenedorTrabajadores.classList.remove("col-md-12");
  }
  if (tipo.value === "detallado") {
    contenedorTrabajadores.classList.remove("d-none");
    contenedorTrabajadores.classList.add("col-md-12");
  }
}
function generar() {
  let trabajadores = [];
  let meses = [];

  trabajadores = Array.from(trabajador.selectedOptions).map(
    (option) => option.value
  );
  meses = Array.from(mesInput.selectedOptions).map((option) => option.value);
  const anioSeleccionado = anio.value;
  let error = false;

  if (
    (trabajadores.length == 0 || meses.length == 0 || anioSeleccionado === 0) &&
    tipo.value === "detallado"
  ) {
    error = true;
  }
  if (
    (meses.length === 0 || anioSeleccionado === 0) &&
    tipo.value === "general"
  ) {
    error = true;
  }
  if (
    (meses.length === 0 || anioSeleccionado === 0) &&
    tipo.value === "tardanza"
  ) {
    error = true;
  }

  if (error) {
    Swal.fire("Aviso", "Datos Insuficientes".toUpperCase(), "warning");
  }

  if (!error) {
    if (tipo.value === "detallado"){
      trabajadores.forEach((trabajador) => {
        // Dentro de cada trabajador, recorrer el array de meses
        meses.forEach((mes) => {
          // Imprimir trabajador, mes y año seleccionado
          $.ajax({
            url: base_url + "Reporte/generar_reporte_detallado",
            type: "POST",
            data: {
              trabajador: trabajador,
              mes: mes,
              anio: anioSeleccionado,
              tipo: tipo.value
            }, // Puedes enviar datos adicionales si es necesario
            success: function (response) {
              console.log(response);
              const datos = JSON.parse(response);

              borrarArchivo(datos);
            },
            error: function (xhr, status, error) {
              console.error(error);
            }
          });
        });
      });
    }
      
    if (tipo.value === "general" || tipo.value === "tardanza") {
      meses.forEach((mes) => {
        // Imprimir trabajador, mes y año seleccionado
        $.ajax({
          url: base_url + "Reporte/generar_reporte_general",
          type: "POST",
          data: { mes: mes, anio: anioSeleccionado, tipo: tipo.value }, // Puedes enviar datos adicionales si es necesario
          success: function (response) {
            console.log(response);
            const datos = JSON.parse(response);

            borrarArchivo(datos);
          },
          error: function (xhr, status, error) {
            console.error(error);
          }
        });
      });
    }
  }
}

function borrarArchivo(datos) {
  var link = document.createElement("a");
  link.href = base_url + datos.archivo;
  link.download = datos.nombre; // Puedes establecer un nombre para el archivo descargado aquí
  document.body.appendChild(link);
  link.click();
  document.body.removeChild(link);

  $.ajax({
    url: base_url + "Reporte/borrar",
    type: "POST",
    data: { filePath: datos.nombre },
    success: function (result) {
      console.log(result);
      if (result.status === "success") {
        console.log("Archivo eliminado:", result.message);
      }
    },
    error: function (xhr, status, error) {
      // console.error('Error:', error);
    }
  });
}

// function getCurrentDate() {
//   const date = new Date();
//   const year = date.getFullYear();
//   const month = ("0" + (date.getMonth() + 1)).slice(-2);
//   const day = ("0" + date.getDate()).slice(-2);
//   return `${year}-${month}-${day}`;
// }

document.addEventListener("DOMContentLoaded", function () {
  llenarSelectAnio();
  llenarSelectMes();
  llenarSelectTrabajador();
  toggleTrabajadores();
  // updateVisibility();
  // periodo.addEventListener("change", updateVisibility);

  // Escuchar cambios en el selector de tipo
  tipo.addEventListener("change", toggleTrabajadores);
});

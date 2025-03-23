const btnAccion = document.querySelector("#btnAccion");
// NOMBRE DE MIS INPUTS

const formulario = document.querySelector("#formulario");
const inputHiddenFile = document.querySelector("#nombreArchivoActual");
const labelFile = document.querySelector("#nombreArchivo");
const archivo = document.getElementById("archivo");

var buttons = document.querySelectorAll('button[data-toggle="collapse"]');
var collapses = document.querySelectorAll(".collapse");

const botonImportar = document.getElementById("Importar");

const loadingMessage = document.getElementById("loadingMessage");

document.addEventListener("DOMContentLoaded", function () {
  botonImportar.disabled = true;
  collapsebutton();
});

function resetFileInput() {
  archivo.value = "";
  inputHiddenFile.value = "";
  labelFile.innerHTML = "Seleccione un Archivo";
  botonImportar.disabled = true;
  $("#formulario").removeClass("was-validated");
  botonImportar.classList.replace("btn-success", "btn-secondary");
}

archivo.addEventListener("change", function (event) {
  if (!event.target.files.length) {
    // El input file está vacío, restablecer los valores
    resetFileInput();
  } else {
    // Obtener el nombre del nuevo archivo seleccionado por el usuario
    var nuevoNombreArchivo = event.target.files[0].name;
    var extension = nuevoNombreArchivo.split(".").pop().toLowerCase();

    // Actualizar el valor del campo oculto si el nombre del archivo ha cambiado
    if (extension === "csv" || extension === "xlsx") {
      inputHiddenFile.value = nuevoNombreArchivo;
      labelFile.innerHTML = nuevoNombreArchivo;
      // Habilitar el botón de importar
      botonImportar.disabled = false;
      botonImportar.classList.replace("btn-secondary", "btn-success");
    } else {
      Swal.fire("Aviso", "Tipo de archivo no válido.", "warning");
      resetFileInput();
    }
  }
});

function limpiarEncabezado(header) {
  // Mapear caracteres especiales a sus equivalentes correctos
  const caracterCorrecto = {
    á: "á",
    é: "é",
    í: "í",
    ó: "ó",
    ú: "ú",
    Á: "Á",
    É: "É",
    Í: "Í",
    Ó: "Ó",
    Ú: "Ú",
    ñ: "ñ",
    Ñ: "Ñ",
    // Puedes añadir más caracteres según tus necesidades
  };

  // Reemplazar caracteres especiales en cada elemento del encabezado
  let cleanedHeader = header.map((item) => {
    return item.replace(/[áéíóúÁÉÍÓÚñÑ]/g, (m) => caracterCorrecto[m] || m);
  });

  return cleanedHeader;
}

formulario.addEventListener("submit", function (e) {
  e.preventDefault();
  let formData = new FormData();
  let file = archivo.files[0];
  formData.append("archivo", file);

  if (!file) {
    Swal.fire(
      "Aviso",
      "Por favor, selecciona un archivo CSV o XLS".toUpperCase(),
      "warning"
    );
    return;
  }
  let extension = file.name.split(".").pop().toLowerCase();
  if (extension === "xlsx") {
    let reader = new FileReader();
    reader.onload = function (e) {
      let data = new Uint8Array(e.target.result);
      let workbook = XLSX.read(data, { type: "array" });
      let sheet = workbook.Sheets[workbook.SheetNames[0]];
      let jsonData = XLSX.utils.sheet_to_json(sheet, { header: 1 });

      // Aquí puedes trabajar con jsonData, que es un array de objetos
      // console.log(jsonData[0]);
      //   console.log(JSON.stringify(jsonData[0]));
      // let header = Object.keys(jsonData[0]); // Obtener encabezado del CSV/XLS
      let cleanedHeader = limpiarEncabezado(jsonData[0]);
      formData.append("encabezado", JSON.stringify(cleanedHeader));

      let fila_1 = jsonData[1];
      formData.append("fila_1", JSON.stringify(fila_1));
      $.ajax({
        url: base_url + "Importar/validar_archivo",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        beforeSend: function () {
          loadingMessage.style.display = "block";
          botonImportar.disabled = true;
        },
        success: function (response) {
          console.log(response);
          const res = JSON.parse(response);
          if (res.validado) {
            // cargarDatos_xlsx(file, res.tipo);
            // if (res.tipo == "frontera_2" || res.tipo == "samu_2") {
            //   cargarDatos_xlsx(file, res.tipo);
            // }
            // vertical || samu 1 igual
            if (res.tipo == "frontera_1") {
              cargarDatos_xlsx_frontera(file);
            }
            if (res.tipo == "samu_1") {
              cargarDatos_xlsx_samu(file);
            }

            // if(res.tipo=='samu_1'){
            //     cargarDatos_xlsx_vertical(file, res.tipo);
            // }
            // Llamar a sendBatch con el archivo
          } else {
            loadingMessage.style.display = "none";
            botonImportar.disabled = false;
            Swal.fire("Aviso", res.msg, "warning");
          }
        },
        error: function (xhr, status, error) {
          botonImportar.disabled = false;
          loadingMessage.style.display = "none";
          Swal.fire("Aviso", "Error al validar el archivo.", "error");
        },
      });
      // console.log(JSON.stringify(jsonData));

      // Continuar con el envío del formulario y el procesamiento en el servidor
      // Aquí puedes continuar con tu lógica de envío AJAX
    };
    reader.readAsArrayBuffer(file);
  }
  if (extension === "csv") {
    Papa.parse(file, {
      header: true,
      skipEmptyLines: true,
      // delimiter: ";",
      encoding: "UTF-8",
      complete: function (results) {
        let data = results.data;
        if (data.length === 0) {
          Swal.fire(
            "Aviso",
            "El archivo está vacío o no tiene datos válidos.",
            "warning"
          );
          return;
        }
        let header = Object.keys(data[0]); // Obtener encabezado del CSV/XLS
        let cleanedHeader = limpiarEncabezado(header);
        formData.append("encabezado", JSON.stringify(cleanedHeader)); // Enviar encabezado al servidor para validación
        // console.log(cleanedHeader)
        $.ajax({
          url: base_url + "Importar/validar_archivo",
          type: "POST",
          data: formData,
          contentType: false,
          processData: false,
          beforeSend: function () {
            loadingMessage.style.display = "block";
            botonImportar.disabled = true;
          },
          success: function (response) {
            // console.log(response);
            const res = JSON.parse(response);
            if (res.validado) {
              cargarDatos_csv(file, res.tipo); // Llamar a sendBatch con el archivo
            } else {
              loadingMessage.style.display = "none";
              botonImportar.disabled = false;
              Swal.fire("Aviso", res.msg, "warning");
            }
          },
          error: function (xhr, status, error) {
            botonImportar.disabled = false;
            loadingMessage.style.display = "none";
            Swal.fire("Aviso", "Error al validar el archivo.", "error");
          },
        });
      },
    });
  }
  if (extension === "xls") {
    Swal.fire(
      "Aviso",
      "Por favor, selecciona un archivo CSV o XLS".toUpperCase(),
      "warning"
    );
    // let reader = new FileReader();
    // reader.onload = function (e) {
    //   let data = new Uint8Array(e.target.result);
    //   let workbook = XLSX.read(data, { type: "array" });
    //   let sheet = workbook.Sheets[workbook.SheetNames[0]];
    //   let jsonData = XLSX.utils.sheet_to_json(sheet, { header: 1 });

    //   let header = jsonData[0].map((item) =>
    //     typeof item === "string" ? item : ""
    //   );
    //   let cleanedHeader = limpiarEncabezado(header);

    //   // console.log(header);
    //   // console.log(jsonData[0]);
    //   // console.log(jsonData);
    //   // console.log(JSON.stringify(jsonData[0]));
    // //   console.log(cleanedHeader);
    // };
    // reader.readAsArrayBuffer(file);
  }
});

function cargarDatos_csv(file, tipo) {
  resetProgressBar()
  let total = 0;
  let ignorado = 0;
  let aceptado = 0;
  let modificado = 0;
  let batchSize = 1000; // Número de registros por lote
  let reader = new FileReader();

  reader.onload = function (e) {
    let data = Papa.parse(e.target.result, {
      header: true,
      skipEmptyLines: true,
    }).data;

    if (data.length === 0) {
      Swal.fire(
        "Aviso",
        "El archivo está vacío o no tiene datos válidos.",
        "warning"
      );
      return;
    }
      
      let totalBatches = Math.ceil(data.length / batchSize);
    

      function sendBatch(batchNumber) {
        if (batchNumber >= totalBatches) {
          loadingMessage.style.display = "none";
          // $('#progress-container').hide();
          resetFileInput();
          Swal.fire(
            "Aviso",
            `Todos los datos han sido enviados. <br> Aceptados: ${aceptado}  <br> Modificados: ${modificado} <br> Ignorados: ${ignorado} <br>Total: ${total}`,
            "success"
          );
          // Swal.fire("Aviso", `Todos los datos han sido enviados. <br> Aceptados: ${aceptado} <br> Ignorados: ${ignorado} <br> Total: ${total}`, "success");

          return;
        }

        let start = batchNumber * batchSize;
        let end = start + batchSize;
        let batch = data.slice(start, end);
        let url = "";

        if (tipo == "asistencia_csv") {
          url = base_url + "Importar/importar_asistencia_csv";
        }
        if (tipo == "usuario_csv") {
          url = base_url + "Importar/importar_trabajador_csv";
        }
        // console.log(url);
        

        $.ajax({
          url: url,
          type: "POST",
          data: JSON.stringify(batch),
          contentType: "application/json",
          processData: false,
          beforeSend: function () {
            loadingMessage.style.display = "block";
            botonImportar.disabled = true;
            $('#progress-container').show();
          },
          success: function (response) {
            // console.log(response);
            const res = JSON.parse(response);
            console.log(res);
            total = total + res.total;
            ignorado = ignorado + res.ignorado;
            aceptado = aceptado + res.aceptado;
            modificado = modificado + res.modificado;
            updateProgress(batchNumber,totalBatches);
            // console.table(res);
            sendBatch(batchNumber + 1);
          },
          error: function (xhr, status, error) {
            botonImportar.disabled = false;
            loadingMessage.style.display = "none";
            Swal.fire("Aviso", "No se cargó correctamente.", "warning");
          },
        });
      }

      sendBatch(0); // Iniciar el envío de lotes
  };

  reader.readAsText(file);
}
// NO FUNCIONARA DE 1K EN 1K PORQUE ESTA HACIA ABAJO
function cargarDatos_xlsx_frontera(file) {
  resetProgressBar()
  let reader = new FileReader();
  let totalBatches = 0;
  let currentBatch = 0;
  
  reader.onload = function (e) {
      let data = new Uint8Array(e.target.result);
      let workbook = XLSX.read(data, { type: "array" });
      let sheet = workbook.Sheets[workbook.SheetNames[0]];
      let jsonData = XLSX.utils.sheet_to_json(sheet, { header: 1 });

      // Eliminar el encabezado
      jsonData.shift();

      if (jsonData.length === 0) {
          Swal.fire(
              "Aviso",
              "El archivo está vacío o no tiene datos válidos.",
              "warning"
          );
          return;
      }

      // Agrupar los datos por nombre y fecha con horas
      let groupedData = {};
      jsonData.forEach(row => {
          let nombre = row[1]; // Columna 2 es "nombre"
          let fechaHora = row[3]; // Columna 4 es "fecha/hora"
          let hora = obtenerHoraFormateada_frontera(fechaHora); // Obtener la hora formateada
          let fecha = obtenerFechaFormateada_frontera(fechaHora); // Obtener fecha formateada
          let numero = row[2]; // Columna 3 es "Nro."

          if (!groupedData[nombre]) {
              groupedData[nombre] = {};
          }

          if (!groupedData[nombre][fecha]) {
              groupedData[nombre][fecha] = {
                  "Nombre": nombre,
                  "Fecha": fecha,
                  "Horas": [],
                  "Nro.": numero
              };
          }

          groupedData[nombre][fecha].Horas.push(hora);
      });

      // Convertir el objeto agrupado en un array de lotes para enviar
      let batches = [];
      Object.keys(groupedData).forEach(nombre => {
          let persona = {
              "Nombre": nombre,
              "Fechas": []
          };

          Object.keys(groupedData[nombre]).forEach(fecha => {
              let datosFecha = groupedData[nombre][fecha];
              persona.Fechas.push({
                  "Fecha": datosFecha.Fecha,
                  "Horas": datosFecha.Horas,
                  "Nro.": datosFecha["Nro."]
              });
          });

          batches.push(persona);
      });

      totalBatches = batches.length;

      function sendBatch(batchIndex) {
          if (batchIndex >= batches.length) {
              // console.log(contador)
              loadingMessage.style.display = "none";
              resetFileInput();
              Swal.fire("Aviso", "Todos los datos han sido enviados.", "success");
              return;
          }

          let batch = batches[batchIndex];

          $.ajax({
              url: base_url + "Importar/importar_asistencia_frontera/",
              type: "POST",
              data: JSON.stringify(batch.Fechas),
              contentType: "application/json",
              processData: false,
              beforeSend: function () {
                  loadingMessage.style.display = "block";
                  $('#progress-container').show();
                 
              },
              success: function (response) {
                  // console.log('Envío exitoso para Nombre: ' + batch.Nombre);
                  // contador++;
                  // console.log(response);
                  const res = JSON.parse(response);
                  updateProgress(batchIndex, totalBatches);
                  // console.table(res);
                  sendBatch(batchIndex + 1); // Envía el siguiente lote después de que el actual se haya enviado con éxito
              },
              error: function (xhr, status, error) {
                  resetFileInput();
                  loadingMessage.style.display = "none";
                  Swal.fire("Aviso", "No se cargó correctamente para Nombre: " + batch.Nombre, "warning");
              },
          });
      }

      sendBatch(0); // Iniciar el envío de lotes agrupados por nombre y fecha
  };
  reader.readAsArrayBuffer(file);
}

function cargarDatos_xlsx_samu(file) {
  resetProgressBar()
  let contador =0;
  let reader = new FileReader();
  reader.onload = function (e) {
      let data = new Uint8Array(e.target.result);
      let workbook = XLSX.read(data, { type: "array" });
      let sheet = workbook.Sheets[workbook.SheetNames[0]];
      let jsonData = XLSX.utils.sheet_to_json(sheet, { header: 1 });

      // Eliminar el encabezado
      jsonData.shift();

      if (jsonData.length === 0) {
          Swal.fire(
              "Aviso",
              "El archivo está vacío o no tiene datos válidos.",
              "warning"
          );
          return;
      }

      // Agrupar los datos por nombre y fecha con horas
      let groupedData = {};
      jsonData.forEach(row => {
          let nombre = row[1]; // Columna 2 es "nombre"
          let fechaHora = row[3]; // Columna 4 es "fecha/hora"
          // let hora = fechaHora.split(' ')[1]; // Obtener la hora
          let hora =  obtenerHoraFormateada_samu(fechaHora);
          let fecha = obtenerFechaFormateada_samu(fechaHora); // Obtener fecha formateada
          let numero = row[2]; // Columna 3 es "Nro."

          if (!groupedData[nombre]) {
              groupedData[nombre] = {};
          }

          if (!groupedData[nombre][fecha]) {
              groupedData[nombre][fecha] = {
                  "Nombre": nombre,
                  "Fecha": fecha,
                  "Horas": [],
                  "Nro.": numero
              };
          }

          groupedData[nombre][fecha].Horas.push(hora);
      });

      // Convertir el objeto agrupado en un array de lotes para enviar
      let batches = [];
      Object.keys(groupedData).forEach(nombre => {
          let persona = {
              "Nombre": nombre,
              "Fechas": []
          };

          Object.keys(groupedData[nombre]).forEach(fecha => {
              let datosFecha = groupedData[nombre][fecha];
              persona.Fechas.push({
                  "Fecha": datosFecha.Fecha,
                  "Horas": datosFecha.Horas,
                  "Nro.": datosFecha["Nro."],
                  "nombre":datosFecha.Nombre
              });
          });

          batches.push(persona);
      });

      function sendBatch(batchIndex) {
          if (batchIndex >= batches.length) {
              loadingMessage.style.display = "none";
              // console.log(contador);
              resetFileInput();
              Swal.fire("Aviso", "Todos los datos han sido enviados.", "success");
              return;
          }

          let batch = batches[batchIndex];
          // console.log(JSON.stringify(batch.Fechas));
          $.ajax({
              url: base_url + "Importar/importar_asistencia_samu/",
              type: "POST",
              data: JSON.stringify(batch.Fechas),
              contentType: "application/json",
              processData: false,
              beforeSend: function () {
                  loadingMessage.style.display = "block";
                  $('#progress-container').show();
              },
              success: function (response) {
                  // console.log('Envío exitoso para Nombre: ' + batch.Nombre);
                  // contador++;
                  // console.log(response);
                  const res = JSON.parse(response);
                  // console.table(res);
                  sendBatch(batchIndex + 1); // Envía el siguiente lote después de que el actual se haya enviado con éxito
                  updateProgress(batchIndex, batches.length);
                },
              error: function (xhr, status, error) {
                  resetFileInput();
                  loadingMessage.style.display = "none";
                  Swal.fire("Aviso", "No se cargó correctamente para Nombre: " + batch.Nombre, "warning");
              },
          });
      }

      sendBatch(0); // Iniciar el envío de lotes agrupados por nombre y fecha
  };
  reader.readAsArrayBuffer(file);
}

function cargarDatos_xlsx_vertical(file, tipo) {
  let reader = new FileReader();
  reader.onload = function (e) {
    let data = new Uint8Array(e.target.result);
    let workbook = XLSX.read(data, { type: "array" });
    let sheet = workbook.Sheets[workbook.SheetNames[0]];
    let jsonData = XLSX.utils.sheet_to_json(sheet, { header: 1 });

    // Eliminar el encabezado
    jsonData.shift();

    if (jsonData.length === 0) {
      Swal.fire(
        "Aviso",
        "El archivo está vacío o no tiene datos válidos.",
        "warning"
      );
      return;
    }

    let batchSize = 1000; // Número de registros por lote
    let totalBatches = Math.ceil(jsonData.length / batchSize);

    function sendBatch(batchNumber) {
      if (batchNumber >= totalBatches) {
        loadingMessage.style.display = "none";
        resetFileInput();
        Swal.fire("Aviso", "Todos los datos han sido enviados.", "success");
        return;
      }

      let start = batchNumber * batchSize;
      let end = start + batchSize;
      let batch = jsonData.slice(start, end);

      $.ajax({
        url: base_url + "Importar/importar_nuevo/" + tipo,
        type: "POST",
        data: JSON.stringify(batch),
        contentType: "application/json",
        processData: false,
        beforeSend: function () {
          loadingMessage.style.display = "block";
          //   botonImportar.disabled = true;
        },
        success: function (response) {
          const res = JSON.parse(response);
          // console.log(res);
          sendBatch(batchNumber + 1);
        },
        error: function (xhr, status, error) {
          resetFileInput();
          loadingMessage.style.display = "none";
          Swal.fire("Aviso", "No se cargó correctamente.", "warning");
        },
      });
    }

    sendBatch(0); // Iniciar el envío de lotes
  };
  reader.readAsArrayBuffer(file);
}

function collapsebutton() {
  buttons.forEach(function (button) {
    button.addEventListener("click", function () {
      var target = document.querySelector(this.dataset.target);

      // Cierra todos los paneles excepto el seleccionado
      collapses.forEach(function (collapse) {
        if (collapse !== target) {
          $(collapse).collapse("hide");
        }
      });

      // Abre el panel seleccionado
      $(target).collapse("toggle");
    });
  });
}


function obtenerHoraFormateada_samu(fechaHora) {
  let partes = fechaHora.split(" ");
  let hora = partes[1];
  let periodo = partes[2];

  if (periodo === "AM" || periodo === "am") {
    let horaPartes = hora.split(":");
    let horas = horaPartes[0].padStart(2, '0');
    let minutos = horaPartes[1].padStart(2, '0');
    let segundos = horaPartes[2].padStart(2, '0');
    // return horas + ":" + minutos + ":" + segundos;
    return horas + ":" + minutos + ":00";
  } else if (periodo === "PM" || periodo === "pm") {
    let horaPartes = hora.split(":");
    let horas = parseInt(horaPartes[0]);
    if (horas === 12) {
      horas = horas.toString().padStart(2, '0');
    } else {
      horas = (horas + 12).toString().padStart(2, '0');
    }
    let minutos = horaPartes[1].padStart(2, '0');
    let segundos = horaPartes[2].padStart(2, '0');
    // return horas + ":" + minutos + ":" + segundos;
    return horas + ":" + minutos + ":00";
  }
}

function obtenerHoraFormateada_frontera(fechaHora) {
  let partes = fechaHora.split(" ");
  let horaCompleta = partes[1]; // Obtener la parte de la hora
  let horaPartes = horaCompleta.split(":");

  // Asegurar que la hora tenga el formato HH:MM:00
  let horas = horaPartes[0].padStart(2, '0');
  let minutos = horaPartes[1].padStart(2, '0');
  let segundos = '00';

  return `${horas}:${minutos}:${segundos}`;
}

function updateProgress(batchNumber, totalBatches) {
  let progress = Math.min(100, ((batchNumber + 1) / totalBatches) * 100);
  $('.progress-bar').css('width', progress + '%').attr('aria-valuenow', progress);
  $('#progress-text').text(progress.toFixed(2) + '%');

  console.log(`Progreso actual: ${progress.toFixed(2)}% - Batch ${batchNumber + 1} de ${totalBatches}`);
}

function resetProgressBar() {
  $('.progress-bar').css('width', '0%').attr('aria-valuenow', 0);
  $('#progress-text').text('0%');
}
function obtenerFechaFormateada_frontera(fechaHora) {
  let partesFechaHora = fechaHora.split(" ");
  let fechaPartes = partesFechaHora[0].split("/");

  if (fechaPartes.length === 3) {
    // Formato DD/MM/YYYY
    let dia = fechaPartes[0].padStart(2, "0");
    let mes = fechaPartes[1].padStart(2, "0");
    let anio = fechaPartes[2];
    return `${anio}-${mes}-${dia}`;
  } else {
    // Otro formato de fecha, devolver tal cual
    return fechaHora;
  }
}
function obtenerFechaFormateada_samu(fechaHora) {
  let partes = fechaHora.split(" ");
  let fechaPartes = partes[0].split("-");

  if (fechaPartes.length === 3) {
    // Formato DD-mmm-YY
    let dia = fechaPartes[0];
    let mes = obtenerNumeroMes(fechaPartes[1]);
    let anio = "20" + fechaPartes[2]; // Suponiendo que siempre es 20YY
    return anio + "-" + mes + "-" + dia;
  } else {
    // Formato YYYY-MM-DD
    return partes[0];
  }
}

function obtenerNumeroMes(mesAbreviado) {
  let meses = {
    "ene": "01", "feb": "02", "mar": "03", "abr": "04", "may": "05", "jun": "06",
    "jul": "07", "ago": "08", "sep": "09", "oct": "10", "nov": "11", "dic": "12"
  };
  return meses[mesAbreviado.toLowerCase()];
}
// Llamar a la función cuando se abre el modal
function abrirModal() {
  myModal.show();
}

// Función para cerrar el modal
function cerrarModal() {
  myModal.hide();
}

const meses = {
  January: "Enero",
  February: "Febrero",
  March: "Marzo",
  April: "Abril",
  May: "Mayo",
  June: "Junio",
  July: "Julio",
  August: "Agosto",
  September: "Septiembre",
  October: "Octubre",
  November: "Noviembre",
  December: "Diciembre",
};
const dayNames = [
  "Lunes",
  "Martes",
  "Miércoles",
  "Jueves",
  "Viernes",
  "Sábado",
  "Domingo",
];

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
  "Diciembre",
];

const events = [
  // {
  //   // title: "All Day Event",
  //   start: "2024-07-01 16:00:00",
  //   end: "2024-07-01 17:00:00",
  //   backgroundColor: "#f96472", // Rojo oscuro pastel
  // },
  // {
  //   // title: "Long Event",
  //   start: "2024-07-07 10:00:00",
  //   end: "2024-07-07 11:00:00",
  //   backgroundColor: "#f9a072", // Naranja oscuro pastel
  // },
  // {
  //   // title: "Repeating Event",
  //   start: "2024-07-09 12:00:00",
  //   end: "2024-07-09 13:00:00",
  //   backgroundColor: "#f91A72", // Amarillo oscuro pastel
  // },
  // {
  //   // title: "Repeating Event",
  //   start: "2024-07-16 12:00:00",
  //   end: "2024-07-16 13:00:00",
  //   backgroundColor: "#72f984", // Verde oscuro pastel
  // },
  // {
  //   // title: "Conference",
  //   start: "2024-07-11 16:00:00",
  //   end: "2024-07-13 17:00:00",
  //   backgroundColor: "#72c9f9", // Azul oscuro pastel
  // },
  // {
  //   // title: "Meeting",
  //   start: "2024-07-12 10:30:00",
  //   end: "2024-07-12 12:30:00",
  //   backgroundColor: "#f972d4", // Rosa oscuro pastel
  // },
  // {
  //   // title: "Lunch",
  //   start: "2024-07-12 12:00:00",
  //   end: "2024-07-12 12:00:00",
  //   backgroundColor: "#f99772", // Durazno oscuro pastel
  // },
  // {
  //   // title: "Meeting",
  //   start: "2024-07-12 14:30:00",
  //   end: "2024-07-12 14:30:00",
  //   backgroundColor: "#f9d772", // Amarillo claro oscuro pastel
  // },
  //   {
  //     // title: "Dinner",
  //     start: "2024-07-12 01:00:00",
  //     end: "2024-07-12 01:01:00",
  //   },
  //   {
  //     // title: "Happy Hour",
  //     start: "2024-07-12 01:30:00",
  //     end: "2024-07-12 02:30:00",
  //   },
  //   {
  //     // title: "Birthday Party",
  //     start: "2024-07-13 07:00:00",
  //     end: "2024-07-13 07:00:00",
  //   },
  //   {
  //     title: "Click for Google",
  //     url: "http://google.com/",
  //     start: "2024-07-28",
  //     // editable: opcion === "bien" ? true : false,
  //   },
];
const Toast = Swal.mixin({
  toast: true,
  position: "top-end",
  showConfirmButton: false,
  timer: 1800,
  timerProgressBar: true,
  didOpen: (toast) => {
    toast.onmouseenter = Swal.stopTimer;
    toast.onmouseleave = Swal.resumeTimer;
    //   console.log(Swal.timerProgressBar);
  },
});

let calendario = document.getElementById("Calendario");
const titleModal = document.querySelector("#titleModal");
const myModal = new bootstrap.Modal(document.getElementById("nuevoModal"));
const btnAccion = document.querySelector("#btnAccion");
const frm = document.querySelector("#formulario");
// formulario
let input_id = document.querySelector("#id");
const input_nombre = document.querySelector("#nombre");
const input_fecha_inicio = document.querySelector("#fecha_inicio");
const input_hora_desde = document.querySelector("#hora_desde");
const input_hora_hasta = document.querySelector("#hora_hasta");
const h1_hora_extra = document.getElementById("total_duracion");
// const input_fecha_fin = document.querySelector("#fecha_fin");
const input_tipo = document.querySelector("#tipo");
// const input_descripcion = document.querySelector("#descripcion");
const radioTrue = document.getElementById("radio-true");
const radioFalse = document.getElementById("radio-false");
const select1 = document.getElementById("trabajador");
const myModalDelete = new bootstrap.Modal(document.getElementById("borrar"));
let tiempo = "";
let max_tiempo ="";
let min_tiempo ="";

let year = new Date().getFullYear();
input_fecha_inicio.setAttribute("min", year + "-01-01");
input_fecha_inicio.setAttribute("max", year + "-12-31");

// input_fecha_fin.setAttribute("min", year + "-01-01");
// input_fecha_fin.setAttribute("max", year + "-12-31");

function llenarTrabajadores() {
  const url = base_url + `Api/listarTrabajadoresActivos`;
  $.ajax({
    data: [],
    url: url,
    type: "post",
    beforeSend: function () {
      // console.log('procesando');
    },
    success: function (response) {
      const res = JSON.parse(response);
      res.forEach((opcion) => {
        // Crear un elemento de opción
        let option = document.createElement("option");
        // Establecer el valor y el texto de la opción

        option.value = opcion.id;
        if (opcion.dni == null) {
          option.text = opcion.apellido_nombre;
        } else {
          option.text = opcion.apellido_nombre + " - " + opcion.dni;
        }
        // Agregar la opción al select
        select1.appendChild(option);
      });
    },
  });
}

function llenarCalendario(selectedValue) {
  const datos = [];
  const id = selectedValue;

  const url = base_url + `HoraExtra/listar`;
  var parametros = {
    id: id,
  };
  $.ajax({
    data: parametros,
    url: url,
    type: "post",
    beforeSend: function () {
      // console.log('procesando');
    },
    success: function (response) {
      const res = JSON.parse(response);
      // console.table(res);
      // const horasExtraDisponibles = res.horasExtraDisponibles;
      // console.log("Horas extra disponibles:", horasExtraDisponibles);
      
     
      tiempo = res.horasExtraDisponibles.horas_extra_disponibles || "00:00";
      min_tiempo = res.horasExtraDisponibles.min_fecha_desde || "2024-08-01";
      max_tiempo = res.horasExtraDisponibles.max_fecha_hasta || "2024-08-01";
    

      // Asegúrate de que 'tiempo' sea una cadena
      tiempo = String(tiempo);

      let formattedTiempo;

      if (tiempo.includes("-")) {
        // Si contiene un negativo, ajusta el formato
        let parts = tiempo.split(":");
        formattedTiempo = `-${parts[0]}:${parts[1].replace("-", "")}`;
      } else {
        // Si no contiene un negativo, usa el tiempo directamente
        formattedTiempo = tiempo;
      }
      
      h1_hora_extra.innerHTML = `Tiempo: ${formattedTiempo}`;
     
      const listaDatos = res.listaDatos;

      listaDatos.forEach((valores) => {
        const evento = {
          title: valores.diferencia,
          start: valores.desde,
          end: valores.hasta,
          id: valores.id,
          tipo: valores.tipo,

          estado: valores.estado,

          allDay: false,
          backgroundColor:
            valores.tipo_consulta === "aumentar"
              ? "#229954"
              : valores.tipo_consulta === "restar"
              ? "#5499C7"
              : valores.tipo_consulta === "usado"
              ? "#5499C7"
              : undefined,
        }; //#5499C7 #F39C12 #27AE60
        // 27AE60 verde
        // 5499C7 azul
        //  F39C12 naranja
        // #E74C3C rojo
        datos.push(evento);
      });

      $("#Calendario").fullCalendar("removeEvents");
      $("#Calendario").fullCalendar("addEventSource", datos);

      // Refresca el calendario para mostrar los nuevos eventos
      $("#Calendario").fullCalendar("refetchEvents");
    },
  });

  // const calendar = $("#Calendario").fullCalendar({

  //   function showContextMenu(e, event) {
  //     var contextMenu = $("#eventContextMenu");
  //     var editMenuItem = contextMenu.find("#editEvent");
  //     var deleteMenuItem = contextMenu.find("#deleteEvent");

  //     if (event.tipo === "feriado") {
  //       editMenuItem.show();
  //       deleteMenuItem.hide();
  //     } else if (event.tipo === "compensable") {
  //       editMenuItem.show();
  //       deleteMenuItem.show();
  //     }

  //     // Position the context menu
  //     contextMenu
  //       .css({
  //         top: e.pageY || e.originalEvent.touches[0].pageY,
  //         left: e.pageX || e.originalEvent.touches[0].pageX,
  //       })
  //       .show();

  //     // Handle menu item clicks
  //     $("#editEvent")
  //       .off("click")
  //       .on("click", function () {
  //         $("#eventContextMenu").hide();
  //         // Call your function to edit the event
  //         abrirModal(2, event);
  //       });

  //     $("#deleteEvent")
  //       .off("click")
  //       .on("click", function () {
  //         $("#eventContextMenu").hide();
  //         // Call your function to delete the event
  //         deleteEvent(event);
  //         myModalDelete.show();
  //       });
  //   }

  //   $(document).click(function(e) {
  //     // Hide the context menu if the click is outside of it
  //     if (!$(e.target).closest('#eventContextMenu').length) {
  //         $('#eventContextMenu').hide();
  //     }
  // });

  //   var longPressTimer;

  //   function startLongPressTimer(touch, event) {
  //     longPressTimer = setTimeout(function () {
  //       showContextMenu(touch, event);
  //     }, 800); // 800ms long press duration
  //   }

  //   function clearLongPressTimer() {
  //     clearTimeout(longPressTimer);
  //   }
  function deleteEvent(event) {
    // Your existing code to delete the event
    // myModalDelete.show();

    // console.log('Deleting event:', event.id);
    // $('#calendar').fullCalendar('removeEvents', event._id);
    $("#deleteEventBtn").click(function () {
      // console.log('Delete button clicked for event id:', event.id);

      const url = base_url + "Festividades/eliminar/" + event.id;
      $.ajax({
        data: [], //datos que se envian a traves de ajax
        url: url, //archivo que recibe la peticion
        type: "POST", //método de envio
        success: function (response) {
          console.log(response);
          const res = JSON.parse(response);
          Toast.fire({
            icon: res.icono,
            title: res.msg,
          });

          myModalDelete.hide();

          MostrarCalendario();
        },
      });
    });
  }
}
function mostrarCalendario() {
  const fechaActual = new Date();
  const añoActual = fechaActual.getFullYear();
  // const añoActual = 2025;
  const fechaInicio = añoActual + "-01-01"; // Primero de enero del año actual
  const fechaFin = añoActual + 1 + "-01-01"; // Primer día del próximo año

  const calendar = $("#Calendario").fullCalendar({
    // calendario.fullCalendar({
    editable: false,
    selectable: true,
    height: "auto",
    defaultView: "month",
    firstDay: 1,
    // initialView: 'dayGridMonth',
    defaultView: "month",
    height: "auto",
    dayMaxEventRows: true, // Habilita la limitación de filas de eventos por día
    dayMaxEvents: 3,
    showNonCurrentDates: true,
    events: [],
    timeFormat: "H:mm",
    displayEventTitle: true,
    displayEventTime: true, // Oculta la hora del evento
    displayEventEnd: true, // Oculta el fin del evento
    header: {
      left: "prev,next today",
      center: "title",
      // right: "month,agendaWeek,agendaDay,listMonth",
      right: "month,listMonth",
    },

    validRange: {
      start: fechaInicio,
      end: fechaFin,
    },
    events: events,
    eventClick: function (calEvent, jsEvent, view) {
      // console.log(calEvent.id);
      // console.log('editar');
      // const tipo = 1;

      abrirModal(2, calEvent);

      // console.log(calEvent.start.format('YYYY-MM-DD'))
    },
    dayClick: function (date, jsEvent, view) {
      let eventsOnDay = $("#Calendario").fullCalendar(
        "clientEvents",
        function (event) {
          return moment(event.start).isSame(date, "day");
        }
      );

      // Si hay eventos en el día, seleccionar el primer evento
      if (eventsOnDay.length > 0) {
        let calEvent = eventsOnDay[0];

        abrirModal(2, calEvent);

        return;
      }

      abrirModal(1, null, date);
    },

    dayRender: function (date, cell) {
      cell.bind("contextmenu", function (e) {
        e.preventDefault();
        showContextMenu(e, date);
      });
    },

    viewRender: function (view, element) {
      // console.log('se hizo cambio')
      // cambiarIdiomaCalendario();
      var mesActual = view.intervalStart.month();
      var añoActual = view.intervalStart.year();
      var nombremes = monthNames[mesActual];
      // CAMBIAR NOMBRE DEL MES
      $(".fc-center").html("<h2>" + nombremes + " " + añoActual + "</h2>");
      // CAMBIAR NOMBRE DEL DIA

      $(".fc-day-header").each(function (index) {
        $(this).text(dayNames[index]);
      });

      $(".fc-list-heading-alt").each(function (index) {
        $(this).text(dayNames[index]);
      });

      $(".fc-list-heading-main").each(function () {
        var texto = $(this).text();
        for (var mesIngles in meses) {
          if (texto.includes(mesIngles)) {
            var mesEspañol = meses[mesIngles];
            $(this).text(texto.replace(mesIngles, mesEspañol));
          }
        }
      });
      $(".fc-list-empty").text("No hay eventos para mostrar");

      $(".fc-month-button").text("Mes");
      $(".fc-today-button").text("Ahora");
    },
    eventAfterRender: function (event, element, view) {
      $(".fc-time").each(function () {
        $(this).empty(); // Elimina todo el contenido del elemento
      });
    },
    // eventDrop: function(event, delta, revertFunc, jsEvent, ui, view) {
    //     handleEventChange(event);
    //     console.log(event)
    // },
    // eventResize: function(event, delta, revertFunc, jsEvent, ui, view) {
    //     handleEventChange(event);
    // },

    // eventRender: function (event, element) {
    //   element.bind("contextmenu", function (e) {
    //     e.preventDefault();
    //     showContextMenu(e, event);
    //   });

    //   element.on("touchstart", function (e) {
    //     var touch = e.originalEvent.touches[0];
    //     startLongPressTimer(touch, event);
    //   });

    //   element.on("touchend touchmove", function (e) {
    //     clearLongPressTimer();
    //   });
    // },
  });
}

function abrirModal(tipo, calEvent = null, date = null) {
  // crear
  if (tipo == 1 && date) {
    frm.reset();
    resetRequiredFields();
    btnAccion.textContent = "Registrar";
    titleModal.textContent = "Crear Evento";
    input_id.value = null;
    input_tipo.value = "";
    let fechaFormateada = date.format("YYYY-MM-DD");
    input_fecha_inicio.value = fechaFormateada;
    // input_fecha_fin.value = fechaFormateada;
    // console.log(date.format('DD-MM-YYYY'));
    document.querySelector("#radio-true").checked = true;
    document.querySelectorAll("#estado-grupo").forEach((element) => {
      element.style.display = "none";
    });
  }
  // editar
  if (tipo == 2 && calEvent) {
    frm.reset();
    resetRequiredFields();
    btnAccion.textContent = "Actualizar";
    titleModal.textContent = "Actualizar Calendario";
    let id = calEvent.id;
    const url = base_url + `HoraExtra/editar/${id}`;
    $.ajax({
      data: [],
      url: url,
      type: "post",
      beforeSend: function () {
        // console.log('procesando');
      },
      success: function (response) {
        const res = JSON.parse(response);
        input_id.value = res.id;
        input_fecha_inicio.value = res.fecha_desde;
        input_hora_desde.value = res.hora_desde;
        input_hora_hasta.value = res.hora_hasta;
        input_tipo.value = res.tipo;

        // console.log(input_fecha_inicio.value,
        //   input_hora_desde.value,
        //   input_hora_hasta.value,
        //   input_tipo.value)

        if (res.estado == "Activo") {
          radioTrue.checked = true;
          radioFalse.checked = false;
        } else {
          radioFalse.checked = true;
          radioTrue.checked = false;
        }
        document.querySelectorAll("#estado-grupo").forEach((element) => {
          element.style.display = "block";
        });
      },
    });

    //
    // // input_nombre.value = calEvent.title;

    // let fechaFormateada_inicio = calEvent.start.format("YYYY-MM-DD");
    // let desde = calEvent.start.format("HH:mm");
    // let hasta = calEvent.end.format("HH:mm");

    // // console.log(calEvent.start,calEvent.end)
    // input_hora_desde.value = desde;
    // input_hora_hasta.value = hasta;

    // // let fechaFormateada_fin = calEvent.end
    // //   .clone()
    // //   .subtract(1, "day")
    // //   .format("YYYY-MM-DD"); // Resta 1 día a la fecha de fin

    // input_fecha_inicio.value = fechaFormateada_inicio;
    // input_tipo.value = calEvent.tipo;

    // document.querySelectorAll("#estado-grupo").forEach((element) => {
    //   element.style.display = "block";
    // });
  }

  myModal.show();

  $("#nuevoModal").on("shown.bs.modal", function () {
    // input_hora_desde.focus();
  });
}

function resetRequiredFields() {
  // Obtener todos los elementos de entrada requeridos
  $("#formulario").removeClass("was-validated");
}

function cerrarModal() {
  myModal.hide();
}

function cerrarModalBorrar() {
  myModalDelete.hide();
}

frm.addEventListener("submit", function (e) {
  e.preventDefault();

  let data = new FormData(this);
  data.append("trabajador_id", select1.value);
  data.append("tiempo_usable", tiempo);
  data.append("min_tiempo", min_tiempo);
  data.append("max_tiempo", max_tiempo);
  console.log(tiempo);
  const url = base_url + "HoraExtra/actualizar";

  // let fechaInicio = data.get('fecha_inicio'); // Formato YYYY-MM-DD

  // var parametros = {
  //     id: data.get('id'),
  //     fecha_desde : data.get('fecha_inicio'),
  //     fecha_hasta :
  //     tipo : data.get('tipo'),
  //     desde: data.get('hora_desde'),
  //     hasta: data.get('hora_desde'),
  //     estado:data.get('estado'),
  //   };

  $.ajax({
    url: url,
    method: "POST",
    data: data,
    processData: false,
    contentType: false,
    beforeSend: function () {
      // console.log('procesando');
    },
    success: function (response) {
      // console.log(response);
      const res = JSON.parse(response);
      Toast.fire({
        icon: res.icono,
        title: res.msg,
      });
      if (res.icono == "success") {
        frm.reset();
        cerrarModal();
        llenarCalendario(select1.value);
      }
    },
  });
});

document.addEventListener("DOMContentLoaded", function () {
  llenarTrabajadores();
  mostrarCalendario();
  $("#trabajador").on("change", function () {
    // Obtiene el valor seleccionado del select
    var selectedValue = $(this).val();
    // Muestra el valor en la consola
    if (selectedValue > 1) {
      var currentDate = $("#myEvent").fullCalendar("getDate");
      // var currentMonth = currentDate.month() + 1; // Sumamos 1 porque los meses son indexados desde 0
      // var currentYear = currentDate.year();

      llenarCalendario(selectedValue);
      //   testing(selectedValue)
      // console.log(selectedValue);
    }
  });
});

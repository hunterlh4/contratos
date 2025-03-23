let calendario = document.getElementById('Calendario');
const titleModal = document.querySelector("#titleModal");
const myModal = new bootstrap.Modal(document.getElementById("nuevoModal"));
const btnAccion = document.querySelector("#btnAccion");
const frm = document.querySelector("#formulario");
// formulario
let input_id = document.querySelector("#id");
const input_nombre = document.querySelector("#nombre");
const input_fecha_inicio = document.querySelector("#fecha_inicio");
const input_fecha_fin = document.querySelector("#fecha_fin");
const input_tipo = document.querySelector("#tipo");
const input_descripcion = document.querySelector("#descripcion");
const radioTrue = document.getElementById('radio-true');
const radioFalse = document.getElementById('radio-false');

const myModalDelete = new bootstrap.Modal(document.getElementById("borrar"));

let year = new Date().getFullYear();
input_fecha_inicio.setAttribute("min", year + "-01-01");
input_fecha_inicio.setAttribute("max", year + "-12-31");

input_fecha_fin.setAttribute("min", year + "-01-01");
input_fecha_fin.setAttribute("max", year + "-12-31");

const dayNames2 = {
    Sunday: "Domingo",
    Monday: "Lunes",
    Tuesday: "Martes",
    Wednesday: "Miércoles",
    Thursday: "Jueves",
    Friday: "Viernes",
    Saturday: "Sábado",
    Sun: "Domingo",
    Mon: "Lunes",
    Tue: "Martes",
    Wed: "Miércoles",
    Thu: "Jueves",
    Fri: "Viernes",
    Sat: "Sábado",
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
    }
  });



function obtenerNumeroMes(nombreMes) {
    return monthNames.findIndex(mes => mes === nombreMes) + 1;
}

function MostrarCalendario(){
    const datos = [];

    const fechaActual = new Date();
    const añoActual = fechaActual.getFullYear();
    // const añoActual = 2025;
    const fechaInicio = añoActual + '-01-01'; // Primero de enero del año actual
    const fechaFin = (añoActual + 1) + '-01-01'; // Primer día del próximo año


    const url = base_url + "Festividades/listar";
    $.ajax({
        data: [], //datos que se envian a traves de ajax
        url: url, //archivo que recibe la peticion
        type: "post", //método de envio
        beforeSend: function () {
          // console.log('procesando');
        },
        success: function (response) {
            const res = JSON.parse(response);
            

            res.forEach(valores => {
                let diaFormateado = String(valores.dia_inicio).padStart(2, '0');
                let mesFormateado = String(valores.mes_inicio).padStart(2, '0');

                let diaFormateado_2 = String(valores.dia_fin).padStart(2, '0');
                let mesFormateado_2 = String(valores.mes_fin).padStart(2, '0');
                // let fechaFormateada = mesFormateado + '-' + diaFormateado;
                // const fecha = añoActual +'-'+ valores.mes+'-'+ valores.dia;
                const fecha_inicio = añoActual +'-'+ mesFormateado+'-'+ diaFormateado;
                // const fecha_fin = añoActual +'-'+ mesFormateado_2+'-'+ diaFormateado_2;
                let fecha_fin = new Date(añoActual, parseInt(mesFormateado_2) - 1, parseInt(diaFormateado_2));
                // Añadir un día a la fecha de finalización
                fecha_fin.setDate(fecha_fin.getDate() + 1);
                

                // console.log(fecha_inicio,fecha_fin);
                // const fecha = '2024-06-12';
                const evento = {
                    title: valores.nombre,
                    start: fecha_inicio,
                    end: fecha_fin,
                    id: valores.id,
                    tipo:valores.tipo,
                    descripcion:valores.descripcion,
                    estado:valores.estado,
                    
                    allDay: true,
                    backgroundColor: valores.tipo === 'feriado' ? '#E74C3C' : (valores.tipo === 'compensable' ? '#2F89C5' : undefined)
                };                                              //#5499C7 #F39C12 #27AE60
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
    // console.log(datos);

   


   const calendar = $("#Calendario").fullCalendar({
    // calendario.fullCalendar({
        selectable: true,
        editable: false,
       
        locale: 'es',
        firstDay: 1,
        
        // initialView: 'dayGridMonth',
        defaultView: "month",
        height: 'auto',
        showNonCurrentDates: true,
        events: datos,
        header: {
            right: "prev,next today",
            center: "title",
            left: "",
        },
        validRange: {
            start: fechaInicio,
            end: fechaFin
        },
        eventClick: function (calEvent, jsEvent, view) {
            // console.log(calEvent.id);
            // console.log('editar');
            // const tipo = 1;
           
            if(nivel_session==1 || nivel_session==100){
                abrirModal(2, calEvent);
            }
            // console.log(calEvent.start.format('YYYY-MM-DD'))
        },
        dayClick: function(date, jsEvent, view) {
       
            let eventsOnDay = $('#Calendario').fullCalendar('clientEvents', function(event) {
                return moment(event.start).isSame(date, 'day');
            });
    
            // Si hay eventos en el día, seleccionar el primer evento
            if (eventsOnDay.length > 0) {
                let calEvent = eventsOnDay[0];
                if(nivel_session == 1 || nivel_session==100){
                    abrirModal(2, calEvent);
                }
                return;
            }
    
    
            if(nivel_session==1 || nivel_session==100){
                abrirModal(1, null, date);
            }
           
        },

        // dayRender: function(date, cell) {
        //     cell.bind('contextmenu', function(e) {
        //         e.preventDefault();
        //         showContextMenu(e, date);
        //     });
        // },
        
        viewRender: function (view, element) {
            // console.log('se hizo cambio')
            // cambiarIdiomaCalendario();
            var mesActual = view.intervalStart.month();
            var añoActual = view.intervalStart.year();
            var nombremes = monthNames[mesActual];
            // CAMBIAR NOMBRE DEL MES
            $(".fc-center").text(nombremes + " " + añoActual);
            // CAMBIAR NOMBRE DEL DIA

            $(".fc-day-header").each(function (index) {
            $(this).text(dayNames[index]);
            });

            $(".fc-month-button").text("Mes");
            $(".fc-today-button").text("Ahora");

            
            
        },
        eventDrop: function(event, delta, revertFunc, jsEvent, ui, view) {
            handleEventChange(event);
        },
        eventResize: function(event, delta, revertFunc, jsEvent, ui, view) {
            handleEventChange(event);
        },

        eventRender: function(event, element) {
            // // Añadir botón de cerrar (X)
            // element.empty();

            // // Creamos el contenido deseado
            // var content = $('<div class="fc-content d-flex justify-content-between"></div>');
        
            // // Columna 1: Título del evento
            // var title = $('<span class="fc-title"></span>').text(event.title);
            // content.append(title);
        
            // // Columna 2: Botones de Editar y Eliminar
            // var buttonsColumn = $('<div class="buttons-column d-flex"></div>');
        
            // // Botón de Editar
            // var editButton = $('<button type="button" class="btn btn-sm btn-info"><i class="far fa-edit"></i></button>');
            // editButton.on('click', function() {
            //     abrirModal(2, event); // Llama a la función abrirModal con el evento como parámetro
            // });
            // buttonsColumn.append(editButton);
        
            // // Botón de Eliminar (solo para eventos de tipo 'institucional')
            // if (event.tipo == 'institucional') {
            //     var deleteButton = $('<button type="button" class="btn btn-sm btn-danger"><i class="far fa-trash-alt"></i></button>');
            //     deleteButton.on('click', function() {
            //         $('#borrar').modal('show');
            //     });
            //     buttonsColumn.append(deleteButton);
            // }
        
            // content.append(buttonsColumn);
        
            // // Añadimos el contenido al elemento de evento
            // element.append(content);
        
            // // Añadir el ID del evento al elemento principal
            // element.attr('data-event-id', event.id);
           
            
    
            // Verifica que el botón de cerrar se añadió correctamente
            // console.log('Close button added:', element.find('.close-button').length);

            element.bind('contextmenu', function(e) {
                e.preventDefault();
                // showContextMenu(e, event);
            });

            element.on('touchstart', function(e) {
                var touch = e.originalEvent.touches[0];
                startLongPressTimer(touch, event);
            });

            element.on('touchend touchmove', function(e) {
                clearLongPressTimer();
            });
        }

        
    });
    
    function showContextMenu(e, event) {
        var contextMenu = $('#eventContextMenu');
        var editMenuItem = contextMenu.find('#editEvent');
        var deleteMenuItem = contextMenu.find('#deleteEvent');

        if (event.tipo === 'feriado') {
            editMenuItem.show();
            deleteMenuItem.hide();
        } else if (event.tipo === 'compensable') {
            editMenuItem.show();
            deleteMenuItem.show();
        }

        // Position the context menu
        contextMenu.css({
            top: e.pageY || e.originalEvent.touches[0].pageY,
            left: e.pageX || e.originalEvent.touches[0].pageX
        }).show();
        

        // Handle menu item clicks
        $('#editEvent').off('click').on('click', function() {
            $('#eventContextMenu').hide();
            // Call your function to edit the event
            abrirModal(2, event);
        });

        $('#deleteEvent').off('click').on('click', function() {
            $('#eventContextMenu').hide();
            // Call your function to delete the event
            deleteEvent(event);
            myModalDelete.show();
        });
    }

    $(document).click(function(e) {
        // Hide the context menu if the click is outside of it
        if (!$(e.target).closest('#eventContextMenu').length) {
            $('#eventContextMenu').hide();
        }
    });

    var longPressTimer;

    function startLongPressTimer(touch, event) {
        longPressTimer = setTimeout(function() {
            showContextMenu(touch, event);
        }, 800); // 800ms long press duration
    }

    function clearLongPressTimer() {
        clearTimeout(longPressTimer);
    }

    // function abrirModal(mode, event) {
    //     // Your existing code to open modal for editing
    //     console.log('Editing event:', event);
    // }

    function deleteEvent(event) {
        // Your existing code to delete the event
        // myModalDelete.show();
        
        // console.log('Deleting event:', event.id);
        // $('#calendar').fullCalendar('removeEvents', event._id);
        $('#deleteEventBtn').click(function() {
            // console.log('Delete button clicked for event id:', event.id);
        
        const url = base_url + "Festividades/eliminar/"+event.id;
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

        })
    }
}



// $(document).on('click', '.close-button', function(e) {
//     e.stopPropagation(); // Evitar el click en el evento principal
//     const eventId = $(this).closest('.fc-event').data('event-id'); // Obtener el ID del evento
//     console.log('Close button clicked for event id:', eventId); // Log para comprobar el click
//     myModalDelete.show();
//     $('#deleteEventBtn').data('event-id', eventId); // Guardar el ID del evento en el botón de eliminar
//     console.log('Event ID set on delete button:', $('#deleteEventBtn').data('event-id')); // Verificar que el ID se ha asignado
// });


function borrar(){
    $('#deleteEventBtn').click(function() {
        // Aquí puedes agregar tu lógica para eliminar el evento con AJAX
        var eventId = $(this).data('event-id');  // Asegúrate de que este selector sea correcto
        console.log('Delete button clicked for event id:', eventId);
        myModalDelete.hide();
    
    });

}
function abrir(){
    myModalDelete.show();
}

function handleEventChange(event) {
    console.clear();
    const calendario_id = event.id;
    const nombre = event.title;
    const tipo = event.tipo;
    const descripcion = event.descripcion;
    const estado = event.estado;
    let calendario_inicio = event.start.format('YYYY-MM-DD');
    let calendario_fin = event.end ? event.end.clone().subtract(1, 'days').format('YYYY-MM-DD') : calendario_inicio;

    console.log('Se ha movido/redimensionado un evento:', calendario_id);
    console.log('inicio antes:', calendario_inicio);
    console.log('fin antes:', calendario_fin);
    let inicio = calendario_inicio.split('-');
    let fin = calendario_fin.split('-');
    let dia_Inicio = parseInt(inicio[2], 10).toString(); // Obtienes el día 
    let mes_Inicio = parseInt(inicio[1], 10).toString(); // Obtienes el mes
    let dia_Fin = parseInt(fin[2], 10).toString(); // Obtienes el día
    let mes_Fin = parseInt(fin[1], 10).toString();; // Obtienes el mes

    const url = base_url + "Festividades/actualizarCalendar";
    var parametros = {
        id: calendario_id,
        nombre : nombre,
        tipo : tipo,
        descripcion:descripcion,
        dia_inicio: dia_Inicio,
        mes_inicio: mes_Inicio,
        dia_fin:dia_Fin,
        mes_fin: mes_Fin,
        estado:estado,
      };
    //   console.log(parametros);

    //   const Toast = Swal.mixin({
    //     toast: true,
    //     position: "top-end",
    //     showConfirmButton: false,
    //     timer: 1800,
    //     timerProgressBar: true,
    //     didOpen: (toast) => {
    //       toast.onmouseenter = Swal.stopTimer;
    //       toast.onmouseleave = Swal.resumeTimer;
    //     //   console.log(Swal.timerProgressBar);
    //     }
    //   });
      

    $.ajax({
        data: parametros, //datos que se envian a traves de ajax
        url: url, //archivo que recibe la peticion
        type: "POST", //método de envio
        beforeSend: function () {
          // console.log('procesando');
        },
        success: function (response) {
            const res = JSON.parse(response);
            Toast.fire({
                icon: res.icono,
                title: res.msg,
              });
        },
    
    })

    // Obtén el evento actualizado del calendario
    // var eventoEnCalendario = $('#Calendario').fullCalendar('clientEvents', event.id)[0];
    // let calendario_inicio_actual = eventoEnCalendario.start.format('YYYY-MM-DD');
    // let calendario_fin_actual = eventoEnCalendario.end ? eventoEnCalendario.end.clone().subtract(1, 'days').format('YYYY-MM-DD') : calendario_inicio_actual;

    // console.log('Nueva posición en el inicio:', calendario_inicio_actual);
    // console.log('Nueva posición en el fin:', calendario_fin_actual);
}

function abrirModal(tipo, calEvent = null, date = null) {
// crear
    if (tipo == 1 && date) {
        frm.reset();
        resetRequiredFields();
        btnAccion.textContent = 'Registrar';
        titleModal.textContent = "Crear Evento";
        input_id.value = null;
        input_tipo.value ='feriado';
        let fechaFormateada = date.format('YYYY-MM-DD');
        input_fecha_inicio.value = fechaFormateada;
        input_fecha_fin.value = fechaFormateada;
        // console.log(date.format('DD-MM-YYYY'));
        document.querySelector('#radio-true').checked = true;
        document.querySelectorAll('#estado-grupo').forEach(element => {
            element.style.display = 'none';
        });
    }
    // editar
    if (tipo == 2 && calEvent){
        frm.reset();
        resetRequiredFields();
        btnAccion.textContent = 'Actualizar';
        titleModal.textContent = "Actualizar Calendario";

        input_id.value = calEvent.id;
        input_nombre.value = calEvent.title;
        input_descripcion.value = calEvent.descripcion;

        let fechaFormateada_inicio = calEvent.start.format('YYYY-MM-DD');
        let fechaFormateada_fin = calEvent.end.clone().subtract(1, 'day').format('YYYY-MM-DD'); // Resta 1 día a la fecha de fin

        input_fecha_inicio.value = fechaFormateada_inicio;
        // input_fecha_fin.value = fechaFormateada_fin;
        input_fecha_fin.value = fechaFormateada_inicio;
        input_tipo.value = calEvent.tipo;

        document.querySelectorAll('#estado-grupo').forEach(element => {
            element.style.display = 'none';
        });
    }
    
    myModal.show();

    $('#nuevoModal').on('shown.bs.modal', function() {
        input_nombre.focus();
    });

   
}

frm.addEventListener("submit", function (e) {
    e.preventDefault();
    
    let data = new FormData(this);
    const url = base_url + "Festividades/actualizarCalendar";

    let fechaInicio = data.get('fecha_inicio'); // Formato YYYY-MM-DD
    // let fechaFin = data.get('fecha_fin'); // Formato YYYY-MM-DD
    let fechaFin = data.get('fecha_inicio'); // Formato YYYY-MM-DD

    // Dividir fecha_inicio en dia_inicio y mes_inicio
    let fechaInicioParts = fechaInicio.split('-');
    let dia_inicio = fechaInicioParts[2]; // Día
    let mes_inicio = fechaInicioParts[1]; // Mes

    // Dividir fecha_fin en dia_fin y mes_fin
    let fechaFinParts = fechaFin.split('-');
    let dia_fin = fechaFinParts[2]; // Día
    let mes_fin = fechaFinParts[1]; // Mes

    var parametros = {
        id: data.get('id'),
        nombre : data.get('nombre'),
        tipo : data.get('tipo'),
        descripcion:data.get('descripcion'),
        dia_inicio: dia_inicio,
        mes_inicio: mes_inicio,
        dia_fin:dia_fin,
        mes_fin: mes_fin,
        estado:data.get('estado'),
      };

    //   const Toast = Swal.mixin({
    //     toast: true,
    //     position: "top-end",
    //     showConfirmButton: false,
    //     timer: 2000,
    //     timerProgressBar: true,
    //     didOpen: (toast) => {
    //       toast.onmouseenter = Swal.stopTimer;
    //       toast.onmouseleave = Swal.resumeTimer;
    //     //   console.log(Swal.timerProgressBar);
    //     }
    //   });
      

    $.ajax({
        data: parametros, //datos que se envian a traves de ajax
        url: url, //archivo que recibe la peticion
        type: "POST", //método de envio
        beforeSend: function () {
          // console.log('procesando');
        },
        success: function (response) {
            const res = JSON.parse(response);
            Toast.fire({
                icon: res.icono,
                title: res.msg,
              });
              if(res.icono=='success'){
                frm.reset();
                cerrarModal();
               
              }
              MostrarCalendario();
        },
    
    })
      
});

function resetRequiredFields() {
    // Obtener todos los elementos de entrada requeridos
    $('#formulario').removeClass('was-validated');
}

function cerrarModal() {
    myModal.hide();
}

function cerrarModalBorrar() {
    myModalDelete.hide();
}
document.addEventListener('DOMContentLoaded', function() {
    MostrarCalendario();
    // ModificarCalendario();

    
});







// Función para cambiar el idioma del calendario




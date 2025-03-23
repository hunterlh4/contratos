function obtenerNotificaciones() {
  $.ajax({
    url: base_url_1 + "Admin/notificacion", // Asegúrate de que esta URL apunte a tu método notificacion
    method: "GET",
    success: function (response) {
      // console.log(response);
      // Aquí puedes manejar la respuesta y actualizar tu interfaz de usuario
      data = JSON.parse(response);

      mostrarNotificaciones(data);
    },
    error: function (jqXHR, textStatus, errorThrown) {
      console.error(
        "Error al obtener las notificaciones:",
        textStatus,
        errorThrown
      );
    },
  });
}

function mostrarNotificaciones(data) {
    let total = data.total.count; // Total de notificaciones
    $("#totalNotificaciones").text(total);
    if(total=='0'){
        $("#totalNotificaciones").text('');
    }

    // Actualiza el contador de notificaciones
    // $("#totalNotificaciones").text(total);

    if (total === 0) {
        $("#listaNotificaciones").html(`
            <a href="#"  class="dropdown-item">
                <span class="dropdown-item-desc"> 
                    
                    <span class="time messege-text">No hay usuarios pendientes por aprobar</span>
                </span>
            </a>
            `);
            ajustarAlturaListaNotificaciones('auto');
            return;
    }

    // Construye el HTML para cada notificación
    let listaNotificacionesHtml = '';
    data.notificaciones.forEach(function(notificacion) {
        // Calcula la diferencia de tiempo desde la creación de la notificación hasta ahora
        let fechaCreacion = new Date(notificacion.create_at);
        let ahora = new Date();
        let diferencia = ahora.getTime() - fechaCreacion.getTime();

        // Calcula los componentes de tiempo
        let segundos = Math.floor(diferencia / 1000);
        let minutos = Math.floor(segundos / 60);
        let horas = Math.floor(minutos / 60);
        let dias = Math.floor(horas / 24);
        let meses = Math.floor(dias / 30);
        let años = Math.floor(meses / 12);

        // Define el texto de tiempo transcurrido
        let tiempoTranscurrido = '';
        if (años > 0) {
            tiempoTranscurrido = años === 1 ? 'hace 1 año' : `hace ${años} años`;
        } else if (meses > 0) {
            tiempoTranscurrido = meses === 1 ? 'hace 1 mes' : `hace ${meses} meses`;
        } else if (dias > 0) {
            tiempoTranscurrido = dias === 1 ? 'hace 1 día' : `hace ${dias} días`;
        } else if (horas > 0) {
            tiempoTranscurrido = horas === 1 ? 'hace 1 hora' : `hace ${horas} horas`;
        } else if (minutos > 0) {
            tiempoTranscurrido = minutos === 1 ? 'hace 1 minuto' : `hace ${minutos} minutos`;
        } else {
            tiempoTranscurrido = 'hace unos momentos';
        }

        let inicialNombre = notificacion.nombre.charAt(0);
        let inicialApellido = notificacion.apellido.charAt(0);

        // Construye el HTML para la notificación
        listaNotificacionesHtml += `
        <a href="Usuario" class="dropdown-item"> 
            <span class="dropdown-item-avatar text-white">
                <figure class="avatar mr-2 bg-danger text-white" data-initial="${inicialNombre}${inicialApellido}"></figure>
            </span> 
            <span class="dropdown-item-desc"> 
                <span class="message-user">${notificacion.username}</span>
                <span class="time messege-text">pendiente de aprobación.</span>
                <span class="time">${tiempoTranscurrido}</span>
            </span>
        </a>`;
        // mensaje ${notificacion.mensaje}
        //   <span class="message-user">${notificacion.nombre} ${notificacion.apellido}</span>
});

    // Inserta las notificaciones en el contenedor
    $("#listaNotificaciones").html(listaNotificacionesHtml);
    ajustarAlturaListaNotificaciones('auto');
    if(total > 4){
       
        ajustarAlturaListaNotificaciones('250px');
    }
    
   
   
}

function ajustarAlturaListaNotificaciones(nuevaAltura) {
    let listaNotificaciones = $("#listaNotificaciones");
    listaNotificaciones.css("height", nuevaAltura); // Establece la nueva altura según el parámetro proporcionado
}

$(document).ready(function () {
  // Llama a la función para obtener las notificaciones cuando el documento esté listo
//   obtenerNotificaciones();
});

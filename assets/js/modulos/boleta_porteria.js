
const nuevo = document.querySelector("#nuevo_registro");
const frm = document.querySelector("#formulario");
const titleModal = document.querySelector("#titleModal");
const btnAccion = document.querySelector("#btnAccion");
const myModal = new bootstrap.Modal(document.getElementById("nuevoModal"));

// INPUTS

const idElement = document.querySelector('#id');
const solicitanteElement = document.querySelector('#solicitante');
const aprobadorElement = document.querySelector('#aprobador');
let tipo_boleta = document.querySelector("#tipo");
let fechaInicioElement = document.querySelector("#fecha");
// let fechaFinElement = document.querySelector("#fecha_fin");
const horaSalidaElement = document.querySelector('#hora_salida');
const horaEntradaElement = document.querySelector('#hora_entrada');
const razonElement = document.querySelector('#razon');
const otra_razonElement = document.querySelector('#otra_razon');
// 
const btn_salida = document.querySelector('#btn_salida');
const btn_entrada = document.querySelector('#btn_retorno');

const tbl_boleta_dias = document.getElementById("table-dias-alex");
var tabla_dias, tabla_horas;
const tbl_boleta_horas = document.getElementById("table-horas-alex");

let mytable; // = document.querySelector("#table-1");
let tblUsuario;
var data9 ;
var datos;

// Ajustar el tamaño del modal
 // Establece el ancho máximo del modal


document.addEventListener("DOMContentLoaded", function() {
    prueba();
    llenartablaHoras();
    llenarSelectSolicitante();
    // llenarSelectAprobador();

  

  
    
    //submit usuarios
   
});

frm.addEventListener("submit", function(e) {
    horaSalidaElement.disabled =false;
    horaEntradaElement.disabled =false;
    e.preventDefault();
    let data = new FormData(this);
    const url = base_url + "Boleta/registrarHora";
   
    $.ajax({
        url: url,
        method: 'POST',
        data: data,
        processData: false, 
        contentType: false,
        beforeSend: function() {
            // Se ejecuta antes de enviar la solicitud
            console.log('Enviando solicitud...');
        },
        success: function(response) {
            console.log(response);
            horaSalidaElement.disabled =true;
            horaEntradaElement.disabled =true;
            // console.log(response);
            const res = JSON.parse(response);
            // console.log(response);
            if (res.icono == "success") {
                // horaSalidaElement.disabled =true;
                // horaEntradaElement.disabled =true;
                
                tabla_horas.ajax.reload();
                frm.reset(); // Limpia el formulario
                cerrarModal(); // Oculta el modal y el fondo oscuro
                
            }
            Swal.fire("Aviso", res.msg.toUpperCase(), res.icono);
        },
        error: function(xhr, status, error) {
            // Se ejecuta si hay algún error en la solicitud
            console.error('Error en la solicitud:', error);
        }
    });

   
});

function llenartablaHoras() {
    tipo = "1";
    tabla_horas = $("#table-horas-alex").DataTable({
      ajax: {
        url: base_url + "Boleta/listarPorteria",
        type: "POST", // Especifica el método HTTP como POST
        dataSrc: "",
        data: function (data) {
          // Agrega los parámetros que deseas enviar
          data.parametro = "1";
  
          // Agrega más parámetros si es necesario
          return data;
        },
      },
      columns: [
        // Define tus columnas aquí según la estructura de tus datos
        { data: "posicion" },
  
        { data: "numero" },
        { data: "nombre_trabajador" },
        { data: "fecha_nueva" },
        // { data: "fecha_fin_formateada" },
        { data: "hora_salida" },
        { data: "hora_entrada" },
        { data: "estado_tramite" },
        // { data: "estado" },
        { data: "accion" },
      ],
      dom: "Bfrtip",
      columnDefs: [
        //   { width: "15px", targets: 0 }, // Ancho de la primera columna
        //   { width: "30px", targets: 1 }, // Ancho de la segunda columna
        //   { width: "250px", targets: 2 }, // Ancho de la segunda columna
        // Agrega más columnDefs según sea necesario
      ],
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

function edit(id) {

    $.ajax({
        url: base_url + "Boleta/edit/" + id,
        type: 'GET',

        success: function(response) {
                frm.reset();
                resetRequiredFields();
                console.log(response);
                cambiarEstadoInputs(0);
                const res = JSON.parse(response); 
                
                idElement.value = res.id;
                solicitanteElement.value = res.trabajador_id;
                aprobadorElement.value = res.aprobado_por;
                fechaInicioElement.value = res.fecha_inicio;
                // fechaFinElement.value = res.fecha_fin;
                horaSalidaElement.value =res.hora_salida;
                horaEntradaElement.value = res.hora_entrada;
                razonElement.value = res.razon;
                otra_razonElement.value = res.razon_especifica;
                
                horaSalidaElement.disabled =true;
                horaEntradaElement.disabled =true;
                btn_entrada.disabled=true;
                btn_salida.disabled=true;
                btn_entrada.classList.replace('btn-success', 'btn-dark');
                btn_salida.classList.replace('btn-success', 'btn-dark');
                btnAccion.disabled=true;
                btnAccion.style.display='none';
              
                if(res.hora_salida==null && res.hora_entrada == null){
                    // horaSalidaElement.disabled = false;
                    btn_salida.disabled = false;
                    btnAccion.disabled=false;
                    btnAccion.style.display='block';
                    // horaEntradaElement.disabled = true;
                    // btn_entrada.disabled=true;
                    btn_salida.classList.replace('btn-dark','btn-success');
                }
                if(res.hora_salida !=null && res.hora_entrada == null){
                    // horaEntradaElement.disabled = false;
                    btn_entrada.disabled = false;
                    btnAccion.disabled=false;
                    btnAccion.style.display='block';
                    btn_entrada.classList.replace('btn-dark','btn-success');
                   
                }
                // if(res.hora_entrada==null){
                //     horaEntradaElement.style.disabled=true;
                //     console.log('entro entrada');
                // }

                if (!aprobadorElement.value) {
                        
                   
                        var opcion = document.createElement('option');
                        opcion.value = res.aprobado_por; // Cambia 'default_value' al valor predeterminado que desees
                        opcion.text = res.aprobado_por;
                        
                        aprobadorElement.appendChild(opcion);
                        aprobadorElement.value = opcion.value;
                        
                       
                    
                    }
              
                
                
                btnAccion.textContent = 'Actualizar';
                titleModal.textContent = "Actualizar Boleta";
                myModal.show();
        },
        error: function(xhr, status, error) {
            console.error(error);
        }
    });


  
       
   
}

function llenarSelectSolicitante(){
   
        $.ajax({
            url: base_url + "Api/listartrabajadores",
            type: 'GET',
    
            success: function(response) {
                    datos = JSON.parse(response); 
                    datos.forEach(opcion => {
                    // Crear un elemento de opción
                    let option = document.createElement("option");
                    // Establecer el valor y el texto de la opción
    
                    if (opcion.estado === "Inactivo" ) {
                        // Aplicar estilo al campo seleccionado
                        option.style.color = "red"; // Cambiar a tu color deseado
                    }
                    
                    option.value = opcion.id;
                   
                    if(opcion.dni==null){
                        option.text = opcion.apellido_nombre;
                       
                    }else{
                        
                        option.text = opcion.apellido_nombre+ ' - '+ opcion.dni;
                    }
                    
                    // Agregar la opción al select
                    solicitante.appendChild(option);
                    });
                    datos.forEach(opcion => {
                        // Crear un elemento de opción
                        let option = document.createElement("option");
                        // Establecer el valor y el texto de la opción
        
                        if (opcion.estado === "Inactivo" ) {
                            // Aplicar estilo al campo seleccionado
                            option.style.color = "red"; // Cambiar a tu color deseado
                        }
                        
                        option.value = opcion.id;
                       
                        if(opcion.dni==null){
                            option.text = opcion.apellido_nombre;
                           
                        }else{
                            
                            option.text = opcion.apellido_nombre+ ' - '+ opcion.dni;
                        }
                        
                        // Agregar la opción al select
                        aprobador.appendChild(option);
                        });
            },
            error: function(xhr, status, error) {
                console.error(error);
            }
        });
    
}

function llenarSelectAprobador(){
   
    $.ajax({
        url: base_url + "Boleta/listarTrabajadoresPorCargoNivel",
        type: 'POST',

        success: function(response) {
            datos = JSON.parse(response); 
            console.log(response);
            // Limpiar el select aprobadorElement
            aprobadorElement.innerHTML = '';
            datos.map(function(item) {
                var option = document.createElement('option');
                if (item.trabajador_estado === "Inactivo" ) {
                    option.style.color = "red";
                }
                option.value = item.trabajador_id;
                if(item.trabajador_dni==null){
                    option.text = item.trabajador_nombre;
                }else{
                    option.text = item.trabajador_nombre+ ' - '+ item.trabajador_dni;
                }
                aprobadorElement.appendChild(option);
                
                });
        },
        error: function(xhr, status, error) {
            console.error(error);
        }
    });

}


// reiniciar validaciones
function resetRequiredFields() {
    // Obtener todos los elementos de entrada requeridos
    $('#formulario').removeClass('was-validated');
}

// Llamar a la función cuando se abre el modal
function abrirModal() {
    myModal.show();
}

// Función para cerrar el modal
function cerrarModal() {
    myModal.hide();
}

function cambiarEstadoInputs(accion){

    $('#resultado').empty();
    // idElement.disabled = true;
    solicitanteElement.disabled = false;
    aprobadorElement.disabled = false;
    fechaInicioElement.disabled = false;
    // fechaFinElement.disabled = false;
    horaSalidaElement.disabled = true;
    horaEntradaElement.disabled = true;
    razonElement.disabled=false;
    otra_razonElement.disabled=false;
   
    if(accion==0){
        idElement.disabled = false;
        solicitanteElement.disabled = true;
        aprobadorElement.disabled = true;
        fechaInicioElement.disabled = true;
        // fechaFinElement.disabled = true;
        horaSalidaElement.disabled = false;
        horaEntradaElement.disabled = false;
        razonElement.disabled=true;
        otra_razonElement.disabled=true;

       
    }
    // 
    
    
}

// solicitanteElement.addEventListener('change', function() {
//     var selectedValue = solicitanteElement.value;
//     if(selectedValue==''){
//         selectedValue = 0;
//     }
//     $.ajax({
//         url: base_url + "Boleta/listarTrabajadoresPorCargoNivel",
//         type: 'POST',
//         data: { id: selectedValue }, // Puedes enviar datos adicionales si es necesario
//         success: function(response) {
//             datos = JSON.parse(response); 
//             // Limpiar el select aprobadorElement
//             aprobadorElement.innerHTML = '';
//             datos.map(function(item) {
//                 var option = document.createElement('option');
//                 if (item.trabajador_estado === "Inactivo" ) {
//                     option.style.color = "red";
//                 }
//                 option.value = item.trabajador_id;
//                 if(item.trabajador_dni==null){
//                     option.text = item.trabajador_nombre;
//                 }else{
//                     option.text = item.trabajador_nombre+ ' - '+ item.trabajador_dni;
//                 }
//                 aprobadorElement.appendChild(option);
//             });
//             console.log(response);
//         },
//         error: function(xhr, status, error) {
//             console.error(error);
//         }
//     });
// });

function removeDefaultOption() {
    const defaultOption = document.getElementById('defaultOption');
    if (defaultOption) {
        defaultOption.remove();
    }
}



function prueba(){
   
    $.ajax({
        url: base_url + "Boleta/listarPorteria",
        type: 'POST',

        success: function(response) {
            
            console.log(response);
           
                
           
        },
        error: function(xhr, status, error) {
            console.error(error);
        }
    });

}

function salida() {
    // Obtener la hora actual
    let now = new Date();
    let hours = now.getHours().toString().padStart(2, '0');
    let minutes = now.getMinutes().toString().padStart(2, '0');
    let currentTime = `${hours}:${minutes}`;

    // Asignar la hora actual al input
    document.getElementById('hora_salida').value = currentTime;
  }

  function retorno() {
    // Obtener la hora y minuto actual
    let now = new Date();
    let hours = now.getHours().toString().padStart(2, '0');
    let minutes = now.getMinutes().toString().padStart(2, '0');
    let currentTime = `${hours}:${minutes}`;

    // Asignar la hora y minuto actual al input
    document.getElementById('hora_entrada').value = currentTime;
  }
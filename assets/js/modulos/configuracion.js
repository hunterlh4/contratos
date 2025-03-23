const frm = document.querySelector("#formulario");

// const btnAccion = document.querySelector("#btnAccion");


// FORM
const id = document.querySelector('#id');
const api_1 = document.querySelector('#api_1');
const api_2 = document.querySelector('#api_2');
// FORM

document.addEventListener("DOMContentLoaded", function() {

    llenarDatos();
    
    //levantar modal
 
    //submit usuarios
  
});

function guardar(){
    frm.addEventListener("submit", function(e) {
        e.preventDefault();
       
        const formData = new FormData(frm);
        const url = base_url + "Configuracion/actualizar";
      
        $.ajax({
            url: url,
            method: 'POST',
            data: formData,
            processData: false, 
            contentType: false,
            beforeSend: function() {
                // Se ejecuta antes de enviar la solicitud
                console.log('Enviando solicitud...');
            },
            success: function(response) {
                // Se ejecuta cuando se recibe una respuesta exitosa
                // console.log(response);
                const res = JSON.parse(response);
                // console.response();
                if (res.icono == "success") {
                    
                    frm.reset();
                    llenarDatos();
                }
                Swal.fire("Aviso", res.msg.toUpperCase(), res.icono);
              
            },
            error: function(xhr, status, error) {
                // Se ejecuta si hay algún error en la solicitud
                console.error('Error en la solicitud:', error);
            }
        });

       
    });

}

function actualizartabla(){
    mytable = $('#table-alex').DataTable();
    // var datosSeleccionados = tabla.rows('.selected').data();
    tabla.ajax.reload();
}


function llenarDatos() {

    $.ajax({
        url: base_url + "Configuracion/getConfiguracion",
        type: 'GET',

        success: function(response) {
                frm.reset();
                resetRequiredFields();
                console.log(response);
             
                const res = JSON.parse(response); 
                // console.log(res);
                
                if (res && res.id !== undefined && res.api_1 !== undefined && res.api_2 !== undefined) {
                    $('#id').val(res.id);
                    $('#api_1').val(res.api_1);
                    $('#api_2').val(res.api_2);
                } else {
                    // Si la respuesta está vacía o no contiene los datos esperados, establecer valores vacíos
                    $('#id').val('');
                    $('#api_1').val('');
                    $('#api_2').val('');
                }
                

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
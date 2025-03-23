
const nuevo = document.querySelector("#nuevo_registro");
const frm = document.querySelector("#formulario");
const titleModal = document.querySelector("#titleModal");
const btnAccion = document.querySelector("#btnAccion");
const myModal = new bootstrap.Modal(document.getElementById("nuevoModal"));



let mytable; // = document.querySelector("#table-1");
let tblUsuario;
var data9 ;
var datos;

// Ajustar el tamaño del modal
 // Establece el ancho máximo del modal


document.addEventListener("DOMContentLoaded", function() {

    llenarTabla();
    

  

    //levantar modal
    nuevo.addEventListener("click", function() {
        frm.reset();
        resetRequiredFields()
        btnAccion.textContent = 'Registrar';
        titleModal.textContent = "Nuevo Horario";

        document.querySelector('#radio-true').checked = true;
        document.querySelector('#id').value = '';
        document.querySelectorAll('#estado-grupo').forEach(element => {
            element.style.display = 'none';
        });
        myModal.show();
    });
    
    //submit usuarios
    frm.addEventListener("submit", function(e) {
        e.preventDefault();
        let data = new FormData(this);
        const url = base_url + "Horario/registrar";
        const http = new XMLHttpRequest();
        http.open("POST", url, true);
        http.send(data);
        http.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                console.log(this.responseText);
                const res = JSON.parse(this.responseText);
                if (res.icono == "success") {
                    
                    tblUsuario.ajax.reload();
                    frm.reset(); // Limpia el formulario
                    cerrarModal(); // Oculta el modal y el fondo oscuro
                }
                Swal.fire("Aviso", res.msg.toUpperCase(), res.icono);
            }
        }
    });
});


function llenarTabla(){
    tblUsuario = $("#table-alex").DataTable({
        ajax: {
            url: base_url + "Horario/listar",
            dataSrc: "",
        },
        columns: [
            { data: "id" },
            { data: "nombre" },
            { data: "comentario" },
            { data: "estado" },
            { data: "accion" },

        ],
        dom: 'Bfrtip',
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
                extend: 'copy',
                exportOptions: {
                    columns: [0, 1, 2, 3] // Especifica las columnas que deseas copiar
                }
            },
            {
                extend: 'csv',
                exportOptions: {
                    columns: [0, 1, 2, 3] // Especifica las columnas que deseas exportar a CSV
                }
            },
            {
                extend: 'excel',
                exportOptions: {
                    columns: [0, 1, 2, 3] // Especifica las columnas que deseas exportar a Excel
                }
            },
            {
                extend: 'pdf',
                exportOptions: {
                    columns: [0, 1, 2, 3] // Especifica las columnas que deseas exportar a PDF
                }
            },
            {
                extend: 'print',
                exportOptions: {
                    columns: [0, 1, 2, 3] // Especifica las columnas que deseas imprimir
                }
            }
        ]
    });
}



function actualizartabla(){
    mytable = $('#table-alex').DataTable();
    // var datosSeleccionados = tabla.rows('.selected').data();
    tabla.ajax.reload();
}


function Edit(id) {
    const url = base_url + "Horario/edit/" + id;
    const http = new XMLHttpRequest();
    http.open("GET", url, true);
    http.send();
    http.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            frm.reset();
            resetRequiredFields();
            console.log(this.responseText);
            const res = JSON.parse(this.responseText);
            document.querySelector('#id').value = res.id;
            document.querySelector('#nombre').value = res.nombre;
       
            document.querySelector('#comentario').value = res.comentario;
            
            if(res.estado=='Activo'){
                document.querySelector('#radio-true').checked = true;
                document.querySelector('#radio-false').checked = false;
            }else{
                document.querySelector('#radio-false').checked = true;
                document.querySelector('#radio-true').checked = false;
            }
           
            document.querySelectorAll('#estado-grupo').forEach(element => {
                element.style.display = 'block';
            });
            // document.querySelector('#password').setAttribute('readonly', 'readonly');
            btnAccion.textContent = 'Actualizar';
            titleModal.textContent = "Modificar Horario";
            myModal.show();
            
            //$('#nuevoModal').modal('show');
        }
    }
}

function sendId(id) {
    //  window.location.href =  base_url + 'HorarioDetalle?id=' + encodeURIComponent(id);
   
    const url = base_url + "Horario/temporal/" + id;
    const http = new XMLHttpRequest();

    http.open('GET', url, true);
    http.onload = function() {
        if (http.status >= 200 && http.status < 300) {
            console.log('Llamada al controlador realizada correctamente.');
            window.location.href = base_url + "HorarioDetalle";
        } else {
            console.error('Error al llamar al controlador:', http.statusText);
        }
    };

    http.onerror = function() {
        console.error('Error de red al intentar llamar al controlador.');
    };

    http.send();
}

// function View(id) {
//     const url = base_url + "Horario/edit/" + id;
//     const http = new XMLHttpRequest();
//     http.open("GET", url, true);
//     http.send();
//     http.onreadystatechange = function() {
//         if (this.readyState == 4 && this.status == 200) {
//             frm.reset();
//             resetRequiredFields();
//             console.log(this.responseText);
//             const res = JSON.parse(this.responseText);
//             document.querySelector('#id').value = res.id;
//             document.querySelector('#nombre').value = res.nombre;
       
//             document.querySelector('#comentario').value = res.comentario;
            
//             if(res.estado=='Activo'){
//                 document.querySelector('#radio-true').checked = true;
//                 document.querySelector('#radio-false').checked = false;
//             }else{
//                 document.querySelector('#radio-false').checked = true;
//                 document.querySelector('#radio-true').checked = false;
//             }
           
//             document.querySelectorAll('#estado-grupo').forEach(element => {
//                 element.style.display = 'block';
//             });
//             // document.querySelector('#password').setAttribute('readonly', 'readonly');
//             btnAccion.textContent = 'Actualizar';
//             titleModal.textContent = "Modificar Horario";
//             myModal.show();
            
//             //$('#nuevoModal').modal('show');
//         }
//     }
// }

// function ViewDetail(id) {
//     // Crear un objeto FormData para enviar los datos por POST
//     const url = base_url + "HorarioDetalle/" + id;
//     console.log(url);
//     const http = new XMLHttpRequest();
//     var formData = new FormData();
//     formData.append('id', id);

//     var form = document.createElement('form');
//     form.method = 'POST';
//     form.action = '<?php echo BASE_URL . "HorarioDetalle/index"; ?>'; // URL del controlador PHP
    
//     // Crear un campo oculto para enviar el valor 'id'
//     var input = document.createElement('input');
//     input.type = 'hidden';
//     input.name = 'id';
//     input.value = id;
    
//     // Agregar el campo oculto al formulario
//     form.appendChild(input);
    
//     // Adjuntar el formulario al cuerpo del documento y enviarlo
//     document.body.appendChild(form);
//     form.submit();
    
// }


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
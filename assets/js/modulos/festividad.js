
const nuevo = document.querySelector("#nuevo_registro");
const frm = document.querySelector("#formulario");
const titleModal = document.querySelector("#titleModal");
const btnAccion = document.querySelector("#btnAccion");
const myModal = new bootstrap.Modal(document.getElementById("nuevoModal"));
const input_id =  document.querySelector('#id');
const nombre = document.querySelector('#nombre');
const fecha = document.querySelector('#fecha');
const descripcion = document.querySelector('#descripcion');
const tipo = document.querySelector('#tipo');
const activo = document.querySelector('#radio-true');
const inactivo = document.querySelector('#radio-false');


let year = new Date().getFullYear();
fecha.setAttribute("min", year + "-01-01");
fecha.setAttribute("max", year + "-12-31");

let mytable; // = document.querySelector("#table-1");
let tblUsuario;
var data9 ;
var datos;

// Ajustar el tamaño del modal
 // Establece el ancho máximo del modal


document.addEventListener("DOMContentLoaded", function() {

    llenarTabla();
});

nuevo.addEventListener("click", function() {
    frm.reset();
    resetRequiredFields()
    btnAccion.textContent = 'Guardar';
    titleModal.textContent = "Registrar Festividad";

    document.querySelector('#radio-true').checked = true;
    document.querySelector('#id').value = '';
    document.querySelectorAll('#estado-grupo').forEach(element => {
        element.style.display = 'none';
    });
    myModal.show();
});

//submit usuarios
frm.addEventListener("submit", function (e) {
    e.preventDefault();
    let data = new FormData(this);
    const url = base_url + "Festividades/registrar";

    $.ajax({
      url: url,
      method: "POST",
      data: data,
      processData: false,
      contentType: false,
      beforeSend: function () {
        // Se ejecuta antes de enviar la solicitud
        console.log("Enviando solicitud...");
      },
      success: function (response) {
        // Se ejecuta cuando se recibe una respuesta exitosa
        console.log(response);
        const res = JSON.parse(response);
        if (res.icono == "success") {
          // llenarTablaDias();
          tblUsuario.ajax.reload();

          frm.reset(); // Limpia el formulario
          cerrarModal(); // Oculta el modal y el fondo oscuro
        }
        Swal.fire("Aviso", res.msg.toUpperCase(), res.icono);
      },
      error: function (xhr, status, error) {
        // Se ejecuta si hay algún error en la solicitud
        console.error("Error en la solicitud:", error);
      },
    });
});


function llenarTabla(){
    tblUsuario = $("#table-alex").DataTable({
        ajax: {
            url: base_url + "Festividades/listar",
            dataSrc: "",
        },
        columns: [
            { data: "posicion" },
            { data: "nombre" },
            { data: "tipo" },
            { data: "fecha" },
            { data: "estado" },
            { data: "accion" },

        ],
        dom: 'Bfrtip',
        
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



function edit(id) {
    $.ajax({
      url: base_url + "Festividades/edit/" + id,
      type: "GET",
  
      success: function (response) {
            frm.reset();
            resetRequiredFields();
            console.log(response);
            const res = JSON.parse(response);
            console.log(res);
            // console.log(res.nombre);
            input_id.value = res.id;
            nombre.value = res.nombre;
            descripcion.value = res.descripcion;
            const mes_dia = {
                mes: res.mes,  // Mayo
                dia: res.dia   // Día 1
            };
    
            // Asegurándose de que mes y dia tengan dos dígitos
            const mes = String(mes_dia.mes).padStart(2, '0');
            const dia = String(mes_dia.dia).padStart(2, '0');
            const formattedDate = `${year}-${mes}-${dia}`;
            fecha.value = formattedDate;
            
            tipo.value = res.tipo;
            
            if(res.estado=='Activo'){
                activo.checked = true;
                inactivo.checked = false;
            }else{
                inactivo.checked = true;
                activo.checked = false;
            }
           
            document.querySelectorAll('#estado-grupo').forEach(element => {
                element.style.display = 'block';
            });
            // document.querySelector('#password').setAttribute('readonly', 'readonly');
            btnAccion.textContent = 'Actualizar';
            titleModal.textContent = "Modificar Horario";
            myModal.show();
        },
            //$('#nuevoModal').modal('show');
            error: function (xhr, status, error) {
                console.error(error);
              },
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